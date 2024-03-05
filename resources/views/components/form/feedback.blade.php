@props(['name'])
@if ($errors->has($name))
<div class="text-danger">{{$errors->first()}}</div>
@endif
