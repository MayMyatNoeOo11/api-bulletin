<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $paragraphs = $this->faker->paragraphs(rand(2, 6));
         $title = $this->faker->unique()->realText(10);
         $postTitle = $this->faker->unique()->realText(60);
        // $description = "{$title}";
        // foreach ($paragraphs as $para) {
        //     $description .= "{$para}";
        // }

        return [
            'title' =>  $title,
            'description' =>  $postTitle,
            'status' => '1',
            'created_user_id'=>'1',            
            'updated_user_id' => '1'
            
        ];
    }
}
