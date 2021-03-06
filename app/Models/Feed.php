<?php

namespace App\Models;

use Carbon\Carbon;
use App\Jobs\ProcessFeed;
use App\Support\FeedEntry;
use App\Support\FeedReader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feed extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'last_updated_at' => 'datetime'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($feed) {
            dispatch(new ProcessFeed($feed));
        });
    }

    public function entries()
    {
        return $this->hasMany(Entry::class)->latest();
    }

    public function unreadEntries()
    {
        return $this->hasMany(Entry::class)->where('read', 0)->orWhereDate('updated_at', Carbon::today())->latest();
    }

    public function process(): bool
    {
        $reader = FeedReader::make($this->url)->read();

        if ($reader->updated()->isBefore($this->last_processed_at)) {
            return false;
        }

        $reader->entries()->each(function (FeedEntry $entry) {
            $this->entries()->updateOrCreate([
                'feed_entry_id' => $entry->id,
            ], [
                'title' => $entry->title,
                'summary' => $entry->summary,
                'link' => $entry->link,
                'updated' => $entry->updated,
            ]);
        });

        return true;
    }
}
