<?php

declare(strict_types=1);

namespace App\Services;

interface PexelsVideoServiceInterface
{
    /**
     * Search for videos using the Pexels API.
     *
     * @param array $params
     * @return array
     */
    public function search(array $params): array;
}