<?php

namespace Database\Seeders\Product;

use App\Models\Product\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produsts = collect([
            [
                'id' => Str::uuid(),
                'name' => 'CRM Software',
                'description' => 'Cloud-based customer management tool',
                'price' => '14999.00',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Email Marketing Tool',
                'description' => 'Automate email campaigns',
                'price' => '4999.00',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Accounting Software',
                'description' => 'Easy invoicing and tax reports',
                'price' => '9999.00',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Inventory Management',
                'description' => 'Manage stock and track sales',
                'price' => '6999.00',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Project Tracking Tool',
                'description' => 'Visual boards for task progress',
                'price' => '7999.00',
            ],
        ]);

        $produsts->each(function ($produst) {
            Product::insert($produst);
        });
    }
}
