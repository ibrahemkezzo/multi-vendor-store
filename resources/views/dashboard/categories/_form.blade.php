
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
    <x-form.input type='text' name='name' label='category name' :value="$category->name"/>
</div>
<div class="form-group">
    <label for="department_id" >department</label><br>
    <select  name="department_id" id="department_id" class="form-control">
        @foreach ($departments as $department)
        <option value="{{$department->id}}" @selected(old('department_id',$category->department_id )== $department->id)>{{$department->name}}</option>
        @endforeach
    </select>
    @if ($errors->has('department_id'))
<div class="text-danger">{{$errors->first()}}</div>
    @endif
    {{-- <x-form.selected label='department_id' name='department_id' :value="$category->id" first_op='primary category' :departments="$departments" /> --}}
</div>
<div class="form-group">
    <label for="description" >description</label>
    <textarea name="description" id="description" class="form-control">{{old('description',$category->description)}}</textarea>
</div>
<div class="form-group">
    <label > image</label>
    <input type="file" name="image" id="" class="form-control">
    @isset($category->image)
    <img src="/storage/{{$category->image}}"alt="" width="80px" >
    @endisset
    @error('image')
    <div class="text-danger">
        {{$message}}
    </div>
    @enderror

</div>
<div class="form-group">


    <x-form.checked name='status' label='status' :checked="$category->status" :options="['active'=>'Active','archived'=>'Archived']" />


</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary form-control">{{$button_key??'update'}}</button>
</div>
