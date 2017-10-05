<!--
/**
 * Created by PhpStorm.
 * User: Bugra
 * Date: 27.04.2017
 * Time: 23:23
 */
-->
@extends('loacal.loacalcommon', ['title' => 'Frequently Asked Questions'])
@section('loacalContent')
    <div class='container-fluid centered'>
        <h2>Bookings</h2>
        <div class="accordion container">
            <h4 class="accordion-toggle">How do I book an experience?</h4>
            <div class="accordion-content">
                <p>
                    When you reserve an experience at Loacal.com, experience provider receives an email with your request and the initial contact has been made. Depending on loacal’s availability, s/he will approve or edit or cancel your request. You can now communicate with the host using the <a href="/bookingrequest">Message Box</a>. While others are comfortable letting you book their experience instantly without waiting for approval. After the approval, you will be requested to pay for your experience.
                    Read <a href="/how-it-works">How it works</a> for details.
                </p>
            </div>

            <h4 class="accordion-toggle">I have not received a confirmation email. What should I do?</h4>
            <div class="accordion-content">
                <p>
                    First things first, we recommend checking your Junk folder as it might be waiting for you there.
                    You should have received a confirmation email within 24 hours of placing your order. If it's later than that and you still haven't heard anything, <a href="">let us know.</a>
                </p>
            </div>

            <h4 class="accordion-toggle">When am I charged for a reservation?</h4>
            <div class="accordion-content">
                <p>
                    Initial step of a reservation is agreeing on details of the experience, while some experiences offer instant booking. Your payment information is not requested until the loacal accepts your booking. Once the host accepts your request, you will be asked for the payment.
                </p>
            </div>
            <h4 class="accordion-toggle">How can I get an invoice?</h4>
            <div class="accordion-content">
                <p>
                    We can provide you with an invoice for your experience, so please contact us from payments@loacal.com
                </p>
            </div>
            <h4 class="accordion-toggle">Will my guide speak my language?</h4>
            <div class="accordion-content">
                <p>
                    And this it’s a good one. One of our main aims as Loacal.com is to offer as many activities in as many languages as possible in order for travelers to have the option to communicate with locals who can speak their languages.
                    You can filter experiences by spoken language at our <a href="/experiences">Explore page</a>. This information is also available at the experience page of a particular activity.
                    Note that an activity being able to be conducted in your language, doesn’t mean it is only conducted in your language. Many guides are multilingual and give tours in multiple languages.

                </p>
            </div>
        </div>

        <h2>Security</h2>
        <div class="accordion container">
            <h4 class="accordion-toggle">Why should I pay and communicate through Loacal.com?</h4>
            <div class="accordion-content">
                <p>
                    Paying and communicating through Loacal.com is not only a requirement in our Terms of Service—it also protects you by Safe and Secure Payments protected under our Terms, Cancellation and Refund Policies. Never pay outside of our platform, app or website and report any off-site payment to us immediately.
                </p>
            </div>
            <h4 class="accordion-toggle">How do I know if an email is really from Loacal.com?</h4>
            <div class="accordion-content">
                <p>
                    If you receive an email that appears to be from Loacal.com or are directed to a website that looks like Loacal.com requesting sensitive personal information, be cautious. When in doubt, <strong>do not click on any link provided.</strong> Start with Loacal.com homepage in your browser and go from there.
                </p>
            </div>
            <h4 class="accordion-toggle">Can others see my email address?</h4>
            <div class="accordion-content">
                <p>
                    We don't share your personal email address even after you have a confirmed reservation. You should never provide your email address to a host. All your communication is required and is suggested to be through Loacal.com for security reasons.
                </p>
            </div>
            <h4 class="accordion-toggle">Any Safety Tips for Travelers?</h4>
            <div class="accordion-content">
                <p>
                    Before booking an experience, check the certificates and personal/agency verifications completed by the host and make sure that you are feeling safe enough before booking the experience. If you have any hesitation, you may contact the loacal directly or email us clarifying your concerns and we will do our best to direct/ help you.
                </p>
            </div>
            <h4 class="accordion-toggle">What do I do if I feel unsafe during a trip?</h4>
            <div class="accordion-content">
                <p>
                    Better safe than be sorry, says Walters. Be sure to read our Safety Tips and loacal details before booking an experience.
                    If you encounter an emergency situation, or if your personal safety is threatened while travelling, <strong>contact local police or emergency services immediately.</strong>

                    If you need help from us, please call +44 75 99 1717 01
                </p>
            </div>
        </div>
        <h2>Pricing</h2>
        <div class="accordion container">
            <h4 class="accordion-toggle">Are taxes included in the price?</h4>
            <div class="accordion-content">
                <p>
                    This depends on the experience selected, but it’s easy to see what's included by reading your booking confirmation. Tax requirements change from country to country so it's always good to check.
                </p>
            </div>
        </div>
        <h2>Bookings</h2>
        <div class="accordion container">
            <h4 class="accordion-toggle">Do I pay the full price for my child(ren)?</h4>
            <div class="accordion-content">
                <p>
                    Information regarding children is dependent on the experience and located at the Pricing data of each experience. Please note that added costs for children, if any, are not included in the reservation price. Make sure that your booking request covers this information correctly. Your confirmation email should have this detail. If you are still not sure on your request or need to request a change, directly contact to your Loacal using the <a href="">Message Box.</a>
                </p>
            </div>
            <h4 class="accordion-toggle">Can I book an activity in a different currency?</h4>
            <div class="accordion-content">
                <p>
                    No, while you browse through Loacal.com, you can can choose to see an estimation of the price in various currencies however, booking will be in euros. Be aware that your bank may charge you a currency conversion fee. Check with your bank about their policy before booking.
                </p>
            </div>
        </div>
        <h2>Cancellation</h2>
        <div class="accordion container">
            <h4 class="accordion-toggle">Can I cancel my booking?</h4>
            <div class="accordion-content">
                <p>
                    Yes! Any cancellation fees are determined by the experience and/or listed in your <a href="/cancellation">cancellation policy.</a>
                </p>
            </div>
            <h4 class="accordion-toggle">How can I cancel my booking?</h4>
            <div class="accordion-content">
                <p>
                    Either send a message to Loacal directly, or ideally, cancel your booking via clicking the cancel button at <a href="/my-account">My Bookings.</a>
                </p>
            </div>
            <h4 class="accordion-toggle">If I need to cancel my booking, will I pay a fee?</h4>
            <div class="accordion-content">
                <p>
                    If you cancel the booking request before the confirmation of host, you will not be charged any fees or commission.
                    If your booking is no longer free to cancel, you may incur a cancellation fee. Any cancellation fees are determined by the experience. You must cancel your trip for a refund. You will pay any additional costs to the experience.
                </p>
            </div>
            <h4 class="accordion-toggle">Can I cancel or change my dates for a booking?</h4>
            <div class="accordion-content">
                <p>
                    Changing your dates for a booking is possible depending on availability. If you choose to cancel your booking, you may incur charges, determined by the experience provider. You will pay any additional costs to the experience.
                </p>
            </div>
            <h4 class="accordion-toggle">Where can I find my experience's cancellation policy?</h4>
            <div class="accordion-content">
                <p>
                    You can find this in your booking confirmation.
                </p>
            </div>
            <h4 class="accordion-toggle">How do I know if my booking was cancelled?</h4>
            <div class="accordion-content">
                <p>
                    After you cancel a booking with us, you should receive an email confirming the cancellation. Check your inbox and spam/junk mail folders. If you don’t receive an email within 24 hours, please contact our customer services to confirm we received your cancellation.
                </p>
            </div>
            <h4 class="accordion-toggle">Am I entitled for a full refund?</h4>
            <div class="accordion-content">
                <p>
                    The refund amount you will receive depends on several variables. For example, experiences that require preparation will determine their policy accordingly. Fees and surcharges collected in conjunction with the ticket will only be refunded if applicable.
                </p>
            </div>
            <h4 class="accordion-toggle">Is it possible to get a refund for cancellation due to bereavement?</h4>
            <div class="accordion-content">
                <p>
                    In the sad event of a bereavement, we wish to help you, not add to your troubles. You or host who thinks has a valid reason for a booking cancellation such as death of an immediate family member, certain illness situations, travellers in the reservation actively on jury duty during the dates of planned travel, travel cancellation due to third party...etc should contact cancellation@loacal.com immediately fully explaining the reason, with relevant proofs and documents. If the excuse is approved, refund will be provided
                </p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.accordion').find('.accordion-toggle').click(function() {
                $(this).next().slideToggle('600');
                $(".accordion-content").not($(this).next()).slideUp('600');
            });
            $('.accordion-toggle').on('click', function() {
                $(this).toggleClass('active').siblings().removeClass('active');
            });
        });
    </script>
@endsection
