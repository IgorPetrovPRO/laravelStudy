<?php

namespace Services\Telegram;

use Http;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
    public function test_send_message_success():void
    {
        Http::fake([
            TelegramBotApi::HOST.'*' => Http::response(['ok' => true], 200)
        ]);

        $result = TelegramBotApi::sendMessage('',1,'Testing');
        $this->assertTrue($result);
    }

}
