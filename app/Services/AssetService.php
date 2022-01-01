<?php

namespace App\Services;

use \Validator;
use \Storage;

use App\Models\Admin;
use App\Models\Asset;
use Carbon\Carbon;

class AssetService
{
  public function paginate($param = [], $pagesize = 36){
    $query = Asset::query();
    $query = $query->orderBy("created_at", "desc");

    return $query->paginate($pagesize);
  }

  public function add($file) {
    $path = $file->store('assets');
    $asset = Asset::create([
      "path" => $path
    ]);
    return $asset;
  }
  public function delete($id) {
    $asset = Asset::find($id);
    $asset->delete();
    \Storage::delete($asset->path);
    return $asset;
  }
}