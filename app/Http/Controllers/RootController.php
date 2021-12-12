<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RootController extends Controller
{
    public function __construct(){
    }

    public function index(){
        return view("index");
    }
}

