<?php
if(is_readable('vendor/autoload.php'))
    require_once 'vendor/autoload.php';

/********* SINGLE PAGE PARSING ***********/
/*
$muk = new \Lorenum\Muk\SingleHTMLMukSample();
$muk->setMaxScriptExecutionTime(0); //Unlimited execution time
$muk->process();
var_dump($muk->getResult());
*/

/********* MULTI PAGE PARSING ***********/
$muk = new \Lorenum\Muk\PaginationHTMLMukSample();
$muk->setMaxScriptExecutionTime(20); //Unlimited execution time
$muk->process(2, 1000);
var_dump($muk->getResult());