<?php

namespace App\Providers\Integrators\Apis;

use App\Enums\SpotifyModelTypeEnum;
use App\Enums\SpotifyModulesEnum;
use App\Providers\BaseApi;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class Spotify extends BaseApi
{
    protected string $url = 'https://api.spotify.com/v1/';

    private string $apiKey = '';

    public function __construct()
    {
        $this->refreshApiKey();
    }

    private function handleSpotifyError(Response $response)
    {
        throw new \Exception(
            message: 'Spotify API request failed: '.$response->json('error.message'),
            code: $response->status(),
        );
    }

    private function refreshApiKey(): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic '.base64_encode(env('SPOTIFY_CLIENT_ID').':'.env('SPOTIFY_CLIENT_SECRET')),
        ])->asForm()->post(url: 'https://accounts.spotify.com/api/token', data: [
            'grant_type' => 'client_credentials',
        ]);

        $data = $response->json();
        $this->apiKey = $data['access_token'];
    }

    private function refreshUserToken(): void
    {
        /** @var \App\Models\User $user */
        $user = JWTAuth::parseToken()->authenticate();

        $token = $this->post(
            endpoint: 'https://accounts.spotify.com/api/token',
            params: [
                'grant_type' => 'refresh_token',
                'refresh_token' => $user->spotify_refresh_token,
            ],
            headers: [
                'Authorization' => 'Basic '.base64_encode(env('SPOTIFY_CLIENT_ID').':'.env('SPOTIFY_CLIENT_SECRET')),
            ]
        );
    }

    private function request(string $endpoint, string $method, array $params, array $headers, callable $unauthorizedCallback)
    {
        $response = $this->$method(
            endpoint: $endpoint,
            params: $params,
            headers: $headers
        );

        if ($response->unauthorized()) {
            $unauthorizedCallback();
            unset($response);
            $response = $this->$method(
                endpoint: $endpoint,
                params: $params,
                headers: $headers
            );
        }

        if ($response->failed()) {
            $this->handleSpotifyError($response);
        }

        return $response->json();
    }

    private function spotifyUserRequest(string $endpoint, string $method, array $params, array $headers): array {}

    /**
     * @param  array<int,mixed>  $params
     * @param  array<int,mixed>  $headers
     */
    private function spotifyRequest(string $endpoint, string $method, array $params, array $headers): array
    {
        return $this->request(
            endpoint: $endpoint,
            method: $method,
            params: $params,
            headers: $headers,
            unauthorizedCallback: function () {
                $this->refreshApiKey();
            }
        );
    }

    private function search(string $query, SpotifyModelTypeEnum $type, int $limit = 10): array
    {
        return $this->spotifyRequest(
            endpoint: 'search',
            method: 'get',
            params: [
                'q' => $query,
                'type' => $type->value,
                'limit' => $limit,
            ],
            headers: [
                'Authorization' => 'Bearer '.$this->apiKey,
            ]
        );
    }

    public function getRelationForId(string $entityId, SpotifyModulesEnum $entityModule, SpotifyModulesEnum $relationModule): array
    {
        return $this->spotifyRequest(
            endpoint: $entityModule->value.'/'.$entityId.'/'.$relationModule->value,
            method: 'get',
            params: [],
            headers: [
                'Authorization' => 'Bearer '.$this->apiKey,
            ]
        );
    }

    public function findById(string $id, SpotifyModulesEnum $module): array
    {
        return $this->spotifyRequest(
            endpoint: $module->value.'/'.$id,
            method: 'get',
            params: [],
            headers: [
                'Authorization' => 'Bearer '.$this->apiKey,
            ]
        );
    }

    public function indexType(SpotifyModelTypeEnum $type, int $limit = 10, string $query = ''): array
    {
        return $this->search(query: $query, type: $type, limit: $limit)[Str::plural($type->value)]['items'];
    }
}
