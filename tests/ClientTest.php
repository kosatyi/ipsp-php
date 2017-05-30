<?php

use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testCreateClientInstance()
    {
        $client = new Ipsp_Client( 1000 , 'test', 'api.fondy.eu' );
        $this->assertTrue( $client instanceof Ipsp_Client );
    }
}
