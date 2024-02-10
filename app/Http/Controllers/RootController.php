<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Thema;
use App\Models\Usecase;

class RootController extends Controller
{

    public function __construct(){
    }

    public function index(){
        $themas = Thema::with(["usecases"])->get();
        $totalPrice = Usecase::sum("price");
        return view("index", [
            "themas" => $themas, "totalPrice" => $totalPrice
        ]);
    }
}

