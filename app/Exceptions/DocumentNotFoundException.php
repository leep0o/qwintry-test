<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class DocumentNotFoundException extends Exception
{
    /**
     * @var string
     */
    public $message;

    /**
     * DocumentNotFoundException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct();
        $this->message = $message;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json($this->message);
    }
}
