<?php

interface  setup{    //interface class implemented by all classes
  
    public function dbConnect();
    
    public function freedBResource();
    
}

Class Configuration implements setup{
 
  public $dbHost="localhost";
  
  public $pword="mysql";
  
  public $username="root";
  
  public $dbname="jims";
  
  public $dbhandle;
   

function _construct(){ 
    
    date_default_timezone_set('Africa/Nairobi'); //Global timezone -Used throughout application
    
}
public function dbConnect(){
    
    $conn= mysqli_connect($this->dbHost, $this->username, $this->pword,$this->dbname);//Connect to a database
if (!$conn){
	die("connection failded".mysqli_connect_errno());
}
  return $conn;
  
 }
 
 public function freedBResource(){
     
      $close= mysqli_close($this->dbConnect()); //Free database resources after transactions
 }
 
 /*public function DatabaseConnection(setup $s){
     
     $s->dbConnect();
     
     $s->freedBResource();
 }*/
 }
?>
