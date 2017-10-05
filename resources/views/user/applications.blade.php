<!--
/**
 * Created by PhpStorm.
 * User: Bugra
 * Date: 27.04.2017
 * Time: 23:38
 */
-->

@extends("layouts.app")

@section("content")
    <div class="row mt40">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-header">
                    <div class="col-lg-12 margin-tb">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <div class="pull-left">
                            <h2>Users Management</h2>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr><th>User</th><th>Message</th><th></th></tr>
                        @foreach ($aLa as $key => $oLa)
                            <tr><td><strong>{{ $oLa->user->name }}</strong></td><td>{{ $oLa->applicant_message }}</td><td>
                                    {!! Form::open(['method' => 'PATCH','route' => ['loacal-applications.update', $oLa->id],'style'=>'display:inline']) !!}
                                    {!! Form::checkbox('loacal_agent', 1,false, ['id' => 'loacal_agent']) !!}
                                    <label for="loacal_agent">Agent</label>

                                    {!! Form::submit('Accept', ['class' => 'btn btn-success']) !!}
                                    {!! Form::close() !!}
                                    {!! Form::open(['method' => 'DELETE','route' => ['loacal-applications.destroy', $oLa->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Reject', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td></tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection