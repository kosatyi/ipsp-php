<?php

class Ipsp_ResourceTest extends PHPUnit_Framework_TestCase
{


    /**
     * @var
     */
    protected static $resource;

    /**
     *
     */
    public static function setUpBeforeClass()
    {
        self::$resource = new Ipsp_Resource();
    }

    /**
     *
     */
    public static function tearDownAfterClass()
    {
        self::$resource = null;
    }


    /**
     *
     */
    public function testResource()
    {
        $this->assertInstanceOf( Ipsp_Resource::class , self::$resource );
    }

    /**
     *
     */
    public function testSetClient()
    {
        self::$resource->setClient(new Ipsp_Client(900002,'test','api.fondy.eu'));
    }
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testSetClientException()
    {
        self::$resource->setClient(array());
    }
    /**
     * @depends testResource
     * @param Ipsp_Resource $resource
     */
    public function testIsValid($resource){
        self::$resource->isValid(array());
    }
    /**
     * @depends testResource
     * @param Ipsp_Resource $resource
     */
    public function testIsValidParam($resource){
        self::$resource->isValidParam('key','value');
    }

    /**
     * @depends testResource
     * @param Ipsp_Resource $resource
     */
    public function testSetParams($resource){
        self::$resource->setParams(array(
            'key'=>'value'
        ));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testSetParamsException(){
        self::$resource->setParams(new stdClass());
    }


    /**
     *
     */
    public function testSetParam(){
        self::$resource->setParam('key','value');
    }


    /**
     *
     */
    public function testGetParams(){
        $value = self::$resource->getParams();
        $this->assertArrayHasKey('merchant_id', $value);
        $this->assertArrayHasKey('signature', $value);
    }

    /**
     *
     */
    public function testGetParam(){
        $value = self::$resource->getParam('key');
        $this->assertEquals('value',$value);
    }


    /**
     *
     */
    public function testGetUrl(){
        $value = self::$resource->getUrl();
        $this->assertEquals('https://api.fondy.eu/api',$value);
    }


    /**
     *
     */
    public function testXMLFormat(){
        self::$resource->setFormat('xml');
    }

    /**
     * @return array
     */
    public function formatProvider(){
        return array(
            'xml format'    => array('xml','xml',TRUE,'1011'),
            'json format' => array('json','json',TRUE,'1011'),
            'form encode format' => array('form','form',TRUE,'1011'),
            'undefined format' => array('custom','json',FALSE,'1011')
        );
    }
    /**
     * @dataProvider formatProvider
     * @param $format
     * @param $formatExpected
     * @param $formatIsSet
     * @param $errorCode
     */
    public function testCall($format,$formatExpected,$formatIsSet,$errorCode){
        self::$resource->setPath('/reports');
        $setFormat = self::$resource->setFormat($format);
        $this->assertEquals($formatIsSet,$setFormat);
        $this->assertEquals($formatExpected,self::$resource->getFormat());
        self::$resource->call(array('param'=>'value'));
        $this->assertEquals($errorCode,self::$resource->getResponse()->getErrorCode());
    }

}
