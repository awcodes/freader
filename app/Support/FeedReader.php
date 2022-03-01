<?php

namespace App\Support;

use Carbon\Carbon;
use SimpleXMLElement;
use Illuminate\Support\Collection;
use Orchestra\Parser\Xml\Document;
use Illuminate\Support\Facades\Http;
use Orchestra\Parser\Xml\Facade as Xml;

class FeedReader
{
    protected ?SimpleXMLElement $document = null;

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

        $xmlString = Http::get($this->url);

        $xml = new SimpleXMLElement($xmlString->body());

        $this->document = $xml;

        return $this;
    }

    public function updated(): Carbon
    {
        $date = isset($this->document->updated) ? $this->document->updated : $this->document->channel->lastBuildDate;

        return Carbon::parse($date);
    }

    public function entries(): Collection
    {
        // RSS rss has item
        // ATOM feed has entry

        $entries = [];

        if (isset($this->document->entry)) {
            foreach ($this->document->entry as $entry) {
                $newEntry = [
                    'id' => $entry->id,
                    'title' => $entry->title,
                    'link' => $entry->link['href'],
                    'summary' => $entry->summary,
                    'content' => null,
                    'updated' => Carbon::parse($entry->updated),
                ];
                $entries[] = new FeedEntry(...$newEntry);
            }
        } elseif (isset($this->document->channel->item)) {
            foreach ($this->document->channel->item as $item) {
                $newEntry = [
                    'id' => $item->guid,
                    'title' => $item->title,
                    'link' => $item->link,
                    'summary' => $item->description,
                    'content' => $item->content,
                    'updated' => Carbon::parse($item->pubDate),
                ];
                $entries[] = new FeedEntry(...$newEntry);
            }
        }

        return collect($entries);
    }

    public function loaded(): bool
    {
        return $this->document !== null;
    }
}
