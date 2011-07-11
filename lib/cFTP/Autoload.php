<?php
/**
 * This file is part of cFTP library.
 * 
 * @author Robert Pasiński <szadows@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * cFTP autoloader
 */
 class cFTP_Autoloader
 {
     /**
      * Registers cFTP_Autloader::Autoload
      *
      * @return bool
      */
     public static function Initialize()
     {
         return spl_autoload_register( array(new self, 'Autoload') );
     }

     /**
      * cFTP autoloader function
      *
      * @param string $className Class name
      */
     public static function Autoload($className)
     {
        if( strncmp('cFTP', $className, 4 ) )
             return;

        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\'))
        {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$fileName;
     }
 }

 if( !isset($cFTP_AutoLoad) || $cFTP_AutoLoad )
    cFTP_Autoloader::Initialize();

?>
