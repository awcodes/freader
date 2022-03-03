<?php

namespace App\Http\Livewire;

use App\Models\Feed;
use App\Models\Entry;
use Livewire\Component;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Freader extends Component
{
    public $feeds;
    public $currentFeed;
    public $currentEntry;
    public $counts = [];

    public function mount()
    {
        $this->feeds = Feed::with('unreadEntries')->get();
        $this->feeds->map(function ($item) {
            return $this->counts[$item->id] = $item->unreadEntries->where('read', 0)->count();
        });
        $this->setCurrentFeed();
        $this->setCurrentEntry();
    }

    public function setCurrentFeed($id = null)
    {
        $this->currentFeed = $id ? $this->feeds->where('id', $id)->first() : $this->feeds->first();
        $this->setCurrentEntry();
    }

    public function setCurrentEntry($id = null)
    {
        if ($id) {
            $entry = Entry::where('id', $id)->first();
            $entry->update(['read' => true]);
        } else {
            $first = $this->currentFeed->unreadEntries->where('read', 0)->first();
            if ($first) {
                $first->update(['read' => true]);
            }
        }

        $this->currentFeed->refresh();
        $this->updateCount($this->currentFeed->id);

        $this->currentEntry = $id ? $entry : $first;
    }

    public function updateCount($feedId)
    {
        $this->counts[$feedId] = $this->counts[$feedId] - 1;
    }

    public function render()
    {
        return view('livewire.freader');
    }
}
