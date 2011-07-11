<?php
/**
 * This file is part of cFTP library.
 * 
 * @author Robert Pasiński <szadows@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * CHMOD
 */
 class cFTP_Chmod
 {
    # Base
     const NONE     = 0;
     const EXECUTE  = 1;
     const WRITE    = 2;
     const READ     = 4;
     const FULL     = 7;
     
    # Mixin's
     const WRITE_EXECUTE    = 3;
     const READ_EXECUTE     = 5;
     const READ_WRITE       = 6;
     
     
     protected $chmod;
     protected $chmod_owner;
     protected $chmod_group;
     protected $chmod_everyone;
     
     public function __construct($chmod = 0000)
     {
         $this->chmod = min(abs($chmod), 777);

         $chmod = (string)$this->chmod;

         $this->chmod_owner =    (int)$chmod[0];
         $this->chmod_group =    (int)$chmod[1];
         $this->chmod_everyone = (int)$chmod[2];                  
     }
     
     /**
      * Returns Owner access mode
      *
      * @return int Owner access mode
      */
     public function getOwnerAccessMode()
     {
         return $this->chmod_owner;
     }
     
     /**
      * Sets owner access mode
      *
      * @param int $mode Mode to set
      */
     public function setOwnerAccessMode($mode)
     {
         $this->chmod_owner = min(abs((int)$mode), 7);
     }
     
     
     /**
      * Returns group access mode
      *
      * @return int Owner access mode
      */
     public function getGroupAccessMode()
     {
         return $this->chmod_group;
     }
     
     /**
      * Sets group access mode
      *
      * @param int $mode Mode to set
      */
     public function setGroupAccessMode($mode)
     {
         $this->chmod_group = min(abs((int)$mode), 7);
     }
     
     
     /**
      * Returns everyone access mode
      *
      * @return int Owner access mode
      */
     public function getEveryoneAccessMode()
     {
         return $this->chmod_group;
     }
     
     /**
      * Sets everyone access mode
      *
      * @param int $mode Mode to set
      */
     public function setEveryoneAccessMode($mode)
     {         
         $this->chmod_group = min(abs((int)$mode), 7);
     }
     
     /**
      * Returns CHMOD
      * 
      * @return int CHMOD
      */
     public function getChmod()
     {
         $owner     = (string)$this->chmod_owner;
         $group     = (string)$this->chmod_owner;
         $everyone  = (string)$this->chmod_owner;
         
         $chmod = '0'.$owner.$group.$everyone;
         
         return (int)$chmod;
     }
     
     
 }
 
?>
