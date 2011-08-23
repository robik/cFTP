<?php
/**
 * This file is part of cFTP library.
 * 
 * @author Robert Pasiński <szadows@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Contains list of Exception codes
 */

 class cFTP_ExceptionCodes
 {
     /**
      * Could not connect
      */
     const Connect          = 1;
     
     /**
      * Could not disconnect
      */
     const Disconnect       = 2;
     
     /**
      * Could not log in to FTP server
      */
     const Login            = 3;
     
     /**
      * Could not set passive mode
      */
     const SetPassiveMode   = 4;
     
     /**
      * Could not execute command on server
      */
     const ExecCmd          = 5;
     
     /**
      * Could not execute SITE command on server
      */
     const ExecSiteCmd      = 6;
     
     /**
      * Could not get directory name
      */
     const GetDirName       = 7;
     
     /**
      * Could not get remote system type
      */
     const GetSystemType    = 8;
     
     /**
      * Could not get option value
      */
     const GetOptionValue   = 9;
     
     /**
      * Could not set option value
      */
     const SetOptionValue   = 10;
     
     /**
      * Could not chmod
      */
     const CHMOD            = 11;
     
     
     
     /**
      * Could not list items [cFTP_Directory::listItems()]
      */
     const ListItems        = 20;
     
     /**
      * Could not list items advanced [cFTP_Directory::listAdvanced()]
      */
     const ListItemsAdv     = 21;
     
     /**
      * Could not change directory
      */
     const ChangeDir        = 22;
     
     /**
      * Could not create directory
      */
     const CreateDir        = 23;
     
     /**
      * Could not remove directory
      */
     const RemoveDir        = 24;
     
     /**
      * Could not list items [cFTP_Directory::walk()]
      */
     const ListItemsCallback = 25;
     
     
     
     /**
      * Could not download file
      */
     const Download         = 30;
     
     /**
      * Could not upload file
      */
     const Upload           = 31;
     
     /**
      * Could not get file size
      */
     const GetFileSize      = 32;
     
     /**
      * Could not get file data and save to open file pointer
      */
     const GetFileData      = 33;
     
     /**
      * Could not add file data from open file pointer
      */
     const AddFileData      = 34;
     
     /**
      * Could not delete file
      */
     const Delete           = 35;
     
     /**
      * Could not rename file
      */
     const Rename           = 36;     
     
 }

?>
