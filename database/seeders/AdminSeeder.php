<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory()->count(4)->state(
            new Sequence(
                ['username' => 'admin1'],
                ['username' => 'admin2'],
                ['username' => 'admin3'],
                ['username' => 'admin4'],
            )
        )->create();
    }
}
