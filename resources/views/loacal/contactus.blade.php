@extends('loacal.loacalcommon', ['title' => 'How can we help?'])
@section('loacalContent')

    <div class="container-fluid centered">
        <h4 class="loacal-blue">You couldn't find an answer to your question at <a href="/faq">FAQ</a>? Don't worry! We are one-step behind.</h4>
        <div class="col-md-6 col-xs-12">
            <div class="loacal-blue-dark-bg">
                <h3 class="white padding-top-bottom-10">Write us an email.</h3>
            </div>
            <div>
                <h4>info@loacal.com</h4>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="loacal-blue-dark-bg">
                <h3 class="white padding-top-bottom-10">Contact us by WhatsApp</h3>
            </div>
            <div>
                <h4>+44 75 99 1717 01</h4>
            </div>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="loacal-blue-dark-bg">
                <h3 class="white padding-top-bottom-10">Or, fill in the form below.</h3>
            </div>
            <div class="centered">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-area">
                        <form role="form">

                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" type="textarea" id="message" placeholder="Message" maxlength="140" rows="7" required></textarea>
                            </div>

                            <button type="button" id="submit" name="submit" class="btn btn-primary pull-right">Submit Form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection