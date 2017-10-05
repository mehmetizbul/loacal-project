<!--
/**
 * Created by PhpStorm.
 * User: bugra
 * Date: 24.04.17
 * Time: 09:56
 */
-->

@extends('layouts.app')

@section('content')
    <div class="container mt40">
        <div class="">
            <div class="panel panel-default">

                <div class="panel-header text-center">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Users Management</h2>
                        </div>
                        <div class="pull-right" style="margin-top: 10px;">
                            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <form action="/users" method="GET">
                        {{ Form::select(
                            'role',
                            array_merge(['All'],
                            \App\Role::pluck('display_name','id')->toArray()),
                            $selectedrole,
                            array('onchange'=> 'this.form.submit()')
                            ) }}
                    </form>
                </div>
                <div class="panel-body text-center">
                    {!! $data->appends(['role' => $selectedrole])->links() !!}
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->slug }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->roles))
                                        @foreach($user->roles as $v)
                                            <label class="label label-success">{{ $v->display_name }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $data->appends(['role' => $selectedrole])->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection