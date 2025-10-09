<div class="form-group">
    <x-form.input type="text" name="number" label="{{ __('Order Number') }}" :value="$order->number" />
</div>

<div class="form-group">
    <label for="store_id">{{ __('Store') }}</label>
    <select name="store_id" id="store_id" class="form-control">
        @foreach ($stores as $store)
            <option value="{{ $store->id }}" @selected(old('store_id', $order->store_id) == $store->id)>{{ $store->name }}</option>
        @endforeach
    </select>
    @error('store_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>{{ __('Order Items') }}</label>
    <textarea name="items" id="items" class="form-control" readonly>{{ $items }}</textarea>
    <small class="form-text text-muted">{{ __('Order items cannot be edited here. Manage items separately.') }}</small>
</div>

<div class="form-group">
    <x-form.checked name="payment_status" label="{{ __('Payment Status') }}" :checked="$order->payment_status" :options="['pending' => __('Pending'), 'paid' => __('Paid'), 'failed' => __('Failed')]" />
</div>

<div class="form-group">
    <x-form.checked name="status" label="{{ __('Status') }}" :checked="$order->status" :options="['pending' => __('Pending'), 'processing' => __('Processing'), 'delivering' => __('Delivering'), 'completed' => __('Completed'), 'canceled' => __('Canceled'), 'refunded' => __('Refunded')]" />
</div>

<div class="form-group">
    <button type="submit" class="btn btn-outline-primary form-control">{{ $button_key ?? __('Update') }}</button>
</div>
