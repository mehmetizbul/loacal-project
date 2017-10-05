<h4 index="{{ $index }}" class="accordion-toggle">Experience Owner: <span></span><i
        class="fa fa-check unchecked add_experience_row_success fa-pull-right"
        aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content" style="width:100%;">
        <div class="form-group ">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <select class="form-control" name="owner" id="owner" data-parsley-required="true">
                    <option value="0">Please select the experience owner</option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" {{old('owner') == $owner->id ? ' selected="selected"':( isset($oExp) ? ($oExp->admin()->id == $owner->id ? ' selected="selected"' : ''):'') }}>{{ $owner->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</div>