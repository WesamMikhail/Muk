<?php
namespace Lorenum\Muk\Core;

use Lorenum\Muk\Request\Request;

abstract class TimeMuk extends BaseMuk{

    /**
     * @param float $time (minutes) how long this script should be recursively running for
     * @throws \Lorenum\Muk\Exceptions\InvalidRequestUrl
     */
    public final function process($time){
        $start = microtime(true);

        $request = new Request();
        $this->beforeRequest($request);
        $this->doRequest($request);
        $this->afterRequest($request);

        $this->addExecutionTime((microtime(true) - $start) / 60);

        //If the total execution time so far is less than the desired script running time, we run the process again.
        //This is repeated until the time threshold is satisfied
        if($this->getExecutionTime() < $time)
            $this->process($time);
    }
}