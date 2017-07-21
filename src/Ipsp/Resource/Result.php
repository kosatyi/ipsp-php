<?php

/**
 * Class Ipsp_Resource_PaymentResult
 */
class Ipsp_Resource_Result extends Ipsp_Resource{
    public function call( $data = NULL ){
        if( empty( $data ) )
        {
            $this->parseResponseData();
        } else{
            $this->setResponse($data);
        }
        return $this;
    }
    private function parseResponseData(){
       $body = file_get_contents('php://input');
       $types = $this->request->getContentTypes();
       $types = array_flip($types);
       $type = explode(';',$_SERVER['CONTENT_TYPE']);
       $type = trim($type[0]);
       if(isset($types[$type])){
           $this->format = $types[$type];
           $data = $this->parseRespose($body);
           $this->setResponse($data);
       }
    }
    public function validResponse(){
        $valid    = FALSE;
        $response = $this->getResponse();
        if( $response AND $data = $response->getData() ){
            $signature = $data['signature'];
            unset($data['signature']);
            if( array_key_exists('response_signature_string',$data))
                unset($data['response_signature_string']);
            $valid = $signature == $this->getSignature($data);
        }
        return $valid;
    }
}