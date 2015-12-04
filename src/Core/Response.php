<?php
namespace Lorenum\Muk\Core;

class Response{
    protected $status;
    protected $headers;
    protected $body;

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

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body) {
        $this->body = $body;
    }


}