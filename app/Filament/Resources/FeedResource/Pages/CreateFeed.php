<?php

namespace App\Filament\Resources\FeedResource\Pages;

use App\Jobs\ProcessFeed;
use App\Filament\Resources\FeedResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeed extends CreateRecord
{
    protected static string $resource = FeedResource::class;
}
