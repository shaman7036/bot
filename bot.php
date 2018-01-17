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
$config = require('./../botconfig.php');
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
                            ->setActionBody('btn2-click')
                            ->setText('Оставшееся количество занятий'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#00BFFF')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn3-click')
                            ->setText('Последнее посещение'),
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#20B2AA')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('btn4-click')
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

    ->onText('|btn2-click|s', function ($event) use ($bot, $botSender, $log) {
        $log->info('click on button');
        $receiverId = $event->getSender()->getId();
     $bot->getClient()->sendMessage(
            (new \Viber\Api\Message\Text())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setText('Нажмите на кнопку, что бы указать номер телефона.')
                    ->setKeyboard(
                        (new \Viber\Api\Keyboard())
                        ->setButtons([
                            (new \Viber\Api\Keyboard\Button())
                            ->setBgColor('#8074d6')
                            ->setTextSize('large')
                            ->setTextHAlign('center')
                            ->setActionType('reply')
                            ->setActionBody('setphone-click')
                            ->setText('Указать номер'),
                          
                        ]))
        );
          
        
    })
    
    
    ->onText('|btn1-click|s', function ($event) use ($bot, $botSender, $log) {
        $log->info('click on button');
        $receiverId = $event->getSender()->getId();
        $bot->getClient()->sendMessage(
            (new \Viber\Api\Message\Contact())
                    ->setSender($botSender)
                    ->setReceiver($receiverId)
                    ->setName('Администратор R1Sport')
                    ->setPhoneNumber('+375445531041')
                    
                    
        );
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
    
    ->run();
} catch (Exception $e) {
    $log->warning('Exception: '. $e->getMessage());
    if ($bot) {
        $log->warning('Actual sign: '. $bot->getSignHeaderValue());
        $log->warning('Actual body: '. $bot->getInputBody());
    }
}