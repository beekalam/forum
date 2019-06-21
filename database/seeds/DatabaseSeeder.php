<?php

use App\Reply;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(\App\User::class)->create([
            'email' => 'beekalam@gmail.com',
            'name' => 'beekalam',
            'password' => bcrypt('secret')
        ]);

        $threads = factory(\App\Thread::class,10)->create();
        $threads->each(function($thread){
            factory(Reply::class,5)->create(['thread_id' => $thread->id]);
        });

    }
}
