<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
/**
 * Before you run this example:
 * 1. install monolog/monolog: composer require monolog/monolog
 * 2. copy config.php.dist to config.php: cp config.php.dist config.php
 *
 * @author Novikov Bogdan <hcbogdan@gmail.com>
 */
require_once("./vendor/autoload.php");
use Viber\Bot;
use Viber\Api\Sender;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$config = require('./config.php');
$apiKey = $config['apiKey'];
// reply name
$botSender = new Sender([
    'name' => 'R1Sport',
    'avatar' => 'https://developers.viber.com/img/favicon.ico',
]);
// log bot interaction
$log = new Logger('bot');
$log->pushHandler(new StreamHandler('/tmp/bot.log'));
$bot = null;
try {
    // create bot instance
    $bot = new Bot(['token' => $apiKey]);
    $bot
    // first interaction with bot - return "welcome message"
    ->onConversation(function ($event) use ($bot, $botSender, $log) {
        $log->info('onConversation handler');
               return     (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setText("Здравствуйте, я бот R1Sport. Выберите, пожалуйста, интересующий вас вопрос")
             ->setKeyboard(
                        (new \Viber\Api\Keyboard())
                        ->setButtons([
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#8074d6')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn1-click')
                            ->setText('Контактная Информация'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#2fa4e7')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Оставшееся количество занятий'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#00BFFF')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Последнее посещение'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#20B2AA')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Депозитный счет'),
                        ])
                    );
    })
    
    // when user subscribe to PA
    ->onSubscribe(function ($event) use ($bot, $botSender, $log) {
        $log->info('onSubscribe handler');
        $this->getClient()->sendMessage(
            (new \Viber\Api\Message\Text())
            ->setSender($botSender)
            ->setText('Thanks for subscription!')
        );
    })
    ->onText('|btn1-click|s', function ($event) use ($bot, $botSender, $log) {
        $log->info('click on button');
        $receiverId = $event->getSender()->getId();
        $bot->getClient()->sendMessage(
            (new \Viber\Api\Message\Location())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setLat(53.9243211)
                    ->setLng(27.5993729)
                    
                    
        );
        
        $bot->getClient()->sendMessage(
            (new \Viber\Api\Message\Url())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setMedia('https://R1Sport.by')
                    
        );
          $bot->getClient()->sendMessage(
            (new \Viber\Api\Message\Contact())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setName('Администратор R1Sport')
                    ->setPhoneNumber('+375445531041')
                    ->setKeyboard(
                        (new \Viber\Api\Keyboard())
                        ->setButtons([
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#8074d6')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn1-click')
                            ->setText('Контактная Информация'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#2fa4e7')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Оставшееся количество занятий'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#00BFFF')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Последнее посещение'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#20B2AA')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Депозитный счет'),
                        ]))
                    
        );
        
    })
    ->onText('|k\d+|is', function ($event) use ($bot, $botSender, $log) {
        $caseNumber = intval(
            preg_replace(
                '|[^0-9]|s', '',
                $event->getMessage()->getText()
            )
        );
        $log->info('onText demo handler #'.$caseNumber);
        $client = $bot->getClient();
        $receiverId = $event->getSender()->getId();
        switch ($caseNumber) {
            case 0:
                $client->sendMessage(
                    (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setText('Basic keyboard layout')
                    ->setKeyboard(
                        (new \Viber\Api\Keyboard())
                        ->setButtons([
                            (new \Viber\Api\Keyboard\Button())
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Tap this button')
                        ])
                    )
                );
                break;
            //
            case 1:
                $client->sendMessage(
                    (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setText("Здравствуйте, я бот R1Sport. Выберите, пожалуйста, интересующий вас вопрос")
                    ->setKeyboard(
                        (new \Viber\Api\Keyboard())
                        ->setButtons([
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#8074d6')
                            ->setTextSize('small')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Контактная Информация'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#2fa4e7')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Оставшееся количество занятий'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#555555')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn-click')
                            ->setText('Последнее посещение'),
                        ])
                    )
                );
                break;
            //
            case 2:
                $client->sendMessage(
                    (new \Viber\Api\Message\Contact())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setName('Администратор R1Sport')
                    ->setPhoneNumber('+375445531041')
                );
                break;
            //
            case 3:
                $client->sendMessage(
                    (new \Viber\Api\Message\Location())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setLat(48.486504)
                    ->setLng(35.038910)
                );
                break;
            //
            case 4:
                $client->sendMessage(
                    (new \Viber\Api\Message\Sticker())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setStickerId(114408)
                );
                break;
            //
            case 5:
                $client->sendMessage(
                    (new \Viber\Api\Message\Url())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setMedia('https://R1Sport.by')
                );
                break;
            //
            case 6:
                $client->sendMessage(
                    (new \Viber\Api\Message\Picture())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setText('some media data')
                    ->setMedia('https://developers.viber.com/img/devlogo.png')
                );
                break;
            //
            case 7:
                $client->sendMessage(
                    (new \Viber\Api\Message\Video())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setSize(2 * 1024 * 1024)
                    ->setMedia('http://techslides.com/demos/sample-videos/small.mp4')
                );
                break;
        }
    })
    ->run();
} catch (Exception $e) {
    $log->warning('Exception: '. $e->getMessage());
    if ($bot) {
        $log->warning('Actual sign: '. $bot->getSignHeaderValue());
        $log->warning('Actual body: '. $bot->getInputBody());
    }
}