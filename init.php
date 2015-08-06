<?php

require_once 'autoload.php';

$client = new Ipsp_Client( 1000 ,'test' );
$ipsp   = new Ipsp_Api( $client );