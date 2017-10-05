<h4 index="{{ $index }}" class="accordion-toggle">Availability: <span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content">
        <div class="form-group">
            <div class="col-md-12">
                <div class="panel panel-default clearfix">
                    <div class="col-xs-12 toggle-header">
                        <div class="col-xs-4">
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="hidden-xs"><b><u>All</u></b></span>
                            <span class="visible-xs"><b><u>All</u></b></span>
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.monday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.monday') }}</span>
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.tuesday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.tuesday') }}</span>
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.wednesday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.wednesday') }}</span>
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.thursday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.thursday') }}</span>
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.friday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.friday') }}</span>
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.saturday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.saturday') }}</span>
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.sunday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.sunday') }}</span>
                        </div>
                    </div>

                    <div id="feature-1" class="collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    {{ Lang::get('experience.availability') }}
                                </div>
                                <div class="col-xs-1 text-center">
                                    <input {{ isset($oExp) ? (count($oExp->availability) == 7 ? "checked" : "") : "" }} type="checkbox"
                                           id="toggle-all-availability">
                                </div>
                                <div class="col-xs-1 text-center">
                                        <input {{ (is_array(old('availability')) && in_array(1, old('availability'))) ? "checked":(isset($oExp) ? (in_array(1,$oExp->availability()) ? "checked" : "") : "checked") }} name="availability[]"
                                           class="availability" type="checkbox"
                                           value="1">
                                </div>
                                <div class="col-xs-1 text-center">
                                    <input {{ (is_array(old('availability')) && in_array(2, old('availability'))) ? "checked":(isset($oExp) ? (in_array(2, $oExp->availability()) ? "checked" : "") : "checked" )}} name="availability[]"
                                           class="availability" type="checkbox"
                                           value="2">
                                </div>
                                <div class="col-xs-1 text-center">
                                    <input {{ (is_array(old('availability')) && in_array(3, old('availability'))) ? "checked":(isset($oExp) ? (in_array(3, $oExp->availability()) ? "checked" : "") : "checked" )}} name="availability[]"
                                           class="availability" type="checkbox"
                                           value="3">
                                </div>
                                <div class="col-xs-1 text-center">
                                    <input {{ (is_array(old('availability')) && in_array(4, old('availability'))) ? "checked":(isset($oExp) ? (in_array(4, $oExp->availability()) ? "checked" : "") : "checked" )}} name="availability[]"
                                           class="availability" type="checkbox"
                                           value="4">
                                </div>
                                <div class="col-xs-1 text-center">
                                    <input {{ (is_array(old('availability')) && in_array(5, old('availability'))) ? "checked":(isset($oExp) ? (in_array(5, $oExp->availability()) ? "checked" : "") : "checked" )}} name="availability[]"
                                           class="availability" type="checkbox"
                                           value="5">
                                </div>
                                <div class="col-xs-1 text-center">
                                    <input {{ (is_array(old('availability')) && in_array(6, old('availability'))) ? "checked":(isset($oExp) ? (in_array(6, $oExp->availability()) ? "checked" : "") : "checked" )}} name="availability[]"
                                           class="availability" type="checkbox"
                                           value="6">
                                </div>
                                <div class="col-xs-1 text-center">
                                    <input {{ (is_array(old('availability')) && in_array(7, old('availability'))) ? "checked":(isset($oExp) ? (in_array(7, $oExp->availability()) ? "checked" : "") : "checked" )}} name="availability[]"
                                           class="availability" type="checkbox"
                                           value="7">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).off("change", "#toggle-all-availability").on("change", "#toggle-all-availability", function () {
            $(".availability").prop("checked", $(this).prop("checked"));
        });    });
</script>