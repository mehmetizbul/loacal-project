<h4 index="{{ $index }}" class="accordion-toggle">Purchase Note: <span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content" style="width:100%;">
        <div class="form-group">
            @if(isset($view))
                <div class="visible-textarea col-md-12">
                    {!! $oExp->purchase_note !!}
                </div>
            @else
                {!! Form::textarea('purchase_note', isset($oExp) ? $oExp->purchase_note : "", array('id' => 'purchase_note','placeholder' => 'Purchase Note','class' => 'form-control')) !!}
            @endif
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#purchase_note').ckeditor();
    });
</script>