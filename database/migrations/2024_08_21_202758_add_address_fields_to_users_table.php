<?php

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->foreignId('country_id')
            //     ->constrained()
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');

            $table->foreignIdFor(Country::class, 'country_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(State::class, 'state_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(City::class, 'city_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeignIdFor(Country::class);
            $table->dropForeignIdFor(State::class);
            $table->dropForeignIdFor(City::class);
        });
    }
};
