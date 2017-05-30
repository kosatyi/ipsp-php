<?php

/**
 * Class Ipsp_Response
 */
class Ipsp_Response {
    private $data = array();
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
    public function redirectTo($prop=''){
        if( $this->$prop ){
            header(sprintf('Location: %s',$this->$prop));
        }
    }
    public function isSuccess(){
        return $this->response_status=='success';
    }
    public function isFailure(){
        return $this->response_status=='failure';
    }
    public function getErrorCode(){
        return $this->error_code;
    }
    public function getErrorMessage(){
        return $this->error_message;
    }
    public function getCheckoutUrl(){
        return $this->checkout_url;
    }
    public function redirectToCheckout(){
        return $this->redirectTo('checkout_url');
    }
}