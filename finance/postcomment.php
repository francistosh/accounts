<?php

      session_start();
      
      include 'operations/Mumin.php';
  
      $mumin=new Mumin();
    

      $action=$_GET['action'];
      
      if($action=="post"){
      
      $post=  mysql_escape_string($_POST['mycomment']);
      
      $user=$_SESSION['uname'];  
      
 
     $qu="INSERT INTO posts (id,text,user)VALUES (0,'$post','$user')";   
     
     $id=$mumin->insertdbContent($qu);
     
     header('Location: posts.php'); 
 
      }
      
      else{
          
          
     $postId=$_GET['postid'];
     
     $qu="DELETE FROM posts WHERE id LIKE '$postId'";   
     
     $id=$mumin->insertdbContent($qu);
     
     header('Location: posts.php'); 
          
          
      }
?>
