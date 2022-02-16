<?php

use Illuminate\Database\Seeder;
use App\Photo;
use App\User;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 100; $i++){
            Photo::create([
                'path' => 'dammy.jpg',
                'user_id' => rand(1, 20)
            ]);
        }
    }
}
