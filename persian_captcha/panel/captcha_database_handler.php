<?php

// THIS CLASS HANDLES CONNECTIONS BETWEEN CAPTCHA-SCRIPTS AND DATABASE

require_once "includes/database_auth.php";

class CaptchaDatabase 
{
    // declare attribute
    private $mysql;
    private $info;

    // constructor
    public function __construct() {
        $this->mysql = new mysqli(
            DB_HOST_NAME,
            DB_USERNAME,
            DB_PASSWORD,
            (DB_DATABASE === '') ? NULL : DB_DATABASE 
        );
        // check if connection was succesful
        if ($this->mysql->connect_error) {
            return FALSE;
        }
        // set charset to support Persian
        $this->mysql->set_charset("utf8");
        $this->info = $this->getInfo();
    }

    // a function that fetches a word from database
    public function getWord()
    {
        $this->clearStoredResults();
        $table_name = $this->info["selected_table"];
        $limit = $this->info["table_list"][$table_name];
        $sql = "SELECT * FROM `". $table_name ."` WHERE id = " . rand(1,$limit);
            if ($this->mysql->multi_query($sql)) {
                do {
                    if ($result = $this->mysql->store_result()) {
                        while ($row = $result->fetch_row()) {
                            $this->clearStoredResults();
                            return $row[1];
                        }
                        $result->free();
                    }
                } while ($this->mysql->next_result());
            }
            return FALSE;
    }

    // a function that gets current settings
    public function getInfo()
    {
        $this->clearStoredResults();
        $sql = "SELECT * FROM `setting`";
            if ($this->mysql->multi_query($sql)) {
                do {
                    if ($result = $this->mysql->store_result()) {
                        while ($row = $result->fetch_row()) {
                            $this->clearStoredResults();
                            return [
                                "captcha_type" => (int) $row[0],
                                "selected_table" => $row[1],
                                "table_list" => json_decode($row[2] , true)
                            ];
                        }
                        $result->free();
                    }
                } while ($this->mysql->next_result());
            }
            return FALSE;
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