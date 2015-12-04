<?php
namespace Lorenum\Muk\Core;

use Lorenum\Muk\Exceptions\InvalidRequestUrl;

abstract class Muk {
    /**
     * @var mixed container variable for the generated result
     */
    protected $result;

    /**
     * @var float Time it took to execute the full operation
     */
    protected $time;

    /**
     * Get total operation time
     *
     * @return float
     */
    public function getTime(){
        return $this->time;
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
     * Runs the actual request cycle as described below:
     *
     *  Muk->beforeRequest()
     *  Muk->doRequest()
     *  Muk->afterRequest()
     *
     * The sleep factor is introduced to allow for a wait period between requests in order not to DDoS the server!
     *
     * @param int  number of times this process should be executed
     * @param int $sleep number of milliseconds to wait between requests
     * @throws InvalidRequestUrl
     */
    public final function process($loop = 1, $sleep = 0){
        $start = microtime(true);
        for($i = 0; $i < $loop; $i++) {
            $request = new Request();
            $this->beforeRequest($request);
            $this->doRequest($request);
            $this->afterRequest($request);
            usleep($sleep * 1000);
        }

        $this->time = (time() - $start) / 60;
    }

    /**
     * The function in which the actual remote cal is made
     *
     * @param Request $request
     * @throws InvalidRequestUrl
     */
    public final function doRequest(Request $request){
        if(is_null($request->getUrl()) || $request->getUrl() == '')
            throw new InvalidRequestUrl;

        //TODO substitute this curl approach with a requestManager object
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$request->getUrl());
        curl_setopt($ch, CURLOPT_HEADER, 1);

        if($request->getMethod() == "POST"){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request->getData()));
        }

        //todo complete headers support
        if(!is_null($request->getHeaders())){
            foreach($request->getHeaders() as $key => $val){
                if($key == "User-Agent")
                    curl_setopt($ch, CURLOPT_USERAGENT, $val);
            }
        }

        $result = curl_exec($ch);

        //Parse headers and body
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        list($headerString, $bodyString) = explode("\r\n\r\n", $result, 2);

        //Convert header-string into an array
        $headers = [];
        foreach (explode("\r\n", $headerString) as $i => $line) {
            if ($i === 0)
                $headers['http_code'] = $line;
            else {
                list ($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        }

        curl_close($ch);

        //Generate the request object and inject it into the request
        $response = new Response();
        $response->setStatus($status);
        $response->setBody($bodyString);
        $response->setHeaders($headers);

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
}