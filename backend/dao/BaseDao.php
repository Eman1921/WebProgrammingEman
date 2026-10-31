<?php

require_once __DIR__ . '/../config/config.php';

class BaseDao
{
    private static ?PDO $connection = null;
    protected string $table_name;
    protected array $columns;

    public function __construct(string $table_name, array $columns = [])
    {
        $this->table_name = $table_name;
        $this->columns = $columns;
    }

    private static function connection(): PDO
    {
        if (self::$connection === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST()
                . ';dbname=' . Config::DB_NAME()
                . ';charset=utf8mb4';

            self::$connection = new PDO(
                $dsn,
                Config::DB_USER(),
                Config::DB_PASSWORD(),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }

        return self::$connection;
    }

    protected function query(string $query, array $params = []): array
    {
        $statement = self::connection()->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    protected function query_unique(string $query, array $params = []): ?array
    {
        $rows = $this->query($query, $params);
        return $rows[0] ?? null;
    }

    protected function execute(string $query, array $params = []): int
    {
        $statement = self::connection()->prepare($query);
        $statement->execute($params);
        return $statement->rowCount();
    }

    protected function only_columns(array $entity): array
    {
        return array_intersect_key($entity, array_flip($this->columns));
    }

    public function get_all(): array
    {
        return $this->query("SELECT * FROM {$this->table_name} ORDER BY id");
    }

    public function get_by_id(int $id): ?array
    {
        return $this->query_unique(
            "SELECT * FROM {$this->table_name} WHERE id = :id",
            ['id' => $id]
        );
    }

    public function count_all(): int
    {
        $result = $this->query_unique("SELECT COUNT(*) AS total FROM {$this->table_name}");
        return (int) $result['total'];
    }

    public function add(array $entity): array
    {
        $entity = $this->only_columns($entity);

        if (count($entity) === 0) {
            throw new Exception('No writable columns were provided.');
        }

        $columns = array_keys($entity);
        $query = "INSERT INTO {$this->table_name} ("
            . implode(', ', $columns)
            . ') VALUES (:' . implode(', :', $columns) . ')';

        $this->execute($query, $entity);
        $entity['id'] = (int) self::connection()->lastInsertId();
        return $entity;
    }

    public function update(array $entity, int $id): bool
    {
        $entity = $this->only_columns($entity);

        if (count($entity) === 0) {
            return false;
        }

        $fields = [];
        foreach (array_keys($entity) as $column) {
            $fields[] = "$column = :$column";
        }

        $entity['id'] = $id;
        $query = "UPDATE {$this->table_name} SET "
            . implode(', ', $fields)
            . ' WHERE id = :id';

        return $this->execute($query, $entity) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->execute(
            "DELETE FROM {$this->table_name} WHERE id = :id",
            ['id' => $id]
        ) > 0;
    }

    public function begin_transaction(): void
    {
        self::connection()->beginTransaction();
    }

    public function commit(): void
    {
        self::connection()->commit();
    }

    public function rollback(): void
    {
        self::connection()->rollBack();
    }
}
