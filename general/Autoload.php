<?php

include 'Configuration.php';


Class Autoload extends Configuration{
    
    public $mohallaTable="mohalla";
    public $muminTable="mumin";
    
    function _construct() {
        parent::_construct();
    }
    
    public function Autoload_data($tb){
        
        parent::dbConnect();
        
        $data=array();
        
        $query="SELECT * FROM $tb";
        
        $result=  mysqli_query($query);
        
        while($row=  mysqli_fetch_array($result)){
            
            $data[]=$row;
        }
        parent::freedBResource();
        
        return $data;
    }
      public function sabilAutocomplete(){
        
        parent::dbConnect();
        
        $sabilnos=array();
        
        $query="SELECT sabilno FROM $this->muminTable";
        
        $result=  mysqli_query($query);
        
        while($row=  mysqli_fetch_array($result)){
            
         $sabilnos[]=$row['sabilno'];
        }
        parent::freedBResource();
        
        return $sabilnos;
    }
    
    public function DatabaseSearch($query){
       
         parent::dbConnect();
        
         $data=array();
        
         $result=  mysql_query($query);
        
         while($row=  mysql_fetch_array($result)){
            
         $data[]=$row;
        }
         parent::freedBResource();
        
        return $data;
    } 
    
    
    
}
?>
