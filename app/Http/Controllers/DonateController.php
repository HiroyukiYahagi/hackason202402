<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donate;

use Payjp\Payjp;
use Payjp\Customer;
use Payjp\Charge;

class DonateController extends Controller
{
    public function __construct(){
        Payjp::setApiKey(config('services.payjp.private'));
    }

    public function view($hash){
        return view("donate.view", [
            "hash" => $hash
        ]);
    }

    public function toConfirm(Request $request, $hash){
        $request->validate( Donate::validator() );
        $request->session()->put("donate", $request->all());
        return redirect()->route("donate.confirm", [
            "hash" => $hash
        ]);
    }

    public function confirm(Request $request, $hash){
        $donate = $request->session()->get("donate");
        if( $donate == null ){
            return redirect()->route("donate.view", [
                "hash" => $hash
            ]);
        }
        return view("donate.confirm", [
            "donate" => $donate, "hash" => $hash
        ]);
    }

    public function submit(Request $request, $hash){
        $donate = $request->session()->get("donate");
        if( $donate == null ){
            return redirect()->route("donate.view", [
                "hash" => $hash
            ]);
        }

        try {
            $customer = Customer::create([
                "card" => $donate["payment_token"],
                "description" => $donate["name"]
            ]);
            Charge::create([
                "customer" => $customer["id"],
                "currency" => "jpy",
                "amount" => $donate["price"]
            ]);
            $donate["payment_token"] = $customer["id"];
        } catch (\Exception $e) {
          \Log::warn($e);
          session()->flash("error", "クレジットカードが利用できません");
          session()->flash("error_detail", "・有効期限が切れている\n・入力したカード情報に誤りがある\n・利用残高が不足している\n\nなどの理由で決済できませんでした。\nお手数おかけしますが入力した内容や利用残高を確認し再度ご入力ください。");
        }

        $donate = Donate::create($donate);
        return redirect()->route("donate.thanks", [
            "donate" => $donate
        ]);
    }

    public function thanks(Donate $donate){
        return view("donate.thanks", [
            "donate" => $donate
        ]);
    }
}
