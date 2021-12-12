@if (session('success_message'))
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        {{ session('success_message') }}
    </div>
@elseif(session('danger_message'))
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        {{ session('danger_message')}}
    </div>
@endif
