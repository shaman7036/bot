<?php
require_once("vendor/autoload.php");

use Viber\Client;

$apiKey = '<PLACE-YOU-API-KEY-HERE>'; // from "Edit Details" page
$webhookUrl = '<PLACE-YOU-HTTPS-URL>'; // for exmaple https://my.com/bot.php

try {
    $client = new Client([ 'token' => $apiKey ]);
    $result = $client->setWebhook($webhookUrl);
    echo "Success!\n";
} catch (Exception $e) {
    echo "Error: ". $e->getError() ."\n";
}