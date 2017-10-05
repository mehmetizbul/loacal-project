<h4 index="{{ $index }}" class="accordion-toggle">Transportation: <span></span><i
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
                    <input {{ old('transportation')== 3 ?"checked" :(isset($oExp) ? ($oExp->transportation == 3 ? "checked" : "") : "" )}} value="3"
                           type="checkbox" name="transportation"
                           class="transportation-toggle toggle inline-block">
                    <span class="inline-block">Yes</span>
                </div>
                <div class="col-md-6 mt10" style="height: 40px">
                    <p class="inline-block mt20">Available upon request (free)</p>
                </div>
                <div class="col-md-6 mt10">
                    <span class="inline-block">No</span>
                    <input {{ old('transportation')== 2?"checked" :(isset($oExp) ? ($oExp->transportation == 2 ? "checked" : "") : "" )}} value="2"
                           type="checkbox" name="transportation"
                           class="transportation-toggle toggle inline-block">
                    <span class="inline-block">Yes</span>
                </div>
                <div class="col-md-6 mt10" style="height: 40px">
                    <p class="inline-block mt20">Included in price</p>
                </div>
                <div class="col-md-6 mt10">
                    <span class="inline-block">No</span>
                    <input {{ old('transportation')== 1?"checked" :(isset($oExp) ? ($oExp->transportation == 1 ? "checked" : "") : "" )}} value="1"
                           type="checkbox" name="transportation"
                           class="transportation-toggle toggle inline-block">
                    <span class="inline-block">Yes</span>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).off("change", ".transportation-toggle").on("change", ".transportation-toggle", function () {
            if ($(this).prop("checked")) {
                $(".transportation-toggle").not($(this)).prop('checked', false)
            }
        });    });
</script>