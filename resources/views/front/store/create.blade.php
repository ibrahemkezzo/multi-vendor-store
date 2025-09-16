<x-front-layout title='Rigester-Store'>

    <x-slot name='breadcrumb'>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">New Store</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>New Store</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container py-5">
        <x-form.alert type='info' />
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Create Your Store</h4>
                    </div>
                    <div class="card-body p-5">

                        {{-- Progress Steps --}}
                        <div class="d-flex justify-content-between mb-4">
                            <div class="step text-center">
                                <div class="circle bg-primary text-white" id="circle1">1</div>
                                <small>Admin Info</small>
                            </div>
                            <div class="step text-center">
                                <div class="circle bg-light border text-dark" id="circle2">2</div>
                                <small>Store Info</small>
                            </div>
                        </div>

                        {{-- Multi-step Form --}}
                        <form id="storeForm" method="POST" action="{{route('stores.store')}}" enctype="multipart/form-data">
                            @csrf

                            {{-- STEP 1: Admin Info --}}
                            <div id="step1">
                                <h5 class="mb-3 text-primary">Admin Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="admin[name]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="admin[username]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="admin[email]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="admin[phone_number]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="admin[password]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-primary nextBtn">Next</button>
                                </div>
                            </div>

                            {{-- STEP 2: Store Info --}}
                            <div id="step2" style="display:none;">
                                <h5 class="mb-3 text-primary">Store Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Store Name</label>
                                        <input type="text" name="store[name]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Slug</label>
                                        <input type="text" name="store[slug]" class="form-control" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="store[description]" rows="3" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Department</label>
                                        <select name="store[department_id]" class="form-select">
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Logo Image</label>
                                        <input type="file" name="store[logo_image]" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Cover Image</label>
                                        <input type="file" name="store[cover_image]" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary prevBtn">Back</button>
                                    <button type="submit" class="btn btn-success">Create Store</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        {{-- JS for Multi-step --}}
        <script>
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const circle1 = document.getElementById('circle1');
            const circle2 = document.getElementById('circle2');
            const nextBtn = document.querySelector('.nextBtn');
            const prevBtn = document.querySelector('.prevBtn');

            // عند الضغط على زر Next
            nextBtn.addEventListener('click', function() {
                step1.style.display = 'none';
                step2.style.display = 'block';
                // تحديث حالة الدوائر
                circle1.classList.remove('bg-primary', 'text-white');
                circle1.classList.add('bg-light', 'border', 'text-dark');
                circle2.classList.remove('bg-light', 'border', 'text-dark');
                circle2.classList.add('bg-primary', 'text-white');
            });

            // عند الضغط على زر Back
            prevBtn.addEventListener('click', function() {
                step2.style.display = 'none';
                step1.style.display = 'block';
                // تحديث حالة الدوائر
                circle2.classList.remove('bg-primary', 'text-white');
                circle2.classList.add('bg-light', 'border', 'text-dark');
                circle1.classList.remove('bg-light', 'border', 'text-dark');
                circle1.classList.add('bg-primary', 'text-white');
            });
        </script>
    @endpush

    @push('style')
        <style>
            .circle {
                width: 35px;
                height: 35px;
                line-height: 35px;
                border-radius: 50%;
                display: inline-block;
                font-weight: bold;
            }
        </style>
    @endpush
</x-front-layout>
