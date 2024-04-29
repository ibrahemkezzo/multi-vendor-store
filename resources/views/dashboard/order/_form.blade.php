@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <x-form.input type='text' name='number' label='order number' :value="$order->number" />
</div>
<div class="form-group">
    <label for="stroe">store</label><br>
    <select name="stroe" id="stroe" class="form-control">
        @foreach ($stores as $store)
            <option value="{{ $store->id }}" @selected(old('store', $order->store_id) == $store->id)>{{ $store->name }}</option>
        @endforeach
    </select>
    @if ($errors->has('store'))
        <div class="text-danger">{{ $errors->first() }}</div>
    @endif
    {{-- <x-form.selected label='parent_id' name='parent_id' :value="$order->id" first_op='primary order' :parents="$parents" /> --}}
</div>
<div class="form-group">
    <label for="products">products </label>
    <textarea name="prodcuts" id="products" class="form-control">{{ old('products',$items) }}</textarea>
</div>

<div class="form-group">
    <x-form.checked name='payment_status' label='payment_status' :checked="$order->payment_status" :options="['pending' => 'pending','paid'=>'paid' ,'failed'=>'failed',]" />
</div>
<div class="form-group">
    <x-form.checked name='status' label='status' :checked="$order->status" :options="['pending' => 'pending', 'processing' => 'procressimg','delivering'=>'delivering','completed'=>'completed','canceled'=>'canceeled','refunded'=>'refunded']" />
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary form-control">{{ $button_key ?? 'update' }}</button>
</div>

