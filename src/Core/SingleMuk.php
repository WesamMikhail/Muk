<?php
namespace Lorenum\Muk\Core;

use Lorenum\Muk\Request\Request;

abstract class SingleMuk extends BaseMuk{

    /**
     * @param null $options options are not used for this Muk
     * @throws \Lorenum\Muk\Exceptions\InvalidRequestUrl
     */
    public final function process($options = null){
        $start = microtime(true);

        $request = new Request();
        $this->beforeRequest($request);
        $this->doRequest($request);
        $this->afterRequest($request);

        $this->addExecutionTime((microtime(true) - $start) / 60);
    }
}