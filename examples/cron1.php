<?php
if(is_readable('../vendor/autoload.php'))
    require_once '../vendor/autoload.php';

/********* SINGLE PAGE PARSING ***********/
$muk = new \Lorenum\Muk\Examples\SingleHTMLMuk();
$muk->setMaxScriptExecutionTime(20); //20 seconds max allowed execution time
$muk->process();
$result = $muk->getResult();

//You can now store or output the result in the DB if you haven't already stored them using the afterRequest() method in your Muk
var_dump($result);

echo "This operation took: " . $muk->getExecutionTime() . " seconds." . PHP_EOL;
