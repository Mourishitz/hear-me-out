<?php

namespace App\Providers;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class BaseApi
{
    protected string $url;

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param  array<string,mixed>  $params
     * @param  array<string,mixed>  $headers
     */
    public function get(string $endpoint, array $params, array $headers = []): Response
    {
        return Http::withHeaders($headers)
            ->get($this->getUrl().$endpoint, $params);
    }

    /**
     * @param  array<string,mixed>  $params
     * @param  array<string,mixed>  $headers
     */
    public function post(string $endpoint, array $params, array $headers = []): Response
    {
        return Http::withHeaders($headers)
            ->post($this->getUrl().$endpoint, $params);
    }

    /**
     * @param  array<string,mixed>  $params
     * @param  array<string,mixed>  $headers
     */
    public function put(string $endpoint, array $params, array $headers = []): Response
    {
        return Http::withHeaders($headers)
            ->put($this->getUrl().$endpoint, $params);
    }

    /**
     * @param  array<string,mixed>  $params
     * @param  array<string,mixed>  $headers
     */
    public function delete(string $endpoint, array $params, array $headers = []): Response
    {
        return Http::withHeaders($headers)
            ->delete($this->getUrl().$endpoint, $params);
    }

    /**
     * @param  array<string,mixed>  $params
     * @param  array<string,mixed>  $headers
     */
    public function patch(string $endpoint, array $params, array $headers = []): Response
    {
        return Http::withHeaders($headers)
            ->patch($this->getUrl().$endpoint, $params);
    }
}
