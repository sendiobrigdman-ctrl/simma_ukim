<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lowongan;

/** @extends Factory<\App\Models\Lowongan> */
class LowonganFactory extends Factory
{
    protected $model = Lowongan::class;

    public function definition(): array
    {
        return [
            'title' => 'Demo Lowongan',
        ];
    }
}
