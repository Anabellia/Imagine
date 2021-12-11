<?php

namespace Database\Factories;
use App\Models\ImageProperties;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImagePropertiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ImageProperties::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => $this->faker->paragraph(),
        ];
    }
}

