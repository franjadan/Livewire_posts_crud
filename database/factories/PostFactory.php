<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Image;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $path = 'https://picsum.photos/640/480.jpg';
        $filename = uniqid() . '.jpg';
        Image::make($path)->save(public_path('storage/posts/' . $filename));

        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            'image' => 'posts/' . $filename
        ];
    }
}
