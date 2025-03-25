
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
    <x-form.input type='text' name='name' label='admin name' :value="$admin->name"/>
</div>


<fieldset>
    <legend>
        {{__('Roles')}}
    </legend>

    @foreach ($roles as $role)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" >
        <label class="form-check-label">
            {{ $role->name }}
        </label>
    </div>
    @endforeach
</fieldset>


<div class="form-group">
    <button type="submit" class="btn btn-outline-primary form-control">{{$button_key??'update'}}</button>
</div>
