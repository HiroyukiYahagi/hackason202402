<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donate;
use App\Models\User;
use App\Services\ThemeService;

class IndexController extends Controller
{
    protected $themeService;

    public function __construct(ThemeService $themeService){
        $this->middleware(['auth:user'])->except(['add', 'login']);
        $this->themeService = $themeService;
    }

    public function index(Request $request){
        return redirect()->route("user.donates.index");
    }

    public function login(Request $request){
        $user = User::orderBy("id", "desc")->first();
        \Auth::guard("user")->login($user);
        return redirect()->route("user.index");
    }

    public function logout(Request $request){
        \Auth::guard("user")->logout();
        return redirect()->route("root.index");
    }

    public function edit(Request $request){
        return view("user.edit", [
            "title" => "ユーザー情報の変更"
        ]);
    }

    public function add(Request $request){
        $request->validate([
            "nick_name" => "required",
            "price" => "required|numeric",
            "description" => "required",
            "card_number" => "required",
            "card_yearmonth" => "required",
            "card_cvc" => "required",
        ]);
        $user = User::firstOrCreate([
            'email' => "test@test.com"
        ]);
        if($user->wasRecentlyCreated){
            $user->fill([
                'nick_name' => $request->input("nick_name"), 
                'password' => str_random(16), 
                'hash' => str_random(32), 
                'payjp_token' => str_random(16)
            ]);
            $user->save();    
        }
        $donate = $this->themeService->createDonate([
            "user_id" => $user->id,
            'payjp_token' => str_random(16), 
            'price' => $request->input("price"), 
            'description' => $request->input("description")
        ]);
        \Auth::guard("user")->login($user);
        return redirect()->route("user.index");
    }

}
