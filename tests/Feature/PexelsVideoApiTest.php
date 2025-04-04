<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\PexelsVideoServiceInterface;

class PexelsVideoApiTest extends TestCase
{
    /**
     * Test if the API returns a 200 status code.
     */
    public function test_api_returns_expected_json(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnsureTokenIsValid::class);
        $this->instance(PexelsVideoServiceInterface::class, new class implements PexelsVideoServiceInterface {
            public function search(array $params): array
            {
                return [
                    'items' => [
                        [
                            'id' => 1,
                            'width' => 1920,
                            'height' => 1080,
                            'duration' => 120,
                            'userName' => 'Albert Cruz',
                            'videoPictures' => [
                                ['id' => 101, 'nr' => 1, 'picture' => 'https://example.com/picture1.jpg'],
                                ['id' => 102, 'nr' => 2, 'picture' => 'https://example.com/picture2.jpg'],
                            ],
                            'videoFiles' => [
                                [
                                    'id' => 9326316,
                                    'quality' => 'uhd',
                                    'file_type' => 'video/mp4',
                                    'width' => 2560,
                                    'height' => 1440,
                                    'fps' => 29.97,
                                    'link' => 'https://videos.pexels.com/video1.mp4',
                                    'size' => 56038183
                                ]
                            ],
                        ]
                    ],
                    'page' => 1,
                    'per_page' => 1,
                    'total_pages' => 1
                ];
            }
        });

        $response = $this->getJson('/api/videos?query=nature&per_page=1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'items' => [
                '*' => [
                    'id',
                    'width',
                    'height',
                    'duration',
                    'userName',
                    'videoPictures' => [
                        '*' => [
                            'id',
                            'nr',
                            'picture'
                        ]
                    ],
                    'videoFiles' => [
                        '*' => [
                            'id',
                            'quality',
                            'file_type',
                            'width',
                            'height',
                            'fps',
                            'link',
                            'size'
                        ]
                    ]
                ]
            ],
            'page',
            'per_page',
            'total_pages'
        ]);
    }
}
