<x-front-layout title="register">
    <x-slot name='breadcrumb'>
        <div class="preloader" style="opacity: 0; display: none;">
            <div class="preloader-inner">
                <div class="preloader-icon">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <!-- /End Preloader -->
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Register</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>Register</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot>

    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div class="register-form">
                        <div class="title text-center">
                            <h3 class="text-primary mb-4">Create Your Account</h3>
                        </div>

                        <!-- عرض تنبيه عام لجميع الأخطاء -->
                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill"/>
                                </svg>
                                <div>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('front.register') }}" class="row" method="post">
                            @csrf
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="reg-fn">Name</label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror" type="text" id="reg-fn" required>
                                    @error('name')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                                <use xlink:href="#exclamation-triangle-fill"/>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="reg-email">E-mail Address</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror" type="email" id="reg-email" required>
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

                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="reg-phone">Phone Number</label>
                                    <input name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" type="text" id="reg-phone" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                                <use xlink:href="#exclamation-triangle-fill"/>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="reg-pass">Password</label>
                                    <input name="password" class="form-control @error('password') is-invalid @enderror" type="password" id="reg-pass" required>
                                    @error('password')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                                <use xlink:href="#exclamation-triangle-fill"/>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="reg-pass-confirm">Confirm Password</label>
                                    <input name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" id="reg-pass-confirm" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <svg class="bi me-1" width="16" height="16" role="img" aria-label="Error:">
                                                <use xlink:href="#exclamation-triangle-fill"/>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="button">
                                <button class="btn btn-primary" type="submit">Register</button>
                            </div>
                            <p class="outer-link">Already have an account? <a href="{{ route('front.login') }}">Login Now</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('style')
        <style>
            .is-invalid {
                border-color: #dc3545;
            }
            .is-invalid:focus {
                box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
            }
        </style>
    @endpush

    @push('script')
        <!-- Bootstrap Icons for Error Symbols -->
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>

        <script>
            // إزالة حدود الخطأ عند تصحيح الإدخال
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        </script>
    @endpush
</x-front-layout>
