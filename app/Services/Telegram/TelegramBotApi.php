<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use \Exception;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';
    public static function sendMessage(string $token, int $chatId, string $text):void
    {
        HTTP::withoutVerifying()->get(self::HOST.$token.'/sendMessage',[
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }
}
