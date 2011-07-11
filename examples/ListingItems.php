<?php
 /**
  * Example #2:
  *     Listing items in directory
  * 
  * @package Examples
  * @desc This example shows how to list items in directory
  */

# Include cFTP_Autoloader
 include '../lib/cFTP/Autoload.php';


# Where to connect
 $ftp_host = 'ftp.mozilla.org';
 
# Some set-up
 $ftp_connection = new cFTP_Connection( $ftp_host ); 
 $ftp =            new cFTP_Session();
 
# Connect
 $ftp->connect($ftp_connection);
 
# Login (default as anonymous)
 $ftp->login();

# Loop items and print 'em
 $items = $ftp->dir('.')->listItems(); 
 foreach( $items as $item )
 {
     echo "<b>$item</b> found <br/>";
 }
  
# Close the connection
 $ftp->close();
 
?>
