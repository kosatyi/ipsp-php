<?php

/**
 * Class Ipsp_Resource_Refund
 */
class Ipsp_Resource_Verification extends Ipsp_Resource{
    protected $path   = '/checkout/url';
    protected $defaultParams = array(
        'verification'=>'y',
        'verification_type'=>'code'
    );
    protected $fields = array(
        'merchant_id'=>array(
            'type'    => 'string',
            'required'=>TRUE
        ),
        'order_id'=>array(
            'type'    => 'string',
            'required'=>TRUE
        ),
        'currency' => array(
            'type' => 'string',
            'required'=>TRUE
        ),
        'amount' => array(
            'type' => 'integer',
            'required'=>TRUE
        ),
        'verification'=>array(
            'type' => 'string',
            'equal'=> 'y'
        ),
        'verification_type'=>array(
            'type' => 'string',
            'equal'=> 'y',
            'required'=>TRUE
        ),
        'signature' => array(
            'type' => 'string',
            'required'=>TRUE
        ),
        'version' => array(
            'type' => 'string',
            'required'=>FALSE
        )
    );
}