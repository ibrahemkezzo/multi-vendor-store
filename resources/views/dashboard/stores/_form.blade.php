
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
    <x-form.input type='text' name='name' label='store name' :value="$store->name"/>
</div>
<div class="form-group">
    <label for="department_id" >Department</label><br>
    <select  name="department_id" id="department_id" class="form-control">
        @foreach ($departments as $department)
        <option value="{{$department->id}}" @selected(old('department_id',$store->department_id )== $department->id)>{{$department->name}}</option>
        @endforeach
    </select>
    @if ($errors->has('department_id'))
<div class="text-danger">{{$errors->first()}}</div>
    @endif
    {{-- <x-form.selected label='parent_id' name='parent_id' :value="$store->id" first_op='primary store' :parents="$parents" /> --}}
</div>
<div class="form-group">
    <label for="description" >description</label>
    <textarea name="description" id="description" class="form-control">{{old('description',$store->description)}}</textarea>
</div>
<div class="form-group">
    <label >logo</label>
    <input type="file" name="logo_image" id="" class="form-control">
    @isset($store->logo_image)
    <img src="/storage/{{$store->logo_image}}"alt="" width="80px" >
    @endisset
    @error('logo_image')
    <div class="text-danger">
        {{$message}}
    </div>
    @enderror

</div>
<div class="form-group">
    <label >cover</label>
    <input type="file" name="cover_image" id="" class="form-control">
    @isset($store->cover_image)
    <img src="/storage/{{$store->cover_image}}"alt="" width="80px" >
    @endisset
    @error('cover_image')
    <div class="text-danger">
        {{$message}}
    </div>
    @enderror

</div>
<div class="form-group">


    <x-form.checked name='status' label='status' :checked="$store->status" :options="['active'=>'Active','archived'=>'Archived']" />


</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary form-control">{{$button_key??'update'}}</button>
</div>
