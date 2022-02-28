<?php

namespace Database\Seeders;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Adam',
            'email' => 'awcodes1@gmail.com',
        ]);

        /**
         * Initial Feeds
         */
        $feeds = [
            'Smashing Magazine' => 'https://www.smashingmagazine.com/feed/',
            'Code in WP' => 'https://www.codeinwp.com/feed/',
            'Coding the Smart Way' => 'https://medium.com/feed/codingthesmartway-com-blog/',
            'CSS Tricks' => 'https://css-tricks.com/feed/',
            'Delicious Brains' => 'https://deliciousbrains.com/feed/',
            'Laracasts' => 'https://laracasts.com/feed/',
            'Specky Boy' => 'https://speckyboy.com/feed/',
            'Carl Alexander' => 'https://carlalexander.ca/feed/',
            'Tom McFarlin' => 'https://tommcfarlin.com/feed/',
            'Web Design Ledger' => 'https://webdesignledger.com/feed/',
        ];

        foreach ($feeds as $name => $url) {
            Feed::create([
                'name' => $name,
                'url' => $url,
                'last_processed_at' => now()->subDay(),
            ]);
        }
    }
}
