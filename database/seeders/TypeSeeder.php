<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator;

use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $_types = [
            'FRONT-END',
            'BACK-END',
            'FULL-STACK'
        ];

        foreach($_types as $_type){
            $type = new Type();
            $type->name = $_type;
            $type->color = $faker->hexColor();
            $type->save();
        }
    }
}
