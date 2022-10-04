<?php
 session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Income/expense Statement </title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color: #957c17; height:25px; }
.center{text-align: center;}
.left{text-align: left;}
a {
      text-decoration:none;
   }
    a:hover {text-decoration:underline;}
@media print
{ 
#printNot {display:none}

}
-->
</style>
<script>
  $(function() {
	  var itsnumbers=[];
	  var sabilnumbers=[];
       
         
		 $.getJSON("../estates/receipting.php?action=ejamaatnos", function(data) {
   
    $.each(data, function(i,item) {
         itsnumbers.push({label: item.ejno,value: item.ejno});  
       });
   
        });
          function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
      $( "#itsno" )
      // don't navigate away from the field on tab when selecting an item
      .on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            itsnumbers, extractLast( request.term ) ) );
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
      
 });
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;">

<?php 
$localIP = $_SERVER['REMOTE_ADDR'];
echo $localIP;

?>
</body>
</html>