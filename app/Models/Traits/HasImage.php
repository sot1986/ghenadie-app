<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Image;

trait HasImage
{
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
