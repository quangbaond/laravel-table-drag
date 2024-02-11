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
        for ($i = 0; $i < 10; $i++) {
            OrderTable::create([
                'name' => 'title' . $i,
                'description' => 'description' . $i,
                'status' => 1,
                'pid' => 0
            ]);
        }
    }
}
