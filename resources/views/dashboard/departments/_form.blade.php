
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
    </ul>
</div>
@endif

<div class="form-group">
    <x-form.input type='text' name='name' label='department name' :value="$department->name"/>
</div>

<div class="form-group">
    <label for="description" >description</label>
    <textarea name="description" id="description" class="form-control">{{old('description',$department->description)}}</textarea>
</div>
<div class="form-group">
    <label > image</label>
    <input type="file" name="image" id="" class="form-control">
    @isset($department->image)
    <img src="/storage/{{$department->image}}"alt="" width="80px" >
    @endisset
    @error('image')
    <div class="text-danger">
        {{$message}}
    </div>
    @enderror

</div>

<div class="form-group">
    <button type="submit" class="btn btn-outline-primary form-control">{{$button_key??'update'}}</button>
</div>
