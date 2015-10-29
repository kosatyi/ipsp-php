<?php

require_once 'autoload.php';

Ipsp_Resource::gateway('api.oplata.com');

$client = new Ipsp_Client( 1000 ,'test' );

$ipsp   = new Ipsp_Api( $client );
