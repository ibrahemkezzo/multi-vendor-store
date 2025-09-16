<x-front-layout title='profile'>

    <x-slot name='breadcrumb'>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Profile</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="container py-5">
                    <!-- تنبيهات النجاح أو المعلومات -->
                    @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                aria-label="Success:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            {{ __('Saved.') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                aria-label="Info:">
                                <use xlink:href="#info-fill" />
                            </svg>
                            {{ __('A new verification link has been sent to your email address.') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <!-- قسم تحديث المعلومات الشخصية -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>

                            <!-- قسم تغيير كلمة المرور -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>

                            <!-- قسم حذف الحساب -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')
        <!-- Bootstrap Icons -->
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-.94l.91-4.705A.75.75 0 0 1 8 7.013c.22 0 .414.192.486.456l.088-.416zm-.44-2.086c-.406 0-.74.34-.74.75s.335.75.74.75c.406 0 .74-.34.74-.75s-.334-.75-.74-.75z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>
    @endpush
</x-front-layout>
