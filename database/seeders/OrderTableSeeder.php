<?php

namespace Database\Seeders;

use App\Models\OrderTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            OrderTable::query()->create([
                'parent_id' => null,
                'name' => 'Table ' . $i,
            ]);
        }
    }
}
