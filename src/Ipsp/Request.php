<?php

/**
 * Class Ipsp_Request
 */
class Ipsp_Request {
    /**
     * @var Ipsp_Curl
     */
    private $curl;
    /**
     * @var
     */
    private $format;
    /**
     * @var array
     */
    private $contentType = array(
        'json' => 'application/json',
        'xml'  => 'application/xml',
        'form' => 'application/x-www-form-urlencoded'
    );
    /**
     *
     */
    public function __construct(){
        $this->curl = new Ipsp_Curl;
    }
    /**
     * @param $format
     * @return $this
     */
    public function setFormat($format){
        $this->format = $format;
        return $this;
    }
    /**
     * @return string
     */
    private function getContentType($format){
        $type = $this->contentType[$format];
        return  sprintf('Content-Type: %s',$type);
    }

    /**
     * @param array $params
     * @return array|string
     */
    private function getParamsQuery($params=array()){
        if( is_array( $params ) )
            $params = http_build_query($params, NULL, '&');
        return $params;
    }
    /**
     * @return array
     */
    public function getContentTypes(){
        return $this->contentType;
    }
    /**
     * @param string $str
     * @return string
     */
    private function getContentLength($str=''){
        return sprintf('Content-Length: %s',strlen($str));
    }

    /**
     * @param string $url
     * @param array $params
     * @return bool|mixed
     */
    public function doPost( $url = '' , $params=array()){
        $params = $this->getParamsQuery($params);
        $this->curl->create($url);
        $this->curl->option(CURLOPT_SSL_VERIFYPEER, TRUE );
        $this->curl->option(CURLOPT_SSL_VERIFYHOST, 2 );
        $this->curl->post( $params );
        $this->curl->http_header( $this->getContentType( $this->format ));
        $this->curl->http_header( $this->getContentLength( $params ));
        return $this->curl->execute();
    }
    /**
     * @param string $url
     * @param array $params
     * @return bool|mixed|string
     */
    public function doGet( $url='' , $params=array() ){
        $params = $this->getParamsQuery($params);
        $this->curl->create($url.( empty( $params ) ? '' : '?'.$params ));
        $this->curl->option(CURLOPT_SSL_VERIFYPEER, TRUE );
        $this->curl->option(CURLOPT_SSL_VERIFYHOST, 2 );
        $this->curl->http_header( $this->getContentType( $this->format ) );
        $this->curl->http_header( $this->getContentLength( $params ) );
        return $this->curl->execute();
    }
}
