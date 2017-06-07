<?php

/**
 * Class Ipsp_Response
 */
class Ipsp_Response {
    /**
     * @var array
     */
    private $data = array();

    /**
     * @param array $data
     */
    public function __construct($data=array()){
        $this->data = $data;
    }
    /**
     * @param $name
     * @return null
     */
    public function __get($name){
        return isset($this->data[$name]) ? $this->data[$name] : NULL ;
    }
    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function __toString(){
        return json_encode($this->data,JSON_PRETTY_PRINT);
    }
    /**
     * @return array
     */
    public function getData(){
        return $this->data;
    }

    /**
     * @param string $prop
     * @codeCoverageIgnore
     */
    public function redirectTo($prop=''){
        if( $this->$prop ){
            header(sprintf('Location: %s',$this->$prop));
        }
    }

    /**
     * @return bool
     */
    public function isSuccess(){
        return $this->response_status=='success';
    }

    /**
     * @return bool
     */
    public function isFailure(){
        return $this->response_status=='failure';
    }

    /**
     * @return null
     */
    public function getErrorCode(){
        return $this->error_code;
    }

    /**
     * @return null
     */
    public function getErrorMessage(){
        return $this->error_message;
    }

    /**
     * @return null
     */
    public function getCheckoutUrl(){
        return $this->checkout_url;
    }

    /**
     * @codeCoverageIgnore
     */
    public function redirectToCheckout(){
        return $this->redirectTo('checkout_url');
    }
}