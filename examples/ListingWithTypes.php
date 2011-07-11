<?php
 /**
  * Example #3:
  *     Listing items in directory with detecting type
  * 
  * @package Examples
  * @desc This example lists file  with determining item type
  */

# Include cFTP_Autoloader
 include '../lib/cFTP/Autoload.php';


# Where to connect
 $ftp_host = 'ftp.mozilla.org';
 
# Some set-up
 $ftp_connection = new cFTP_Connection( $ftp_host ); 
 $ftp =            new cFTP_Session($ftp_connection); # Note the diffrent way to connect

 
# Login (default as anonymous)
 $ftp->login();
 
 $items = $ftp->dir('.')->listAdvanced();
 foreach( $items as $item )
 {
     if( $item instanceof cFTP_Directory )
         echo 'Directory ';
     else
         echo 'File ';
     
        echo '<b>'.$item->getName().'</b> found <br/>';
 }
  
# Close the connection
 $ftp->close();
 
?>
