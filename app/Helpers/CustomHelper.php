<?php

namespace App\Helpers;

class CustomHelper
{
    public static function onShow($componentInstance,$is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        $alert = $is_confirm ? 'confirm-alert' : 'show-alert';
        $componentInstance->dispatchBrowserEvent($alert, [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data
        ]);
    }

}
