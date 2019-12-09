<?php

use App\User;
use App\Model\Like;
use App\Model\Reply;
use App\Model\Category;
use App\Model\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create();
        factory(Category::class, 5)->create();
        factory(Question::class, 10)->create();
        factory(Reply::class, 50)->create()->each(function($reply) {
            $reply->likes()->save(factory(Like::class)->make());
        });
    }
}
