<?php

use Illuminate\Database\Seeder;

use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            "email" => "support@coco-gourmet.com",
            "password" => "welcome1"
        ]);
    }
}
