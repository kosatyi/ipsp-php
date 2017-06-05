<?php

/**
 * Class IpspClientTest
 */
final class Ipsp_ClientTest extends PHPUnit_Framework_TestCase
{

    public function testClient( )
    {
        $client = new Ipsp_Client( 1000 , 'test', 'api.fondy.eu' );
        $this->assertInstanceOf( Ipsp_Client::class , $client );
        return $client;
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testParameterGatewayEmpty()
    {
        new Ipsp_Client(1000,'test','');
    }
    /**
     * @expectedException InvalidArgumentException
     */
    public function testParameterPasswordEmpty()
    {
        new Ipsp_Client(1000,'','api.fondy.eu');
    }
    /**
     * @expectedException InvalidArgumentException
     */
    public function testParameterMerchantEmpty(){
        new Ipsp_Client( NULL ,'','api.fondy.eu');
    }
    /**
     * @depends testClient
     * @param IPSP_Client $client
     */
    public function testPassword( $client ){
        $password = 'password';
        $client->setPassword( $password );
        $this->assertEquals($password,$client->getPassword());
    }
    /**
     * @depends testClient
     * @param IPSP_Client $client
     */
    public function testId( $client ){
        $id = 1000;
        $client->setId( $id );
        $this->assertEquals($id,$client->getId());
    }
    /**
     * @depends testClient
     * @param IPSP_Client $client
     */
    public function testUrl( $client ){
        $domain = 'api.fondy.eu';
        $url    = sprintf( $client->getUrlFormat() , $domain );
        $client->setId( $url );
        $this->assertEquals($url,$client->getUrl());
    }
    /**
     * @depends testClient
     * @param IPSP_Client $client
     */
    public function testUrlFormat( $client ){
        $urlFormat = 'https://%s/api';
        $this->assertEquals($urlFormat,$client->getUrlFormat());
    }
}