<h4 index="{{ $index }}" class="accordion-toggle">Language: <span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content" style="width:100%;">
        <div class="form-group ">
            <div class="col-md-3">
            </div>
            @if(!isset($view))
                <div class="col-md-6">
                    <select style="height:150px;" multiple class="form-control"
                            name="language[]">
            @else
                <div class="col-md-6" style="position: relative; z-index: 101;">
                    <select style="height:150px;" multiple disabled class="form-control"
                            name="language[]">
            @endif
                    @foreach(\App\Language::orderBy('name')->get() as $lang)
                        <option {{ is_array(old('language')) && in_array($lang->id, old('language')) ? "selected":(isset($oExp) ? (in_array($lang->id,$oExp->languages()) ? "selected" : "") : "" )}} value="{{ $lang->id }}">{{ $lang->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</div>