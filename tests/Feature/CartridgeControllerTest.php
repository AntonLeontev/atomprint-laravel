<?php

namespace Tests\Feature;

use App\Http\Controllers\CartridgeController;
use App\Models\Cartridge;
use App\Models\Color;
use App\Models\Vendor;
use Database\Factories\CartridgeFactory;
use Database\Factories\ColorFactory;
use Database\Factories\VendorFactory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartridgeControllerTest extends TestCase
{
	use LazilyRefreshDatabase;

	public function setUp(): void
	{
		parent::setUp();

		ColorFactory::new()->count(4)->create();
		VendorFactory::new()->count(5)->create();
		CartridgeFactory::new()->count(20)->create();
	}
	
    public function test_json_structure()
    {
        $response = $this->getJson(action([CartridgeController::class, 'index']));

        $response->assertJsonStructure([
			'current_page',
			'first_page_url',
			'from',
			'next_page_url',
			'path',
			'per_page',
			'per_page',
			'prev_page_url',
			'to',
			'data' => [
				'*' => [
					'color_title',
					'id',
					'price_1' => ['value', 'currency', 'currencySimbol', 'string'],
					'price_2' => ['value', 'currency', 'currencySimbol', 'string'],
					'price_5' => ['value', 'currency', 'currencySimbol', 'string'],
					'price_office' => ['value', 'currency', 'currencySimbol', 'string'],
					'printers',
					'title',
					'vendor_title',
				]
			],
		]);
    }

	public function test_vendor_filter()
	{
		$vendor = Vendor::inRandomOrder()->first();

		$response = $this->getJson(action([CartridgeController::class, 'index'], ['vendor[]' => $vendor->id]));

		foreach ($response['data'] as $cartridge) {
			$this->assertSame($vendor->title, $cartridge['vendor_title']);
		}
	}

	public function test_color_filter()
	{
		$colors = Color::inRandomOrder()->take(2)->get(['id', 'title']);
		[$first, $second] = $colors->pluck('id');
		$titles = $colors->pluck('title')->toArray();

		$response = $this->getJson(
			action([CartridgeController::class, 'index'], ["color[]=$first&color[]=$second"])
		);

		foreach ($response['data'] as $cartridge) {
			$this->assertTrue(in_array($cartridge['color_title'], $titles));
		}
	}

	public function test_search()
	{
		$title = Cartridge::inRandomOrder()->first('title')->value('title');
		$search = substr($title, 1);

		$response = $this->getJson(
			action([CartridgeController::class, 'index'], ["search" => $search])
		);

		foreach ($response['data'] as $cartridge) {
			$this->assertTrue(
				str_contains($cartridge['title'], $search)
				|| str_contains($cartridge['printers'], $search)
			);
		}
	}

	public function test_asc_sorting()
	{
		$column = 'price_1';

		[$first, $second] = Cartridge::orderBy($column)->take(2)->get('id')->pluck('id');

		$response = $this->getJson(
			action([CartridgeController::class, 'index'], ['sort' => $column])
		);

		$this->assertSame($first, $response['data'][0]['id']);
		$this->assertSame($second, $response['data'][1]['id']);
	}

	public function test_desc_sorting()
	{
		$column = 'title';

		[$first, $second] = Cartridge::orderByDesc($column)->take(2)->get('id')->pluck('id');

		$response = $this->getJson(
			action([CartridgeController::class, 'index'], ['sort' => $column, 'order' => 'DESC'])
		);

		$this->assertSame($first, $response['data'][0]['id']);
		$this->assertSame($second, $response['data'][1]['id']);
	}
}
