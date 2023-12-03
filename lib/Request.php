<?php

namespace Lib;

class Request
{
    private $requestData;

    public function __construct()
    {
        // Use $_REQUEST to populate the request data
        $this->requestData = $_REQUEST;
    }

    public function get($key, $default = null)
    {
        // Return the value for the given key, or the default value if not found
        return $this->requestData[$key] ?? $default;
    }

    public function all()
    {
        // Return all request data
        return $this->requestData;
    }
}