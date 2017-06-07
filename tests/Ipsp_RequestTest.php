<?php

class Ipsp_RequestTest extends PHPUnit_Framework_TestCase
{
    protected static $formats;
    public static function setUpBeforeClass()
    {
        self::$formats = array(
            'json' => 'application/json',
            'xml'  => 'application/xml',
            'form' => 'application/x-www-form-urlencoded'
        );
    }
    public static function tearDownAfterClass()
    {
        self::$formats = NULL;
    }
    public function testRequest()
    {
        $request = new Ipsp_Request();
        $this->assertInstanceOf( Ipsp_Request::class , $request );
        return $request;
    }
    /**
     * @depends testRequest
     * @param Ipsp_Request $request
     */
    public function testSetFormat($request)
    {
        $request->setFormat('json');
    }
    /**
     * @depends testRequest
     * @param Ipsp_Request $request
     */
    public function testGetContentTypes($request)
    {
        $this->assertArraySubset( self::$formats , $request->getContentTypes() );
    }
    /**
     * @depends testRequest
     * @param Ipsp_Request $request
     */
    public function testDoPost( $request )
    {
        $this->assertEquals('',$request->doPost('_mock_',''));
        $this->assertEquals('',$request->doPost('_mock_', array()));
    }
    /**
     * @depends testRequest
     * @param Ipsp_Request $request
     */
    public function testDoGet( $request )
    {
        $this->assertEquals( '' , $request->doGet('_mock_','') );
        $this->assertEquals( '' , $request->doGet('_mock_', array() ) );
    }
}
