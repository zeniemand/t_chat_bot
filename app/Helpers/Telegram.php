<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram
{
    protected object $http;
    protected string $bot;
    protected int|null $reply_id;

    const URL = "https://api.telegram.org/bot";

    public function __construct(Http $http, string $bot)
    {
        $this->http = $http;
        $this->bot = $bot;
    }

    public function sendMessage(int $chat_id, string $message)
    {
        $http = $this->http::post(self::URL . $this->bot . "/sendMessage", [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html'
        ]);

        if (json_decode($http)->result->message_id) {
            $this->reply_id = json_decode($http)->result->message_id;
        }

        return $this;
    }

    public function sendDocument(int $chat_id,  $file)
    {
       $this->http::attach('document', Storage::get('/public/' . $file), 'киця.png' )->post( self::URL . $this->bot . "/sendDocument", [
            'chat_id' => $chat_id,
            'reply_to_message_id' => $this->reply_id,
        ]);

        $this->reply_id = null;

        return $this;
    }

}
