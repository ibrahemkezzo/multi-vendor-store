@props(['type'])

@if (session()->has("$type"))
<div {{$attributes->class(['alert','alert-success'=>$type == 'success','alert-danger'=>$type == 'info'])}}>
{{session("$type")}}
</div>
@endif
