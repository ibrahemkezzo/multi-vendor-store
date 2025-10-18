<x-front-layout title="Payment">
    <x-slot name="breadcrumb">
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Payment</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('orders.index') }}">Orders</a></li>
                            <li>Payment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    {{-- <form action="{{ route('payment.store') }}" method="POST" id="payment-form"> --}}
                    @csrf
                    <div class="checkout-steps-form-style-1">
                        <ul id="accordionExample">
                            <li>
                                <h6 class="title">Order Summary</h6>
                                <section class="checkout-steps-form-content">
                                    <div class="row">
                                        @foreach ($orders as $order)
                                            <div class="col-12 mb-3">
                                                <p>Order #{{ $order->number }} (Store: {{ $order->store->name }}) -
                                                    {{ currency::formate($order->total) }}</p>
                                            </div>
                                        @endforeach
                                        <div class="col-12 mb-3">
                                            <p>Total Amount: {{ currency::formate($totalAmount / 100) }}</p>
                                        </div>
                                    </div>
                                </section>
                            </li>
                            <li>
                                <h6 class="title">Payment Info</h6>
                                <section class="checkout-steps-form-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <form id="payment-form">
                                                <div id="payment-element">
                                                    <!--Stripe.js injects the Payment Element-->
                                                </div>
                                                <button id="submit">
                                                    <div class="spinner hidden" id="spinner"></div>
                                                    <span id="button-text">Pay now</span>
                                                </button>
                                                <div id="payment-message" class="hidden"></div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </li>
                        </ul>
                    </div>
                    {{-- </form> --}}
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-price-table mt-30">
                            <h5 class="title">Pricing Table</h5>
                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Total Payable:</p>
                                    <p class="price">{{ currency::formate($totalAmount / 100) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')
        <script src="https://js.stripe.com/clover/stripe.js"></script>
        <script defer>
            // This is a public sample test API key.
            // Don’t submit any personally identifiable information in requests made with this key.
            // Sign in to see your own test API key embedded in code samples.
            const stripe = Stripe("{{ config('services.stripe.publishable_key') }}");

            // The items the customer wants to buy
            const items = [{
                id: "xl-tshirt",
                amount: 1000
            }];

            let elements;

            initialize();

            document
                .querySelector("#payment-form")
                .addEventListener("submit", handleSubmit);

            // Fetches a payment intent and captures the client secret
            async function initialize() {
                const {
                    clientSecret
                } = await fetch("{{ route('create.stripe.payment-intent', $order->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        items
                    }),
                }).then((r) => r.json());

                elements = stripe.elements({
                    clientSecret
                });

                const paymentElementOptions = {
                    layout: "accordion",
                };

                const paymentElement = elements.create("payment", paymentElementOptions);
                paymentElement.mount("#payment-element");
            }

            async function handleSubmit(e) {
                e.preventDefault();
                setLoading(true);

                const {
                    error
                } = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        // Make sure to change this to your payment completion page
                        return_url: "http://localhost:4242/complete.html",
                    },
                });

                // This point will only be reached if there is an immediate error when
                // confirming the payment. Otherwise, your customer will be redirected to
                // your `return_url`. For some payment methods like iDEAL, your customer will
                // be redirected to an intermediate site first to authorize the payment, then
                // redirected to the `return_url`.
                if (error.type === "card_error" || error.type === "validation_error") {
                    showMessage(error.message);
                } else {
                    showMessage("An unexpected error occurred.");
                }

                setLoading(false);
            }

            // ------- UI helpers -------

            function showMessage(messageText) {
                const messageContainer = document.querySelector("#payment-message");

                messageContainer.classList.remove("hidden");
                messageContainer.textContent = messageText;

                setTimeout(function() {
                    messageContainer.classList.add("hidden");
                    messageContainer.textContent = "";
                }, 4000);
            }

            // Show a spinner on payment submission
            function setLoading(isLoading) {
                if (isLoading) {
                    // Disable the button and show a spinner
                    document.querySelector("#submit").disabled = true;
                    document.querySelector("#spinner").classList.remove("hidden");
                    document.querySelector("#button-text").classList.add("hidden");
                } else {
                    document.querySelector("#submit").disabled = false;
                    document.querySelector("#spinner").classList.add("hidden");
                    document.querySelector("#button-text").classList.remove("hidden");
                }
            }
        </script>
    @endpush
</x-front-layout>
