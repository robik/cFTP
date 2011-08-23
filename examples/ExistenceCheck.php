<?php
 /**
  * Example #5:
  *     Checking item existence in directory
  * 
  * @package Examples
  * @desc This example checks existence of some directory
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
 $root = $ftp->getDirectory();

 $item = 'foo'; 
 
 echo "Item '$item' ";
 echo $root->childExists($item) ? 'exists' : 'doesn\'t exists'; 
 echo '<br />';
 
 $item = 'pub'; 
 
 echo "Item '$item' ";
 echo $root->childExists($item) ? 'exists' : 'doesn\'t exists';
 
  
# Close the connection
 $ftp->close();
 
?>
