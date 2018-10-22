<?php

use Illuminate\Database\Seeder;

class UserFeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Feed::create([
            'title' => 'Testing',
            'content' => 'Just a testing',
            'post_id' => '1',
        ]);
    }
}
