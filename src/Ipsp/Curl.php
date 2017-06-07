<?php

/**
 * Class Ipsp_Curl
 *
 */
class Ipsp_Curl {
    /**
     * @var string
     */
    protected $response = '';       // Contains the cURL response for debug
    /**
     * @var
     */
    protected $session;             // Contains the cURL handler for a session
    /**
     * @var
     */
    protected $url;                 // URL of the session
    /**
     * @var array
     */
    protected $options = array();   // Populates curl_setopt_array
    /**
     * @var array
     */
    protected $headers = array();   // Populates extra HTTP headers
    /**
     * @var
     */
    public $error_code;             // Error code returned as an int
    /**
     * @var
     */
    public $error_string;           // Error message returned as a string
    /**
     * @var
     */
    public $info;                   // Returned after request (elapsed time, etc)

    /**
     * @throws Exception
     */
    function __construct()
    {
        if (!$this->is_enabled())
            throw new \Exception('curl module not found');
    }

    /**
     * @param array $params
     * @param array $options
     */
    public function post($params=array(),$options=array())
    {
        $params = $this->buildQuery($params);
        $this->options($options);
        $this->http_method('post');
        $this->option(CURLOPT_POST, TRUE);
        $this->option(CURLOPT_POSTFIELDS, $params);
    }

    public function buildQuery( $params ){
        if (is_array($params))
            $params = http_build_query($params, NULL, '&');
        return $params;
    }
    /**
     * @param $header
     * @param null $content
     * @return $this
     */
    public function http_header($header, $content = NULL)
    {
        $this->headers[] = $content ? $header . ': ' . $content : $header;
        return $this;
    }
    /**
     * @param $method
     * @return $this
     */
    public function http_method($method)
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
        return $this;
    }
    /**
     * @param array $options
     * @return $this
     */
    public function options($options = array())
    {
        foreach ($options as $option_code => $option_value)
            $this->option($option_code, $option_value);
        curl_setopt_array($this->session, $this->options);
        return $this;
    }
    /**
     * @param $code
     * @param $value
     * @param string $prefix
     * @return $this
     */
    public function option($code, $value, $prefix = 'opt')
    {
        if (is_string($code) && !is_numeric($code))
            $code = constant('CURL' . strtoupper($prefix) . '_' . strtoupper($code));
        $this->options[$code] = $value;
        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function create($url)
    {
        $this->url = $url;
        $this->session = curl_init($this->url);
        return $this;
    }

    /**
     * @return bool|mixed|string
     */
    public function execute()
    {
        if ( ! isset($this->options[CURLOPT_TIMEOUT]))
        {
            $this->options[CURLOPT_TIMEOUT] = 60;
        }
        if ( ! isset($this->options[CURLOPT_RETURNTRANSFER]))
        {
            $this->options[CURLOPT_RETURNTRANSFER] = TRUE;
        }
        if ( ! isset($this->options[CURLOPT_FAILONERROR]))
        {
            $this->options[CURLOPT_FAILONERROR] = TRUE;
        }
        if ( ! ini_get('safe_mode') && ! ini_get('open_basedir'))
        {
            if ( ! isset($this->options[CURLOPT_FOLLOWLOCATION]))
            {
                $this->options[CURLOPT_FOLLOWLOCATION] = TRUE;
            }
        }
        if ( ! empty($this->headers))
        {
            $this->option(CURLOPT_HTTPHEADER, $this->headers);
        }
        $this->options();
        $this->response = curl_exec($this->session);
        $this->info = curl_getinfo($this->session);
        if ($this->response === FALSE)
        {
            $errno = curl_errno($this->session);
            $error = curl_error($this->session);
            curl_close($this->session);
            $this->set_defaults();
            $this->error_code = $errno;
            $this->error_string = $error;
            return FALSE;
        }
        else
        {
            curl_close($this->session);
            $this->last_response = $this->response;
            $this->set_defaults();
            return $this->last_response;
        }
    }

    /**
     * @return bool
     */
    public function is_enabled()
    {
        return function_exists('curl_init');
    }
    /**
     *
     */
    public function set_defaults()
    {
        $this->response = '';
        $this->headers = array();
        $this->options = array();
        $this->error_code = NULL;
        $this->error_string = '';
        $this->session = NULL;
    }
}
