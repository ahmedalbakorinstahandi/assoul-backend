<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class MessageService
{


    public static function abort($status, $message, $trans = false)
    {
        abort(
            response()->json(
                [
                    'success' => false,
                    'message' => $trans ? trans($message) : $message,
                ],
                $status
            )
        );
    }
}
