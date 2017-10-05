<h4 index="{{ $index }}" class="accordion-toggle">Is this experience
    disabled-friendly?<span>{{ old('disabled_friendly')== 1)? "Yes" : (isset($oExp) ? ($oExp->disabled_friendly ? "Yes" : "No") : "No" }}</span><i
            class="fa fa-check add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content">
        <div class="form-group">
            <span class="inline-block">Disabled Friendly? No</span>
            <input name="disabled_friendly" index="5" value="1"
                   {{old('disabled_friendly')== 1)?"checked" : ( isset($oExp) ? ($oExp->disabled_friendly ? "checked" : "") : "" }} type="checkbox"
                   class="toggle inline-block">
            <span class="inline-block">Yes</span>
        </div>
    </div>
</div>