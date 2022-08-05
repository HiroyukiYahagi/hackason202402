<?php
namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use App\Models\Order;

class RelationService
{
  private function getUrl($path){
    return config("services.relation.url").$path;
  }

  public function getData($path, $method="POST", $params=[]){
    try {
      $client = new Client();

      $response = null;
      if( $method == "POST" ){
        $response = $client->post($this->getUrl($path), [
            'debug' => false,
            "headers" => [
              "Content-Type" => "application/json",
              "Authorization" => "Bearer ".config("services.relation.token")
            ],
            'json' => $params
        ]);
      }else{
        $response = $client->get($this->getUrl($path), [
            'debug' => false,
            "headers" => [
              "Content-Type" => "application/json",
              "Authorization" => "Bearer ".config("services.relation.token")
            ],
            'query' => $params
        ]);
      }
      
      $result = json_decode((string) $response->getBody(), true);

      if( isset($params["groupBy"]) ){
        $result = collect($result)->mapToGroups(function ($item) use($params) {
          $key = null;
          if( $params["groupBy"] == "created_at" ){
            \Log::info($item["created_at"]);
            $key = Carbon::parse( $item["created_at"] )->format("Y-m-d");
          }else{
            $key = $item[ $params["groupBy"] ];
          }
          return [
            $key => $item
          ];
        })->mapWithKeys(function ($item) {
          return [ $item[0]["created_at"] => count($item)];
        });
      }

      return $result;

    } catch (\Exception $e) {
      \Log::error($e);
      return null;
    }
  }
}