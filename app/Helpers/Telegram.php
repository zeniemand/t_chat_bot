<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram
{
    protected object $http;
    protected string $bot;
    protected array $button;
    protected int|null $reply_id;

    const URL = "https://api.telegram.org/bot";

    public function __construct(Http $http, string $bot)
    {
        $this->http = $http;
        $this->bot = $bot;
        $this->setButtons();
    }

    protected function setButtons()
    {
        $this->button = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'button1',
                        'callback_data' => '1'
                    ],
                    [
                        'text' => 'button2',
                        'callback_data' => '2'
                    ]
                ]
            ]
        ];
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

    public function sendMessageWithButtons(int $chat_id, string $message, $button = null)
    {
        $button = $button ?? $this->button;
        $http = $this->http::post(self::URL . $this->bot . "/sendMessage", [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => json_encode($button)
        ]);

        if (json_decode($http)->result->message_id) {
            $this->reply_id = json_decode($http)->result->message_id;
        }

        return $this;
    }

    public function editMessageWithButtons(int $chat_id, string $message, $button = null)
    {
        $button = $button ?? $this->button;
        $http = $this->http::post(self::URL . $this->bot . "/editMessageText", [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => json_encode($button),
            'message_id' => $this->reply_id
        ]);

        if (json_decode($http)->result->message_id) {
            $this->reply_id = json_decode($http)->result->message_id;
        }

        return $this;
    }

}
