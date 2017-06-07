<?php

class Ipsp_XmlDataTest extends PHPUnit_Framework_TestCase
{

    public function testXmlData()
    {
        $xml = new Ipsp_XmlData('<request><param>value</param></request>');
        $this->assertArrayHasKey('param',$xml->xmlToArray());
        $xml->arrayToXml( array(
            'list'=>array(
                'param'=>'value'
            )
        ));
        $this->assertArrayHasKey('list',$xml->xmlToArray());
    }

}
