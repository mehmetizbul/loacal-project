<h4 index="{{ $index }}" class="accordion-toggle">Experience Description<span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content" style="width:100%;">
        <div class="form-group">
            <div class="col-md-12">
                @if(isset($view))
                    <div class="visible-textarea col-md-12">
                        {!! $oExp->description !!}
                    </div>
                @else
                    {!! Form::textarea('description', isset($oExp) ? $oExp->description : null, array('id' => 'description','placeholder' => 'Description','class' => 'form-control')) !!}
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#description').ckeditor();
    });

    $("#editorContainer iframe").contents().find("body").text();
</script>