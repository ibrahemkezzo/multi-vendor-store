
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
    <label for="parent_id" >parent_id</label><br>
    <select  name="parent_id" id="parent_id" class="form-control">
        <option selected value=" ">primary category</option>
        @foreach ($parents as $parent)
        <option value="{{$parent->id}}" @selected(old('parent_id',$category->parent_id )== $parent->id)>{{$parent->name}}</option>
        @endforeach
    </select>
    @if ($errors->has('parent_id'))
<div class="text-danger">{{$errors->first()}}</div>
    @endif
    {{-- <x-form.selected label='parent_id' name='parent_id' :value="$category->id" first_op='primary category' :parents="$parents" /> --}}
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
