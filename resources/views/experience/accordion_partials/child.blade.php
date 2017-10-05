<h4 index="{{ $index }}" class="accordion-toggle">Is this experience
    child-friendly?<span>{{ old('child_friendly')== 1)? "Yes" : (isset($oExp) ? ($oExp->child_friendly ? "Yes" : "No") : "No"}}</span><i
            class="fa fa-check add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content">
        <div class="form-group">
            <span class="inline-block">Child Friendly? No</span>
            <input name="child_friendly" index="4" value="1"
                   {{old('child_friendly')== 1)?"checked" : (isset($oExp) ? ($oExp->child_friendly ? "checked" : "") : "" }} type="checkbox"
                   class="toggle inline-block">
            <span class="inline-block">Yes</span>
        </div>
    </div>
</div>