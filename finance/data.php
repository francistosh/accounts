
<?php
// Connect to MySQL
$link = mysql_connect( 'localhost', 'root', 'itc' );
if ( !$link ) {
  die( 'Could not connect: ' . mysql_error() );
}

// Select the data base
$db = mysql_select_db( 'jims2', $link );
if ( !$db ) {
  die ( 'Error selecting database \'jims2\' : ' . mysql_error() );
}

// Fetch the data
$query = "
  SELECT incomeaccounts.accname,sum(amount) as amount FROM `invoice`,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc group by invoice.incacc";
$result = mysql_query( $query );

// All good?
if ( !$result ) {
  // Nope
  $message  = 'Invalid query: ' . mysql_error() . "\n";
  $message .= 'Whole query: ' . $query;
  die( $message );
}

$data = array();
while ( $row = mysql_fetch_assoc( $result ) ) {
  $data[] = $row;
}
echo json_encode( $data );

// Close the connection
mysql_close($link);
?>