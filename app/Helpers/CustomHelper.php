<?php

namespace App\Helpers;

class CustomHelper
{
    public static function onShow($componentInstance,$is_confirm = false, $title = null, $message = null, $confirm_message = null, $type = null, $data = null)
    {
        $alert = $is_confirm ? 'confirm-alert' : 'show-alert';
        $componentInstance->dispatchBrowserEvent($alert, [
            'title' => $title,
            'message' => $message,
            'confirm_message' => $confirm_message,
            'type' => $type,
            'data' => $data
        ]);
    }

    public static function onRemoveModal($componentInstance, $modalName = null)
    {
        $componentInstance->dispatchBrowserEvent('remove-modal', [
            'modalName' => $modalName
        ]);
    }

}
