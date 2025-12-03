<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function sendErrorResponse(
        string $message = 'Maaf, terjadi kesalahan. Coba beberapa saat lagi atau hubungi tim kami',
        int $code = 500
    ): JsonResponse {
        return response()->json(['error' => $message], $code);
    }
}
