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
                    <form class="card login-form" action="{{route('two-factor.login')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Authenticate</h3>
                                <p>entr the code or recovery code to continu.</p>
                            </div>
                            @if ($errors->has('code'))
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif
                            @if ($errors->has('recovery_code'))
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif

                            <div class="form-group input-group">
                                <label for="reg-fn">The code</label>
                                <input class="form-control" type="password" name="code" id="reg-pass" >
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-re">recoevery code</label>
                                <input class="form-control" type="password" name="recovery_code" id="reg-re" >
                            </div>

                            <div class="button">
                                <button class="btn" type="submit">submit</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->
</x-front-layout>
