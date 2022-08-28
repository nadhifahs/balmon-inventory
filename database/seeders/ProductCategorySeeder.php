<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            ['name' => 'Instrument'],
            ['name' => 'Pemadam'],
            ['name' => 'Pengeras'],
        ];

        ProductCategory::insert($category);

        $category = Product::get();
        $category->map(function($query){
            Product::factory()->count(10)->state(
                new Sequence(['product_category_id' => $query->id])
            )->create();
        });
    }
}
