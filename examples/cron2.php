<?php
if(is_readable('../vendor/autoload.php'))
    require_once '../vendor/autoload.php';


/********* MULTI PAGE PARSING ***********/
$muk = new \Lorenum\Muk\Examples\PaginationHTMLMuk();
$muk->setMaxScriptExecutionTime(0); //Unlimited execution time
$muk->setTimeBetweenRequests(2000);
$muk->iterate(2);
$result = $muk->getResult();

//You can now store or output the result in the DB if you haven't already stored them using the afterRequest() method in your Muk
var_dump($result);

echo "This operation took: " . $muk->getExecutionTime() . " seconds." . PHP_EOL;
