<?php
/**
 * This file is part of cFTP library.
 * 
 * @author Robert Pasiński <szadows@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/*
 * cFTP_Connection class
 * This class represents connection details
 */
 class cFTP_Connection
 {
     /**
      * Contains hostname to connect to
      * 
      * @var string
      */
     protected $host;
     
     /**
      * Contains port to connect to
      *
      * @var int
      */
     protected $port;
     
     /**
      * Contains timeout
      *
      * @var int
      */
     protected $timeout;
     
     /**
      * Should we use SSL?
      *
      * @var bool
      */
     protected $useSSL;
     
     
     /**
      * Creates new cFTP_Connection object
      *
      * @param string $host    The FTP server address. It should not begin with ftp://
      * @param bool   $useSSL  Use SSL connection?
      * @param int    $port    The alternate port to connect to
      * @param int    $timeout The timeout for all subsequent network operations 
      */     
     public function __construct( $host, $useSSL = false, $port = 21, $timeout = 90 )
     {
         $this->setHostName($host);
         $this->setPort    ($port);
         $this->setTimeout ($timeout);
         $this->useSSL     ($useSSL);
     }
     
     
     /**
      * Returns hostname
      *
      * @return string Host name
      */
     public function getHostName()
     {
         return $this->host;
     }
     
     /**
      * Returns port
      *
      * @return int Port
      */
     public function getPort()
     {
         return $this->port;
     }
     
     /**
      * Returns timeout
      *
      * @return int Timeout
      */
     public function getTimeout()
     {
         return $this->timeout;
     }
     
     /**
      * Returns SSL usage
      *
      * @return bool SSL usage
      */
     public function isSSL()
     {
         return $this->useSSL;
     }
     
     /**
      * Returns connection options as array where keys are following:
      * 
      *  'host'    => Hostname <br/>
      *  'port'    => Port <br/>
      *  'timeout' => Timeout <br/>
      *  'ssl'     => SSL usage <br/>
      *
      * @return String[String]
      */
     public function getConnectionOptions()
     {
         return array
         (
             'host'    =>  $this->getHostName(),
             'port'    =>  $this->getPort(),
             'timeout' =>  $this->getTimeout(),
             'ssl'     =>  $this->isSSL()
         );
     }
     
     
     
     /**
      * Sets FTP server address
      *
      * @param string $host FTP server address
      */
     public function setHostName( $host )
     {
         $this->host =    (string)$host;
     }
     
     /**
      * Sets Port to connect to
      *
      * @param int $port Port
      */
     public function setPort( $port = 21 )
     {
         $this->port =    (int)$port;
     }
     
     /**
      * Sets timeout
      *
      * @param int $timeout  Timeout
      */
     public function setTimeout( $timeout = 90 )
     {
         $this->timeout = (int)$timeout;
     }
     
     /**
      * Sets SSL usage
      *
      * @param bool $bool Use SSL?
      */
     public function useSSL($bool)
     {
         $this->useSSL =  (bool)$bool; # What an irony O_o
     }
     
     /**
      * Sets connection options with array where kesy are:
      * 
      *  'host'    => Hostname <br/>
      *  'port'    => Port <br/>
      *  'timeout' => Timeout <br/>
      *  'ssl'     => SSL usage <br/>
      *
      * @param String[String] $options Array with connect options
      */
     public function setConnectionOptions( array $options )
     {
         if( !isset($options['host']) )
             throw new InvalidArgumentException(
                     "Array passed to cFTP_Connection::setConnectionDetails,
                       is invalid. No 'hostname' element.");
         
         
         $this->setHostName  ( $options['host'] );
         
         if( isset($options['port']) ) 
            $this->setPort   ( $options['port'] );
         
         if( isset($options['timeout']) ) 
            $this->setTimeout( $options['timeout'] );
         
         if( isset($options['ssl']) ) 
            $this->useSSL ( $options['ssl'] );
     }     
 }

?>
