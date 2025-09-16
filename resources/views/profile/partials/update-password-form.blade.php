<section>
    <header>
        <h2 class="card-title text-primary">{{ __('Update Password') }}</h2>
        <p class="card-text text-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
            <input id="current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback d-flex align-items-center">
                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('New Password') }}</label>
            <input id="password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback d-flex align-items-center">
                    <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
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
