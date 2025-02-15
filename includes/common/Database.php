<?php


class Database
{
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "restaurant_db";
  

    public $mysqli;
    private $table;
    private $addedSuccess = "added successfully";
    private $updatedSuccess = "updated successfully";
    private $deletedSuccess = "deleted successfully";




    public function __construct()
    {
        try {

            $this->mysqli = new mysqli(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::DATABASE);
        } catch (Exception $e) {
            die("connection failed: " . $e->getMessage()); 
        }
    }


    public function table($table)
    {
        $this->table = $table;
        return $this;
    }


    public function insert($data)
    {

        $names = ""; 
        $values = ""; 
        foreach ($data as $key => $value) {
            $names .= "`$key`,"; //  comma for multible data
            $values .= "'$value',"; //  
        }

        $names = substr($names, 0, -1); // to remove comma in the end 
        $values = substr($values, 0, -1);


        $query = " INSERT INTO `$this->table` ($names) VALUES ($values) ";
        $result = $this->mysqli->query($query);

        if ($result) 
        {
            return $this->addedSuccess;
        } else {
            $_SESSION["errors"][] = "Error in insertion";
        }
    }



    public function read($columns = "*")
    {

        try {
            $query = " SELECT $columns FROM `$this->table` ";
            $result = $this->mysqli->query($query);
            $data = [];
            if ($result) {
                try {

                    if ($result->num_rows) // to check if found data or not
                    {
                        while ($row = $result->fetch_assoc()) {
                            $data[] = $row;
                        }
                    }

                    return $data;
                    

                } catch (Exception $e) {
                    die("Error : " . $e->getMessage());
                       
                }
            }
        } catch (Exception $e) {
            die("Error : " . $e->getMessage());
        }
    }


    public function update($data, $condition)
    {
        try {
            $fields = [];
            foreach ($data as $key => $value) {
                
                $escapedValue = $this->mysqli->real_escape_string($value);
                $fields[] = "`$key` = '$escapedValue'";
            }

            $setClause = implode(', ', $fields);

            $whereClause = '';
            if (!empty($condition)) {
                $conditions = [];
                foreach ($condition as $key => $value) {
                    $escapedValue = $this->mysqli->real_escape_string($value);
                    $conditions[] = "`$key` = '$escapedValue'";
                }
                $whereClause = 'WHERE ' . implode(' AND ', $conditions);
            }

            $query = "UPDATE `$this->table` SET $setClause $whereClause";
            $result = $this->mysqli->query($query);

            if ($result) {
                if ($this->mysqli->affected_rows > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $_SESSION["errors"][] = "Failed to execute the update query";
            }

        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }


    public function delete($condition)
    {
        try {
            $whereClause = '';
            if (!empty($condition)) {
                $conditions = [];
                foreach ($condition as $key => $value) {
                    $escapedValue = $this->mysqli->real_escape_string($value);
                    $conditions[] = "`$key` = '$escapedValue'";
                }
                $whereClause = 'WHERE ' . implode(' AND ', $conditions);
            }

            $query = "DELETE FROM `$this->table` $whereClause";
            $result = $this->mysqli->query($query);
            
            if ($result) {
                return true; 
            } else {
                return false;
            }
        } catch (Exception $e) {
            die("Error : " . $e->getMessage());
        }
    }




    public function find($value, $column = 'id')
    {
        $escapedValue = $this->mysqli->real_escape_string($value);
        $escapedColumn = "`" . str_replace("`", "``", $column) . "`";
        
        $query = "SELECT * FROM `$this->table` WHERE $escapedColumn = '$escapedValue'";
        $result = $this->mysqli->query($query);

        if ($result) {
            if ($result->num_rows) {
                return $result->fetch_assoc();
            }
            return false;
        } else {
            $_SESSION["errors"][] = "data not exists";
        }
    }


    public function encPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }




    public function __destruct()
    {
        $this->mysqli->close();
    }
}

