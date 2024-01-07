<?php

require 'vendor/autoload.php'; // Composer autoloader

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\VAPID;

// Your VAPID keys (replace these with your own)
$privateKey = '1vjk0EpbiqMv2wU4F2JuYvsHamPCsc4RECWMzfxKQ5o';
$publicKey ='BBt4aeJUh0cO3PoGP_T8BKsM8QtggF4zYmWDNvSOtHqwa91VO8sQVqovNBXs-U7DxjczjMw4jeeFOX1pNGktc2c';

// Create a new WebPush instance
$webPush = new WebPush([
    'VAPID' => [
        'subject' => 'leguizcc12@gmail.com', 
        'publicKey' => $publicKey,
        'privateKey' => $privateKey,
    ],
]);

// Example subscription data (replace with your own)
$subscription = Subscription::create([
    'endpoint' => 'https://example.com/push-endpoint',
    'publicKey' => 'your_subscription_public_key',
    'authToken' => 'your_subscription_auth_token',
]);

// Send the notification
$webPush->sendNotification(
    $subscription,
    'Hello, world!',
    null,
    ['TTL' => 300] // Time-to-live in seconds
);

// Close the WebPush instance
$webPush->flush();



/*
[publicKey] => BBt4aeJUh0cO3PoGP_T8BKsM8QtggF4zYmWDNvSOtHqwa91VO8sQVqovNBXs-U7DxjczjMw4jeeFOX1pNGktc2c
[privateKey] => 1vjk0EpbiqMv2wU4F2JuYvsHamPCsc4RECWMzfxKQ5o
*/