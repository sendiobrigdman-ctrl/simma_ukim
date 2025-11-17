<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Aplikasi;

/** @extends Factory<\App\Models\Aplikasi> */
class AplikasiFactory extends Factory
{
    protected $model = Aplikasi::class;

    public function definition(): array
    {
        return [
            'name' => 'Demo Aplikasi',
        ];
    }
}
