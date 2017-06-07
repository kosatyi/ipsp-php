<?php

/**
 * Class Ipsp_ApiTest
 * @backupStaticAttributes enabled
 */
class Ipsp_ApiTest extends PHPUnit_Framework_TestCase
{

    protected static $params;

    public static function setUpBeforeClass()
    {
        self::$params = array(
            'params_key'   => 'order_desc',
            'params_value' => 'Test Order Description',
        );
    }

    public static function tearDownAfterClass()
    {
        self::$params = null;
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
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testHandleError( $api ){
        $api->handleError(1000,'error description','file.tmp',1);
    }

    /**
     * @depends testApi
     * @param Ipsp_Api $api
     */
    public function testHandleException( $api ){
        $api->handleException(new Exception('error description',1000));
    }
    /**
     * @depends testApi
     * @backupGlobals enabled
     * @param Ipsp_Api $api
     */
    public function testHasAcsData( $api ){
        $_POST['MD'] = 'test_md';
        $_POST['PaRes'] = 'test_pa_res';
        $this->assertTrue($api->hasAcsData());
    }

    /**
     * @depends testApi
     * @backupGlobals enabled
     * @param Ipsp_Api $api
     */
    public function testHasResponseStatus( $api ){
        $_POST['response_status'] = 'success';
        $this->assertTrue($api->hasResponseData());
    }

    /**
     * @depends testApi
     * @backupGlobals enabled
     * @param Ipsp_Api $api
     */
    public function testGetCurrentUrl( $api ){
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '';
        $_SERVER['REQUEST_URI'] = '/';
        $this->assertEquals('http://example.com/',$api->getCurrentUrl());
        $_SERVER['HTTP_HOST'] = NULL;
        $this->assertEquals('http://localhost/',$api->getCurrentUrl());
    }

}
