<?php

// NOTICE: this file belongs to ADMIN-PANEL no use in captcha
// THIS CLASS HANDLES CONNECTIONS BETWEEN ADMIN-SCRIPTS AND DATABASE

require_once "includes/database_auth.php";

class Database 
{
    // declare attribute
    public $admin;
    private $mysql;

    // constructor
    public function __construct($admin_username = NULL , $admin_password = NULL) {
        $this->admin = FALSE;
        // set a new connection
        $this->mysql = new mysqli(
            DB_HOST_NAME,
            DB_USERNAME,
            DB_PASSWORD,
            (DB_DATABASE === '') ? NULL : DB_DATABASE 
        );
        // check if connection was succesful
        if ($this->mysql->connect_error) {
            die("Error due to connceting to database.");
        }
        // set charset to support Persian
        $this->mysql->set_charset("utf8");
        // check if user is a valid admin
        if( isset($admin_username) && isset($admin_password ) ){
            $sql = "SELECT * FROM `admin`";
            if ($this->mysql->multi_query($sql)) {
                do {
                    if ($result = $this->mysql->store_result()) {
                        while ($row = $result->fetch_row()) {
                            if ( trim($row[1]) === trim($admin_username) && $row[2] === md5($admin_password) ) {
                                $this->admin = TRUE;
                            }
                        }
                        $result->free();
                    }
                } while ($this->mysql->next_result());
            }
        }
    }
    // a function to execute single query
    public function query(string $query)
    {
        if( !$this->admin ) die("YOU ARE NOT ADMIN!");

        $this->clearStoredResults();
        $result = mysqli_query( $this->mysql , $query);
        if ($result === true) {
            return true;
        }elseif ($result === false) {
            return mysqli_error( $this->mysql );
        }elseif ( gettype($result) === "object") {
            if ( $result->num_rows > 0 ) {
                while($row = $result->fetch_assoc()) $return[] = $row;
                return $return;
            }
            else {
                return $result->fetch_assoc();
            }
        }else {
            return false;
        }
    }
    // a function to execute multi query
    public function multi_query(string $multi_query)
    {
        if( !$this->admin ) die("YOU ARE NOT ADMIN!");

        $this->clearStoredResults();
        $result = mysqli_multi_query( $this->mysql , $multi_query);
        if ($result === true) {
            return true;
        }elseif ($result === false) {
            return mysqli_error( $this->mysql );
        }elseif ( gettype($result) === "object") {
            if ( $result->num_rows > 0 ) {
                while($row = $result->fetch_assoc()) $return[] = $row;
                return $return;
            }
            else {
                return $result->fetch_assoc();
            }
        }else {
            return false;
        }
    }
    // a function to clear unnecessary stored result from mysql buffer
    private function clearStoredResults(){
        do {
             if ($res = $this->mysql->store_result()) {
               $res->free();
             }
            } while ($this->mysql->more_results() && $this->mysql->next_result());        
    
    }
}

?>