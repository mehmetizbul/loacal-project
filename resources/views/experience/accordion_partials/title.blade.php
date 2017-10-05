<h4 index="{{ $index }}" class="accordion-toggle">Experience Title:
    <span>{{ isset($oExp) ? $oExp->title : "" }}</span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content">
        <div class="form-group">
            <div class="col-md-10">
                {!! Form::text('title', isset($oExp) ? $oExp->title : null, array('placeholder' => 'Title','class' => 'form-control','index'=>1)) !!}
            </div>
        </div>
    </div>
</div>