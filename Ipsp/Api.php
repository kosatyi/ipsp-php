<?php

/**
 * Class Ipsp_Api
 */
class Ipsp_Api {

    private $client;
    private $params = array();
    /**
     * Supported currencies
     */
    const UAH = 'UAH';
    const USD = 'USD';
    const EUR = 'EUR';
    const RUB = 'RUB';
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
     * @return bool
     */
    public function initResource($name){
        $class    = implode('_',array('Ipsp','Resource',ucfirst($name)));
        if(!class_exists($class)) new \Exception(sprintf('ipsp resource "%s" not found',$class));
        $resource = new $class;
        return $resource;
    }
    /**
     * @param null $name
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function call($name=NULL,$params=array()) {
        $resource = $this->initResource($name);
        $resource->setClient($this->client);
        return $resource->call(array_merge($this->params,$params));
    }
    /**
     * @param string $key
     * @param string $value
     */
    public function setParam($key='',$value=''){
        $this->params[$key] = $value;
    }
    /**
     * @param string $key
     */
    public function getParam($key=''){
        $this->params[$key];
    }
    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @throws ErrorException
     */
    public function handleError($errno, $errstr, $errfile, $errline) {
        throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
    public function hasAcsData(){
        return isset($_POST['MD']) AND isset($_POST['PaRes']);
    }
    public function hasResponseData(){
        return isset($_POST['response_status']);
    }

    /**
     * @param $callback
     */
    public function success($callback){

    }

    /**
     * @param $callback
     */
    public function failure($callback){

    }
    /**
     * @param Exception $e
     */
    public function handleException(\Exception $e) {
       error_log($e->getMessage());
       $msg = sprintf('<h1>Ipsp PHP Error</h1>'.
           '<h3>%s (%s)</h3>'.
           '<pre>%s</pre>',
           $e->getMessage(),
           $e->getCode(),
           $e->getTraceAsString()
       );
       exit($msg);
    }
}
