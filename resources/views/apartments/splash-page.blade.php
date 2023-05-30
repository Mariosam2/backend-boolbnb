<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <title>{{ config('BoolBnB', 'BoolBnB') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Work+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('assets/js/lottie.js') }}"></script>
    @vite(['resources/js/app.js'])
</head>

<body>
    <style>
        .loading {

            height: 2em;
            width: 2em;
            overflow: visible;
            margin: auto;

        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;

            background-color: rgba(0, 0, 0, 0.3);
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 2500ms infinite linear;
            -moz-animation: spinner 2500ms infinite linear;
            -ms-animation: spinner 2500ms infinite linear;
            -o-animation: spinner 2500ms infinite linear;
            animation: spinner 2500ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(0, 0, 0, 0.6) 1.5em 0 0 0, rgba(0, 0, 0, 0.6) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.6) 0 1.5em 0 0, rgba(0, 0, 0, 0.6) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.6) 0 -1.5em 0 0, rgba(0, 0, 0, 0.6) 1.1em -1.1em 0 0;
            box-shadow: rgba(0, 0, 0, 0.6) 1.5em 0 0 0, rgba(0, 0, 0, 0.6) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.6) 0 1.5em 0 0, rgba(0, 0, 0, 0.6) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.6) -1.5em 0 0 0, rgba(0, 0, 0, 0.6) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.6) 0 -1.5em 0 0, rgba(0, 0, 0, 0.6) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>


    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center text-center">
        <div class="content success-animation d-flex flex-column align-items-center d-none">
            <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_4mcByrGC3f.json" background="transparent"
                speed="0.8" style="width: 300px; height: 300px;" autoplay></lottie-player>
            <h4>Il pagamento è andato a buon fine!</h4>
            <small class="py-3 w-75">Ti stiamo
                reinderizzando ai tuoi
                appartamenti

            </small>
            <div class="loading my-5">Loading&#8230;</div>
        </div>
        <div class="content error-animation  d-flex flex-column align-items-center d-none ">

            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_ucaemjwr.json" background="transparent"
                speed="0.8" style="width: 300px; height: 300px;" autoplay></lottie-player>
            <h4>Ops! Si è verificato un problema</h4>
            <small class="py-4 w-75 d-flex justify-content-center align-items-center">Ti stiamoreinderizzando ai tuoi
                appartamenti
            </small>
            <div class="loading my-5">Loading&#8230;</div>
        </div>
        <div class="content not-found d-flex flex-column align-items-center justify-content-center vh-100 d-none">
            <p class="lead text-center ">
                😨 Ops, Page not found!
            </p>
            <a href="{{ route('apartments.index') }}"><i class="fa-solid fa-arrow-left"></i></a>
        </div>



    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        const stripe = Stripe(
            'pk_test_51Mw2wBCwC7e7f7zD4rvBMlcCUCvvzTmoaf8rZc24v1mtUnxsUi8bRnOx2wRBcrcGv6mOUOw3JwIM3lE9xyWYE6oT00fBqpWCGR'
        );

        // Retrieve the "payment_intent_client_secret" query parameter appended to
        // your return_url by Stripe.js
        try {
            const clientSecret = new URLSearchParams(window.location.search).get(
                'payment_intent_client_secret'
            );

            // Retrieve the PaymentIntent
            stripe.retrievePaymentIntent(clientSecret).then(({
                paymentIntent
            }) => {
                const message = document.querySelector('#message')

                switch (paymentIntent.status) {
                    case 'succeeded':
                        document.querySelector('.content.success-animation').classList.remove('d-none');
                        setTimeout(() => {
                            window.location.href = 'https://boolbnb-host.com/apartments';
                        }, 5000)
                        break;

                    default:
                        document.querySelector('.content.error-animation').classList.remove('d-none');
                        setTimeout(() => {
                            window.location.href = 'https://boolbnb-host.com/apartments';
                        }, 5000)
                        break;
                }
            });
        } catch (error) {
            document.querySelector('.content.not-found').classList.remove('d-none');

        }
    </script>
</body>


</html>
