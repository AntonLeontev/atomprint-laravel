<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\CartridgeFactory;
use Database\Factories\ColorFactory;
use Database\Factories\PrinterFactory;
use Database\Factories\VendorFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        ColorFactory::new()
			->count(4)
			->state(new Sequence(
				['title' => 'black'],
				['title' => 'magenta'],
				['title' => 'yellow'],
				['title' => 'cyan']
			)
		)->create();

		VendorFactory::new()
			->count(3)
			->state(new Sequence(
				['title' => 'HP'],
				['title' => 'Canon'],
				['title' => 'Xerox'],
			))->create();

		$cartridges = CartridgeFactory::new()->count(5);

		PrinterFactory::new()
			->count(5)
			->hasAttached($cartridges)
			->create();
    }
}
