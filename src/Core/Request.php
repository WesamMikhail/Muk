<?php
namespace Lorenum\Muk\Core;

class Request{
    protected $method = "GET";
    protected $url;
    protected $data;
    protected $headers;
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
     * @param mixed $method
     */
    public function setMethod($method) {
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
    public function setHeaders($headers) {
        $this->headers = $headers;
    }


}