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
			'price_1' => $this->faker->numberBetween(10000, 500000),
			'price_2' => $this->faker->numberBetween(10000, 500000),
			'price_5' => $this->faker->numberBetween(10000, 500000),
			'price_office' => $this->faker->numberBetween(10000, 500000),
			'color_id' => Color::inRandomOrder()->value('id'),
			'vendor_id' => Vendor::inRandomOrder()->value('id'),
			'printers' => $this->faker->text(50),
        ];
    }
}
