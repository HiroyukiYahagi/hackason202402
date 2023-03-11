<?php

namespace App\Services\AdResult;

use GuzzleHttp\Client as RequestClient;
use App\Models\MetaAdResult;
use Carbon\Carbon;

class FacebookAdResultService
{

  public function sync( Carbon $from, Carbon $to ){

    $results = [];

    try {
      $client = new RequestClient();

      $ads = $client->get("https://graph.facebook.com/v16.0/act_".config("ads.facebook.account_id")."/ads", [
        'debug' => false,
        'query' => [
          "fields" => "creative",
          "access_token" => config("ads.facebook.access_token"),
        ]
      ]);
      $ads = json_decode((string) $ads->getBody(), true);

      $ads = collect($ads["data"])->mapWithKeys( function($ad){
        return [ $ad["id"] => isset($ad["creative"]["id"]) ? $ad["creative"]["id"] : null ];
      });

      $creatives = $client->get("https://graph.facebook.com/v16.0/act_".config("ads.facebook.account_id")."/adcreatives", [
        'debug' => false,
        'query' => [
          "fields" => "asset_feed_spec",
          "access_token" => config("ads.facebook.access_token"),
        ]
      ]);
      $creatives = json_decode((string) $creatives->getBody(), true);

      $creatives = collect($creatives["data"])->mapWithKeys( function($creative){
        return [ $creative["id"] => $creative ];
      });

      $startUrl = "https://graph.facebook.com/v16.0/act_".config("ads.facebook.account_id")."/insights";

      while( true ){
        $response = $client->get($startUrl, [
            'debug' => false,
            // 'headers' => [
            //   'Authorization' => 'Bearer '.$bot->channel_access_token
            // ],
            'query' => [
                // "fields" => ["impressions","conversions"],
                "fields" => "campaign_id,campaign_name,adset_id,adset_name,ad_id,ad_name,spend,frequency,impressions,clicks,outbound_clicks,conversions,quality_ranking,actions",

                "filtering" => [
                    ["field" => "ad.name", "operator" => "CONTAIN", "value" => "ad000890"]
                ],

                "time_increment" => 1,
                // "date_preset" => "yesterday",
                "time_range" => [
                    "since" => $from->format("Y-m-d"),
                    "until" => $to->format("Y-m-d"),
                ],
                "level" => "ad",
                "access_token" => config("ads.facebook.access_token"),
            ]
        ]);
        $result = json_decode((string) $response->getBody(), true);
        // var_dump($result);

        foreach( $result["data"] as $row ){

          if( isset( $ads[ $row["ad_id"] ] ) && isset( $creatives[ $ads[ $row["ad_id"] ] ] ) ){
            $c = $creatives[$ads[$row["ad_id"]]];
            $row["adcreatives"] = $c;
            $row["full_link"] = isset($c["asset_feed_spec"]["link_urls"][0]["website_url"]) ? $c["asset_feed_spec"]["link_urls"][0]["website_url"] : null;
          }

          $results[] = $this->createResult( "facebook", "display", $row["ad_id"], $row["date_start"], [
            'campaign_name' => $row["campaign_name"],
            'adset_name' => $row["adset_name"],
            'ad_name' => $row["ad_name"],
            'placement' => null,
            'campaign_id' => $row["campaign_id"],
            'adset_id' => $row["adset_id"],
            'full_link' => isset($row["full_link"]) ? $row["full_link"] : null,
            // "link_url" => $row[""],
            'cost' => $row["spend"],
            "dump" => json_encode($row),
            'impression' => $row["impressions"],
            'frequency' => $row["frequency"],
            'click' => isset($row["outbound_clicks"][0]["value"]) ? $row["outbound_clicks"][0]["value"] : null,
            'conversion' => isset($row["actions"]) && collect( $row["actions"] )->firstWhere("action_type", "purchase") != null ? collect( $row["actions"] )->firstWhere("action_type", "purchase")["value"] : 0
          ]);
        }

        if( $result["paging"]["cursors"]["before"] == $result["paging"]["cursors"]["after"] ){
          break;
        }
        $startUrl = $result["paging"]["next"];
      }
      
      return $results;

    } catch (\Exception $e) {
      \Log::error($e);
    }
  }


  public function createResult($partner_name, $media_name, $ad_id, $target_at, $data){
    $result = MetaAdResult::firstOrCreate([
      'partner_name' => $partner_name, 
      'media_name' => $media_name, 
      'ad_id' => $ad_id,
      'target_at' => Carbon::parse($target_at)->startOfDay(),
    ]);

    $result->fill( $data );

    if( isset($data["full_link"]) ){
      preg_match('/utm_source=([\w]*)/', $data["full_link"], $match);
      if( count($match) > 1 ){
          $result->utm_source = $match[1];
      }
      preg_match('/utm_medium=([\w]*)/', $data["full_link"], $match);
      if( count($match) > 1 ){
          $result->utm_medium = $match[1];
      }
      preg_match('/utm_campaign=([\w]*)/', $data["full_link"], $match);
      if( count($match) > 1 ){
          $result->utm_campaign = $match[1];
      }
      preg_match('/utm_content=([\w]*)/', $data["full_link"], $match);
      if( count($match) > 1 ){
          $result->utm_content = $match[1];
      }
      preg_match('/utm_term=([\w]*)/', $data["full_link"], $match);
      if( count($match) > 1 ){
          $result->utm_term = $match[1];
      }
      $result->link_url = explode("?", $data["full_link"])[0];
    }
    $result->save();
    return $result;
  }
}