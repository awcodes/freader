<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Orchestra\Parser\Xml\Document;
use Orchestra\Parser\Xml\Facade as Xml;

class FeedReader
{
    protected ?Document $document = null;

    public function __construct(
        protected string $url
    ) {
    }

    public static function make(string $url): static
    {
        return new static($url);
    }

    public function read(): static
    {
        if ($this->loaded()) {
            return $this;
        }

        $this->document = Xml::load($this->url);

        return $this;
    }

    public function updated(): Carbon
    {
        $results = $this->document->parse([
            'updated' => ['uses' => 'updated'],
            'last_build_date' => ['uses' => 'lastBuildDate'],
        ]);

        $date = $results['updated'] ?: $results['last_build_date'];

        return Carbon::parse($date);
    }

    public function entries(): Collection
    {
        // RSS rss has item
        // ATOM feed has entry

        $articles = $this->document->parse([
            'entries' => [
                'uses' => 'entry[id,title,link::href>link,summary,updated]',
            ],
            'items' => [
                'uses' => 'channel.item[guid,title,link,pubDate,description,author,enclosure]',
            ]
        ]);

        ray($articles);

        if ($articles['entries']) {
            return collect($articles['entries'])->map(fn (array $entry) => new FeedEntry(...[
                'id' => $entry['id'],
                'title' => $entry['title'],
                'link' => $entry['link'],
                'summary' => $entry['summary'],
                'updated' => Carbon::parse($entry['updated']),
            ]));
        } elseif ($articles['items']) {
            return collect($articles['items'])->map(fn (array $item) => new FeedEntry(...[
                'id' => $item['guid'],
                'title' => $item['title'],
                'link' => $item['link'],
                'summary' => $item['description'],
                'updated' => Carbon::parse($item['pubDate']),
            ]));
        }
    }

    public function loaded(): bool
    {
        return $this->document !== null;
    }
}
