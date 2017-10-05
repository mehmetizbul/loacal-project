<!--
/**
 * Created by PhpStorm.
 * User: Bugra
 * Date: 27.04.2017
 * Time: 21:09
 */
-->

@extends('user.accountcommon')

@section('accountheader')
    <div class='container-fluid'>
        <div class='container'>
            <div class='input-fields'>
                <h2>Become a Loacal</h2>
                <form action="/my-account" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ $auth->id }}">
                    <div class='form-group'>
                        <label for='applicant_message'>Tell us why you would like to become a Loacal</label><br/>
                        <textarea rows='5' class='form-control' name='applicant_message' id='applicant_message'></textarea>
                    </div>
                    <button type='submit' class='btn btn-primary'>Let us know!</button>
            </div>
        </div>
    </div>
@endsection