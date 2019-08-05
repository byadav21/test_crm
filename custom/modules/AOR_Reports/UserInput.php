<?php
    /**
     * Created by PhpStorm.
     * User: sadaka
     * Date: 21/09/18
     * Time: 11:18 AM
     */

class UserInput {
//    protected $post, $get, $cookie;

    /**
     * __construct
     *
     * Create a new instance of UserInput
     */
    public function __construct() {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->cookie = $_COOKIE;
    }

    /**
     * get
     * Get a value from $_GET and sanitize it
     *
     * @param string $key    Key to get from array
     * @param string $type   What type is the variable (string, email, int, float, encoded, url, email)
     * @param array  $option Options for filter_var
     * @return mixed will return false on failure
     */
    public function get($key, $type = 'string', $options = array()) {
        if (!isset($this->get[$key])) {
            return false;
        }

        return filter_var($this->get[$key], $this->get_filter($type), $options);
    }

    /**
     * post
     * Get a value from $_POST and sanitize it
     *
     * @param string $key    Key to get from array
     * @param string $type   What type is the variable (string, email, int, float, encoded, url, email)
     * @param array  $option Options for filter_var
     * @return mixed will return false on failure
     */
    public function post($key, $type='string', $options = array()) {
        if (isset($this->post[$key])) {
            return false;
        }

        return filter_var($this->post[$key], $this->get_filter($type), $options);
    }

    /**
     * cookie
     * Get a value from $_COOKIE and sanitize it
     *
     * @param string $key    Key to get from array
     * @param string $type   What type is the variable (string, email, int, float, encoded, url, email)
     * @param array  $option Options for filter_var
     * @return mixed will return false on failure
     */
    public function cookie($key, $type='string', $options = array()) {
        if (isset($this->cookie[$key])) {
            return false;
        }

        return filter_var($this->cookie[$key], $this->get_filter($type), $options);
    }

    private function get_filter($type) {
        switch (strtolower($type)) {
            case 'string':
                $filter = FILTER_SANITIZE_STRING;
                break;

            case 'int':
                $filter = FILTER_SANITIZE_NUMBER_INT;
                break;

            case 'float' || 'decimal':
                $filter = FILTER_SANITIZE_NUMBER_FLOAT;
                break;

            case 'encoded':
                $filter = FILTER_SANITIZE_ENCODED;
                break;

            case 'url':
                $filter = FILTER_SANITIZE_URL;
                break;

            case 'email':
                $filter = FILTER_SANITIZE_EMAIL;
                break;

            default:
                $filter = FILTER_SANITIZE_STRING;
        }

        return $filter;
    }

    public function syncSessions($key){
        if(!empty($this->post)){
            $_SESSION['inputs'][$key] = $this->post;
        }elseif(isset($_SESSION['inputs'])){
            $this->post = isset($_SESSION['inputs'][$key])?$_SESSION['inputs'][$key]:$this->post;
        }
    }

    public function getVal($key, $inputType='post', $default=''){
        switch ($inputType){
            case 'post':
                $array = $this->post;
                break;
            case 'get':
                $array = $this->get;
                break;
        }
        return isset($array[$key])?$array[$key]:$default;
    }

}