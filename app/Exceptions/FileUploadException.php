<?php

namespace App\Exceptions;

use Exception;

class FileUploadException extends Exception
{
    protected $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    public function render()
    {
        return response([
            'status' => 'error',
            'text' => 'file_upload_validation_failed',
            'message' => 'داده‌ّای ارسالی نامعتبر هستند.',
            'data' => $this->exception->validator->messages(),
        ], 422);
    }
}
