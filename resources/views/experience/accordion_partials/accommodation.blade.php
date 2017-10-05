<h4 index="{{ $index }}" class="accordion-toggle">Accommodation: <span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-md-6" style="height: 40px">
                    <p class="inline-block mt20">Available upon request (extra
                        fee)</p>
                </div>
                <div class="col-md-6">
                    <span class="inline-block">No</span>
                    <input {{ old('accommodation')== 3 ?"checked" :(isset($oExp) ? ($oExp->accommodation == 3 ? "checked" : "") : "" )}} type="checkbox"
                           value="3" name="accommodation"
                           class="accommodation-toggle toggle inline-block">
                    <span class="inline-block">Yes</span>
                </div>
                <div class="col-md-6 mt10" style="height: 40px">
                    <p class="inline-block mt20">Available upon request (free)</p>
                </div>
                <div class="col-md-6 mt10">
                    <span class="inline-block">No</span>
                    <input {{ old('accommodation')== 2 ?"checked" :(isset($oExp) ? ($oExp->accommodation == 2 ? "checked" : "") : "" )}} type="checkbox"
                           value="2" name="accommodation"
                           class="accommodation-toggle toggle inline-block">
                    <span class="inline-block">Yes</span>
                </div>
                <div class="col-md-6 mt10" style="height: 40px">
                    <p class="inline-block mt20">Included in price</p>
                </div>
                <div class="col-md-6 mt10">
                    <span class="inline-block">No</span>
                    <input {{ old('accommodation')== 1 ?"checked" :(isset($oExp) ? ($oExp->accommodation == 1 ? "checked" : "") : "" )}} type="checkbox"
                           value="1" name="accommodation"
                           class="accommodation-toggle toggle inline-block">
                    <span class="inline-block">Yes</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).off("change", ".accommodation-toggle").on("change", ".accommodation-toggle", function () {
            if ($(this).prop("checked")) {
                $(".accommodation-toggle").not($(this)).prop('checked', false)
            }
        });    });
</script>