<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cartridge>
 */
class CartridgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name('male'),
			'price' => $this->faker->numberBetween(10000, 500000),
			'color_id' => Color::inRandomOrder()->value('id'),
			'vendor_id' => Vendor::inRandomOrder()->value('id'),
        ];
    }
}
