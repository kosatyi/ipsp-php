<?php

/**
 * Class Ipsp_Request
 */
class Ipsp_Request {
    private $curl;
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
    public function doPost( $url = '' , $params=array() , $format='json' ){
        $this->curl->create($url);
        $this->curl->ssl();
        $this->curl->post($params);
        $this->curl->http_header($this->getContentType( $format ));
        $this->curl->http_header($this->getContentLength( $params ));
        return $this->curl->execute();
    }

    /**
     * @param string $url
     * @param array $params
     * @param string $format
     * @return bool|mixed
     */
    public function doGet( $url='', $params=array(), $format='json' ){
        $this->create($url.(empty($params) ? '' : '?'.http_build_query($params, NULL, '&')));
        $this->curl->ssl();
        $this->curl->http_header($this->getContentType( $format ));
        $this->curl->http_header($this->getContentLength( $params ));
        return $this->curl->execute();
    }

}
