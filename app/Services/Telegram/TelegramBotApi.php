<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Exeption\TelegramBotApiExeption;
use Illuminate\Support\Facades\Http;

use Throwable ;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';
    public static function sendMessage(string $token, int $chatId, string $text):bool
    {
        try{
            $response = HTTP::withoutVerifying()->get(self::HOST.$token.'/sendMessage',[
                'chat_id' => $chatId,
                'text' => $text,
            ])->throw()->json();

            return $response['ok'] ?? false;

        }catch (Throwable $e){
            report(new TelegramBotApiExeption($e->getMessage()));

            return false;
        }

    }
}
