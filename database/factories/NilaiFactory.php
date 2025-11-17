<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Nilai;

/** @extends Factory<\App\Models\Nilai> */
class NilaiFactory extends Factory
{
    protected $model = Nilai::class;

    public function definition(): array
    {
        return [
            'value' => 100,
        ];
    }
}
