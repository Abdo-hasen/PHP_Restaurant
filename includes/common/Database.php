<?php


class Database
{
    // database information
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "restaurant_db";
  

    //helper properties
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


    // take table of db

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    // insert data in db

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


    // read data from db

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



    // update data in db
    public function update($data, $condition)
{
    try {
        $fields = [];
        foreach ($data as $key => $value) {
            // Escape the value to prevent SQL injection
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
                $_SESSION["success"] = $this->updatedSuccess;
            } else {
                $_SESSION["errors"][] = "No changes were made"; 
            }
        } else {
            $_SESSION["errors"][] = "Failed to execute the update query";
        }


    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}


    // delete data in db 

    public function delete($id)
    {

        try {

            $query = "DELETE FROM `$this->table` WHERE `id`='$id'";
            $result = $this->mysqli->query($query);
            if ($result) {
                $_SESSION["success"] =  $this->deletedSuccess;
                redirect(URL);
            } else {
                $_SESSION["errors"][] = "No changes done";
                redirect(URL);
            }
        } catch (Exception $e) {
            die("Error : " . $e->getMessage());
        }
    }



    // find id in db - get data of specefic item 

    public function find($id)
    {
        $query = " SELECT * FROM `$this->table` WHERE `id` = '$id' ";
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

    // fn to encrypt

    public function encPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }



    // close connection

    public function __destruct()
    {
        $this->mysqli->close();
    }
}

