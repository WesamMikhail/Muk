<?php
namespace Lorenum\Muk\Request;

use Lorenum\Muk\Exceptions\InvalidRequestMethod;

class Request{
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";

    protected $method = "GET";
    protected $url;
    protected $data;
    protected $headers = [];
    protected $response;

    /**
     * @return Response
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response) {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Set request HTTP method
     *
     * @param $method
     * @throws InvalidRequestMethod
     */
    public function setMethod($method) {
        if($method !== Request::METHOD_GET && $method !== Request::METHOD_POST)
            throw new InvalidRequestMethod;

        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders(array $headers) {
        $this->headers = $headers;
    }


}