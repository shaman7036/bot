<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once __DIR__ . '/vendor/autoload.php';
//require_once("vendor/autoload.php");

use Viber\Bot;
use Viber\Api\Sender;

$apiKey = '4709a4d7bfe7d000-4e7ef0102d01100c-a229c80409408490';

$botSender = new Sender([
    'name' => 'R1Sport',
    'avatar' => 'https://developers.viber.com/img/favicon.ico',
]);

try {
    $bot = new Bot(['token' => $apiKey]);
    $bot
        ->onSubscribe(function ($event) use ($bot, $botSender) {
                // Пользователь подписался на чат
                $receiverId = $event->getSender()->getId();
                $bot->getClient()->sendMessage(
                    (new \Viber\Api\Message\Text())
                        ->setSender($botSender)
                        ->setReceiver($receiverId)
                        ->setText('Спасибо за подписку!')
                );
            });
    $bot
       ->onConversation(function ($event) use ($bot, $botSender) {
        // это событие будет вызвано, как только пользователь перейдет в чат
        // вы можете отправить "привествие", но не можете посылать более сообщений
        return (new \Viber\Api\Message\Text())
            ->setSender($botSender)
            ->setText("Здравствуйте! Чем я могу вам помочь?");
    })
    ->onText('|Привет|si', function ($event) use ($bot, $botSender) {
        // это событие будет вызвано если пользователь пошлет сообщение 
        // которое совпадет с регулярным выражением
        $receiverId = $event->getSender()->getId();
                $user = $event->getSender()->getName();
                $answer = 'Привет, ' . $user;
        $bot->getClient()->sendMessage(
            (new \Viber\Api\Message\Text())
            ->setSender($botSender)
            ->setReceiver($event->getSender()->getId())
            ->setText($answer. '!')
        );
    })
    ->run();
} catch (Exception $e) {
    // todo - log exceptions
}
