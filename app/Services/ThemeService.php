<?php

namespace App\Services;

use \Validator;
use \Storage;

use App\Models\Donate;
use App\Models\Petition;
use App\Models\Thema;
use App\Models\Usecase;
use App\Models\Affiliation;
use App\Models\Result;
use Carbon\Carbon;

class ThemeService
{
  public function createDonate($params){
    $donate = Donate::create($params);

    $usecases = $this->createUsecases( $donate->description, $donate->price );

    foreach( $usecases as $usecase ){
      $usecase->donate_id = $donate->id;
      $usecase->save();
    }
    return $donate;
  }

  public function createPetition($params){
    $petition = Petition::create($params); 

    $affiliations = $this->createAffiliations( $petition->description,  $petition->desired_price );

    foreach( $affiliations as $affiliation ){
      $affiliation->petition_id = $petition->id;
      $affiliation->save();
    }

    $this->createResults( $petition );

    return $petition;
  }

  private function createUsecases($description, $totalPrice){

    $hits = [];
    $totalScore = 0;

    $themas = Thema::get();

    foreach ( $themas as $thema ){
      $list = explode(",", $thema->keywords);
      foreach( $list as $keyword ){
        if( strpos($description, $keyword) !== false ){
          if( !isset($hits[$thema->id]) ){
            $hits[$thema->id] = 0;
          }
          $hits[$thema->id] += 10;
          $totalScore += 10;
        }
      }
    }
    $cases = [];
    $currentPrice = 0;
    foreach( $hits as $themaId => $score ){
      $cases[] = Usecase::create([
        'thema_id' => $themaId, 
        'description' => $description, 
        'price' => floor($totalPrice * $score / $totalScore)
      ]);   
      $currentPrice += floor($totalPrice * $score / $totalScore);
    } 
    return $cases;
  }

  private function createAffiliations($description, $totalPrice){

    $hits = [];
    $totalScore = 0;

    $themas = Thema::get();

    foreach ( $themas as $thema ){
      $list = explode(",", $thema->keywords);
      foreach( $list as $keyword ){
        if( strpos($description, $keyword) !== false ){
          if( !isset($hits[$thema->id]) ){
            $hits[$thema->id] = 0;
          }
          $hits[$thema->id] += 10;
          $totalScore += 10;
        }
      }
    }
    $cases = [];
    $currentPrice = 0;
    foreach( $hits as $themaId => $score ){
      $cases[] = Affiliation::create([
        'thema_id' => $themaId, 
        'price' => floor($totalPrice * $score / $totalScore)
      ]);   
      $currentPrice += floor($totalPrice * $score / $totalScore);
    } 
    return $cases;
  }

  public function createResults($petition){
    $petition->load(["affiliations.thema.usecases.donate.user"]);

    foreach( $petition->affiliations as $affiliation ){
      foreach( $affiliation->thema->usecases as $usecase ){
        Result::create([
          "usecase_id" => $usecase->id,
          "affiliation_id" => $affiliation->id,
          "price" => 0,
          "status" => 0,
        ]);
      }
    }
  }
}