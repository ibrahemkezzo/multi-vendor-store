@extends('layouts.dashboards')

@section('title', 'Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('info'))
        <div class="alert alert-danger">
            {{ session('info') }}
        </div>
    @endif

    <div class="content container-fluid col-lg-10">

        <ul class="nav nav-tabs" id="profileTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal-info" role="tab"
                    aria-controls="personal-info" aria-selected="true">Personal Info</a>
            </li>
            @if(auth('admin')->user()->hasRole('store-manager'))
                <li class="nav-item">
                    <a class="nav-link" id="store-tab" data-toggle="tab" href="#store-info" role="tab"
                        aria-controls="store-info" aria-selected="false">Store Info</a>
                </li>
            @endif
        </ul>

        <div class="tab-content p-4 border border-top-0" id="profileTabContent">

            {{-- Personal Info Tab --}}
            <div class="tab-pane fade show active" id="personal-info" role="tabpanel" aria-labelledby="personal-tab">
                <section>
                    <header>
                        <h2 class="card-title text-primary">{{ __('Profile Information') }}</h2>
                        <p class="card-text text-muted">
                            {{ __("Update your account's profile information, email address and password.") }}
                        </p>
                    </header>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <!-- Update Profile Info -->
                    <form method="post" action="{{ route('dashboard.profile.update') }}" class="mt-4">
                        @csrf
                        @method('patch')

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $admin->email) }}" required autocomplete="adminname">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($admin instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$admin->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-muted small">
                                        {{ __('Your email address is unverified.') }}
                                        <button form="send-verification"
                                            class="btn btn-link p-0 text-decoration-underline small">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $admin->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">{{ __('UserName') }}</label>
                            <input id="username" name="username" type="text"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $admin->username) }}" required autofocus autocomplete="username">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- phone_number -->
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                            <input id="phone_number" name="phone_number" type="text"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number', $admin->phone_number) }}" required autofocus autocomplete="phone_number">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>

                    <hr class="my-5">

                    <!-- Update Password -->
                    <header>
                        <h2 class="card-title text-primary">{{ __('Update Password') }}</h2>
                        <p class="card-text text-muted">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('dashboard.password.update') }}" class="mt-4">
                        @csrf
                        @method('put')

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                            <input id="current_password" name="current_password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                autocomplete="current-password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('New Password') }}</label>
                            <input id="password" name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </section>
            </div>

            {{-- Store Info Tab --}}
            @if(auth('admin')->user()->hasRole('store-manager'))
                <div class="tab-pane fade" id="store-info" role="tabpanel" aria-labelledby="store-tab">
                    <form action="{{ route('dashboard.store.update', $store->id ?? 0) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="form-row">
                            <div class="col-md-6">
                                <x-form.input type='text' name='name' label='Store Name' :value="$store->name ?? ''" />
                            </div>
                            <div class="col-md-6">
                                <x-form.input type='text' name='slug' label='Store Slug' :value="$store->slug ?? ''" />
                            </div>
                        </div>

                        {{-- <div class="form-row">
                            <div class="col-md-6">
                                <x-form.input type='text' name='phone' label='Phone' :value="$store->phone ?? ''" />
                            </div>
                            <div class="col-md-6">
                                <x-form.input type='email' name='email' label='Email' :value="$store->email ?? ''" />
                            </div>
                        </div>

                        <div class="form-group">
                            <x-form.input type='text' name='address' label='Address' :value="$store->address ?? ''" />
                        </div> --}}

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ $store->description ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <x-form.selected label='Department' name='department_id' :selected="$store->department_id ?? ''" :options="$departments" />
                        </div>

                        {{-- Store Logo --}}
                        <div class="form-group">
                            <label>Store Logo</label>
                            <input type="file" name="logo" class="form-control-file">
                            @if (!empty($store->logo_image))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $store->logo_image) }}" alt="Store Logo" height="80"
                                        class="border rounded">
                                </div>
                            @endif
                        </div>

                        {{-- Store Cover --}}
                        <div class="form-group">
                            <label>Store Cover</label>
                            <input type="file" name="cover" class="form-control-file">
                            @if (!empty($store->cover_image))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $store->cover_image) }}" alt="Store Cover" height="120"
                                        class="border rounded">
                                </div>
                            @endif
                        </div>

                        <br>
                        <button type='submit' class="btn btn-primary">Save Store Info</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

@endsection
