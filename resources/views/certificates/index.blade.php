@extends('layouts.app')

@section('content')
    <div class="container mt40">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-header text-center">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Certificate Management</h2>
                        </div>
                        <div class="pull-right">
                            <!--<a class="btn btn-success" href="{{ route('certificates.create') }}"> Create New Certificate</a>-->
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
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
                    {!! $certificates->render() !!}
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Icon</th>
                            <th>Title</th>
                            <th># used</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($certificates as $key => $certificate)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>
                                    @if($certificate->icon())
                                        <img class='cat-image-admin' src='{{ $certificate->icon() }}' alt='cat_name' />
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $certificate->title }}</td>
                                <td>{{ count($certificate->user_relations()) }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('certificates.show',$certificate->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('certificates.edit',$certificate->id) }}">Edit</a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['certificates.destroy', $certificate->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}

                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $certificates->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection