<?php

namespace Tests\Unit;

use App\DTOs\VideoDTO;
use PHPUnit\Framework\TestCase;
use App\Services\PexelsVideoServiceInterface;

class PexelsVideoServiceTest extends TestCase
{
    /**
     * Test the PexelsVideoServiceInterface implementation with a mock.
     */
    public function test_service_returns_expected_data(): void
    {
        $video = [
            'id' => 1,
            'width' => 1920,
            'height' => 1080,
            'duration' => 120,
            'user' => [
                'id' => 1,
                'name' => 'Albert Cruz',
                'url' => 'https://example.com/user/albertcruz',
            ],
            'video_pictures' => [
                ['id' => 101, 'nr' => 1, 'picture' => 'https://example.com/picture1.jpg'],
                ['id' => 102, 'nr' => 2, 'picture' => 'https://example.com/picture2.jpg'],
            ],
            'video_files' => [
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
            ]
        ];

        $mockService = $this->createMock(PexelsVideoServiceInterface::class);

        $mockService->method('search')
            ->willReturn([
                'items' => [
                    (new VideoDTO($video))->toArray()
                ],
                'page' => 1,
                'per_page' => 1,
                'total_pages' => 1
            ]);

        $result = $mockService->search([
            'query' => 'nature',
            'page' => 1,
            'per_page' => 1
        ]);

        $item = $result['items'][0];

        $this->assertEquals(1, $item['id']);
        $this->assertEquals(1920, $item['width']);
        $this->assertEquals(1080, $item['height']);
        $this->assertEquals(120, $item['duration']);
        $this->assertEquals('Albert Cruz', $item['userName']);

        $this->assertIsArray($item['videoPictures']);
        $this->assertCount(2, $item['videoPictures']);
        $this->assertEquals('https://example.com/picture1.jpg', $item['videoPictures'][0]['picture']);
        $this->assertEquals(101, $item['videoPictures'][0]['id']);
        $this->assertEquals(1, $item['videoPictures'][0]['nr']);

        $this->assertIsArray($item['videoFiles']);
        $this->assertCount(1, $item['videoFiles']);
        $this->assertEquals(9326316, $item['videoFiles'][0]['id']);
        $this->assertEquals('uhd', $item['videoFiles'][0]['quality']);
        $this->assertEquals('video/mp4', $item['videoFiles'][0]['file_type']);
        $this->assertEquals(2560, $item['videoFiles'][0]['width']);
        $this->assertEquals(1440, $item['videoFiles'][0]['height']);
        $this->assertEquals(29.97, $item['videoFiles'][0]['fps']);
        $this->assertEquals('https://videos.pexels.com/video1.mp4', $item['videoFiles'][0]['link']);
        $this->assertEquals(56038183, $item['videoFiles'][0]['size']);
    }

    /**
     * Test the PexelsVideoServiceInterface implementation with invalid data.
     */
    public function test_service_handles_invalid_video_data(): void
    {
        $video = [
            'user' => null,
            'video_pictures' => [
                ['foo' => 'bar'],
            ],
            'video_files' => 'invalid-string',
        ];

        $mockService = $this->createMock(PexelsVideoServiceInterface::class);
        $mockService->method('search')
            ->willReturn([
                'items' => [
                    (new VideoDTO($video))->toArray()
                ],
                'page' => 1,
                'per_page' => 1,
                'total_pages' => 1
            ]);

        $result = $mockService->search([
            'query' => 'test',
            'page' => 1,
            'per_page' => 1
        ]);

        $item = $result['items'][0];

        $this->assertEquals(0, $item['id']);
        $this->assertEquals(0, $item['width'] ?? 0);
        $this->assertEquals(0, $item['height'] ?? 0);
        $this->assertEquals(0, $item['duration']);
        $this->assertEquals('Desconhecido', $item['userName']);

        $this->assertIsArray($item['videoPictures']);
        $this->assertCount(1, $item['videoPictures']);
        $this->assertEquals([
            'id' => 0,
            'nr' => 0,
            'picture' => ''
        ], $item['videoPictures'][0]);

        $this->assertIsArray($item['videoFiles']);
        $this->assertEmpty($item['videoFiles']);
    }
}
