<?php
/**
 * Class Ipsp_Resource
 */
class Ipsp_Resource {
    /**
     * @var string
     */
    protected $method = 'POST';
    /**
     * @var string
     */
    protected $defaultFormat = 'json';
    /**
     * @var string
     */
    protected $format = 'json';
    /**
     * @var
     */
    protected $path;
    /**
     * @var array
     */
    protected $fields = array();
    /**
     * @var array
     */
    protected $defaultParams = array();
    /**
     * @var Ipsp_Request
     */
    protected $request;
    /**
     * @var
     */
    protected $response;
    /**
     * @var array
     */
    protected $types    = array(

    );
    /**
     * @var array
     */
    protected $formatter	= array(
        'json' => 'jsonParams',
        'xml'  => 'xmlParams',
        'form' => 'formParams'
    );
    /**
     * @var array
     */
    protected $parser	= array(
        'json' => 'parseJson',
        'xml'  => 'parseXml',
        'form' => 'parseForm'
    );
    /**
     * @var
     */
    private $client;
    /**
     * @var array
     */
    private $params = array();

    /**
     *
     */
    public function __construct(){
        $this->request  = new Ipsp_Request();
        if(!empty($this->format))
            $this->setFormat($this->format);
        if(!empty($this->defaultParams))
            $this->setParams($this->defaultParams);
    }

    /**
     * @param array $params
     * @return string
     */
    protected function getSignature($params=array()){
        $params = array_filter($params,'strlen');
        ksort($params);
        $params = array_values($params);
        array_unshift( $params , $this->client->getPassword() );
        $params = join('|',$params);
        return(sha1($params));
    }
    /**
     * @param string $json
     * @return mixed
     */
    private function parseJson( $json = '' ){
        $data = json_decode($json,TRUE);
        return $data['response'];
    }

    /**
     * @param string $xml
     * @return array
     */
    private function parseXml( $xml = '' ){
        $xml = new Ipsp_XmlData($xml);
        $data = $xml->xmlToArray();
        return $data;
    }
    /**
     * @param string $query
     * @return array
     */
    private function parseForm($query=''){
        $data = array();
        parse_str($query, $data);
        return $data;
    }
    /**
     * @param $data
     * @return mixed
     * @throws Exception
     */
    protected function parseRespose( $data ){
        $callback = $this->parser[$this->format];
        return call_user_func(array($this,$callback),$data);
    }
    /**
     * @param array $params
     * @return string
     */
    private function jsonParams($params=array()){
        return json_encode(array(
            'request'=>$params
        ));
    }
    /**
     * @param array $params
     * @return string
     */
    private function formParams($params=array()){
        return http_build_query($params);
    }
    /**
     * @param array $params
     * @return mixed
     */
    private function xmlParams($params=array()){
        $xml = new Ipsp_XmlData('<request/>');
        $xml->arrayToXml($params);
        return $xml->asXML();
    }
    /**
     * @param $params
     * @return mixed|null
     */
    protected function buildParams($params){
        return call_user_func(array($this,$this->formatter[$this->format]),$params);
    }
    /**
     * @param Ipsp_Client $client
     */
    public function setClient(Ipsp_Client $client){
        $this->client = $client;
    }
    /**
     * @param $params
     * @return bool
     */
    public function isValid($params){
        $fields = $this->fields;
        return TRUE;
    }
    /**
     * @param $path
     * @return $this
     */
    public function setPath($path){
        $this->path = $path;
        return $this;
    }
    /**
     * @param $format
     * @return $this|bool
     */
    public function setFormat($format){
        if( array_key_exists($format,$this->formatter) ){
            $this->format = $format;
            return TRUE;
        } else {
            $this->format = $this->defaultFormat;
            return FALSE;
        }
    }
    /**
     * @return string
     */
    public function getFormat(){
        return $this->format;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function isValidParam($key,$value){
        return TRUE;
    }
    /**
     * @param array $params
     * @return $this
     */
    public function setParams(Array $params){
        if( $this->isValid($params) ){
            $this->params = array_merge($this->params,$params);
        }
        return $this;
    }
    /**
     * @param String $key
     * @param $value
     * @return $this
     */
    public function setParam($key,$value){
        if( $this->isValidParam($key,$value) ){
            $this->params[$key] = $value;
        }
        return $this;
    }
    /**
     * @return mixed
     */
    public function getParams(){
        $params = $this->params;
        $params['merchant_id'] = $this->client->getId();
        $params['signature']   = $this->getSignature($params);
        return $params;
    }
    /**
     * @param $key
     * @return null
     */
    public function getParam($key){
        return isset($this->params[$key]) ? $this->params[$key] : NULL;
    }
    /**
     * @return string
     */
    public function getUrl(){
        return sprintf('%s%s',$this->client->getUrl(),$this->path);
    }
    /**
     * @return $this
     * @throws Exception
     */
    public function call( $params = array() ){
        $this->setParams( $params );
        $this->request->setFormat( $this->format );
        $data = $this->request->doPost($this->getUrl(),$this->buildParams($this->getParams()));
        $data = $this->parseRespose($data);
        $this->setResponse($data);
        return $this;
    }

    /**
     * @param array $data
     */
    public function setResponse($data=array()){
        $this->response = new Ipsp_Response($data);
    }
    /**
     * @return array
     */
    public function getResponse(){
        return $this->response;
    }

}