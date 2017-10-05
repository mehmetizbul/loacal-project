@extends('layouts.app')

@section('content')
    <div class="container mt40">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-header text-center">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Role Management</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                </div>
                <div class="panel-body text-center">
                    {!! $roles->render() !!}
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>

                                    <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $roles->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection