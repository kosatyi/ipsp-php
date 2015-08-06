<?php
/**
 * Class PaymentClient
 */
class Ipsp_Client {
    private $id;
    private $password;
    public function __construct($id,$password){
        if(empty($id)) throw new \Exception('auth id not set');
        if(empty($password)) throw new \Exception('auth password not set');
        $this->id = $id;
        $this->password = $password;
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
}