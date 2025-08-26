<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class LogHelper
{
    /**
     * Log API requests
     */
    public static function api($message, $level = 'info', $context = [])
    {
        Log::channel('api')->$level($message, $context);
    }

    /**
     * Log debug information
     */
    public static function debug($message, $context = [])
    {
        Log::channel('debug')->debug($message, $context);
    }

    /**
     * Log errors with stack trace
     */
    public static function error($message, $exception = null, $context = [])
    {
        if ($exception) {
            $context['exception'] = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ];
        }

        Log::channel('api')->error($message, $context);
    }

    /**
     * Log authentication events
     */
    public static function auth($action, $user = null, $context = [])
    {
        $context['action'] = $action;
        if ($user) {
            $context['user_id'] = $user->id;
            $context['user_email'] = $user->email;
        }

        Log::channel('api')->info("Auth: $action", $context);
    }
} 