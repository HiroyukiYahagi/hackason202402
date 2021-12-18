<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Auth;
use App\Services\AdminService;

class IndexController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService){
        $this->middleware('auth:admin');
        $this->adminService = $adminService;
    }

    public function index(){
        $admin = Auth::guard("admin")->user();
        $admin->load(["bots"]);
        return view("admin.index", [
            "admin" => $admin
        ]);
    }

    public function edit(Request $request){
        $admin = Auth::guard("admin")->user();
        $this->adminService->edit($admin->id, $request->all());
        return back()->with("message", "情報を更新しました");
    }
}
