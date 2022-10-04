<?php
include_once'Configuration.php';

Class Mumin extends Configuration{
     
       function _construct() {
      
       parent::_construct();
      
  }  
  
  public function getdbContent($query){
    
      
      
      $arraydata=array();
      
      $result= mysqli_query(parent::dbConnect(),$query);
     parent::freedBResource();
      while($row=  mysqli_fetch_assoc($result)){
         
         $arraydata[]=$row;
     }
      
     return $arraydata;
      
      
      
  }
  public function connectiondb (){
	  return parent::dbConnect();
  }
    public function getdbsectname($query){
    
      
      $arraydata=array();
      
      $result= mysqli_query(parent::dbConnect(),$query);
     parent::freedBResource();
      while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
       $arraydata['sector']=$row['sector'];
     }
      
     return $arraydata;
      
      
      
  }

  public function getdbtypename($query){
    
     // parent::dbConnect();
      
      $arraydata=array();
      
      $result= mysqli_query(parent::dbConnect(),$query);
     parent::freedBResource();
      while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
       $arraydata['type']=$row['type'];
     }
      
     return $arraydata;
      
      
      
  }
    public function sendSMS($query){
    
     // parent::dbConnect();
      
      $arraydata=array();
      
      $result= mysqli_query(parent::dbConnect(),$query);
     parent::freedBResource();
      while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
       $arraydata['type']=$row['type'];
     }
      
     return $arraydata;
      
      
      
  }
 public function insertdbContent($query){
    
         $isInserted=0;
       
        // parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),$query);
      
         
      
         if($result){
         
         $isInserted=1;
             
         }else{
			 $isInserted=0;
			 echo "Error:" .$query. "br".mysqli_error(parent::dbConnect());
			 die (mysqli_error(parent::dbConnect()));
		 }
        parent::freedBResource();
         return $isInserted;
    // die ($isInserted);
 }
 
 public function updatedbContent($query){
    
         $isUpdated=0;
       
         //parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),$query);
      
         parent::freedBResource();
      
         if($result){
         
         $isUpdated=1;
             
         }
        
         return $isUpdated;
      
          
  
 }
  public function freedb(){
    
          parent::freedBResource();
 
 }
  public function get_debtorName($dno){
    
        
        // parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),"SELECT debtorname FROM debtors WHERE dno = '$dno' LIMIT 1");
      
         parent::freedBResource();
      
         while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
          
           $dnames=$row['debtorname'];
         }
 
         return $dnames;
     
 }
   public function get_suplierName($sno){
    
        
         //parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),"SELECT suppName FROM suppliers WHERE supplier = '$sno' LIMIT 1");
      
         parent::freedBResource();
      
         while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
          
           $supnames=$row['suppName'];
         }
 
         return $supnames;
     
 }
   public function getsectorname($ejamaat){
    
      //parent::dbConnect();
      
      $result= mysqli_query(parent::dbConnect(),"SELECT sector FROM mumin WHERE ejno = '$ejamaat' LIMIT 1");;
        parent::freedBResource();
      while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
       $sctname=$row['sector'];
     }
      
     return $sctname;
      
      
      
  }
     public function getdepartname($deptid){
    
     // parent::dbConnect();
      
      $result= mysqli_query(parent::dbConnect(),"SELECT deptname FROM department WHERE deptid = '$deptid' LIMIT 1");;
        parent::freedBResource();
      while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
       $sctname=$row['deptname'];
     }
      
     return $sctname;
      
      
      
  }
       public function getcostcentername($costcntrtid){
    
      //parent::dbConnect();
      
      $result= mysqli_query(parent::dbConnect(),"SELECT centrename FROM department2 WHERE id = '$costcntrtid' LIMIT 1");
        parent::freedBResource();
      while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
       $sctname=$row['centrename'];
     }
      
     return $sctname;
      
      
      
  }
   public function getexpnseactname($expenseid){
    
      //parent::dbConnect();
      
      $result= mysqli_query(parent::dbConnect(),"SELECT accname FROM expnseaccs WHERE id = '$expenseid' LIMIT 1");;
        parent::freedBResource();
      while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
       $sctname=$row['accname'];
     }
      
     return $sctname;
  }
     public function getincmename($incmeid){
    
      //parent::dbConnect();
      
      $result= mysqli_query(parent::dbConnect(),"SELECT accname FROM incomeaccounts WHERE incacc = '$incmeid' LIMIT 1");
        parent::freedBResource();
      while($row=  mysqli_fetch_array($result)){
         
       $incmeactname=$row['accname'];
     }
      
     return $incmeactname;
  }
   public function getbankname($bankid){
    
     // parent::dbConnect();
      
      $result= mysqli_query(parent::dbConnect(),"SELECT CONCAT(acname,' : ',acno) AS acname FROM bankaccounts WHERE bacc = '$bankid' LIMIT 1");;
        parent::freedBResource();
      while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
       $bnkctname=$row['acname'];
     }
      
     return $bnkctname;
      
      
      
  }
 public function get_MuminNames($ejno){
    
        
       //  parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),"SELECT * FROM mumin WHERE ejno LIKE '$ejno' LIMIT 1");
      
         parent::freedBResource();
      
         while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
          if($row['mstat']=="Married" || $row['mstat']=="Maried" || $row['mstat']=="married" || $row['mstat']=="M" || $row['mstat']=="maried" ){
            
                if($row['sex']=="Male" || $row['sex']=="M" || $row['sex']=="MALE" ){
                  
                 $names=$row['fprefix']." ".$row['fname']." ".$row['dadname']." ".$row['sname']; 
                 
              }
              else{
             
            $names=$row['fprefix']." ".$row['fname']." ".$row['husband']." ".$row['sname'];
              }
            }
            
           else{ 
           $names=$row['fprefix']." ".$row['fname']." ".$row['dadname']." ".$row['sname'];
            } 
         }
 
         return $names;
     
 }
public function getPrevKey($key, $hash = array())
{
    $keys = array_keys($hash);
    $found_index = array_search($key, $keys);
    if ($found_index === false || $found_index === 0)
        return false;
    return $keys[$found_index-1];
}
  public function get_houseno($ejno){
    
        
        // parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),"SELECT hseno FROM mumin WHERE ejno LIKE '$ejno' LIMIT 1");
      
         parent::freedBResource();
      
         while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
          $hseno = $row ['hseno'];
         }
 
         return $hseno;
     
 }
 
 public function get_MuminHofNamesFromSabilno($sabilno){
    
        
         //parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),"SELECT hofej FROM mumin WHERE sabilno LIKE '$sabilno' AND ejno=hofej LIMIT 1");
      
         parent::freedBResource();
      
         while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
         $hofej=$row['hofej'];
             
         }
       return $this->get_MuminNames($hofej);
         
     
 }
 
 
 
 
 public function get_MuminHofEjnoFromSabilno($sabilno){
    
        
        // parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),"SELECT hofej FROM mumin WHERE sabilno LIKE '$sabilno' AND ejno=hofej LIMIT 1");
      
         parent::freedBResource();
      
         while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
         $hofej=$row['hofej'];
             
         }
       return @$hofej;
         
     
 }
 
 
 
 public function get_MuminHof($ejno){
    
        
        // parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),"SELECT hofej FROM mumin WHERE ejno LIKE '$ejno' LIMIT 1");
      
         parent::freedBResource();
      
         while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
         $hofej=$row['hofej'];
             
         }
        
         return $hofej;
     
 }
 
 
 public function get_Muminsabilno($ejno){
    
        
        // parent::dbConnect();
      
         $result= mysqli_query(parent::dbConnect(),"SELECT sabilno FROM mumin WHERE ejno LIKE '$ejno' LIMIT 1");
      
         parent::freedBResource();
      
         while($row=  mysqli_fetch_array($result,MYSQLI_ASSOC)){
         
         $sabilno=$row['sabilno'];
             
         }
        
         return $sabilno; 
     
 }
 
 
 
  public function refnos($fieldname){
      
    // parent::dbConnect();
     //$mohl = $_SESSION['est_prop'];
     //$qry = "SELECT mohalla FROM anjuman_estates WHERE id LIKE '$mohl' LIMIT 1";
      //$data1=  $this->getdbContent($qry);     
      $estate = $_SESSION['dept_id'];   
     $Instruct="UPDATE refnos SET $fieldname=$fieldname + 1 WHERE est_id LIKE '$estate'";

     $FetchCounter="SELECT $fieldname FROM refnos where est_id LIKE '$estate'";
     
     $result=mysqli_query(parent::dbConnect(),$Instruct);
   
     if($result){
        
     $result1= mysqli_query(parent::dbConnect(),$FetchCounter);
   
     while($row=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
         
     $semiRefinedCounter=$row[$fieldname];
         
     }
    }
   
       return $semiRefinedCounter;
    
    
    }
    
    
      public function Autoload_data($tb){
        
      //  parent::dbConnect();
        
        $data=array();
        
        $query="SELECT * FROM $tb";
        
        $result=  mysqli_query(parent::dbConnect(),$query);
        
        while($row=  mysqli_fetch_array($result)){
            
            $data[]=$row;
        }
        parent::freedBResource();
        
        return $data; 
    }
    
 function numWords($num){
  // error_reporting(E_ALL);
//ini_set('display_errors', 1);
     
   list($num,$dec) = explode(".",$num);    //split number given into normal and decimal parts 

   $output = "";

   if($num{0} == "-")    // checking the first character in the number, if it is a negative - 
   {
      $output = "negative ";
      $num = ltrim($num, "-");   //left trim the number; i.e remove the -ve sign
   }
   else if($num{0} == "+")    // checking the first character in the number, if it is a positive + 
   {
      $output = "positive ";
      $num = ltrim($num, "+");    //left trim the number; i.e remove the +ve sign
   }
   
   if($num{0} == "0")
   {
      $output .= "zero";
   }
   else
   {
      $num = str_pad($num, 36, "0", STR_PAD_LEFT);  // Pads a the $num to a total length of 36 with zero's on its left side
      $group = rtrim(chunk_split($num, 3, " "), " ");  
	      // chunk_split() - Split a string into smaller chunks of three's
	      // rtrim() - Strips whitespace (or other characters) from the end of a each string/number 
	  
      $groups = explode(" ", $group);  //Split a string by string

      $groups2 = array();
      foreach($groups as $g) $groups2[] = $this->convertThreeDigit($g{0}, $g{1}, $g{2});

      for($z = 0; $z < count($groups2); $z++)
      {
         if($groups2[$z] != "")
         {
            $output .= $groups2[$z].  $this->convertGroup(11 - $z).($z < 11 && !array_search('', array_slice($groups2, $z + 1, -1))
             && $groups2[11] != '' && $groups[11]{0} == '0' ? " and " : ", ");
         }
      }

      $output = rtrim($output, ", ");
   }

   if($dec > 0)
   {
      $output .= "  point";
      for($i = 0; $i < strlen($dec); $i++) 
	  $output .= " ".  $this->convertDigit($dec{$i});
   }

   return $output;
}




function convertGroup($index)
{
   switch($index)
   {
      case 11: return " decillion";
      case 10: return " nonillion";
      case 9: return " octillion";
      case 8: return " septillion";
      case 7: return " sextillion";
      case 6: return " quintrillion";
      case 5: return " quadrillion";
      case 4: return " trillion";
      case 3: return " billion";
      case 2: return " million";
      case 1: return " thousand";
      case 0: return "";
   }
}

function convertThreeDigit($dig1, $dig2, $dig3)
{
   $output = "";

   if($dig1 == "0" && $dig2 == "0" && $dig3 == "0") return "";

   if($dig1 != "0")
   {
      $output .= $this->convertDigit($dig1)." hundred";
      if($dig2 != "0" || $dig3 != "0") $output .= " and ";
   }
 
   if($dig2 != "0") $output .= $this->convertTwoDigit($dig2, $dig3);      
   else if($dig3 != "0") $output .=$this-> convertDigit($dig3);

   return $output;
}

function convertTwoDigit($dig1, $dig2)
{
   if($dig2 == "0")
   {
      switch($dig1)
      {
         case "1": return "ten";
         case "2": return "twenty";
         case "3": return "thirty";
         case "4": return "forty";
         case "5": return "fifty";
         case "6": return "sixty";
         case "7": return "seventy";
         case "8": return "eighty";
         case "9": return "ninety";
      }
   }
   else if($dig1 == "1")
   {
      switch($dig2)
      {
         case "1": return "eleven";
         case "2": return "twelve";
         case "3": return "thirteen";
         case "4": return "fourteen";
         case "5": return "fifteen";
         case "6": return "sixteen";
         case "7": return "seventeen";
         case "8": return "eighteen";
         case "9": return "nineteen";
      }
   }
   else
   {
      $temp = $this->convertDigit($dig2);
      switch($dig1)
      {
         case "2": return "twenty-$temp";
         case "3": return "thirty-$temp";
         case "4": return "forty-$temp";
         case "5": return "fifty-$temp";
         case "6": return "sixty-$temp";
         case "7": return "seventy-$temp";
         case "8": return "eighty-$temp";
         case "9": return "ninety-$temp";
      }
   }
}
      
function convertDigit($digit)
{
   switch($digit)
   {
      case "0": return "zero";
      case "1": return "one";
      case "2": return "two";
      case "3": return "three";
      case "4": return "four";
      case "5": return "five";
      case "6": return "six";
      case "7": return "seven";
      case "8": return "eight";
      case "9": return "nine";
   }
}  




}
?>