@extends('layouts.app')

@section('content')
    <div class="container mt40">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show Certificate</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('certificates.index') }}"> Back</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-header">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Title:</strong>
                        {{ $certificate->title }}
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    @if(!empty($certificate->user_relations()))
                        <strong>Currently held by these users:</strong>
                        <table class="table table-bordered text-center">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Role</th>
                            </tr>
                            @foreach($certificate->user_relations() as $oUC)
                                <tr>
                                    <td>{{ $oUC->user()->id }}</td>
                                    <td>{{ $oUC->user()->name }}</td>
                                    <th>
                                        @if(!empty($oUC->user()->roles))
                                            @foreach($oUC->user()->roles as $v)
                                                <label class="label label-success">{{ $v->display_name }}</label>
                                            @endforeach
                                        @endif
                                    </th>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection