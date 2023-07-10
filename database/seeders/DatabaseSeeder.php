<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(10)->create();

         $products=[
            'name'=>'',
            'picPath'=>'',
            'price'=>0
         ];
         for ($i=0; $i < 10; $i++) {
            $products['name']="Teszt Termék".$i;
            $products['price']=$i*111;

            \App\Models\Product::create($products);

        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
