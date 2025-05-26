<?php

  require_once 'core/init.php';
  require_once 'classes/Config.php';

  class DB {

    private static $_instance = null;
    private $_pdo;
    private $_result;
    private static $_test = null;

    private function __construct() {

      try {
        $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
      } catch(PDOException $e) {
        if(isset(self::$_test)){
          return true;
        }else{
          die($e->getMessage());
        }
      }
    }

    public static function getInstance(string $test = null) {

      if(isset($test)){
        self::$_test = true;
      }

      if(!isset(self::$_instance)){
        self::$_instance = new DB();
      }

      return self::$_instance;
    }

    public function getData(string $column, string $table, array $detail = null, bool $test = null): array|string {
      $sql = "SELECT {$column} FROM {$table}";

      if(isset($detail)){
        $detail = implode(" ", $detail);
        $sql = $sql . " WHERE " . $detail;

        if(isset($test)){
          return $sql;
        }
      }

      $giveOrder = $this->_pdo->prepare($sql);
      $giveOrder->execute();

      return $giveOrder->fetchAll();

    }

    public function deleteData(string $table, string $id): void {

      $sql = "DELETE FROM " . $table . " WHERE id = ?";

      $giveOrder = $this->_pdo->prepare($sql);
      $giveOrder->execute([$id]);
    }

    public function addData(string $table, array $data, bool $test = null): bool|string {

      $indexKeys = implode(', ', array_keys($data));

      $indexValues = array_keys($data);

      $increment = 0;
      $amountValues = array();
      $executePath = array();

      foreach($indexValues as $val){
        $increment++;
        $amountValues[$increment] = "?";
      };

      $amountValues = implode(", ", $amountValues);

      $sql = "INSERT INTO {$table}(" . "{$indexKeys}" . ") VALUES (" . "{$amountValues}" . ")";

      if(isset($test)){
        return $sql;
      }

      if($giveOrder = $this->_pdo->prepare($sql)){
        $increment = 0;
        $values = array_values($data);

        foreach($values as $val){
          $giveOrder->bindParam($increment+1, $values[$increment]);
          $increment++;
        };

        $giveOrder->execute();

        return true;

      }else{

        return false;

      }
    }

    public function updateData(string $table, array $newData, string $id, bool $test = null): bool|string {

      $dataKeys = array_keys($newData);

      $queryData = array();

      foreach($dataKeys as $key){
        array_push($queryData, $key . " = ?");
      };

      $queryData = implode(', ', $queryData);

      $sql = "UPDATE {$table} SET {$queryData} WHERE id = {$id}";

      if(isset($test)) {
        return $sql;
      }

      if($giveOrder = $this->_pdo->prepare($sql)) {

        $dataValues = array_values($newData);

        $increment = 0;

        foreach($dataValues as $val){
          $giveOrder->bindParam($increment+1, $dataValues[$increment]);
          $increment++;
        }

        $giveOrder->execute();

        return true;

      }else{

        return false;

      }

    }


  }


?>
