<?php

/**
 * Class Ipsp_ApiTest
 */
class Ipsp_ApiTest extends PHPUnit_Framework_TestCase
{

    protected static $params;

    public static function setUpBeforeClass()
    {
        self::$params = array(
            'params_key'   => 'order_desc',
            'params_value' => 'Test Order Description'
        );
        $_POST = array(
            'MD'=>'test_md',
            'PaRes'=>'test_pa_res',
            'response_status'=>'success'
        );
    }

    public static function tearDownAfterClass()
    {
        self::$params = null;
        $_POST = array();
    }

    /**
     * @return Ipsp_Api
     */
    public function testApi()
    {
        $client = new Ipsp_Client( 1000 , 'test', 'api.fondy.eu' );
        $api    = new Ipsp_Api( $client );
        $this->assertInstanceOf( Ipsp_Api::class , $api );
        return $api;
    }

    /**
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testInitResourceSuccess( $api )
    {
        $checkout = $api->initResource('checkout');
        $this->assertInstanceOf( Ipsp_Resource_Checkout::class , $checkout );
    }
    /**
     * @expectedException Ipsp_Error
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testInitResourceFailure( $api )
    {
        $api->initResource('undefined_resource');
    }
    /**
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testCallSuccess( $api ){
        $result = $api->call('result',array('prop'=>'value'));
        $this->assertInstanceOf( Ipsp_Resource_Result::class , $result );
    }
    /**
     * @expectedException Ipsp_Error
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testCallFailure( $api )
    {
        $api->call('undefined_resource',array('prop'=>'value'));
    }
    /**
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testSetParam( $api ){
        $key    = self::$params['params_key'];
        $value  = self::$params['params_value'];
        $result = $api->setParam($key,$value);
        $this->assertInstanceOf( Ipsp_Api::class , $result );
    }
    /**
     * @depends testApi
     * @depends testSetParam
     * @param Ipsp_Api $api
     */
    public function testGetParam( $api ){
        $key   = self::$params['params_key'];
        $value = self::$params['params_value'];
        $this->assertEquals( $value , $api->getParam($key) );
    }
    /**
     * @expectedException ErrorException
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testHandleError( $api ){
        $api->handleError(1000,'error description','error.file',10);
    }

    /**
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testHasAcsData( $api ){
        $this->assertTrue($api->hasAcsData());
    }

    /**
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testHasResponseStatus( $api ){
        $this->assertTrue($api->hasResponseData());
    }
}
