<?php
if(is_readable('vendor/autoload.php'))
    require_once 'vendor/autoload.php';

/********* SINGLE PAGE PARSING ***********/
$muk = new \Lorenum\Muk\SingleHTMLMukSample();
$muk->setMaxScriptExecutionTime(20); //20 seconds max allowed execution time
$muk->process();
var_dump($muk->getResult());


/********* MULTI PAGE PARSING ***********/
/*
$muk = new \Lorenum\Muk\PaginationHTMLMukSample();
$muk->setMaxScriptExecutionTime(0); //Unlimited execution time
$muk->setTimeBetweenRequests(2000);
$muk->process(2);
var_dump($muk->getResult());
*/

echo "This operation took: " . $muk->getExecutionTime() . " seconds." . PHP_EOL;
