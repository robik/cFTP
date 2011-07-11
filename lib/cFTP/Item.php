<?php
/**
 * This file is part of cFTP library.
 * 
 * @author Robert Pasiński <szadows@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Represents item in FTP
 */
 class cFTP_Item
 {
     /**
      * FTP session handle
      *
      * @var string Handle
      */
     protected $handle;
     
     /**
      * Element( directory/file ) name
      *
      * @var string Name
      */
     protected $name;
     
     public function __construct($handle, $name)
     {
         $this->handle = $handle;
         $this->name = $name;
     }
     
     
     /**
      * Changes element CHMOD
      *
      * @param int $chmod CHMOD
      * @throws cFTP_Exception
      */
     public function changeMode($chmod)
     {
         $success = @ftp_chmod($this->handle, $chmod, $filename);
         
         if( !$success )
             throw new cFTP_Exception( "Could not change element CHMOD" );
         
         return $this;
     }
     
     /**
      * Changes name of element
      *
      * @throws cFTP_Exception
      * 
      * @return cFTP_Element 
      */
     public function rename($newName)
     {
         $success = @ftp_rename($this->handle, $this->name, $newName);
         
         if( !$success )
             throw new cFTP_Exception( "Could not rename" );
         
         return $this;
     }
     
     /**
      * Returns element name
      *
      * @return string Name
      */
     public function getName()
     {
         return $this->name;
     }
     
 }

?>
