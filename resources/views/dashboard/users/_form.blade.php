
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
    <x-form.input type='text' name='name' label='User Name' :value="$user->name"/>
</div>
<div class="form-group">
    <x-form.input type='text' name='phone_number' label='Phone Number' :value="$user->phone_number"/>
</div>
<div class="form-group">
    <x-form.input type='email' name='email' label='Email' :value="$user->email"/>
</div>



