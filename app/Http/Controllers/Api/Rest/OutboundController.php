<?php

namespace App\Http\Controllers\Api\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\LogizardService;
use App\Services\RelationService;
use App\Models\Ranking;

class OutboundController extends Controller
{

    protected $logizardService;
    protected $relationService;

    public function __construct(LogizardService $logizardService, RelationService $relationService){
        $this->logizardService = $logizardService;
        $this->relationService = $relationService;
    }

    function logizard(Request $request){
        $result = $this->logizardService->getData( $request->input("area"), $request->input("path"), $request->input("level"), $request->except(["area", "path", "level"]) );
        return response()->json($result);
    }

    function relation(Request $request){
        $result = $this->relationService->getData( $request->input("path"), $request->input("method"), $request->all() );
        return response()->json($result);
    }

    function rankings(Request $request){
        $rank = Ranking::where("name", $request->input("name"))->first();

        $cnt = isset($rank) ? $rank->registered_cnt : 0;

        $ranking = Ranking::where("registered_cnt", ">", $cnt)->count() + 1;

        $next = Ranking::where("registered_cnt", ">", $cnt)->orderBy("registered_cnt", "ASC")->first();
        $previous = Ranking::where("registered_cnt", "<=", $cnt)->where("id", "<>", optional($rank)->id)->orderBy("registered_cnt", "DESC")->first();

        $max = Ranking::sum("registered_cnt");

        $cnt ++;
        $max ++;

        return response()->json([
            "name" => $request->input("name"),
            "registered_cnt" => floor($cnt / $max * 7000000),
            "ranking" => $ranking,
            "next" => isset($next) ? [
                "name" => $next->name, "registered_cnt" => floor($next->registered_cnt / $max * 7000000),
            ] : null,
            "previous" => isset($previous) ? [
                "name" => $previous->name, "registered_cnt" => floor($previous->registered_cnt / $max * 7000000),
            ] : null
        ]);
    }

    function rankingsImage(Request $request, $name){

        $rank = Ranking::where("name", $name)->first();
        $cnt = isset($rank) ? $rank->registered_cnt : 0;

        $ranking = Ranking::where("registered_cnt", ">", $cnt)->count() + 1;
        
        $max = Ranking::sum("registered_cnt");
        $cnt ++;
        $max ++;

        $registered_cnt = floor($cnt / $max * 7000000);

        //既存の画像リソースを読み込む(PNGの場合)
        $img = imagecreatefromjpeg(public_path().'/images/rankings/base_2.jpg');
        
        $fontcolor = imagecolorallocate($img, 76, 16, 21);

        $font = base_path().'/YuGothicBold.ttf';

        //名前部分
        $text = $name."ちゃん";
        $position = imagettfbbox(48, 0, $font, $text);
        $textWidth = $position[2] - $position[0];
        $left = - 1 * ($textWidth / 2) + 600;
        imagettftext($img, 48, 0, $left, 340, $fontcolor, $font, $text);


        //頭数
        $text = "推定".number_format($registered_cnt)."匹";
        $position = imagettfbbox(48, 0, $font, $text);
        $textWidth = $position[2] - $position[0];
        $left = - 1 * ($textWidth / 2) + 600;
        imagettftext($img, 48, 0, $left, 440, $fontcolor, $font, $text);


        //名前部分
        $text = "第".number_format($ranking)."位";
        $position = imagettfbbox(36, 0, $font, $text);
        $textWidth = $position[2] - $position[0];
        $left = - 1 * ($textWidth / 2) + 600;
        imagettftext($img, 36, 0, $left, 540, $fontcolor, $font, $text);


        //出力する画像の種類のヘッダ情報をつける(以下はPNGの場合)
        header('Content-Type: image/jpeg');

        //画像をPNG形式のデータとして出力
        imagejpeg($img);
        die();
    }
}
