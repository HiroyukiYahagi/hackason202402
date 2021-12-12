@if ($errors->any())
<div class="uk-alert-danger" uk-alert>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif