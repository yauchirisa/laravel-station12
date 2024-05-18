<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{

        /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
        protected $model = Movie::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'title' => $this->faker->realText(10),
            'image_url'=> $this->faker->imageUrl(),
            'published_year'=> $this->faker->year(),
            'is_showing'=> $this->faker->boolean(),
            'description'=> $this->faker->text(10),
            'genre_id'=> Genre::factory()

        ];
    }
}
