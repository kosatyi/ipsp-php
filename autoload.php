<?php

function ipsp_autoload($className){
    $classPath = explode('_',$className);
    if($classPath[0]!='Ipsp') return;
    $filePath = dirname(__FILE__).'/'.implode('/', $classPath).'.php';
    if(file_exists($filePath))
        require_once( $filePath );
}

spl_autoload_register('ipsp_autoload');
