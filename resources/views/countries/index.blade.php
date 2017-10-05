@extends('layouts.app')

@section('content')
    <div class="row mt40">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-header text-center">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Experience Country Management</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('countries.create') }}"> Create New Experience Country</a>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel-body text-center">
                    {!! $countries->render() !!}
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Parent Experience Country</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($countries as $key => $country)
                            <tr class="active">
                                <td>{{ ++$i }}</td>
                                <td>{{ $country->name }}</td>
                                <td>{{ $country->slug }}</td>
                                <td></td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('countries.edit',$country->id) }}">Edit</a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['countries.destroy', $country->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @foreach($subs[$country->id] as $oSub)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $oSub->name }}</td>
                                    <td>{{ $oSub->slug }}</td>
                                    <td>{{ $oSub->parent ? \App\Country::whereId($oSub->parent)->first()->name : "" }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('countries.edit',$oSub->id) }}">Edit</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['countries.destroy', $oSub->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                    {!! $countries->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection