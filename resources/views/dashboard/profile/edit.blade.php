@extends('layouts.dashboards')

@section('title', 'Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
    <div class="container-fluid col-lg-10 py-5">
        <!-- تنبيهات النجاح أو الخطأ -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill"/>
                </svg>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <ul class="nav nav-tabs" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="personal-tab" data-bs-toggle="tab" href="#personal-info" role="tab"
                    aria-controls="personal-info" aria-selected="true">Personal Info</a>
            </li>
            @if(auth('admin')->user()->hasRole('store-manager'))
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="store-tab" data-bs-toggle="tab" href="#store-info" role="tab"
                        aria-controls="store-info" aria-selected="false">Store Info</a>
                </li>
            @endif
        </ul>

        <div class="tab-content p-4 border border-top-0" id="profileTabContent">
            <!-- Personal Info Tab -->
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

                    <!-- Update Admin Info -->
                    <form method="post" action="{{ route('dashboard.profile.admin.update') }}" class="mt-4">
                        @csrf
                        @method('patch')

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $admin->email) }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
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
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">{{ __('Username') }}</label>
                            <input id="username" name="username" type="text"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $admin->username) }}" required autocomplete="username">
                            @error('username')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                            <input id="phone_number" name="phone_number" type="text"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number', $admin->phone_number) }}" required autocomplete="tel">
                            @error('phone_number')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                            <input id="current_password" name="current_password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                autocomplete="current-password">
                            @error('current_password')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('New Password') }}</label>
                            <input id="password" name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </section>
            </div>

            <!-- Store Info Tab -->
            @if(auth('admin')->user()->hasRole('store-manager'))
                <div class="tab-pane fade" id="store-info" role="tabpanel" aria-labelledby="store-tab">
                    <form action="{{ route('dashboard.store.update', $store->id ?? 0) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="store_name" class="form-label">{{ __('Store Name') }}</label>
                                <input type="text" name="name" id="store_name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $store->name ?? '') }}">
                                @error('name')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                            <use xlink:href="#exclamation-triangle-fill"/>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="store_slug" class="form-label">{{ __('Store Slug') }}</label>
                                <input type="text" name="slug" id="store_slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $store->slug ?? '') }}">
                                @error('slug')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                            <use xlink:href="#exclamation-triangle-fill"/>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="store_phone" class="form-label">{{ __('Phone') }}</label>
                                <input type="text" name="phone" id="store_phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $store->phone ?? '') }}">
                                @error('phone')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                            <use xlink:href="#exclamation-triangle-fill"/>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="store_email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" name="email" id="store_email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $store->email ?? '') }}">
                                @error('email')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                            <use xlink:href="#exclamation-triangle-fill"/>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="store_address" class="form-label">{{ __('Address') }}</label>
                            <input type="text" name="address" id="store_address"
                                class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address', $store->address ?? '') }}">
                            @error('address')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $store->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="department_id" class="form-label">{{ __('Department') }}</label>
                            <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror">
                                <option value="">{{ __('Select Department') }}</option>
                                @foreach($departments as $id => $name)
                                    <option value="{{ $id }}" {{ old('department_id', $store->department_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Store Logo -->
                        <div class="mb-3">
                            <label for="logo" class="form-label">{{ __('Store Logo') }}</label>
                            <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror">
                            @error('logo')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                            @if (!empty($store->logo_image))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $store->logo_image) }}" alt="Store Logo" height="80" class="border rounded">
                                </div>
                            @endif
                        </div>

                        <!-- Store Cover -->
                        <div class="mb-3">
                            <label for="cover" class="form-label">{{ __('Store Cover') }}</label>
                            <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror">
                            @error('cover')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                            @if (!empty($store->cover_image))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $store->cover_image) }}" alt="Store Cover" height="120" class="border rounded">
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save Store Info') }}</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    @push('script')
        <!-- Bootstrap Icons -->
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>

        <script>
            // إزالة حدود الخطأ عند تصحيح الإدخال
            document.querySelectorAll('.form-control, .form-select').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        </script>
    @endpush
@endsection
