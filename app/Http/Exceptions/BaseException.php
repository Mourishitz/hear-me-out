<?php

namespace App\Http\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * BaseException
 */
abstract class BaseException extends Exception
{
    protected array $customResponse = [];

    /**
     * Get the default context variables for logging.
     *
     * @return array<string, mixed>
     */
    protected function context(): array
    {
        $context = [
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'previous_file' => $this?->getPrevious()?->getFile(), /** @phpstan-ignore-line **/
            'previous_line' => $this?->getPrevious()?->getLine(), /** @phpstan-ignore-line **/
            'previous_code' => $this->getPreviousOriginalCode($this?->getPrevious()), /** @phpstan-ignore-line **/
            'previous_message' => $this->getPreviousOriginalMessage($this?->getPrevious()), /** @phpstan-ignore-line **/
        ];

        if (! empty($this->customResponse)) {
            return array_merge($context, $this->customResponse);
        }

        return $context;
    }

    private function getPreviousOriginalMessage(?Throwable $previous = null): ?string
    {
        if ($this->getMessage() === $previous?->getMessage()) {
            return $this->getPreviousOriginalMessage($previous?->getPrevious()); /** @phpstan-ignore-line **/
        }

        return $previous?->getMessage();
    }

    private function getPreviousOriginalCode(?Throwable $previous = null): null|int|string
    {
        if ($this->getCode() === $previous?->getCode()) {
            return $this->getPreviousOriginalCode($previous?->getPrevious()); /** @phpstan-ignore-line **/
        }

        return $previous?->getCode();
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error(static::class, $this->context());
    }
}
