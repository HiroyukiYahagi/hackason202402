<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donate;
use App\Models\User;
use App\Models\Vote;
use App\Models\Result;
use App\Services\ThemeService;

class DonateController extends Controller
{
    protected $themeService;

    public function __construct(ThemeService $themeService){
        $this->middleware(['auth:user']);
        $this->themeService = $themeService;
    }

    public function index(Request $request){
        $user = \Auth::guard("user")->user();
        $user->load([ "donates.usecases.thema", "donates.usecases.results.affiliation.petition.shop" ]);
        return view("user.donates.index", [
            "title" => "寄付実績一覧", "user" => $user
        ]);
    }

    public function add(Request $request){
        $request->validate([
            "price" => "required|numeric",
            "description" => "required"
        ]);
        $user = \Auth::guard("user")->user();
        $donate = $this->themeService->createDonate([
            "user_id" => $user->id,
            'payjp_token' => str_random(16), 
            'price' => $request->input("price"), 
            'description' => $request->input("description")
        ]);
        return redirect()->route("user.donates.index");
    }

    public function view(Request $request, Donate $donate){
        return view("user.donates.view", [
            "title" => "寄付の詳細", "donate" => $donate
        ]);
    }

    public function updateResult(Request $request, Result $result){
        $result->load(["affiliation", "usecase"]);
        if( $request->input("status") == 1 ){
            $result->price = min( $result->affiliation->rest_price, $result->usecase->rest_price );
        }
        $result->status = 1;
        $result->save();

        return back()->with("message", "承認ステータスを変更しました");
    }

    public function updateVotes(Request $request, Vote $vote){
        if( $request->input("status") == 1 ){
            $vote->status = 1;
        }else{
            $vote->status = 0;
        }
        $vote->save();
        return back()->with("message", "承認ステータスを変更しました");
    }

}
