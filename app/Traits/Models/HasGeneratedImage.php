<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

trait HasGeneratedImage
{
    abstract protected function imageDir(): string;

    public function makeImage(string $size, string $method = 'resize'): string
    {
        $value = $this->{$this->imageColumn()};

        if($this->multipleImages()) {
            $value = Arr::first($value);
        }

        return $this->imageUrl($value, $size, $method);
    }

    public function makeImages(string $size, string $method = 'resize'): Collection
    {
        return $this->{$this->imageColumn()}
            ->map(fn($value) => $this->imageUrl($value, $size, $method));
    }

    private function imageUrl(?string $file, string $size, string $method = 'resize'): string
    {
        if(empty($file)) {
            return "https://via.placeholder.com/$size";
        }

        return route('image', [
            'size' => $size,
            'dir' => $this->imageDir(),
            'method' => $method,
            'file' => File::basename($file)
        ]);
    }

    protected function imageColumn(): string
    {
        return 'image';
    }

    protected function multipleImages(): bool
    {
        return false;
    }
}
