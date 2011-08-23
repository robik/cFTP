<?php
/**
 * This file is part of cFTP library.
 * 
 * @author Robert Pasiński <szadows@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License 
 */

/**
 * Represents a directory
 */
 class cFTP_Directory extends cFTP_Item
 {
          
     /**
      * Creates new cFTP_Directory object
      * 
      * @param Resource $handle FTP session Handle
      * @param string $name Directory name
      * @throws cFTP_Exception
      */
     public function __construct($handle, $name) 
     {
         if( get_resource_type($handle) != 'FTP Buffer' )
             throw new InvalidArgumentException( 'Specified argument is not valid resource' );
         
         parent::__construct($handle, $name);
     }     
          
     /**
      * List items in directory
      *
      * @param string $filter Regex filter pattern
      * @throws cFTP_Exception
      * 
      * @return string[] Elements in directory
      */
     public function listItems($filter = null)
     {
        $res = @ftp_nlist($this->handle, $this->name);
        
        if( $res === false )
            throw new cFTP_Exception( "Could not list items", 20 );
        
        if( $filter != null )
        {
            $res = preg_grep($filter, $res);
        }
        
        return $res;
     }
     
     /**
      * Lists items in directory and returns array of cFTP_File
      *
      * @param string $filter Regex filter pattern
      * @throws cFTP_Exception
      * 
      * @return cFTP_File[] Files
      */
     public function listAdvanced($filter = null)
     {
         $tmp = @ftp_nlist($this->handle, $this->name);
        
         if( $tmp === false )
             throw new cFTP_Exception( "Could not list items", 21 );
        
         if( $filter != null )
         {
             $tmp = preg_grep($filter, $tmp);
         }
                  
         $res = array();
         foreach( $tmp as $e )
         {             
             $d = new cFTP_Directory($this->handle,  $e);
             
             if( $d->isDirectory() )
                 $res[] = $d;
             else
             {
                 $res[] = new cFTP_File($this->handle, $e);
             }
         }  
         return $res;
     }
     
     /**
      * Changes directory to this directory. Just does `cd` on current directory
      * 
      * @throws cFTP_Exception
      * 
      * @return cFTP_Directory This
      */
     public function open()
     {
         $success = ftp_chdir($this->handle, $this->name);
         
         if( $success === false )
             throw new cFTP_Exception( "Could not change directory", 22 );
         
         return $this;
     }
     
     /**
      * Returns cFTP_File object
      *
      * @param string $name Name
      * 
      * @return cFTP_File File
      */
     public function getFile($name)
     {
         return new cFTP_File($this->handle, $this->name . '/' . $name);
     }
     
     /**
      * Alias for getFile
      *
      * @param string $name Name
      * 
      * @return cFTP_File File
      */
     public function file($name)
     {
         return new cFTP_File($this->handle, $this->name . '/' . $name);
     }
     
     /**
      * Creates new directory
      * 
      * @throws cFTP_Exception
      * 
      * @return cFTP_Directory This
      */
     public function create()
     {
         $success = @ftp_mkdir($this->handle, $this->name);
         
         if( !$success )
             throw new cFTP_Exception( "Could not create directory", 23 );
         
         return $this;
     }
     
     /**
      * Removes directory
      * 
      * @throws cFTP_Exception
      * 
      * @return cFTP_Directory This
      */
     public function remove()
     {
         $success = @ftp_rmdir($this->handle, $this->name);
         
         if( !$success )
             throw new cFTP_Exception( "Could not remove directory", 24 ); 
         
         return $this;
     }
     
     /**
      * Gets Directory
      *
      * @param string $name Directory name
      * 
      * @return cFTP_Directory Directory
      */
     public function getDirectory($name = '.')
     {
         return new cFTP_Directory($this->handle, $this->name . '/' . $name);
     }
     
     /**
      * Alias for getDirectory
      *
      * @param string $name Directory name
      * 
      * @return cFTP_Directory Directory
      */
     public function dir($name = '.')
     {
         return new cFTP_Directory($this->handle, $this->name . '/' . $name);
     }
     
     /**
      * Checks if current directory is directory
      *
      * @return bool False when it is not directory or doesn't exsts
      */
     public function isDirectory()
     {
         if( @ftp_chdir($this->handle, $this->name) === false )
         {
             return false;
         }
         else
         {
             @ftp_chdir ($this->handle, '..');
             return true;
         }
     }
     
     
     
     /**
      * Checks if child exists and return result
      *
      * @param string $childName Element to look for
      * 
      * @return bool Existence
      */
     public function childExists( $childName )
     {
         $elements = $this->dir('..')->listItems();
         
         foreach( $elements as $element )
         {
             if( trim($element, './\\') ==  $childName )
                     return true;
         }
         return false;
     }
     
     /**
      * "Walks" through items and calls $callback
      *
      * @param closure $callback Callback
      * @param string $filter Regex filter pattern
      * 
      * @return cFTP_Directory/cFTP_File
      */
     public function walk( closure $callback, $filter = null )
     {
         if( !is_callable($callback) )
         {
             throw new InvalidArgumentException( 
                "Argument specified to cFTP_Directory::walk must be a valid function" );
         }
         
         $tmp = @ftp_nlist($this->handle, $this->name);
        
         if( $tmp === false )
             throw new cFTP_Exception( "Could not list items", 25 );
        
         if( $filter != null )
         {
             $tmp = preg_grep($filter, $tmp);
         }
                  
         $res = array();
         foreach( $tmp as $e )
         {             
             $d = new cFTP_Directory($this->handle, $e);
             
             if( $d->isDirectory() )
                 $res[] = call_user_func_array ($callback, array($d));
             else
             {
                 $res[] = $callback( 
                     new cFTP_File($this->handle, $e) );
             }
         }        
         return $res;
     }
 }

?>
