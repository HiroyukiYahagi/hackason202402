<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Petition;
use App\Models\Shop;
use App\Services\ThemeService;


class PetitionController extends Controller
{
    protected $themeService;

    public function __construct(ThemeService $themeService){
        $this->middleware(['auth:shop']);
        $this->themeService = $themeService;
    }

    public function index(Request $request){
        $shop = \Auth::guard("shop")->user();
        $shop->load([ "petitions.affiliations.thema.usecases.donate.user", "petitions.receipts.votes.user" ]);
        return view("shop.petitions.index", [
            "title" => "受け取り履歴", "shop" => $shop
        ]);
    }

    public function add(Request $request){
        $request->validate([
            "desired_price" => "required|numeric",
            "description" => "required"
        ]);
        $shop = \Auth::guard("shop")->user();
        $petition = $this->themeService->createPetition([
            "shop_id" => $shop->id,
            'desired_price' => $request->input("desired_price"), 
            'description' => $request->input("description")
        ]);
        return redirect()->route("shop.petitions.index");
    }

    public function view(Request $request, Petition $petition){
        return view("shop.petitions.view", [
            "title" => "受け取り申請の詳細", "petition" => $petition
        ]);
    }

    public function addReceipts(Request $request, Petition $petition){
        $path = $request->file("file")->store('petitions/'.$petition->id);

        $receipts = $petition->receipts()->create([
            "description" => $request->input("description"),
            "price" => $request->input("price"),
            "image_url" => $path
        ]);

        foreach ( $petition->affiliations as $affiliation ) {
            foreach( $affiliation->results as $result ){
                $receipts->votes()->create([
                    "user_id" => $result->usecase->donate->user_id,
                    "score" => null
                ]);
            }
        }
        return back()->with("message", "申請を提出しました");
    }

}
