<?php
 /**
  * Example #7:
  *     Catching Exceptions v2
  * 
  * @package Examples
  * @desc This example shows how to catch exceptions v2
  */

# Include cFTP_Autoloader
 include '../lib/cFTP/Autoload.php';

 
# Where to connect
 $ftp_host = 'fttp.mozilla.org';
 
# Some set-up
 $ftp_connection = new cFTP_Connection( $ftp_host ); 
 $ftp =            new cFTP_Session();
 
 try
 {
     $ftp->connect($ftp_connection);

    # Login (default as anonymous)
     $ftp->login(); 

    # Close the connection
     $ftp->close();
 }
 catch( cFTP_Exception $e)
 {
     if( $e->getCode() == cFTP_ExceptionCodes::Connect )
     {
         echo 'Connection problem.';
     }
 }
?>
