<x-front-layout title="login">
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
                            <h1 class="page-title">Login</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{route('front.home')}}"><i class="lni lni-home"></i> Home</a></li>
                            <li>Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Breadcrumbs -->
    </x-slot>



    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{route('two-factor.enable')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Authentication</h3>
                                <p>if you want to active a feature two-factor authinticate</p>
                            </div>
                            @if (session('status') == 'two-factor-authentication-enabled')
                                <div class="mb-4 font-medium text-sm">
                                    Please finish configuring two factor authentication below.
                                </div>
                            @endif
                            @if (!$user->two_factor_secret)
                            <div class="button">
                                <button class="btn" type="submit">Enable</button>
                            </div>
                            @else
                            <div style="padding-left: 30%; padding-bottom:10%   ">
                                {!! $user->twoFactorQrCodeSvg() !!}
                            </div>

                            <ul class="mb-3">
                                @foreach ($user->recoverycodes() as $code )
                                <li>{{$code}}</li>
                                @endforeach
                            </ul>
                            @method('delete')
                            <div class="button">
                                <button class="btn" type="submit">Disable</button>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->
</x-front-layout>
