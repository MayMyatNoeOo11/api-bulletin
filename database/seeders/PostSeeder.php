<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Database\Factories\PostFactory;
//use Faker\Factory as Faker;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   DB::table('posts')->truncate();
     // PostFactory(App\Models\Post::class, 23)->create();
        
      \App\Models\Post::factory(15)->create();          
        
      
    }
}
