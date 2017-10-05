@extends('layouts.app')

@section('content')
    <div class="row mt40">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-header text-center">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Category Management</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('categories.create') }}"> Create New Category</a>
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
                    {!! $categories->render() !!}
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Parent Category</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($categories as $key => $category)
                            <tr class="active">
                                <td>{{ ++$i }}</td>
                                <td>
                                    @if($category->icon())
                                        <img class='cat-image-admin' src='{{ $category->icon() }}' alt='cat_name' />
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td></td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('categories.edit',$category->id) }}">Edit</a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['categories.destroy', $category->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @foreach($subs[$category->id] as $oSub)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        @if($oSub->icon())
                                            <img class='cat-image-admin' src='{{ $oSub->icon() }}' alt='cat_name' />
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $oSub->name }}</td>
                                    <td>{{ $oSub->slug }}</td>
                                    <td>{{ $oSub->parent ? \App\Category::whereId($oSub->parent)->first()->name : "" }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('categories.edit',$oSub->id) }}">Edit</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['categories.destroy', $oSub->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                    {!! $categories->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection