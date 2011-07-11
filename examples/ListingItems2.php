<?php
 /**
  * Example #4:
  *     Listing items in directory v2
  * 
  * @package Examples
  * @desc This example shows how to list items in directory using callback
  */

# Include cFTP_Autoloader
 include '../lib/cFTP/Autoload.php';


# Where to connect
 $ftp_host = 'ftp.mozilla.org';
 
# Some set-up
 $ftp_connection = new cFTP_Connection( $ftp_host ); 
 $ftp =            new cFTP_Session($ftp_connection);

 
# Login (default as anonymous)
 $ftp->login(); 

# Following code is avaible only on PHP version > 5.3, 
# if you want to do same thing on PHP version lower than 5.3 use create_function()
 $items = $ftp->dir('.')->walk( 
    function( cFTP_Item $e )
    {
        echo '<b>'.$e->getName().'</b> found <br/>';
    });
 
  
# Close the connection
 $ftp->close();
?>
