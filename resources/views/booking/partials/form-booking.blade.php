@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@elseif ($message = Session::get('error'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
@endif
@if ($oBooking->closed)
    <div class="alert alert-danger">
        <p>{{ "This booking is closed" }}</p>
    </div>
@endif


<form action="{{ route('booking.update_booking', $oBooking->id) }}" id="booking_form" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}

    <div class="modal-body col-md-12" style="height: auto;">
        {{-- Info section --}}
        <div class="col-md-12 mt10">
            <h4 class="pull-right mt0" style="margin-right: 3%;">Current Price: {{ $oBooking->total() }} EUR<b id="current_price"></b></h4>
        </div>

        {{-- Number of people section --}}
        <input type="hidden" name="booking[booking_id]" value="{{ $oBooking->id }}"/>
        <?php
        $min = \App\ExperiencePrices::whereExperienceId($oBooking->experience()->id)->whereType("adults")->min("min");
        $max = \App\ExperiencePrices::whereExperienceId($oBooking->experience()->id)->whereType("adults")->max("max");

        ?>
        @if($min && $max)
            <div class="col-md-12 col-xs-12 mt10">
                <div class="col-md-4 col-x-12">
                    <h5>Number of adults</h5>
                </div>
                <div class="col-md-8 col-xs-12">
                    <select required class="form-control" name="booking[adults]">
                        <option value="0">-</option>
                        @for($i=$min;$i<=$max;$i++)

                            <?php $pp = number_format(round(($oBooking->experience()->calculate_price($i)["adults_price"]/$i) * 2, 0)/2, 2, '.', ''); ?>
                            <option {{ $oBooking->number_adults == $i ? "selected" : "" }} value="{{ $i }}">{{ $i }} (€{{ $pp }} pp.)</option>
                        @endfor
                    </select>
                </div>
            </div>
        @elseif($min && !$max)
            <div class="col-md-12 col-xs-12 mt10">
                <div class="col-md-4 col-x-12">
                    <h5>Number of adults</h5>
                </div>
                <div class="col-md-8 col-xs-12">
                    <input required class="form-control" name="booking[adults]" type="number" min="{{ $min }}" value="{{ $oBooking->number_adults }}" step="1"/>
                </div>
            </div>
        @elseif(!$min && $max)
            <div class="col-md-12 col-xs-12 mt10">
                <div class="col-md-4 col-x-12">
                    <h5>Number of adults</h5>
                </div>
                <div class="col-md-8 col-xs-12">
                    <input required class="form-control" name="booking[adults]" type="number" min=1 max="{{ $min }}" value="{{ $oBooking->number_adults }}" step="1"/>
                </div>
            </div>
        @endif

        {{-- Number of children section --}}
        <?php
        $min = \App\ExperiencePrices::whereExperienceId($oBooking->experience()->id)->whereType("children")->min("min");
        $max = \App\ExperiencePrices::whereExperienceId($oBooking->experience()->id)->whereType("children")->max("max");
        ?>

        @if($min && $max)
            <div class="col-md-12 col-xs-12 mt10">
                <div class="col-md-4 col-xs-12">
                    <h5>Number of children</h5>
                </div>
                <div class="col-md-8 col-xs-12">
                    <select required class="form-control" name="booking[children]">
                        <option value="0">-</option>
                        @for($i=$min;$i<=$max;$i++)
                            <?php $pp = number_format(round(($oBooking->experience()->calculate_price(0,$i)["children_price"]/$i) * 2, 0)/2, 2, '.', ''); ?>
                            <option {{ $oBooking->number_children == $i ? "selected" : "" }} value="{{ $i }}">{{ $i }} (€{{ $pp }} pp.)</option>
                        @endfor

                    </select>
                </div>
            </div>
        @elseif($min && !$max)
            <div class="col-md-12 col-xs-12 mt10">
                <div class="col-md-4 col-x-12">
                    <h5>Number of adults</h5>
                </div>
                <div class="col-md-8 col-xs-12">
                    <input required class="form-control" name="booking[children]" type="number" value="{{ $oBooking->number_children }}" min="{{ $min }}" step="1"/>
                </div>
            </div>
        @elseif(!$min && $max)
            <div class="col-md-12 col-xs-12 mt10">
                <div class="col-md-4 col-x-12">
                    <h5>Number of adults</h5>
                </div>
                <div class="col-md-8 col-xs-12">
                    <input required class="form-control" name="booking[children]" type="number" value="{{ $oBooking->number_children }}" min=1 max="{{ $min }}" step="1"/>
                </div>
            </div>
        @endif


        {{-- Extras section --}}
        @if(count($oBooking->experience()->resources()))
            <div class="col-md-12 mt10">
                <div class="col-md-4">
                    <h5>Extras</h5>
                </div>
                <div class="col-md-8">
                    <ul class="list-group">
                        @foreach($oBooking->experience()->resources() as $oRes)
                            <li class="list-group-item">
                                {{ $oRes->title }} (+€{{ $oRes->cost }})
                                <div class="material-switch pull-right">
                                    <input class="extras-toggle" id="extra{{ $oRes->id }}" {{ $oBooking->getAttribute("extras") && in_array($oRes->id,json_decode($oBooking->getAttribute("extras"))) ? "checked" : "" }} name="booking[extras][]" value="{{ $oRes->id }}" type="checkbox"/>
                                    <label for="extra{{ $oRes->id }}" class="label-primary"></label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Datepicker section --}}
        <div class="col-md-12 " id="preferredDate">
            <div class="col-md-4">
                <h5 class="pull-left">Preferred Date</h5>
            </div>

            <div class="col-md-8">
                <div class="input-group date">
                    <input type="text" name="booking[date_pref]" value="{{ implode(",",json_decode($oBooking->dates)) }}" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        @if (!$oBooking->closed)
            <button type="submit" class="btn btn-default pull-left">Update Booking</button>
            @if(in_array(Auth::user(),$oBooking->experience()->admin(true)))
                @if($oBooking->getAttribute("accepted"))
                    <button type="submit" disabled class="btn btn-default pull-right">Accept Booking</button>
                @else
                    <button type="submit" name="accept_booking" class="btn btn-success pull-right">Accept Booking</button>
                @endif
            @elseif($thread->creator() == Auth::user())
                @if($oBooking->getAttribute("accepted"))
                    <button id="proceed2payment" type="button" class="btn btn-success pull-right hide-on-pinned" data-toggle="modal" data-target="#paymentpopup">Proceed to Payment</button>
                    <span id="inforeload"></span>
                @else
                    <button disabled type="button" class="btn btn-success pull-right hide-on-pinned">Proceed to Payment</button>
                    <span id="infowait">Booking must be confirmed by the provider</span>
                @endif
            @endif
        @endif
    </div>
</form>

<!-- Submit Form Input -->

</form>



<div id="paymentpopup" class="modal fade paymentpopup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form accept-charset="UTF-8" data-stripe-publishable-key="{{ config('services.stripe.key') }}" action="{{ route('booking.payment') }}" class="require-validation" data-cc-on-file="false" id="payment-form" method="post">
                {{ csrf_field() }}

                <div style="margin:0;padding:0;display:inline">
                    <input name="utf8" type="hidden" value="✓" />
                    <input name="_method" type="hidden" value="PUT" />
                </div>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="pull-left" style="margin-right: 3%;">Amount to be paid: {{ $oBooking->total() }} EUR</h4>
                    <span class="payment-errors"></span>
                </div>
                <div class="modal-body col-md-12" style="height: auto;">
                    <div class='col-md-2'></div>
                    <div class='col-md-8'>
                        <div class='form-row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Cardholder's Name</label>
                                <input autocomplete='off' data-stripe="name" class='card-name form-control' size='20' type='text'>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label>
                                <input autocomplete='off' data-stripe="number" class='card-number form-control' size='20' type='text'>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='col-xs-4 form-group cvc required'>
                                <label class='control-label'>CVC</label>
                                <input autocomplete='off' data-stripe="cvc" class='card-cvc form-control' placeholder='ex. 311' size='4' type='text'>
                            </div>
                            <div class='col-xs-4 form-group expiration required'>
                                <label class='control-label'>Expiration</label>
                                <input data-stripe="exp-month" class='card-expiry-month form-control' placeholder='MM' size='2' type='text'>
                            </div>
                            <div class='col-xs-4 form-group expiration required'>
                                <label class='control-label'> </label>
                                <input  data-stripe="exp-year" class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-2'></div>
                </div>

                <div class="modal-footer">
                    <div class='form-row'>
                        <div class='col-md-12 form-group'>
                            <button class='form-control btn btn-primary submit-button mt10' type='submit'>Pay »</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script src='https://js.stripe.com/v2/' type='text/javascript'></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        var yyyy2 = today.getFullYear();
        yyyy2 = yyyy2 + 1;

        if(dd<10) {
            dd='0'+dd
        }
        if(mm<10) {
            mm='0'+mm
        }

        today = dd+'/'+mm+'/'+yyyy;
        var endYear = dd+'/'+mm+'/'+yyyy2;
        $('#preferredDate .input-group.date').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
            multidate: true,
            autoclose: false,
            daysOfWeekDisabled: [{{ implode(",",array_diff([1,2,3,4,5,6,7],$oBooking->experience()->availability())) }}],
            weekStart: 1,
            startDate: today,
            endDate: endYear
        });

        $(document).off('change','#booking_form').on('change','#booking_form',function(){
            $('#proceed2payment').prop('disabled', true);
            $("#inforeload").html("Please save your changes or reload page to proceed to payment");
        });


        var $form = $("#payment-form");

        Stripe.setPublishableKey($form.data('stripe-publishable-key'));


        $('form.require-validation').bind('submit', function(e) {
            var $form         = $(e.target).closest('form'),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'].join(', '),
                $inputs       = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid         = true;

            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault(); // cancel on first error
                }
            });
        });

        $form.on('submit', function(e) {
            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                $form.find('button').prop('disabled',true);

                Stripe.createToken({
                    number: $('.card-number').val(),
                    name: $('.card-name').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val(),
                }, stripeResponseHandler);
            }
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
                $form.find('button').prop('disabled',false);

            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                var name = response.card.name;
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();

                $form.append("<input type='hidden' name='reservation[stripe_token]' value='" + token + "'/>");
                $form.append("<input type='hidden' name='reservation[name]' value='"+ name +"'/>");


                $form.get(0).submit();
            }
        }
    });
</script>
