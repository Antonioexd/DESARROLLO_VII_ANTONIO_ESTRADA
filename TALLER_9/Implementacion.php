<?php
require_once "config_pdo.php";

class PedidoManager {
    private $pdo;
    private $maxRetries = 3;
    private $retryDelay = 1; // segundos

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Procesa un pedido con múltiples puntos de guardado.
     */
    public function procesarPedido($cliente_id, $items) {
        $retryAttempts = 0;
        while ($retryAttempts < $this->maxRetries) {
            try {
                // Nivel de aislamiento adecuado para evitar lecturas inconsistentes en esta transacción
                $this->pdo->exec("SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
                $this->pdo->beginTransaction();

                // Crear el pedido y registrar el inicio de la transacción
                $stmt = $this->pdo->prepare("INSERT INTO pedidos (cliente_id, total) VALUES (?, 0)");
                $stmt->execute([$cliente_id]);
                $pedido_id = $this->pdo->lastInsertId();

                // Savepoint después de crear el pedido
                $this->pdo->exec("SAVEPOINT pedido_creado");

                $totalPedido = 0;
                $itemsProcesados = 0;

                foreach ($items as $item) {
                    try {
                        // Verificar stock con lock para evitar actualizaciones concurrentes
                        $stmt = $this->pdo->prepare("SELECT stock, precio FROM productos WHERE id = ? FOR UPDATE");
                        $stmt->execute([$item['producto_id']]);
                        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($producto['stock'] < $item['cantidad']) {
                            throw new Exception("Stock insuficiente para el producto {$item['producto_id']}");
                        }

                        // Guardar estado antes de cada item para posibles reversiones
                        $this->pdo->exec("SAVEPOINT item_" . $itemsProcesados);

                        // Actualizar el stock del producto
                        $stmt = $this->pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
                        $stmt->execute([$item['cantidad'], $item['producto_id']]);

                        // Registrar el detalle del pedido
                        $subtotal = $producto['precio'] * $item['cantidad'];
                        $stmt = $this->pdo->prepare("INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$pedido_id, $item['producto_id'], $item['cantidad'], $producto['precio'], $subtotal]);

                        $totalPedido += $subtotal;
                        $itemsProcesados++;
                    } catch (Exception $e) {
                        // Revertir al último punto de guardado si ocurre un error en el item
                        $this->pdo->exec("ROLLBACK TO SAVEPOINT item_" . ($itemsProcesados - 1));
                        $this->registrarAuditoria($pedido_id, $e->getMessage());
                        echo "Error al procesar el item: " . $e->getMessage() . "<br>";
                        continue;
                    }
                }

                // Actualizar el total del pedido en la tabla principal
                $stmt = $this->pdo->prepare("UPDATE pedidos SET total = ? WHERE id = ?");
                $stmt->execute([$totalPedido, $pedido_id]);

                // Confirmar transacción
                $this->pdo->commit();
                echo "Pedido procesado exitosamente.<br>";
                return;
                
            } catch (PDOException $e) {
                // Manejo de deadlocks con retry
                $this->pdo->rollBack();
                if ($this->esDeadlock($e)) {
                    $retryAttempts++;
                    sleep($this->retryDelay);
                } else {
                    $this->registrarAuditoria(null, $e->getMessage());
                    echo "Error de transacción: " . $e->getMessage() . "<br>";
                    break;
                }
            }
        }
        if ($retryAttempts == $this->maxRetries) {
            echo "Error: Número máximo de intentos alcanzado. Pedido no procesado.<br>";
        }
    }

    /**
     * Verifica si el error es un deadlock.
     */
    private function esDeadlock($e) {
        // Ajusta el mensaje según la base de datos que uses
        return strpos($e->getMessage(), 'Deadlock') !== false;
    }

    /**
     * Registra en la tabla de auditoría el error y la transacción fallida.
     */
    private function registrarAuditoria($pedido_id, $mensaje) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO auditoria (pedido_id, mensaje, fecha) VALUES (?, ?, NOW())");
            $stmt->execute([$pedido_id, $mensaje]);
            echo "Error registrado en auditoría.<br>";
        } catch (PDOException $e) {
            echo "Error al registrar auditoría: " . $e->getMessage() . "<br>";
        }
    }
}

// Ejemplo de uso
$pedidoManager = new PedidoManager($pdo);

// Ejemplo de items para un pedido
$items = [
    ['producto_id' => 1, 'cantidad' => 2],
    ['producto_id' => 2, 'cantidad' => 3],
    ['producto_id' => 3, 'cantidad' => 1]
];

$pedidoManager->procesarPedido(1, $items);
?>
