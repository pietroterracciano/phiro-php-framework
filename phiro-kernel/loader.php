<?php

/**
* Crea le definizioni delle Directories di base
**/
require_once 'defines/directories.php';

/**
* @trick SECURITY
**/
if( empty($PHIRO_KERNEL_DIR) ) exit;

/**
* Crea le definizioni dei Paths
**/
require_once 'defines/paths.php';

/**
* Permette di utilizzare la funzione get_phiro_component_files() che restituisce
* la lista dei Files di un "componente" astratto del Framework
* (Serve a caricare velocemente Phiro)
**/ 
require_once 'functions/files/read_path.php';
require_once 'functions/files/recursive_read_path.php';
require_once 'functions/framework/get_phiro_component_files.php';

$thisPath = str_replace('\\', '/', dirname(__FILE__));

/**
* @since 0.170422
*
* @see 
*   @function recursive_glob()
*       @definedIn \phiro-kernel\functions\...\recursive_glob.php
*
* Carica i files che estendono le funzioni PHP e compongono le funzioni di base del Framework
**/
$files = get_phiro_component_files($thisPath.'/functions');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @since 0.170422
*
* Carica i file che compongono il @namespace Phiro\Lang
**/
$files = get_phiro_component_files($thisPath.'/classes/lang');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @since 0.170701
*
* Carica i file che compongono il @namespace Phiro\ADTs (Abstract Data Types / Tipi di Dato Astratti)
**/
$files = get_phiro_component_files($thisPath.'/classes/adts');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @since 0.170422
*
* Carica i file che compongono il @namespace Phiro\IO
**/
$files = get_phiro_component_files($thisPath.'/classes/io/');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @since 0.170602
*
* Carica i file che compongono il @namespace Phiro\Security
**/
$files = get_phiro_component_files($thisPath.'/classes/security/');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* @since 0.170602
*
* Carica i file che compongono il @namespace Phiro\Cache
**/
$files = get_phiro_component_files($thisPath.'/classes/cache/');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

/**
* Crea le definizioni delle Impostazioni
**/
require_once 'defines/config.php';

/**
* @since 0.170528
*
* Carica le definizioni della Lingua scelta
**/
require_once 'defines/languages/'.strtolower($PHIRO_LANGUAGE).'.php';

/**
* @since 0.170424
*
* @see @class Phiro\Lang\Server
*   @definedIn \phiro-kernel\classes\lang\Server.php
*
* @define @global @instance $PhiroServer                       : Contiene tutte le informazioni del Server su cui viene eseguito Phiro
*   @instanceOfClass Phiro\Lang\Server
**/
global $PhiroServer;
$PhiroServer = new Phiro\Lang\Server();


$PhiroFastQueue = new Phiro\ADTs\FastQueue();

print_r($PhiroFastQueue);


exit;

print_r( "get_os_path                   ".get_os_path()."\n" );
print_r( "get_relative_os_path          ".get_relative_os_path()."\n" );
print_r( "get_web_path                  ".get_web_path()."\n" );
print_r( "get_relative_web_path         ".get_relative_web_path()."\n" );
print_r( "get_web_url                   ".get_web_url()."\n" );
print_r( "get_relative_web_url          ".get_relative_web_url()."\n" );
print_r( "get_query_string              ".get_query_string()."\n" );
//@print_r( "get_query_string_as_array     ".get_query_string_as_array()."\n" );
//@print_r( "get_query_string_as_object    ".get_query_string_as_object()."\n" );

exit;

if($PhiroServer->isApacheWebServer()) {
    if($PhiroServer->isWebServerModuleAvailable('mod_rewrite'))
        new Phiro\Lang\FastException(
            array(
                'message' => '
                    <h3>'.str_replace('%s1', 'mod_rewrite', ps1_IS_NOT_ACTIVATED).'</h3>
                    <p>'.str_replace('%s1', 'mod_rewrite', PHIRO_NEEDS_COMPONENT_ps1_TO_WORK).'</p>
                    <div class="break"></div>
                    <p>
                        <a target="_blank" href="https://www.google.it/search?q=aggiornare+php+su+xampp">
                            - '.str_replace( ['%s1', '%s2'], ['PHP', 'XAMPP'], HOW_DO_I_UPDATE_MY_VERSION_OF_ps1_ON_ps2).'
                        </a>
                    </p>',
                'template' => get_absolute_os_path().'\\'.get_admin_directory().'\\fast-exception.php',
            )
        );

    
}

exit;

print_r( "get_os_path                   ".get_os_path()."\n" );
print_r( "get_relative_os_path          ".get_relative_os_path()."\n" );
print_r( "get_os_url                    ".get_os_url()."\n" );
print_r( "get_relative_os_url           ".get_relative_os_url()."\n" );
print_r( "get_web_path                  ".get_web_path()."\n" );
print_r( "get_relative_web_path         ".get_relative_web_path()."\n" );
print_r( "get_web_url                   ".get_web_url()."\n" );
print_r( "get_relative_web_url          ".get_relative_web_url()."\n" );
print_r( "get_query_string              ".get_query_string()."\n" );
@print_r( "get_query_string_as_array     ".get_query_string_as_array()."\n" );
@print_r( "get_query_string_as_object    ".get_query_string_as_object()."\n" );
exit;

$queue = new Phiro\ADT\Queue();

$queue->add('prova');
$queue->add('cavolo');
$queue->add('cavolo');
$queue->add('cavolo');

print_r($queue);

print_r( get_query_params() );


exit;

if($PhiroServer->getPHPVersionID() < 50400)
    new Phiro\Lang\FastException(
        array(
            'message' => '
                <h3>'.str_replace('%s1', 'PHP', ps1_IS_NOT_UP_TO_DATE).'</h3>
                <p>'.str_replace('%s1', 'PHP', PHIRO_NEEDS_AN_UPDATE_VERSION_OF_ps1_TO_WORK).'</p>
                <div class="break"></div>
                <div class="break"></div>
                <table class="col-7 fixed-layout">
                    <tbody>
                        <tr>
                            <th>'.INSTALLED_VERSION.'</th>
                            <td>'.$PhiroServer->getPHPVersionID().' ('.$PhiroServer->getPHPVersion().')</td>
                        </tr>
                        <tr class="required">
                            <th>'.MINIMUM_REQUIRED_VERSION.'</th>
                            <td>50400 (5.4.00)</td>
                        </tr>
                    </tbody>
                </table>
                <div class="break"></div>
                <p>
                    <a target="_blank" href="https://www.google.it/search?q=aggiornare+php+su+xampp">
                        - '.str_replace( ['%s1', '%s2'], ['PHP', 'XAMPP'], HOW_DO_I_UPDATE_MY_VERSION_OF_ps1_ON_ps2).'
                    </a>
                    <br />
                    <a target="_blank" href="https://www.google.it/search?q=aggiornare+php+su+iis">
                        - '.str_replace( ['%s1', '%s2'], ['PHP', 'IIS'], HOW_DO_I_UPDATE_MY_VERSION_OF_ps1_ON_ps2).'
                    </a>
                </p>',
            'template' => $PHIRO_ABS_ADMIN_PATH.'\\fast-exception.php',
        )
    );

/*
function prova($value = '') {
    echo "FUNZIONE CALLBACK 10 : ".$value."\n\n";
}

function provab($value = '') {
    echo "FUNZIONE CALLBACK 15 : ".$value."\n\n";
}


add_action('mia_azione', 
    function($value) { 
        echo "ANON FUNC CALLBACK 10 :".$value."\n\n"; 
    },
    10
);

add_action('mia_azione', 'provab', 15);

do_action('mia_azione', 'argomento 1', 'argomento 2');

add_filter('prova', function($string, $stringB = '') {
    return $string.' '.$stringB;
});

add_filter('prova', function($string, $stringB = '') {
    return 'nuovo filtro '.$string.' '.$stringB."\n\n";
});


echo apply_filters('prova', 'cavolo', 'prezzemolo');

echo apply_filters('prova', 'cavolo', 'prezzemolo');

echo apply_filters('prova', 'cavolo', 'prezzemolo');


exit;

$cipher = new \Phiro\Security\Ciphers\TwoWay(
        array(
            'privateKey' => '{;isT!A{+6gb%)oRJ{]3j@!{t;:?§(An',
            'publicKey' => random_string(64, 'WITH_SPECIAL_CHARS'),
            'type' => 'Pseudo',
        )
    );

$crypted = $cipher->encrypt('Effettua una criptazione di prova Bla bla bla bla bla');

echo $crypted."\n\n";

echo $cipher->decrypt( $crypted );


exit;


print_r($prova = new Phiro\Cache());


$prova->addToPool(
    'utente', 
    array(
        'ID' => '3318597842',
        'name' => 'Pietro',
        'surname' => 'Terracciano',
        'birthday' => '26021995',
        'university' => 'Fisciano UNISA'
    )
    
);
*/


?>