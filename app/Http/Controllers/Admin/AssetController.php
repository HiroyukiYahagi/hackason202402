<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Auth;
use App\Services\AssetService;
use App\Models\Asset;

class AssetController extends Controller
{
    protected $assetService;

    public function __construct(AssetService $assetService){
        $this->middleware('auth:admin');
        $this->assetService = $assetService;
    }

    public function index(Request $request){
        $assets = $this->assetService->paginate();
        return view("admin.assets", [
            "assets" => $assets
        ]);
    }

    public function add(Request $request){
        $asset = $this->assetService->add($request->file("file"));
        return response()->json([
            "result" => true, "asset" => $asset
        ]);
    }

    public function delete(Request $request, Asset $asset){
        $asset = $this->assetService->delete($asset->id);
        return back()->with("message", "素材を削除しました");
    }
}
