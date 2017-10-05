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
                            <h2>Experiences Management</h2>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="status">Experience Status:</label>
                        <select class="form-control" id="status" onchange="window.location.href='/experiences/manage/'+this.value;">
                            <option {{ $status=="live" ? "selected" : "" }} value="live">Live</option>
                            <option {{ $status=="draft" ? "selected" : "" }} value="draft">Draft</option>
                            <option {{ $status=="pending" ? "selected" : "" }} value="pending">Pending</option>
                            <option {{ $status=="archive" ? "selected" : "" }} value="archive">Archive</option>
                        </select>
                    </div>
                    <table class="table table-bordered">
                        <tr><th>#</th><th>Title</th><th>Author</th><th>Admins</th><th></th></tr>

                        @foreach ($aExp as $oExp)
                            <tr><td>{{ $oExp->id }}</td><td><strong>{{ $oExp->title }}</strong></td><td>{{ $oExp->author() ? $oExp->author()->name : "" }}</td>
                                <td>
                                    @if($oExp->admin(true))
                                        @foreach($oExp->admin(true) as $oAdm)
                                            <span>{{ $oAdm->name }}</span>
                                        @endforeach
                                    @else
                                        {{ $oExp->author()->name." (Author)" }}
                                    @endif
                                </td>
                                <td>
                                    @if($status != "live")
                                        <a href="/experience/{{ $oExp->id }}/view" type="button" class="btn btn-info">View</a>
                                    @endif
                                    @if($status == "live")
                                        <a href="/experience/{{ $oExp->slug }}" type="button" class="btn btn-success">View</a>
                                    @elseif($status == "pending")
                                        {!! Form::open(['method' => 'POST','route' => ['experience.accept', $oExp->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Accept', ['class' => 'btn btn-success']) !!}
                                    @endif
                                    <input type="hidden" value="{{ $status }}" name="status"/>
                                    {!! Form::close() !!}
                                    @if($status == "draft")
                                            <a href="/experience/{{ $oExp->id }}/edit" type="button" class="btn btn-default">Edit</a>
                                    @endif

                                    @if($status != "archive" && $status != "draft")
                                        {!! Form::open(['method' => 'DELETE','route' => ['experience.destroy', $oExp->id],'style'=>'display:inline']) !!}
                                        <button class="btn btn-danger btn-primary" data-toggle="confirmation"
                                                data-btn-ok-label="Get rid of it!" data-btn-ok-icon="glyphicon glyphicon-share-alt"
                                                data-btn-ok-class="btn-success"
                                                data-btn-cancel-label="Stoooop!" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
                                                data-btn-cancel-class="btn-danger"
                                                data-title="Is it ok?" data-content="Do you really want to do that?">
                                            {{ $status == "live" ? "Archive" : "Reject"}}
                                        </button>
                                        <input type="hidden" value="{{ $status }}" name="status"/>
                                        {!! Form::close() !!}
                                    @endif
                                </td></tr>
                        @endforeach
                    </table>
                    {!! $aExp->links() !!}
                </div>
            </div>
        </div>
    </div>
    {!! Html::script('dist/bootstrap-confirmation/bootstrap-confirmation.min.js') !!}
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                // other options
            });
        });
    </script>
@endsection
