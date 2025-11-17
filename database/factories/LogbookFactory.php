<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Logbook;
use App\Models\Aplikasi;

/** @extends Factory<\App\Models\Logbook> */
class LogbookFactory extends Factory
{
    protected $model = Logbook::class;

    public function definition(): array
    {
        $aplikasi = Aplikasi::factory()->create();

        return [
            'aplikasi_id' => $aplikasi->id,
            'content' => "Entry for aplikasi {$aplikasi->id}",
        ];
    }
}
