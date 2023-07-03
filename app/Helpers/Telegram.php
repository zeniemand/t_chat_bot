<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Telegram
{
    protected object $http;
    protected string $bot;

    const URL = "https://api.telegram.org/bot";

    public function __construct(Http $http, string $bot)
    {
        $this->http = $http;
        $this->bot = $bot;
    }

    public function sendMessage(int $chat_id, string $message)
    {
        $this->http::post(self::URL . $this->bot . "/sendMessage", [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html'
        ]);
    }

}
