<?php

class Ipsp_ResponseTest extends PHPUnit_Framework_TestCase
{

    public function testGetData()
    {
        $response = new Ipsp_Response(array(
            'key1'=>'value1',
            'key2'=>'value2',
        ));
        $data     = $response->getData();
        $this->assertArrayHasKey('key1',$data);
        $this->assertArrayHasKey('key2',$data);
    }
    public function testSuccessData()
    {
        $status        = 'success';
        $checkout_url  = 'http://example.com/';
        $response = new Ipsp_Response(array(
            'response_status'=>$status,
            'checkout_url'=>$checkout_url
        ));
        $this->assertTrue($response->isSuccess());
        $this->assertEquals($checkout_url,$response->getCheckoutUrl());
    }
    public function testFailureData()
    {
        $status        = 'failure';
        $error_code    = '1000';
        $error_message = 'test error message';
        $response = new Ipsp_Response(array(
            'response_status'=>$status,
            'error_code'=>$error_code,
            'error_message'=>$error_message
        ));
        $this->assertTrue($response->isFailure());
        $this->assertEquals($error_code,$response->getErrorCode());
        $this->assertEquals($error_message,$response->getErrorMessage());
    }
}
