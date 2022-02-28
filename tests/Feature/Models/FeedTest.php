<?php

use App\Models\Feed;
use App\Support\FeedReader;

it('can be process', function () {
    $feed = Feed::create([
        'name' => 'Laracasts',
        'url' => 'https://laracasts.com/feed',
        'last_processed_at' => now()->subYears(10),
    ]);

    expect($feed->process())
        ->toBeTrue();

    expect($feed->entries()->count())
        ->not->toBe(0);

    $entry = FeedReader::make('https://laracasts.com/feed')->read()->entries()->first();

    expect($feed->entries()->first())
        ->title->toBe($entry->title)
        ->summary->toBe($entry->summary)
        ->content->toBe($entry->content)
        ->feed_entry_id->toBe($entry->id);
});

it('will not be processed if feed is older than most recent processed timestamp', function () {
    $feed = new Feed([
        'name' => 'Foo',
        'url' => 'https://laracasts.com/feed',
        'last_processed_at' => now()->addYear(),
    ]);

    expect($feed->process())->toBeFalse();
});
