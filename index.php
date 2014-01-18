<?php

ini_set('display_errors', 0);
ini_set('allow_url_fopen', 1);

set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__) . '/library/',
    get_include_path()
)));

spl_autoload_register(function ($className) {
        $fileParts = explode('\\', ltrim($className, '\\'));

        if (false !== strpos(end($fileParts), '_'))
            array_splice($fileParts, -1, 1, explode('_', current($fileParts)));

        $fileName = implode(DIRECTORY_SEPARATOR, $fileParts) . '.php';
        
        if ($fileName = stream_resolve_include_path($fileName))
            include_once  $fileName;
});


$configWs = include 'config.php' ;

try {
    if (!is_array($configWs))
        throw new InvalidArgumentException('Não foi encontrado o array de configurações');
    
    $classes = new \Gti\CreateClass($configWs);
    $classes->generate();

    if (isset($_GET['wsdl'])) {    
        $discovery = new Zend_Soap_AutoDiscover();
        $discovery->setClass($classes->currentClass['class']['name']);        
        $discovery->handle();
    } else {
        $soap = new Zend_Soap_Server(null, array('uri' => 'http://' . $classes->serverName . $classes->currentClass['uri']));
        $soap->setClass($classes->currentClass['class']['name']);
        $soap->handle();
    }
} catch (Exception $e) {
    header('Content-type: text/plain; charset=utf-8');
    echo "Houve um erro {$e->getMessage()}";
}
