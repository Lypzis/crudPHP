<?php
class Address{
  private $pdo = null;
  private $stmt = null;

  // will automatically attempt to connect to the 
  // database when a new address object is created
  function __construct(){
    try {
      $this->pdo = new PDO(
        "mysql:host=".MYSQL_HOST.";dbname=".MYSQL_NAME.";charset=".MYSQL_CHAR,
        MYSQL_USER, MYSQL_PASS, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
        ]
      );
    } catch (Exception $ex) { die($ex->getMessage()); }
  }

  // Will automatically close the database connection when the
  // address object is being destroyed.
  function __destruct(){
    if ($this->stmt!==null) { $this->stmt = null; }
    if ($this->pdo!==null) { $this->pdo = null; }
  }

  // Runs a given SQL database entry
  function query($sql, $cond=[]){
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) { 
      $this->error = $ex->getMessage();
      return false;
    }
    $this->stmt = null;
    return true;
  }

  // Adds a new address book entry
  function create($address){
    return $this->query(
      "INSERT INTO `address_book` (`address`) VALUES (?)",
      [$address]
    );
  }

  // Gets all address book entries from the database
  function read(){
    $this->stmt = $this->pdo->prepare("SELECT * FROM `address_book`");
    $this->stmt->execute();
    $entries = $this->stmt->fetchAll();
    return count($entries)==0 ? false : $entries ;
  }

  // Update an address book entry
  function update($address, $id){
    return $this->query(
      "UPDATE `address_book` SET `address`=? WHERE `id`=?",
      [$address, $id]
    );
  }

  // Delete an address book entry
  function delete($id){
    return $this->query(
      "DELETE FROM `address_book` WHERE `id`=?",
      [$id]
    );
  }
}
?>