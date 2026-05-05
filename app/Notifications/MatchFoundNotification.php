<?php

namespace App\Notifications;

use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MatchFoundNotification extends Notification
{
    use Queueable;

    public function __construct(
        public LostItem $lostItem,
        public FoundItem $foundItem
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'       => "A found item may match your lost \"{$this->lostItem->item_name}\".",
            'lost_item_id'  => $this->lostItem->id,
            'found_item_id' => $this->foundItem->id,
            'found_item'    => $this->foundItem->item_name,
            'lost_item'     => $this->lostItem->item_name,
        ];
    }
}
