<?php

namespace Phiro;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;
use Phiro\Lang;

require_once '/constants/paths.php';
require_once '/classes/lang/Habitat.php';
require_once '/classes/lang/Exception.php';
require_once '/classes/utils/Json.php';

Lang\Habitat::_checkServerCompatibilities();

use Phiro\IO;

require_once '/classes/utils/String.php';
require_once '/classes/lang/AbstractCaller.php';
require_once '/classes/io/Structurator.php';
require_once '/classes/io/File.php';

$file  = new IO\File('.htaccess', IO\File::ENTRY_MODE_W_PLUS);

if(!$file->exists()) {
    if(!$file->open()) 
        new Lang\Exception('Impossible to create ".htaccess" in '.Constants\Paths\ABS_FILE.'.htaccess is essential to manage rewrite rules<br/><br/><b>Please create it in '.Constants\Paths\ABS_FILE.' and copy these lines:</b><br/><br />
        DirectoryIndex '.Constants\Paths\RELATIVE.'/index.php<br/>
        FallbackResource '.Constants\Paths\RELATIVE.'/index.php<br/>
        '.htmlentities('<files phiro-db-schema.php>').'<br/>
            order allow,deny<br/>
            deny from all<br/>
        '.htmlentities('</files>').'<br/><br/>
        '.htmlentities('<files phiro-config.php>').'<br/>
            order allow,deny<br/>
            deny from all<br/>
        '.htmlentities('</files>').'<br/><br/>
        '.htmlentities('<files phiro-rewrite-rules.php>').'<br/>
            order allow,deny<br/>
            deny from all<br/>
        '.htmlentities('</files>'), null, Lang\Exception::FAST_LAUNCH, Lang\Exception::LAUNCH_AS_HTML);
    
    $file->write('
    DirectoryIndex '.Constants\Paths\RELATIVE.'/index.php
    FallbackResource '.Constants\Paths\RELATIVE.'/index.php
    <files phiro-db-schema.php>
        order allow,deny
        deny from all
    </files>
    <files phiro-config.php>
        order allow,deny
        deny from all
    </files>
    <files phiro-rewrite-rules.php>
        order allow,deny
        deny from all
    </files>');
    if(!$file->close()) new Lang\Exception('Impossible to close ".htaccess" in '.Constants\Paths\ABS_FILE, '.htaccess is essential to manage rewrite rules<br/><br/>1. Check if a Program is using file and close it<br/>2. Delete ".htaccess" in '.Constants\Paths\ABS_FILE.' and refresh this window', null, Lang\Exception::FAST_LAUNCH, Lang\Exception::LAUNCH_AS_HTML);
}

/**
* @see Phiro\IO\File
* @see Phiro\Constants
*
* Carica i file che compongono il namespace Phiro\Constants
**/
$files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/constants/*', 'php');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @see Phiro\IO\File
* @see Phiro\Constants
*
* Carica i file che compongono il namespace Phiro\Core
**/
$files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/lang/*', 'php');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @see Phiro\IO\File
* @see Phiro\Constants
*
* Carica i file che compongono il namespace Phiro\IO (Input Output)
**/
$files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/io/*', 'php');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @see Phiro\IO\File
* @see Phiro\Constants
*
* Carica i file che compongono il namespace Phiro\UI (User Interface)
**/
$files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/ui/*', 'php');
if(!empty($files)) { foreach($files as $file) require_once($file);  }
$files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/ui/widgets/*', 'php');
if(!empty($files)) { foreach($files as $file) require_once($file);  }
$files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/ui/partials/*', 'php');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @see Phiro\IO\File
* @see Phiro\Constants
*
* Carica i file che compongono il namespace Phiro\Utils (Utilities)
**/
$files = Io\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/utils/*', 'php');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @see Phiro\IO\File
* @see Phiro\Constants
*
* Carica i file che compongono il namespace Phiro\Filters
**/
$files = Io\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/filters/*', 'php');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

new Lang\Rewrite($_SERVER['REQUEST_URI'], Lang\Rewrite::FAST_REQUEST);

?>