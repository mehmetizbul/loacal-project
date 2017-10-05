<h4 index="{{ $index }}" class="accordion-toggle">Duration <span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-md-4">
                    <span>Duration:</span>
                </div>
                <div class="col-md-4">
                    <input name="duration" type="number"
                           value="{{old('duration')? old('duration'):(isset($oExp) ? $oExp->duration : "") }}"
                           step="0.01" min="0" class="form-control">
                </div>
                <div class="col-md-4">
                    <select name="duration_unit" class="form-control"
                            onchange="document.getElementById('duration_unit').value = this.value;
                                                        document.getElementById('pm_duration_unit').value = this.value;">
                        <option {{old('duration_unit') == "minute" ? "selected":(isset($oExp) ? ($oExp->duration_unit == "minute" ? "selected" : "") : "")}} value="minute">
                            Minutes
                        </option>
                        <option {{ old('duration_unit') == "hour" ? "selected":(isset($oExp) ? ($oExp->duration_unit == "hour" ? "selected" : "") : "")}} value="hour">
                            Hours
                        </option>
                        <option {{ old('duration_unit') == "day" ? "selected":(isset($oExp) ? ($oExp->duration_unit == "day" ? "selected" : "") : "")}} value="day">
                            Days
                        </option>

                    </select>
                </div>
            </div>
        </div>
    </div>
</div>