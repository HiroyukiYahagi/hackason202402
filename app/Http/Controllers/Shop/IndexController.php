<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Petition;
use App\Services\ThemeService;

class IndexController extends Controller
{
    protected $themeService;

    public function __construct(ThemeService $themeService){
        $this->middleware(['auth:shop'])->except(['add', 'login']);
        $this->themeService = $themeService;
    }

    public function index(Request $request){
        return redirect()->route("shop.petitions.index");
    }

    public function login(Request $request){
        $shop = Shop::orderBy("id", "desc")->first();
        \Auth::guard("shop")->login($shop);
        return redirect()->route("shop.index");
    }

    public function logout(Request $request){
        \Auth::guard("shop")->logout();
        return redirect()->route("shop.index");
    }

    public function edit(Request $request){
        return view("shop.edit", [
            "title" => "受取者の情報の編集"
        ]);
    }

    public function add(Request $request){
        $request->validate([
            "shop_name" => "required",
            "desired_price" => "required|numeric",
            "description" => "required"
        ]);
        $shop = Shop::firstOrCreate([
            'email' => "test@test.com"
        ]);
        if($shop->wasRecentlyCreated){
            $shop->fill([
                'shop_name' => $request->input("shop_name"), 
                'password' => str_random(16), 
                'hash' => str_random(32),
                "description" => $request->input("description")
            ]);
            $shop->save();    
        }
        $petition = $this->themeService->createPetition([
            "shop_id" => $shop->id,
            'desired_price' => $request->input("desired_price"), 
            'description' => $request->input("description")
        ]);
        \Auth::guard("shop")->login($shop);
        return redirect()->route("shop.index");
    }

}
