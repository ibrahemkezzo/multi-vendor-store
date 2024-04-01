<x-front-layout >

        <x-slot name='breadcrumb'>
            <!-- Start Breadcrumbs -->
            <div class="breadcrumbs">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="breadcrumbs-content">
                                <h1 class="page-title">Shop Grid</h1>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <ul class="breadcrumb-nav">
                                <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                                <li>Shop Grid</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumbs -->
        </x-slot>


        <!-- Start Item Details -->
        <section class="item-details section">
            <div class="container">
                <div class="top-area">
                    <div class="row align-items-center">
                        @foreach ($products as $product)
                        <x-front.product :product="$product"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- End Item Details -->

        <!-- Review Modal -->
        <div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Leave a Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-name">Your Name</label>
                                    <input class="form-control" type="text" id="review-name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-email">Your Email</label>
                                    <input class="form-control" type="email" id="review-email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-subject">Subject</label>
                                    <input class="form-control" type="text" id="review-subject" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-rating">Rating</label>
                                    <select class="form-control" id="review-rating">
                                        <option>5 Stars</option>
                                        <option>4 Stars</option>
                                        <option>3 Stars</option>
                                        <option>2 Stars</option>
                                        <option>1 Star</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="review-message">Review</label>
                            <textarea class="form-control" id="review-message" rows="8" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer button">
                        <button type="button" class="btn">Submit Review</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Review Modal -->
        @push('script')
            <script type="text/javascript">
                const current = document.getElementById("current");
                const opacity = 0.6;
                const imgs = document.querySelectorAll(".img");
                imgs.forEach(img => {
                    img.addEventListener("click", (e) => {
                        //reset opacity
                        imgs.forEach(img => {
                            img.style.opacity = 1;
                        });
                        current.src = e.target.src;
                        //adding class
                        //current.classList.add("fade-in");
                        //opacity
                        e.target.style.opacity = opacity;
                    });
                });
            </script>
        @endpush

</x-front-layout>
