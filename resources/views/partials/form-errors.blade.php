@if ($errors->any())
<div class="text-danger" >
<a class="uk-alert-close" uk-close></a>
<div class="uk-margin-top">
<ul class="uk-list">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
</div>
@endif