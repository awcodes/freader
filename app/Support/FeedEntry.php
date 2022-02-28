<?php

namespace App\Support;

use Carbon\Carbon;

class FeedEntry
{
    public function __construct(
        public string $id,
        public string $title,
        public string $link,
        public Carbon $updated,
        public ?string $summary,
    ) {
    }
}
