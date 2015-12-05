<?php
namespace Lorenum\Muk\Core;

use GuzzleHttp\Client;
use Lorenum\Muk\Request\Request;
use Lorenum\Muk\Request\Response;
use Lorenum\Muk\Exceptions\InvalidRequestUrl;

abstract class BaseMuk {
    /**
     * @var mixed container variable for the generated result
     */
    protected $result;

    /**
     * @var float Time it took to execute the full operation
     */
    protected $time = 0;

    /**
     * @var int sleep time between requests in milliseconds
     */
    protected $sleep = 1000;



    /**
     * Sleep time in milliseconds between requests
     *
     * @param int $sleep
     */
    public function setTimeBetweenRequests($sleep) {
        $this->sleep = $sleep;
    }

    /**
     * Get total operation time in minutes
     *
     * @return float
     */
    public function getExecutionTime(){
        return $this->time;
    }

    /**
     * Add execution time to the total script run time.
     *
     * @param float $time time to add in minutes
     */
    protected function addExecutionTime($time){
        $this->time = $this->time + $time;
    }

    /**
     * @return mixed
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result) {
        $this->result = $result;
    }

    /**
     * Set PHP's max script execution time
     *
     * @param int $seconds set to 0 for unlimited time
     */
    public function setMaxScriptExecutionTime($seconds){
        set_time_limit($seconds);
    }

    /**
     * The function in which the actual remote cal is made
     *
     * @param Request $request
     * @throws InvalidRequestUrl
     */
    public function doRequest(Request $request){
        if(is_null($request->getUrl()) || $request->getUrl() == '')
            throw new InvalidRequestUrl;


        //Using Guzzle instead of the old curl
        //We also use the cacert.pem to verify all SSL connections
        $client = new Client();
        $result = $client->request($request->getMethod(), $request->getUrl(), [
            'headers' => $request->getHeaders(),
            'verify' => __DIR__ . '/cacert.pem'
        ]);


        //Generate the request object and inject it into the request
        $response = new Response();
        $response->setStatus($result->getStatusCode());
        $response->setBody($result->getBody());
        $response->setHeaders($result->getHeaders());

        $request->setResponse($response);
    }



    /**
     * This function runs BEFORE the actual request.
     * All boilerplate and preparation code must be included here
     *
     * @param Request $request
     */
    abstract public function beforeRequest(Request $request);

    /**
     * This function runs AFTER the actual request.
     * All parsing and result handling is made here
     *
     * @param Request $request
     */
    abstract public function afterRequest(Request $request);

    /**
     * This function dictates the processing order of the script.
     * Ideally, any implementing class should implement something that resembles SingleMuk::process()
     *
     * @param $options
     */
    abstract public function process($options);
}