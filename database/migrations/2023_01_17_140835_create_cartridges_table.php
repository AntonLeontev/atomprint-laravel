<?php

use App\Models\Cartridge;
use App\Models\Color;
use App\Models\Printer;
use App\Models\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartridges', function (Blueprint $table) {
            $table->id();
			
            $table->string('title')->unique();

            $table->text('printers')->nullable();

			$table
				->foreignIdFor(Color::class)
				->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

			$table
				->foreignIdFor(Vendor::class)
				->constrained()
				->cascadeOnDelete()
				->cascadeOnUpdate();

            $table->unsignedBigInteger('price_1');
            $table->unsignedBigInteger('price_2');
            $table->unsignedBigInteger('price_5');
            $table->unsignedBigInteger('price_office');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cartridges');
    }
};
