<?php
/**
 * This file is part of cFTP library.
 * 
 * @author Robert Pasiński <szadows@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Represents a FTP session
 */
 class cFTP_Session
 {
     /**
      * Contains FTP session handle
      *
      * @var Resource
      */
     protected $handle;     
     
     /**
      * Contains cFTP_Session object
      *
      * @var cFTP_Connection
      */
     protected $connection;
     
     
     
     /**
      * Creates new cFTP_Session object
      *
      * @param cFTP_Connection [$connection] Connection details, can be omitted
      */
     public function __construct(cFTP_Connection $connection = null)
     {
         if( $connection != null )         
             $this->connect($connection);         
     }
     
     public function __destruct() 
     {
         @ftp_quit($this->handle);
     }
            
     
     /**
      * Connects to FTP server
      *
      * @param cFTP_Connection $connection 
      * 
      * @return cFTP_Session This
      */
     public function connect( cFTP_Connection $connection )
     {
         $this->connection = $connection;
         $host =    $this->connection->getHostName();
         $port =    $this->connection->getPort();
         $timeout = $this->connection->getTimeout();
         $ssl =     $this->connection->isSSL();
         
         if( $ssl )
            $this->handle = @ftp_ssl_connect( $host, $port, $timeout);
         else
            $this->handle = @ftp_connect($host, $port, $timeout);
         
         if( $this->handle === false )
                 throw new cFTP_Exception("Could not connect", 1);
         
         return $this;
     }
          
     /**
      * Closes the session
      */
     public function close()
     {
         $success = @ftp_quit($this->handle);
         
         if( !$success )
             throw new cFTP_Exception("Could not disconnect", 2);
     }
     
     /**
      * Log in to FTP Server. To log in as anonymous, do not specify any parameters
      *
      * @param string $user     Username
      * @param string $password Password
      * 
      * @return cFTP_Session This
      */
     public function login( $user = 'anonymous', $password = '' )
     {
         $this->user = $user;
         $this->password = $password;
         
         $success = @ftp_login( $this->handle, $user, $password );
         
         if( !$success )
             throw new cFTP_Exception( "Could not log in" , 3);
         
         return $this;
     }
     
     /**
      * Sets passive mode On/Off
      *
      * @param bool $bool Set passive mode?
      */
     public function setPassiveMode( $bool )
     {
         $success = @ftp_pasv( $this->handle, (bool)$bool );
         
         if( !$success )
             throw new cFTP_Exception( "Passive mode can not be set", 4 );
     }     
     
     /**
      * Gets directory
      *
      * @param string $name Directory name
      * 
      * @return cFTP_Directory Directory
      */
     public function getDirectory($name = '.')
     {
         return new cFTP_Directory($this->handle, $name);
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
         return new cFTP_Directory($this->handle, $name);
     }
     
     /**
      * Sends an arbitrary command to the FTP server
      *
      * @param string $command Command to execute
      * 
      * @return array Response
      */
     public function doCommand($command)
     {
         return @ftp_raw($this->handle, $command);
     }
     
     /**
      * Sends a SITE EXEC command request to the FTP server
      *
      * @param string $command
      * 
      * @return cFTP_Session This
      */
     public function execute($command)
     {
         $success = @ftp_exec($this->handle, $command);
         
         if( !$success )
             throw new cFTP_Exception( "Could not execute command", 5 );
         
         return $this;
     }
     
     /**
      * Executes SITE command to the FTP server
      *
      * @param string $cmd Command
      * 
      * @return cFTP_Session This
      */
     public function doSiteCommand($cmd)
     {
         $success = @ftp_site($this->handle, $cmd);
         
         if( !$success )
             throw new cFTP_Exception( "Could not execute SITE command", 6 );
         
         return $this;
     }
     
     /**
      * Returns directory name
      *
      * @throws cFTP_Exception 
      * 
      * @return string Directtory name
      */
     public function getCurrent()
     {
         $res = @ftp_pwd($this->handle);
         
         if( $res === false )
             throw new cFTP_Exception( "Could not get directory name", 7 );
         
         return $res;
     }
     
     /**
      * Returns system type
      *
      * @return string System type
      */
     public function getSystemType()
     {
         $res = @ftp_systype($this->handle);
         
         if( $res === false )
             throw new cFTP_Exception( "Could not get system type", 8 );
         
         return $res;
     }
     
     
     /**
      * Returns FTP option value
      *
      * @param int $option Option id. Supported are: <code>FTP_TIMEOUT_SEC</code>, <code>FTP_AUTOSEEK</code>
      * @throws cFTP_Exception
      * 
      * @return mixed Option Value
      */
     public function getOptionValue( $option )
     {
         $res = @ftp_get_option($this->handle, $option);
         
         if( $res === false )
             throw new cFTP_Exception( "Could not get option value", 9 );
         
         return $res;
     }
     
     /**
      * Sets FTP option value
      *
      * @param int $option Option id. Supported are: <code>FTP_TIMEOUT_SEC</code>, <code>FTP_AUTOSEEK</code>
      * @param type $value Value to set
      * @throws cFTP_Exception
      * 
      * @return cFTP_Session This
      */
     public function setOptionValue( $option, $value )
     {
         $success = @ftp_get_option($this->handle, $option, $value);
         
         if( $success === false )
             throw new cFTP_Exception( "Could not set option value", 10 );
         
         return $this;
     }
     
     /**
      * Builds URI that you can use to get current directory
      * 
      * Schema: ftp://username:password@host:port/dirs
      * 
      * @param bool $include_pwd Include current directory path to URI?
      *
      * @return string URI
      */
     public function buildURI($include_pwd = true)
     {
         $r  = 'ftp://';
         $r .= $this->user;
         if( $this->password )
             $r .= ':'.$this->password;
         
         $r .= '@'.$this->connection->getHostName();
         $r .= ':'.$this->connection->getPort();
         
         if( $include_pwd && $pwd = @ftp_pwd($this->handle) )
            $r .= '/'.ltrim($pwd, '/');
         
         return $r;
     }
     
 }
?>

