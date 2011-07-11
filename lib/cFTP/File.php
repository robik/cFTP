<?php
/**
 * This file is part of cFTP library.
 * 
 * @author Robert Pasiński <szadows@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Represents a File
 */
 class cFTP_File extends cFTP_Item
 {
     /**
      * Creates new cFTP_File object
      * 
      * @param Resource $handle FTP session Handle
      * @param string $name File name
      * @throws cFTP_Exception
      */
     public function __construct($handle, $name) 
     {
         if( get_resource_type($handle) != 'FTP Buffer' )
             throw new InvalidArgumentException( 'Specified argument is not valid resource' );
         
         parent::__construct($handle, $name);
     }
     
     /**
      * Downloads file
      *
      * @param string $localName Path to save the file
      * @param int $mode The transfer mode, <code>FTP_ASCII</code> or <code>FTP_BINARY</code>
      * @param int $startPos The position in the remote file to start downloading from
      * @throws cFTP_Exception
      * 
      * @return cFTP_File This
      */
     public function download($localName, $mode = FTP_BINARY, $startPos = 0)
     {         
         $success = @ftp_get( $this->handle, $localName, $this->name, $mode, $startPos );
      
         if( !$success )
             throw new cFTP_Exception( "Could not download file", 30 );
         
         return $this;
     }
     
     /**
      * Uploads file
      *
      * @param string $localFile Path to upload the file
      * @param int $mode The transfer mode, <code>FTP_ASCII</code> or <code>FTP_BINARY</code>
      * @param int $startPos The position in the local file to start uploading to
      * @throws cFTP_Exception
      * 
      * @return cFTP_File 
      */
     public function upload($localFile, $mode = FTP_BINARY, $startPos = 0)
     {
         $success = @ftp_put( $this->handle, $this->name, $localName, $mode, $startPos );
         
         if( !$success )
             throw new cFTP_Exception( "Could not upload file", 31 );
         
         return $this;
     }

     /**
      * Gets file size
      * 
      * @throws cFTP_Exception
      *
      * @return int File size 
      */
     public function getSize()
     {
         $res = @ftp_size($this->handle, $this->name);
         
         if( $res == -1 )
             throw new cFTP_Exception( "Could not get file size", 32 );
         
         return $res;
     }
     
     /**
      * Downloads file and saves to opened file
      * 
      * @param resource $handle An open file pointer in which save content
      * @param int $mode The transfer mode, <code>FTP_ASCII</code> or <code>FTP_BINARY</code>
      * @param int $startPos The position in the remote file to start downloading from
      * @throws cFTP_Exception
      * 
      * @return cFTP_File This
      */
     public function fGet($handle, $mode = FTP_BINARY, $startPos = 0)
     {         
         $success = @ftp_fget( $this->handle, $this->name, $handle, $mode, $startPos );
      
         if( !$success )
             throw new cFTP_Exception( "Could not get file data", 33 );
         
         return $this;
     }
     
     /**
      * Uploads the data from a file pointer to a remote file on the FTP server
      * 
      * @param resource $handle An open file pointer on the local file
      * @param int $mode The transfer mode, <code>FTP_ASCII</code> or <code>FTP_BINARY</code>
      * @param int $startPos The position in the remote file to start downloading from
      * @throws cFTP_Exception
      * 
      * @return cFTP_File This
      */
     public function fPut($handle, $mode = FTP_BINARY, $startPos = 0)
     {         
         $success = @ftp_fput( $this->handle, $handle, $this->name, $mode, $startPos );
      
         if( !$success )
             throw new cFTP_Exception( "Could not download file", 34 );
         
         return $this;
     }
 }

?>
