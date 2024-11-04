<?php
class Paginator {
    private $pdo;
    private $table;
    private $perPage;
    private $page;

    public function __construct($pdo, $table, $perPage = 10) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->perPage = $perPage;
    }

    public function setPage($page) {
        $this->page = max(1, (int)$page);
    }

    public function getResults() {
        $offset = ($this->page - 1) * $this->perPage;
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $this->perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageInfo() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");
        $totalItems = $stmt->fetchColumn();
        return [
            'current_page' => $this->page,
            'per_page' => $this->perPage,
            'total_items' => $totalItems,
            'total_pages' => ceil($totalItems / $this->perPage)
        ];
    }
}
?>
