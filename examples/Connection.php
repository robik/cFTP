<?php
 /**
  * Example #1:
  *     Connecting to FTP server
  * 
  * @package Examples
  * @desc Very basic example how to connect to ftp server. Do not use it in with out Exception-catching.
  */

# Include cFTP_Autoloader
 include '../lib/cFTP/Autoload.php';


# Where to connect
 $ftp_host = 'ftp.mozilla.org';
 
# Some set-up
 $ftp_connection = new cFTP_Connection( $ftp_host ); 
 $ftp =            new cFTP_Session();

 
 $ftp->connect($ftp_connection); 
 
# Login (default as anonymous)
 $ftp->login();
 
# If passive mode is required
#  Note: Passive mode must be set after successful login
 # $ftp->setPassiveMode(true);
 
echo 'If you see this text only, it probably means that we have successfully connected.';
  
# Close the connection
 $ftp->close();  
?>
