@extends('layouts.app')

@section('sidebar')

@include("layouts.sidebar.bot")

@endsection


@section('content')
    
<h1>
  <span class="uk-text-small">{{ $bot->name }}</span><br/>
  {{ $account->name }}
</h1>

<hr />

<table class="uk-margin uk-table uk-table-striped uk-table-middle uk-table-small">
  <thead>
    <tr>
      <th class="uk-width-medium">Props</th>
      <th>Value</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Created</td>
      <td>{{ $account->created_at }}</td>
    </tr>
    <tr>
      <td>Blocked</td>
      <td>{{ $account->blocked_at }}</td>
    </tr>
    <tr>
      <td>UID</td>
      <td>{{ $account->hash }}</td>
    </tr>
    <tr>
      <td>name</td>
      <td>{{ $account->name }}</td>
    </tr>
    <tr>
      <td>reply_token</td>
      <td>{{ $account->reply_token }}</td>
    </tr>
  </tbody>
</table>

<h2>拡張プロパティ</h2>

<div id="properties-table">
  <form method="post" action="{{route('admin.accounts.edit', ['bot' => $bot, 'account' => $account])}}">
    <table class="uk-margin uk-table uk-table-striped uk-table-middle uk-table-small">
      <thead>
        <tr>
          <th class="uk-width-medium">Props</th>
          <th>Value</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(property, index) in properties">
          <td>
            <div class="uk-margin-small">
              <input class="uk-input" type="text" v-bind:name="'property['+index+'][key]'" v-model="property.key" />
            </div>
            <div class="uk-margin-small uk-text-center">
              <button type="button" class="uk-icon-button uk-button-danger" v-on:click="removeLabel(index)">
                <span uk-icon="trash"></span>
              </button>
            </div>
          </td>
          <td>
            <div v-for="(_, idx) in property.data" uk-grid class="uk-grid-small uk-margin-small uk-table-middle">
              <div class="uk-width-expand">
                <input class="uk-input" type="text" v-bind:name="'property['+index+'][data][]'" v-model="property.data[idx]" />
              </div>
              <div class="uk-width-auto">
                <button type="button" class="uk-icon-button uk-button-danger" v-on:click="removeProperties(property, idx)">
                  <span uk-icon="trash"></span>
                </button>
              </div>
            </div>
            <div class="uk-margin-small uk-text-center">
              <button type="button" class="uk-icon-button uk-button-default" v-on:click="addProperties(property)">
                <span uk-icon="plus"></span>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="uk-text-center">
            <button type="button" class="uk-icon-button uk-button-default" v-on:click="addLabel()">
              <span uk-icon="plus"></span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="uk-margin uk-text-center">
      <button class="uk-button uk-button-primary uk-width-medium">
        更新する
      </button>
    </div>
    @csrf
  </form>
</div>

<script type="text/javascript">
let actionList = new Vue({
  el: '#properties-table',
  data: {
    properties: @json($account->property_table)
  },
  methods: {
    addLabel: function(){
      this.properties.push( {
        key: "",
        data: []
      });
    },
    removeLabel: function(index){
      this.properties = this.properties.filter( function(action, idx){
        return index != idx;
      });
    },
    addProperties: function(property){
      property.data.push("");
    },
    removeProperties: function(property, index){
      property.data = property.data.filter( function(param, idx){
        return index != idx;
      });
    }
  }
});
</script>

@endsection
