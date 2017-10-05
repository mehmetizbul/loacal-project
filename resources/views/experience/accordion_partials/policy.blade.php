<h4 index="{{ $index }}" class="accordion-toggle">Cancellation Policy: <span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content" style="width:100%;">
        <div class="form-group">
            <div class="col-md-12">
                @if(isset($view))
                    <div class="visible-textarea col-md-12">
                        {!! $oExp->cancellation_policy !!}
                    </div>
                @else
                    {!! Form::textarea('cancellation_policy', isset($oExp) ? $oExp->cancellation_policy : "", array('id' => 'cancellation_policy','placeholder' => 'Cancellation Policy','class' => 'form-control')) !!}
                @endif
            </div>
        </div>
    </div>
</div>
