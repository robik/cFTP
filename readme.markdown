# cFTP

cFTP is simple FTP library written in PHP5.

## Getting started

### Requirements

- PHP 5
- FTP functions enabled

### Installing

Copy `lib/cFTP` directory to your project libraries directory.


## Examples

 - [Establishing Connection](https://github.com/robik/cFTP/blob/master/examples/Connection.php)
 - [Listing items](https://github.com/robik/cFTP/blob/master/examples/ListingItems.php)
 - [Listing with types](https://github.com/robik/cFTP/blob/master/examples/ListingWithTypes.php)
 - [Walking trough items](https://github.com/robik/cFTP/blob/master/examples/ListingItems2.php)
 - [Existence check](https://github.com/robik/cFTP/blob/master/examples/ExistenceCheck.php)
 - [Exceptions](https://github.com/robik/cFTP/blob/master/examples/Exceptions.php)
 - [Exceptions #2](https://github.com/robik/cFTP/blob/master/examples/Exceptions2.php) 


## Basics

The first thing we have to do is to establish  new FTP connection, 
to do that we can use `cFTP_Connection` which represents details of our connection. Here's basic usage of `cFTP_Connection` class:

    include 'path/to/cFTP/Autoload.php'; # 1
    
    $ftp_c = new cFTP_Connection(); # 2
    $ftp_c->setHostName('ftp.example.com'); # 3
    
    $ftp = new cFTP_Session($ftp_c); # 4
    $ftp->login(); # 5
    
    # Do operations here
    
    $ftp->close(); # 6

Here's step by step guide what are we doing in above code:

 1. Include cFTP autoloader. If you are using own autoloader, you can skip it.
 2. Create new instance of `cFTP_Connection`.
 3. Fill `$ftp_c` with connection details.
 4. Create new FTP session with connection details stored in `$ftp_c`.
 5. Login as `anonymous`.
 6. Close the connection.

That's everything you need to connect to FTP server :) 

## Directories

Now let's try to check what's in our drectory. To do this, we'll use `cFTP_Session::dir` function:

    include 'lib/cFTP/Autoload.php';
    
    $ftp_c = new cFTP_Connection();
    $ftp_c->setHostName('ftp.mozilla.org');

    $ftp = new cFTP_Session($ftp_c);
    $ftp->login();
    
    foreach( $ftp->dir('.')->listItems() as $item)
    {
        echo "$item found<br />";
    }
    
    $ftp->close();

Which should result in:

    README found
    index.html found
    pub found

In above piece od code we've added `foreach` loop through all items in `.` directory (current). 
But that may not be enough. What if we want to determine type of item? 
In that case `cFTP_Directory::listAdvanced` may come handy:

    $items = $ftp->dir('.')->listAdvanced();
    foreach( $items as $item )
    {        
        if( $item instanceof cFTP_Directory )
            echo 'Directory ';
        else
            echo 'File ';

        echo '<b>'.$item->getName().'</b> found<br/>';
    }

 > `cFTP_Directrory::listAdvanced` differs that returns object instead of raw name.

Above code should result in:

    File README found
    File index.html found
    Directory pub found

### Other directory functions

 - #### getFile( _$name_ )
    Does the same what `file` does.
    
    Example:

        $myfile = $ftp->dir()->getFile('foo.txt');

 - #### create()
    Creates new directory.
    
    Example:

        $mydir = $ftp->getDirectory('pub')->create();

 - #### remove()
    Removes directory.
    
    Example:
    
        $mydir->remove();

 - #### isDirectory()

    Checks if specified path is correct directory.
    
    Example:
    
        echo 'foo is a'.($ftp->dir('foo')->isDirectory() ? 'directory' : 'file');

 - #### exists( _$name_ )

    Check if specified child(files and directories) exists.
    
    Example:
    
        $ftp->dir('foo')->exists('off');

 - #### walk( _closure $callback_, _$filter_ )

    Walks through child items.
    
    Example:
    
        $ftp->dir()->walk(
                        function($e)
                        {
                            if( $e instanceof cFTP_Directory )
                            {
                                echo 'Directory: ';
                            }
                            else
                            {
                                echo 'File: ';
                            }
                            
                            echo $e->getName().' <br/>';
                        }
                    );


## Files

We know basic `cFTP_Directory` methods ( probably :) ) so we can start operating on files, to operate on them we can will `cFTP_File`. Here's simple example of uploading file:

    $ftp->dir()
        ->file('tmp.txt')
        ->upload('tmp.txt');

To upload use `download` function:

    $ftp->dir()
        ->file('tmp.txt')
        ->download('copy.txt');

### Other file functions

 - #### rename( _$newName_ )

    Renames file. Also useful for moving files.
    
    Example:
    
        $ftp->dir()->file('foo.txt')->rename('off.txt');

 - #### getSize()

    Returns file size.
    
    Example:
    
        $size = $ftp->dir()->file('foo.txt')->getSize();

 - #### fGet( _$handle, $mode = FTP_ASCII, $startPos = 0_ )

    Downloads file and saves in file handle.
    
    Example:
    
        $f = fopen('foo.txt', 'w+');
        $ftp->dir()
            ->file('tmp.txt')
            ->fGet($f);
        fclose($f);

 - #### fPut( _$handle, $mode = FTP_BINARY, $startPos = 0_ )

    Uploads file from file handle.
    
    Example:
    
        $f = fopen('foo.txt', 'r');
        $ftp->dir()
            ->file('foo.txt')
            ->fPut($f);
        fclose($f);

 
## Exceptions

cFTP throws `cFTP_Exception` when something fails (like connecting to server) so we can eaisly `catch` them in `try .. catch` statement. Also each exception thrown have it's own code that help us identify it :). Here's short example:

    try
     {
        $ftp->connect($ftp_connection);

         # Login (default as anonymous)
         $ftp->login(); 

         # Close the connection
         $ftp->close();
     }
     catch( cFTP_Exception $e)
     {
         # We can compare Excpetion code to one of `cFTP_ExceptionCodes` const
         # to avoid using `try .. catch` statement on FTP functions
         if( $e->getCode() == cFTP_ExceptionCodes::Connect )
         {
             echo 'Connection problem.';
         }
     }

## Todo

 - Add support for `ftp_nb_*`