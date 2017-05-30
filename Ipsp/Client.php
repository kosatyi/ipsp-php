<?php
/**
 * Class PaymentClient
 */
class Ipsp_Client {

    private $id;

    private $password;

    private $url;
    /**
     * @param string $id
     * @param string $password
     * @param string $domain
     */
    public function __construct($id='',$password='',$domain=''){
        if(empty($id)) throw new \InvalidArgumentException('auth id not set');
        if(empty($password)) throw new \InvalidArgumentException('auth password not set');
        if(empty($domain)) throw new \InvalidArgumentException('ipsp gateway not set');
        $this->id = $id;
        $this->password = $password;
        $this->url = sprintf('https://%s/api',$domain);
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
