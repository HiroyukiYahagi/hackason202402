@extends('layouts.user')

@section('content')
    
<form method="post" action="{{route('accounts.edit', ['hash' => $account->hash])}}">
  <div class="uk-margin" id="properties-table">
    <div class="uk-margin-small">
      <label class="uk-form-label">
        ユーザー名
      </label>
      <div class="uk-form-controls">
        <input class="uk-input" type="text" readonly name="name" value="{{ $account->name }}" disabled />
      </div>
    </div>

    <hr/>

    <div class="uk-margin-small" v-for="(property, index) in properties">
      <label class="uk-form-label" v-text="property.key"></label>
      <div class="uk-form-controls">
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
      </div>
      <input type="hidden" v-bind:name="'property['+index+'][key]'" v-model="property.key" />
    </div>

  </div>

  <div class="uk-margin uk-text-center">
    <button class="uk-width-large uk-button uk-button-primary">
      更新する
    </button>
  </div>
  @csrf
</form>

<script type="text/javascript">
let actionList = new Vue({
  el: '#properties-table',
  data: {
    properties: @json($account->property_table)
  },
  methods: {
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
