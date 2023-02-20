@extends('layouts.user')



@section('content')
    <div class="col panel panel-default flex-grow-1 spacing">

        <p class="text-center" for="amount">Importo:
            <strong>

                @if ($product->name == 'Bronze')
                    10$
                @elseif ($product->name == 'Silver')
                    25$
                @else
                    50$
                @endif
            </strong>

        </p>
        <div class="panel-body d-flex justify-content-center">

            <form role="form"
                action="{{ route('products.process-payment', ['apartment' => $apartment->slug, 'product' => $product->prod_id]) }}"
                method="post" class="stripe-payment mt-4" data-cc-on-file="false"
                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="stripe-payment">
                @csrf






                <label class='control-label'> Card Number</label>
                <input autocomplete="cc-family-name" id="card_number" pattern="[0-9]{13,19}" class='form-control card-num'
                    size='20' type='text'>

                <label class='control-label'>Name on Card</label>
                <input id="card_name" class='form-control cardholder-name' type='text'>

                <label class='control-label'>Expiration Month</label> <input class='form-control card-expiry-month'
                    placeholder='MM' size='2' type='text'>
                <label class='control-label'>Expiration Year</label> <input class='form-control card-expiry-year'
                    placeholder='YYYY' size='4' type='text'>

                <label class='control-label'>CVC</label>
                <input id="cvv" pattern="[0-9]{3,4}" autocomplete='off' class='form-control card-cvc'
                    placeholder='es 111' size='4' type='text'>
                <div class="error">
                    <div class="hide">

                    </div>
                </div>
                <input type="submit" value="Effettua pagamento">






            </form>
        </div>

    </div>
    </div>
    </div>

    </body>
    <script src="{{ asset('assets/js/jquery.slim.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/stripe.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            var $form = $(".stripe-payment");
            $('form.stripe-payment').bind('submit', function(e) {
                var $form = $(".stripe-payment"),
                    inputVal = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputVal),
                    $errorStatus = $form.find('div.error'),
                    valid = true;
                $errorStatus.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorStatus.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    console.log($('.cardholder-name').val(), $('.card-num').val());
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        name: $('.cardholder-name').val(),
                        number: $('.card-num').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val(),

                    }, stripeRes);
                }

            });

            function stripeRes(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
@endsection
