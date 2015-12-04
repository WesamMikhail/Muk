<?php
//TODO rework sample so it looks like a real project

if(is_readable('vendor/autoload.php'))
    require_once 'vendor/autoload.php';

/********* SINGLE PAGE PARSING ***********/
$muk = new \Lorenum\Muk\SingleHTMLMukSample();
$muk->setMaxScriptExecutionTime(0); //Unlimited execution time
$muk->process();
var_dump($muk->getResult());


/********* MULTI PAGE PARSING ***********/
/*
$muk = new \Lorenum\Muk\PaginationHTMLMukSample();
$muk->setMaxScriptExecutionTime(20); //Unlimited execution time
$muk->setTimeBetweenRequests(2000);
$muk->process(2);
var_dump($muk->getResult());
*/

echo "This operation took: " . $muk->getExecutionTime() . " seconds.";