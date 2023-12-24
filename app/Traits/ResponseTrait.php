<?php

namespace App\Traits;

trait ResponseTrait
{
    protected function successResponse(array $data = [], int $code = 200): array {
        return [
            "status" => "ok",
            "data" => $data,
        ];
    }

    protected function failedResponse(array $errors, int $code = 500): array {
        return [
            "status" => "failed",
            "errors" => $errors,
        ];
    }
}
