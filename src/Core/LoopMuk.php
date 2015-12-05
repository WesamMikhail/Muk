<?php
namespace Lorenum\Muk\Core;

use Lorenum\Muk\Request\Request;

abstract class LoopMuk extends BaseMuk{

    /**
     * @param int $loop number of times this muk should be run
     * @throws \Lorenum\Muk\Exceptions\InvalidRequestUrl
     */
    public final function process($loop = 1){
        $start = microtime(true);

        for($i = 0; $i < $loop; $i++) {
            $request = new Request();
            $this->beforeRequest($request);
            $this->doRequest($request);
            $this->afterRequest($request);
            usleep($this->sleep * 1000); // x1000 because usleep() takes microseconds and our execution time is given in milliseconds
        }

        $this->addExecutionTime((microtime(true) - $start) / 60);
    }
}