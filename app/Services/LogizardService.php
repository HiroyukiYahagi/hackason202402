<?php
namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use App\Models\Order;

class LogizardService
{
  private function getUrl($path){
    return config("services.logizard.base_path").$path;
  }

  private function getAreaIdFromKey($areaKey){
    return config("services.logizard.area.".$areaKey);
  }

  private function getClient($areaId){
    $client = new Client(['cookies' => true]);

    // LOGIN
    $response = $client->post($this->getUrl("/login/login/keylogin"), [
        'debug' => false,
        'json' => [
            "APP_KEY" => config("services.logizard.app_key"), 
            "AUTH_KEY" => config("services.logizard.auth_key"), 
            "OWNER_ID" => config("services.logizard.owner_id"), 
            "AREA_ID" => $areaId
        ]
    ]);
    $result = json_decode((string) $response->getBody(), true);
    if( $result["ERROR_CODE"] != 0 ){
        throw new \Exception("LOGIZARDの認証に失敗しました");
    }
    return $client;
  }

  public function getData($areaKey, $path, $level=null, $params=[]){
    try {
      $areaId = $this->getAreaIdFromKey($areaKey);

      $client = $this->getClient( $areaId );

      $params["OWNER_ID"] = config("services.logizard.owner_id");
      $params["AREA_ID"] = $areaId;

      $response = $client->post($this->getUrl($path), [
          'debug' => false,
          'json' => $params
      ]);
      $result = json_decode((string) $response->getBody(), true);

      if( $result["ERROR_CODE"] != 0 ){
        return $result;
      }
      $result = $result["DATA"];
      if( $level != null ){
        if( $level == "EXPORT_DATA" ){
          $header = [];
          $ret = [];
          foreach( $result[$level] as $index => $row ){
            if( $index == 0 ){
              $header = explode(",", $row);
              continue;
            }
            $rs = [];
            $r = explode(",", $row);
            foreach( $r as $idx => $d ){
              $rs[  str_replace('"', '', $header[$idx]) ] = str_replace('"', '', $d);
            }
            $ret[]  = $rs;
          }
          return $ret;
        }

        $level = explode(".", $level);
        foreach( $level as $l ){
          $result = $result[$l];
        }
      }
      return $result;

    } catch (\Exception $e) {
      \Log::error($e);
      return null;
    }
  }
}