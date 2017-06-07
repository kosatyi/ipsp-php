<?php

/**
 * Class Ipsp_Api
 */
class Ipsp_Api {

    /**
     * @var Ipsp_Client
     */
    private $client;
    /**
     * @var array
     */
    private $params = array();
    /**
     * Supported currencies
     */
    const UAH = 'UAH';
    /**
     *
     */
    const USD = 'USD';
    /**
     *
     */
    const EUR = 'EUR';
    /**
     *
     */
    const RUB = 'RUB';
    /**
     *
     */
    const GBP = 'GBP';
    /**
     * @param Ipsp_Client $client
     */
    public function __construct( Ipsp_Client $client ){
        $this->client   = $client;
        set_error_handler(array($this, 'handleError'));
        set_exception_handler(array($this, 'handleException'));
    }

    /**
     * @param $name
     * @return mixed
     * @throws Ipsp_Error
     */
    public function initResource($name){
        $class    = implode('_',array('Ipsp','Resource',ucfirst($name)));
        if(!class_exists($class)) throw new Ipsp_Error(sprintf('Resource "%s" not found',$class));
        $resource = new $class;
        return $resource;
    }

    /**
     * @param null $name
     * @param array $params
     * @return mixed
     * @throws Ipsp_Error
     */
    public function call( $name = NULL , $params = array() ) {
        $resource = $this->initResource($name);
        $resource->setClient($this->client);
        return $resource->call(array_merge($this->params,$params));
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setParam( $key = '' , $value = ''){
        $this->params[$key] = $value;
        return $this;
    }
    /**
     * @param string $key
     */
    public function getParam( $key = '' ){
        return $this->params[$key];
    }

    /**
     * @return bool
     */
    public function hasAcsData(){
        return isset($_POST['MD']) AND isset($_POST['PaRes']);
    }

    /**
     * @return string
     */
    public function getCurrentUrl(){
        if(isset($_SERVER['HTTP_HOST']))
        {
            $secure   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off'||$_SERVER['SERVER_PORT']==443);
            $protocol = $secure ? "https://" : "http://";
            $host     = $_SERVER['HTTP_HOST'];
            $path     = $_SERVER['REQUEST_URI'];
        } else{
            $protocol = 'http://';
            $host     = 'localhost';
            $path     = '/';
        }
        return $protocol.$host.$path;
    }

    /**
     * @return bool
     */
    public function hasResponseData(){
        return isset($_POST['response_status']);
    }
    /**
     * @param $callback
     * @codeCoverageIgnore
     */
    public function success( $callback ){
        // TODO: implement success callback
    }
    /**
     * @param $callback
     * @codeCoverageIgnore
     */
    public function failure($callback){
        // TODO: implement failure callback
    }
    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     */
    public function handleError($errno, $errstr, $errfile, $errline) {
        error_log($errstr);
        $msg = sprintf('<div style="background:#efefef;font:12px/1 monospace;border:1px solid #ccc;padding:10px;">'.
            '<h2 style="margin:0 0 10px 0">Ipsp Php Error</h2>'.
            '<h4 style="margin:0 0 10px 0">%s (%s)</h3>'.
            '<pre style="margin:0;">%s line: %s</pre>'.
            '</div>',
            $errstr,
            $errno,
            $errfile,
            $errline
        );
        print($msg);
    }
    /**
     * @param Exception $e
     */
    public function handleException(\Exception $e) {
       error_log($e->getMessage());
       $msg = sprintf('<div style="background:#efefef;font:12px/1 monospace;border:1px solid #ccc;padding:10px;">'.
           '<h2 style="margin:0 0 10px 0">Ipsp Php Error</h2>'.
           '<h4 style="margin:0 0 10px 0">%s (%s)</h3>'.
           '<pre style="margin:0;">%s</pre>'.
           '</div>',
           $e->getMessage(),
           $e->getCode(),
           $e->getTraceAsString()
       );
       print($msg);
    }
}
