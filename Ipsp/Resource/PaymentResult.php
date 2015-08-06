<?

/**
 * Class Ipsp_Resource_PaymentResult
 */
class Ipsp_Resource_PaymentResult extends Ipsp_Resource{
    public function call($data=array()){
        $this->setResponse($data);
        return $this;
    }
}