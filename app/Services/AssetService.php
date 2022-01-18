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
    // $rowPath = $file->store('assets', 'local');
    // $filePath = Storage::disk('local')->path($rowPath);
    // $dir = explode(".", $rowPath)[0];

    // Storage::disk('local')->makeDirectory($dir);

    // $image = \Image::make($filePath);
    // $image->orientate();
    // foreach( [1040, 700, 460, 300, 240] as $size ){
    //   $image->resize($size, null, function ($constraint) {
    //     $constraint->aspectRatio();
    //   });
      
    //   $newPath = $dir."/".$size;
    //   $image->save( storage_path("app/".$newPath) );
    //   $newFile = Storage::disk('local')->get($newPath);
    //   Storage::put($newPath, $newFile);
    // }
    // $path = $file->store('assets');
    // $asset = Asset::create([
    //   "path" => $path
    // ]);
    // Storage::disk('local')->deleteDirectory($dir);
    // Storage::disk('local')->delete($rowPath);


    $path = $file->store('assets');
    $fullPath = Storage::path($path);
    $dir = explode(".", $path)[0];

    Storage::makeDirectory($dir);
    $fullDir = Storage::path($dir);

    foreach( [1040, 700, 460, 300, 240] as $size ){
      exec("convert ".$fullPath." -resize ".$size."x ".$fullDir."/".$size);
    }

    $asset = Asset::create([
      "path" => $path
    ]);

    return $asset;
  }
  public function delete($id) {
    $asset = Asset::find($id);
    $asset->delete();
    \Storage::delete($asset->path);
    \Storage::deleteDirectory(explode(".", $asset->path)[0]);
    return $asset;
  }
}