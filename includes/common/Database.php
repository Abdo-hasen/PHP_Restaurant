<?php

class Database
{
    // Database information
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "restaurant_db";

    // Helper properties
    public $mysqli;
    private $table;
    private $query = '';
    private $where = '';
    private $join = '';

    public function __construct()
    {
        try {
            $this->mysqli = new mysqli(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::DATABASE);
            if ($this->mysqli->connect_error) {
                throw new RuntimeException("Connection failed: " . $this->mysqli->connect_error);
            }
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw $e;
        }
    }

    // Set the table name
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    // Add a SELECT clause
    public function select(string $columns = "*"): self
    {
        $this->query = "SELECT $columns FROM `$this->table`";
        return $this;
    }

    // Add a JOIN clause
    public function join(string $table, string $condition, string $type = 'INNER'): self
    {
        $this->join .= " $type JOIN `$table` ON $condition";
        return $this;
    }

    // Add a WHERE clause
    public function where(array $conditions): self
    {
        $this->where = ' WHERE ' . implode(' AND ', array_map(function ($key, $value) {
            return "`$key` = '$value'";
        }, array_keys($conditions), $conditions));
        return $this;
    }

    // Execute the query and fetch results
    public function get(): array
    {
        $query = $this->query . $this->join . $this->where;
        $result = $this->mysqli->query($query);

        if (!$result) {
            throw new RuntimeException("Query failed: " . $this->mysqli->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $result->free();
        return $data;
    }

    // Close the database connection
    public function close(): void
    {
        $this->mysqli->close();
    }
    // Insert data into the database
    public function insert(array $data): bool
    {
        if (empty($data)) {
            throw new InvalidArgumentException("Data array cannot be empty.");
        }

        $columns = implode('`, `', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $query = "INSERT INTO `$this->table` (`$columns`) VALUES ($placeholders)";

        try {
            $stmt = $this->mysqli->prepare($query);
            if (!$stmt) {
                throw new RuntimeException("Failed to prepare the insert query: " . $this->mysqli->error);
            }

            $types = $this->getParamTypes($data);
            $stmt->bind_param($types, ...array_values($data));

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            error_log("Insert error: " . $e->getMessage());
            throw $e;
        }
    }

    // Read data from the database
    public function read(string $columns = "*"): array
    {
        $query = "SELECT $columns FROM `$this->table`";

        try {
            $result = $this->mysqli->query($query);
            if (!$result) {
                throw new RuntimeException("Failed to execute the read query: " . $this->mysqli->error);
            }

            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $result->free();
            return $data;
        } catch (Exception $e) {
            error_log("Read error: " . $e->getMessage());
            throw $e;
        }
    }

    // Update data in the database
    public function update(array $data, array $condition): bool
    {
        if (empty($data)) {
            throw new InvalidArgumentException("Data array cannot be empty.");
        }

        $setClause = $this->prepareSetClause($data);
        $whereClause = $this->prepareWhereClause($condition);
        $query = "UPDATE `$this->table` SET $setClause $whereClause";

        try {
            $stmt = $this->mysqli->prepare($query);
            if (!$stmt) {
                throw new RuntimeException("Failed to prepare the update query: " . $this->mysqli->error);
            }

            $types = $this->getParamTypes($data) . $this->getParamTypes($condition);
            $params = array_merge(array_values($data), array_values($condition));
            $stmt->bind_param($types, ...$params);

            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            error_log("Update error: " . $e->getMessage());
            throw $e;
        }
    }

    // Delete data from the database
    public function delete($id, string $column = 'id'): bool
    {
        $query = "DELETE FROM `$this->table` WHERE `$column` = ?";

        try {
            $stmt = $this->mysqli->prepare($query);
            if (!$stmt) {
                throw new RuntimeException("Failed to prepare the delete query: " . $this->mysqli->error);
            }

            $stmt->bind_param('s', $id);
            $success = $stmt->execute();
            $stmt->close();

            return $success;
        } catch (Exception $e) {
            error_log("Delete error: " . $e->getMessage());
            throw $e;
        }
    }

    // Find a specific record by ID
    public function find($id, string $column = 'id'): ?array
    {
        $query = "SELECT * FROM `$this->table` WHERE `$column` = ?";

        try {
            $stmt = $this->mysqli->prepare($query);
            if (!$stmt) {
                throw new RuntimeException("Failed to prepare the find query: " . $this->mysqli->error);
            }

            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            return $row ?: null;
        } catch (Exception $e) {
            error_log("Find error: " . $e->getMessage());
            throw $e;
        }
    }

    // Encrypt password
    public function encPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Close the database connection
    public function __destruct()
    {
        $this->mysqli->close();
    }

    // Helper method to prepare SET clause for UPDATE
    private function prepareSetClause(array $data): string
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "`$key` = ?";
        }
        return implode(', ', $fields);
    }

    // Helper method to prepare WHERE clause
    private function prepareWhereClause(array $condition): string
    {
        if (empty($condition)) {
            return '';
        }

        $conditions = [];
        foreach ($condition as $key => $value) {
            $conditions[] = "`$key` = ?";
        }
        return 'WHERE ' . implode(' AND ', $conditions);
    }

    // Helper method to get parameter types for binding
    private function getParamTypes(array $data): string
    {
        $types = '';
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }
}