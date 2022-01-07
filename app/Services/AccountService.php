<?php

namespace App\Services;

use \Validator;
use \Storage;

use App\Models\Admin;
use App\Models\Account;
use Carbon\Carbon;

class AccountService
{
  public function paginate($param = [], $pagesize = 36){
    $query = Account::query();

    if( isset($param["created_at"]["to"]) ){
      $query = $query->whereBetween("created_at", [
        $param["created_at"]["from"], $param["created_at"]["to"]
      ]);
    }

    if( isset($param["blocked_at"]["to"]) ){
      $query = $query->whereBetween("blocked_at", [
        $param["blocked_at"]["from"], $param["blocked_at"]["to"]
      ]);
    }

    if( isset($param["name"]) ){
      $query = $query->where("name", "LIKE", "%".$param["name"]."%");
    }

    if( isset($param["status"]) ){
      switch($param["status"]){
      case "all":
        break;
      case "only_active":
        $query = $query->whereNull("blocked_at");
        break;
      case "only_blocked":
        $query = $query->whereNotNull("blocked_at");
        break;
      }
    }

    $query = $query->orderBy("created_at", "desc");

    return $query->paginate($pagesize);
  }

  public function delete($id) {
    $account = Account::find($id);
    $account->delete();
    return $account;
  }
}