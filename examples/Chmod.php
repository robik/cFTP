<?php
 /**
  * Example #9:
  *     Change file mode
  * 
  * @package Examples
  * @desc This example shows how to change file mode
  */

# Include cFTP_Autoloader
 include '../lib/cFTP/Autoload.php';

 
# Where to connect
 $ftp_host = 'ftp.mozilla.org';
 
# Some set-up
 $ftp_connection = new cFTP_Connection( $ftp_host ); 
 $ftp =            new cFTP_Session();
 
 try
 {
     $ftp->connect($ftp_connection);

    # Login (default as anonymous)
     $ftp->login(); 
     $root = $ftp->dir();
     
     if( !$root->childExists('foo.txt') )
         die("File doesn't exists");
     
     # Create new Chmod helper
     $chmod = new cFTP_Chmod;
     $chmod->setEveryoneAccessMode( cFTP_Chmod::READ );
     $chmod->setGroupAccessMode( cFTP_Chmod::READ_WRITE );
     $chmod->setOwnerAccessMode( cFTP_Chmod::FULL );
     
     $root->file('foo.txt')->changeMode($chmod);

    # Close the connection
     $ftp->close();
 }
 catch( cFTP_Exception $e)
 {
     switch( $e->getCode() )
     {
         case cFTP_ExceptionCodes::Connect:
             echo 'Could not connect';
         break;
         
         case cFTP_ExceptionCodes::Login:
             echo 'Could not login';    
         break;
         
         case cFTP_ExceptionCodes::Chmod:
             echo 'Could not download file';
         break;
        default:
            echo 'Unknown error occured';
     }
 }
?>
