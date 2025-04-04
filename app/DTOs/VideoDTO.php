<?php

declare(strict_types=1);

namespace App\DTOs;

class VideoDTO
{
    public int $id;
    public int $width;
    public int $height;
    public int $duration;
    public string $userName;
    public array $videoFiles = [];
    public array $videoPictures = [];

    /**
     * VideoDTO constructor.
     *
     * @param array $data
     */
    public function __construct(array $video)
    {
        $this->id = $video['id'] ?? 0;
        $this->width = $video['width'] ?? 0;
        $this->height = $video['height'] ?? 0;
        $this->duration = $video['duration'] ?? 0;
        $this->userName = $video['user']['name'] ?? 'Desconhecido';
        $this->videoFiles = array_map(function ($file) {
            return [
                'id' => $file['id'] ?? 0,
                'quality' => $file['quality'] ?? '',
                'file_type' => $file['file_type'] ?? '',
                'width' => $file['width'] ?? 0,
                'height' => $file['height'] ?? 0,
                'fps' => $file['fps'] ?? 0,
                'link' => $file['link'] ?? '',
                'size' => $file['size'] ?? 0,
            ];
        }, is_array($video['video_files'] ?? null) ? $video['video_files'] : []);
        
        $this->videoPictures = array_map(function ($picture) {
            return [
                'id' => $picture['id'] ?? 0,
                'nr' => $picture['nr'] ?? 0,
                'picture' => $picture['picture'] ?? '',
            ];
        }, is_array($video['video_pictures'] ?? null) ? $video['video_pictures'] : []);
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'width' => $this->width,
            'height' => $this->height,
            'duration' => $this->duration,
            'userName' => $this->userName,
            'videoFiles' => $this->videoFiles,
            'videoPictures' => $this->videoPictures,
        ];
    }
}
