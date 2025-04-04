<?php

namespace Tests\Unit;

use App\DTOs\VideoDTO;
use PHPUnit\Framework\TestCase;

class VideoDTOTest extends TestCase
{
    /**
     * Test if the VideoDTO correctly maps the video data.
     */
    public function test_video_dto(): void
    {
        $video = [
            'id' => 1,
            'width' => 1920,
            'height' => 1080,
            'duration' => 120,
            'user' => [
                'id' => 1,
                'name' => 'Albert Cruz',
                'url' => 'https://example.com/user/johndoe',
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

        $dto = new VideoDTO($video);

        $this->assertIsArray($dto->toArray());

        $this->assertEquals(1, $dto->id);
        $this->assertEquals(1920, $dto->width);
        $this->assertEquals(1080, $dto->height);
        $this->assertEquals(120, $dto->duration);
        $this->assertEquals('Albert Cruz', $dto->userName);

        $this->assertIsArray($dto->videoPictures);
        $this->assertCount(2, $dto->videoPictures);
        $this->assertEquals('https://example.com/picture1.jpg', $dto->videoPictures[0]['picture']);
        $this->assertEquals(101, $dto->videoPictures[0]['id']);
        $this->assertEquals(1, $dto->videoPictures[0]['nr']);

        $this->assertIsArray($dto->videoFiles);
        $this->assertCount(1, $dto->videoFiles);
        $this->assertEquals(9326316, $dto->videoFiles[0]['id']);
        $this->assertEquals('uhd', $dto->videoFiles[0]['quality']);
        $this->assertEquals('video/mp4', $dto->videoFiles[0]['file_type']);
        $this->assertEquals(2560, $dto->videoFiles[0]['width']);
        $this->assertEquals(1440, $dto->videoFiles[0]['height']);
        $this->assertEquals(29.97, $dto->videoFiles[0]['fps']);
        $this->assertEquals('https://videos.pexels.com/video1.mp4', $dto->videoFiles[0]['link']);
        $this->assertEquals(56038183, $dto->videoFiles[0]['size']);
    }

    /**
     * Test if the DTO handles missing or invalid data.
     */
    public function test_missing_or_invalid_data()
    {
        $incompleteVideo = [
            // 'id' => missing
            'width' => null,
            'height' => null,
            'duration' => null,
            // 'user' => missing
            'video_pictures' => [
                ['not_picture_key' => 'broken_url'],
                [],
                ['picture' => null],
            ],
            // 'video_files' => missing
        ];

        $dto = new VideoDTO($incompleteVideo);

        $this->assertEquals(0, $dto->id);
        $this->assertEquals(0, $dto->width);
        $this->assertEquals(0, $dto->height);
        $this->assertEquals(0, $dto->duration);
        $this->assertEquals('Desconhecido', $dto->userName);

        $this->assertIsArray($dto->videoFiles);
        $this->assertEquals([], $dto->videoFiles);

        $this->assertIsArray($dto->videoPictures);
        $this->assertCount(3, $dto->videoPictures);

        foreach ($dto->videoPictures as $picture) {
            $this->assertIsArray($picture);
            $this->assertArrayHasKey('id', $picture);
            $this->assertArrayHasKey('nr', $picture);
            $this->assertArrayHasKey('picture', $picture);

            $this->assertEquals(0, $picture['id']);
            $this->assertEquals(0, $picture['nr']);
            $this->assertEquals('', $picture['picture']);
        }
    }
}
