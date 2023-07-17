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

        $defaultUser=[
            'name'=>"Default User",
            'email'=>"default@user.com",
            'password'=> "password"
        ];

        \App\Models\User::create($defaultUser);

         $products=[
            'name'=>'',
            'file_path'=>'',
            'price'=>0
         ];
         for ($i=0; $i < 10; $i++) {
            $products['name']="Teszt Termék".$i;
            $products['price']=random_int(1,9999);

            \App\Models\Product::create($products);

        }
        for ($i=0; $i < 5; $i++) {
            $products['name']="Product".$i;
            $products['price']=random_int(1,9999);

            \App\Models\Product::create($products);

        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
