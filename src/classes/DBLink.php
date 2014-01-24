<?php
abstract class DBLink{
    private static $conn;

    private function __construct()
    {
    }

    public static function getInstance() {
        if(isset(self::$conn) && self::$conn){
          return self::$conn;
        }
        else{
            try{
                self::$conn = new PDO('mysql:host='.config::$DB_SERVER.';dbname='. config::$DB_NAME . ';charset=UTF8', config::$DB_USER, config::$DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));//Use persistent connection, since the search mechanism causes numerious concurrent and subsequent requests to the db
                self::$conn->exec("SET NAMES utf8"); // Tell the db that we use utf-8 
                self::$conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); //for heavy traffic optimization
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_PERSISTENT, true);//Use persistent connection, since the search mechanism causes numerious concurrent and subsequent requests to the db
                return self::$conn;
             }
            catch (PDOException $e) {
                Debugger::HandleException($e);
            }
        }  

    }
    public function __destruct() {
        $conn = null;
    }


}  
?>
