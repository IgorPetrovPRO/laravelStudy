<?php

namespace Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;
    protected string $token;
    protected string $text;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        parent::__construct($level);
        $this->chatId = (int) $config['chat_id'];
        $this->token = $config['token'];
    }


    protected function write(array $record): void
    {
        //
        app(TelegramBotApiContract::class)::sendMessage(
            $this->token,
            $this->chatId,
            $record['formatted']
        );
        //TelegramBotApi::sendMessage($this->token, $this->chatId, $record['formatted']);
    }

}
