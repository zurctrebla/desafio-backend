<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\VideoDTO;
use Illuminate\Support\Facades\Http;

class PexelsVideoService implements PexelsVideoServiceInterface
{
    private string $token;
    private string $url;

    public function __construct()
    {
        $this->initializeConfig();
    }

    private function initializeConfig(): void
    {
        $this->token = config('config.api_token');
        $this->url = config('config.api_url');

        if (empty($this->token)) {
            throw new \InvalidArgumentException('API token is not set in the environment variables.');
        }

        if (empty($this->url)) {
            throw new \InvalidArgumentException('API URL is not set in the environment variables.');
        }
    }

    public function search(array $params): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->get($this->url, $params);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch data from Pexels API');
        }

        $data = $response->json();

        $items = collect($data['videos'])
            ->map(fn($video) => (new VideoDTO($video))->toArray())
            ->toArray();

        return [
            'items' => (array) $items,
            'page' => (int) $data['page'],
            'per_page' => (int) $data['per_page'],
            'total_pages' => (int) $data['total_results'] > 0
                ? ceil($data['total_results'] / $data['per_page'])
                : 0,
        ];
    }
}
