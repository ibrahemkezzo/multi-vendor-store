@props(['name','value'=>'','type'=>'text','label'=>false])
@if ($label)
<label > {{$label}}</label>
@endif
    <input type="{{$type}}" name="{{$name}}"  {{$attributes->class(['form-control', 'is-invalid' => $errors->has($name)])}}
    value="{{old($name,$value)}}">
    @error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
@enderror


