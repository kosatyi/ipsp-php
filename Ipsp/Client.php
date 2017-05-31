<?php
/**
 * Class PaymentClient
 */
class Ipsp_Client {

    private $id;
    private $password;
    private $url;
    private $urlFormat = 'https://%s/api';
    /**
     * @param null $id
     * @param null $password
     * @param null $domain
     */
    public function __construct( $id = NULL , $password = NULL , $domain = NULL ){
        $this->setId( $id );
        $this->setPassword( $password );
        $this->setUrl( $domain );
    }
    /**
     * @param string $id
     */
    public function setId($id='')
    {
        if( empty($id) )
            throw new \InvalidArgumentException('Merchant id not set');
        $this->id = $id;
    }
    /**
     * @param string $password
     */
    public function setPassword( $password = '')
    {
        if( empty($password) )
            throw new \InvalidArgumentException('Merchant password not set');
        $this->password = $password;
    }

    /**
     * @param string $domain
     */
    public function setUrl( $domain = '')
    {
        if( empty($domain) )
            throw new \InvalidArgumentException('IPSP Gateway domain not set');
        $this->url = sprintf( $this->getUrlFormat() , $domain );
    }
    public function getUrlFormat(){
        return $this->urlFormat;
    }
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    /**
     * @return String
     */
    public function getPassword(){
        return $this->password;
    }
    /**
     * @return String
     */
    public function getUrl(){
        return $this->url;
    }
}
