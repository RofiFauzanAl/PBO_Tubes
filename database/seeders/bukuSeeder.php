<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class bukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for($i = 1; $i <= 1000; $i++){

    	      // insert data ke table pegawai menggunakan Faker
    		DB::table('buku')->insert([
    			'namaBuku' => $faker->name,
    			'author' => $faker->name,
    			'genreBuku' => $faker->name,
    			'jumlahBuku' => $faker->numberBetween(25,40)
    		]);

    	}
    }
}