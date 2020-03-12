<?php  
  

  class Transaction{

    private static $con;
    private static $logger;

    private function __construct() {

    }

    public static function open($database){
      if (empty(self::$con)) {

        //echo "passou auqi "; 
        self::$con = Connection::open($database);
        self::$con->beginTransaction();
        self::$logger = NULL;
      }

    }

    public static function get(){

      return self::$con;
    }

    public static function rollback(){

      if (self::$con) {
        self::$con->rollback();
        self::$con = null;
      }
    }

    public static function close(){

      if (self::$con) {
        self::$con->commit(); // aplica as operações realiadas
        self::$con = null;
      }
    }

    public static function setLogger(Logger $logger){
      self::$logger = $logger;
    }

    public static function log($message){
      if (self::$logger) {
          self::$logger->write($message);
      }
    }

  }


 ?>
