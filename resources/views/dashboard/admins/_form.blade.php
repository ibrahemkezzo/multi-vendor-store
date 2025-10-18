
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
    </ul>
</div>
@endif

<div class="form-group col-md-12">
    <x-form.input type='text' name='name' label='admin name' :value="$admin->name"/>
</div>
<div class="form-group col-md-12">
    <x-form.input type='email' name='email' label='email' :value="$admin->email"/>
</div>
<div class="form-group col-md-12">
    <x-form.input type='text' name='username' label='user name' :value="$admin->username" />
</div>
<div class="form-group col-md-6">
    <x-form.input type='phone' name='phone_number' label='phone number' :value="$admin->phone_number"/>
</div>
@if (Auth::user()->super_admin)
    <div class="col-md-6">
        <x-form.selected label="Select The Store" name="store_id" :options="$stores" :value="isset($admin->store->id)?$admin->store->id:''"/>
    </div>
@endif


<fieldset class="col-md-12">
    <legend>
        {{__('Roles')}}
    </legend>
    {{-- @dd($admin->roles) --}}
    @foreach ($roles as $role)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $admin->roles->contains('id', $role->id) ? 'checked' : '' }}>
        <label class="form-check-label">
            {{ $role->name }}
        </label>
    </div>
    @endforeach
    <div class="form-group col-md-12">
        <x-form.input type='password' name='password' label='password' />
    </div>
</fieldset>



