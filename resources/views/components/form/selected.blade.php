@props(['label','name','options','selected'=>''])

<label  >{{$label}}</label><br>
<select  name="{{$name}}"  {{$attributes->class(['form-control','form-select','is-invalid'=>$errors->has($name)])}}>
    @foreach ($options as $value => $text)
    <option value="{{$value}}" @selected($value== $selected)>{{$text}}</option>
    @endforeach
</select>
@if ($errors->has($name))
<div class="text-danger">{{$errors->first()}}</div>
@endif
