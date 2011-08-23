<?php
/**
  * Example #8:
  *     Downloading and Uploading files
  * 
  * @package Examples
  * @desc This example shows how to upload and download file.
  */

# Include cFTP_Autoloader
 include '../lib/cFTP/Autoload.php';

 
# Where to connect
 $ftp_host = 'ftp.example.com';
 
# Some set-up
 $ftp_connection = new cFTP_Connection( $ftp_host ); 
 $ftp =            new cFTP_Session();
 
 try
 {
     $ftp->connect($ftp_connection);

    # Login (default as anonymous)
     $ftp->login();
     
     $root = $ftp->dir();
     $readme = $root->file('readme');
     
     if( !$root->childExists('readme') )
         die("File doesn't exists :(");
     
    # Download readme
     $readme->download('readme');
     
    # Do something on file...
     
    # Upload modified readme // Requires write privilege
     $readme->upload('readme');
             
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
         
         case cFTP_ExceptionCodes::Download:
             echo 'Could not download file';
         break;
         
         case cFTP_ExceptionCodes::Upload:
             echo 'Could not upload file';
         break;
     
        default:
            echo 'Unknown error occured';
     }
 }
?>
