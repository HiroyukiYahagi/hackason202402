<?php

namespace App\Services;

use \Validator;
use \Storage;

use App\Models\Admin;
use Carbon\Carbon;

class AdminService
{

  public function paginate( $param, $order="created_at", $orderBy="desc", $pagesize=20 ){
    $query = Admin::orderBy($order, $orderBy);

    if( isset($param["email"]) ){
      $query = $query->where("email", "like", "%".$param["email"]."%" );
    }
    if( $pagesize == -1 ){
      return $query->get();
    }
    return $query->paginate($pagesize);
  }

  public function validate($data){
    $email = 'required|string|max:255|unique:admins,email';
    if( isset($data["id"]) ){
      $email = 'required|string|max:255|unique:admins,email,'.$data["id"].',id';
    }
    Validator::make($data, [
      'email' => $email,
      'password' => 'nullable|string|min:8|max:255'
    ])->validate();
  }

  public function add($data) {
    $this->validate($data);

    return Admin::create($data);
  }

  public function edit($id, $data) {
    $admin = Admin::find($id);
    $this->validate( collect( $admin->toArray() )->merge($data)->toArray() );
    $admin->fill( $data );
    $admin->save();
    return $admin;
  }

  public function delete($id) {
    $admin = Admin::find($id);
    $admin->delete();

    return $admin;
  }
}