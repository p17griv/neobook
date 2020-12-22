<?php

require_once 'vendor/autoload.php';

use Neoxygen\NeoClient\ClientBuilder;

$client = ClientBuilder::create()
    ->addConnection('default','http','localhost',7474,true,'neo4j','neobook')
    ->setAutoFormatResponse(true)
    ->build();