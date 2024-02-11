<?php

use Illuminate\Database\Seeder;

use App\Models\Thema;
use App\Models\User;
use App\Models\Donate;
use App\Models\Usecase;
use App\Models\Shop;
use App\Models\Petition;
use App\Models\Affiliation;

class ThemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        for ($i=0; $i < 100; $i++) { 
            $users[] = User::create([
                'email' => str_random(10), 
                'nick_name' => str_random(10), 
                'password' => str_random(10), 
                'hash' => str_random(10), 
                'payjp_token' => str_random(10)
            ]);
        }

        $shops = [];
        for ($i=0; $i < 20; $i++) { 
            $shops[] = Shop::create([
                'email' => str_random(10), 
                'shop_name' => str_random(10), 
                'password' => str_random(10), 
                'hash' => str_random(10)
            ]);
        }

        foreach ( config("themas") as $thema => $data ){
            $thema = Thema::create([
                'title' => $thema, 
                "image_url" => $data["image"],
                'keywords' => isset($data["keywords"]) ? implode($data["keywords"], ",") : null
            ]);

            foreach( $users as $user ){
                if( rand(0,10) >= 3 ){
                    $donate = $user->donates()->create([
                        'price' => rand(10000, 100000), 
                    ]);
                    $donate->usecases()->create([
                        "thema_id" => $thema->id,
                        "price"  => $donate->price
                    ]);
                }
            }

            foreach( $shops as $shop ){
                if( rand(0,10) >= 5 ){
                    $petition = $shop->petitions()->create([
                        'desired_price' => rand(100000, 400000), 
                    ]);
                    $petition->affiliations()->create([
                        "petition_id" => $petition->id,
                        "price"  => $petition->desired_price
                    ]);
                }
            }
        }
    }
}
