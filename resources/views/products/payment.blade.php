@extends('layouts.user')

<head>
    <!--Stripe-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/stripe.css') }}" />
</head>


@section('content')
    <style>
        .preloader {
            position: absolute;
            width: 102px;
            height: 102px;
            left: 50%;
            top: 50%;
            min-height: 102px;
            transform: translateX(-50%) translateY(-50%);

            svg {
                width: 102px;
                height: 102px;


            }

        }

        .preloader .small-circle {
            stroke-dasharray: 210;
            stroke-dashoffset: 210;
            stroke: #51D48E;
            transform-origin: 50%;
            animation: 1s draw-small infinite alternate;
        }

        @keyframes draw-big {
            0% {
                stroke-dashoffset: 0;
                transform: rotateY(180deg) rotate(360deg);
            }

            100% {
                stroke-dashoffset: 240;
                transform: rotateY(180deg) rotate(0deg);
            }
        }

        @keyframes draw-small {
            0% {
                stroke-dashoffset: 0;
                transform: rotate(0deg);
            }

            100% {
                stroke-dashoffset: 210;
                transform: rotate(360deg);
            }
        }

        .preloader .big-circle {
            stroke-dasharray: 240;
            stroke-dashoffset: 240;
            transform-origin: 50%;
            stroke: #45BAE1;
            animation: 1s draw-big infinite alternate 0.5s;
        }
    </style>
    <div class="col panel spacing panel-default flex-grow-1 px-2 px-sm-5 payment-col min-vh-100">
        <div class="w-100 h-100 position-relative loader_container">
            <div class="preloader">
                <svg viewBox="0 0 102 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="big-circle" d="M101 51C101 78.6142 78.6142 101 51 101C23.3858 101 1 78.6142 1 51"
                        stroke="#252525" stroke-width="2" />
                    <path class="small-circle" d="M91 51C91 28.9086 73.0914 11 51 11C28.9086 11 11 28.9086 11 51"
                        stroke="#252525" stroke-width="2" />
                </svg>
            </div>
        </div>
        <div class="payment-container d-flex flex-column justify-content-center d-none">


            <h2 class="payment-title px-3 mb-3 d-none d-sm-block">Abbonamento <span
                    class="{{ strtolower($product->name) }}">{{ $product->name }}</span> per
                <span>{{ $apartment->title }}</span>
            </h2>

            <form id="payment-form" class="w-100 mt-3">
                <div class="d-flex flex-wrap flex-sm-nowrap gap-4 mb-4">
                    <div id="address-element" class="flex-grow-1">
                        <!-- Elements will create form elements here -->
                    </div>
                    <div id="payment-element" class="flex-grow-1 align-self-end">
                        <!--Stripe.js injects the Payment Element-->
                    </div>
                </div>

                <div class="justify-content-between align-items-center mb-2 d-none d-sm-flex" for="amount">
                    <p class="p-2 ps-0 mb-0">
                        Importo:
                        <strong class="price">
                            {{ $product->price }}$
                        </strong>
                    </p>

                </div>
                <button id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Paga</span>
                </button>
            </form>



        </div>

    </div>
    </div>
    </div>

    </body>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        //const axios = window.axios;
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        //console.log(csrfToken)
        // This is your test publishable API key.
        const stripe = Stripe(
            "pk_test_51Mw2wBCwC7e7f7zD4rvBMlcCUCvvzTmoaf8rZc24v1mtUnxsUi8bRnOx2wRBcrcGv6mOUOw3JwIM3lE9xyWYE6oT00fBqpWCGR"
        );
        const paymentForm = document.querySelector("#payment-form");
        const paymentContainer = document.querySelector('.payment-container');
        const loaderElement = document.querySelector('.loader_container')
        let elements;
        let clientSecret;
        initialize();


        paymentForm.addEventListener("submit", handleSubmit);

        // Fetches a payment intent and captures the client secret
        async function initialize() {
            let paymentElement;
            let addressElement
            await fetch('https://boolbnb-host.com/products/process-payment/' + '{{ $apartment->slug }}' +
                    '/' +
                    '{{ $product->prod_id }}', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,

                        },

                    })
                .then(promise => {
                    promise.json().then(resp => {
                        clientSecret = resp.clientSecret;
                        //console.log(resp.clientSecret)
                        elements = stripe.elements({
                            clientSecret
                        });

                        const paymentElementOptions = {

                            layout: "tabs",

                        };

                        paymentElement = elements.create("payment", paymentElementOptions);
                        addressElement = elements.create("address", {
                            mode: "billing",
                            blockPoBox: false,
                            display: {
                                name: 'split',

                            }


                        });




                        let paymentElementReady = false;
                        let addressElementReady = false;

                        const checkElementsReady = () => {
                            if (paymentElementReady && addressElementReady) {

                                loaderElement.classList.add('d-none')
                                paymentContainer.classList.remove('d-none')

                            }
                        }

                        paymentElement.mount("#payment-element");
                        addressElement.mount("#address-element");
                        paymentElement.on('ready', function() {
                            paymentElementReady = true;
                            checkElementsReady();
                        });
                        addressElement.on('ready', function() {
                            addressElementReady = true;
                            checkElementsReady();
                        });




                    })

                })



        }

        async function handleSubmit(e) {
            e.preventDefault();
            setPaymentLoading(true);

            const {
                error
            } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "https://boolbnb-host.com/splash-page",

                },


            });

            if (error) {
                window.location.href = 'https://boolbnb-host.com/splash-page?payment_intent_client_secret=' +
                    clientSecret;
            }


            setPaymentLoading(false);
        }



        // Show a spinner on payment submission
        function setPaymentLoading(isPaymentLoading) {
            if (isPaymentLoading) {
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
@endsection
