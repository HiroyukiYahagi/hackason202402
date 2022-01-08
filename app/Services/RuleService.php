<?php

namespace App\Services;

use \Validator;
use \Storage;

use App\Models\Bot;
use App\Models\Senario;
use App\Models\Rule;
use App\Models\Action;
use Carbon\Carbon;

class RuleService
{
  public function add($senarioId) {
    Validator::make([
      "senario_id" => $senarioId
    ], [
      'senario_id' => 'required|exists:senarios,id',
    ])->validate();

    $senario = Rule::create([
      "name" => "新しいルール",
      "senario_id" => $senarioId
    ]);
    return $senario;
  }

  public function validate($data){
    Validator::make($data, [
      'name' => 'string',
      'priority' => 'integer',
      'is_valid' => 'integer',
    ])->validate();
  }

  public function edit($ruleId, $data) {
    $rule = Rule::find($ruleId);

    $this->validate( collect( $rule->toArray() )->merge($data)->toArray() );
    $rule->fill( $data );
    $rule->save();
    return $rule;
  }

  public function actions($ruleId, $actions) {
    $rule = Rule::find($ruleId);

    Validator::make([
      "actions" => $actions
    ], [
      'actions' => 'array',
      'actions.*.id' => 'nullable|exists:actions,id',
    ])->validate();

    $ids = collect($actions)->map(function ($item, $key) {
        return isset($item["id"]) ? $item["id"] : null;
    })->values();

    $rule->actions()->whereNotIn("id", $ids)->delete();

    foreach( $actions as $index => $action ){
      $act = isset($action["id"]) ? Action::find( $action["id"] ): Action::create();

      $act->fill([
        "rule_id" => $ruleId,
        "name" => $action["name"],
        "body" => $action["body"],
        "action_type" => $action["action_type"],
      ]);
      $act->save();
    }
    
    $rule->load(["actions"]);
    return $rule;
  }

  public function delete($ruleId) {
    $rule = Rule::find($ruleId);
    $rule->delete();
    return $rule;
  }
}