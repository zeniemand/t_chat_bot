<?php

namespace App\Listeners;

use App\Events\OrderStore;
use App\Helpers\Telegram;

class TelegramSubscriber
{
    protected object $telegram;

    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }
    /**
     * @param OrderStore $event
     * @return void
     */
    public function orderStore(OrderStore $event): void
    {
        $data = [
            'id' => $event->order->id,
            'name' => $event->order->name,
            'email' => $event->order->email,
            'product' => $event->order->product
        ];

        $buttons = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Прийняти',
                        'callback_data' => '1|' . $event->order->secret_key
                    ],
                    [
                        'text' => 'Скасувати',
                        'callback_data' => '0|' . $event->order->secret_key
                    ]
                ]
            ]
        ];

        $this->telegram->sendMessageWithButtons(env('CHAT_ID'), (string)view('site.messages.new_order', $data), $buttons)->sendDocument(env('CHAT_ID'), 'cats_logo_1.png');

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function subscribe($event)
    {
        $event->listen(
            OrderStore::class, [
                TelegramSubscriber::class, 'orderStore'
            ]
        );
    }
}
