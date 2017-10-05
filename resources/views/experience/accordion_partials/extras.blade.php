<h4 index="{{ $index }}" class="accordion-toggle">Extras<span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content" style="width: 100%;">
        <div class="form-group">
            <div class="col-md-12">

                @if (Session::has('resources'))
                @foreach(Session::get('resources') as $key=>$oRes)
                <div class="col-md-12 resources_container"
                     index="{{ $key }}">
                    <div class="col-md-6">
                        <span class="inline-block" style="margin-top: 5px;"><br/></span>
                        <input name="resources[{{ $key }}][title]"
                               type="text" class="form-control inline-block"
                               value="{{ $oRes["title"] }}"
                               placeholder="i.e. Entrance to Wine House">
                    </div>
                    <div class="col-md-5">
                        <span class="inline-block" style="margin-top: 5px;">Price (€)</span>
                        <input name="resources[{{ $key }}][price]"
                               type="number" step="0.01" min="0"
                               class="form-control inline-block"
                               value="{{ $oRes["price"] }}"
                               placeholder="i.e. 33.5 ">
                    </div>
                    <div class="col-md-1 centered">
                        <span class="inline-block" style="margin-top: 5px;"><br/></span>
                        @if(!isset($view))
                                    <span class="remove_resource"
                                          remove="{{ $key }}"><i class="fa fa-times"
                                                                 aria-hidden="true"></i></span>
                        @endif
                    </div>
                </div>
                @endforeach

                @elseif(isset($oExp) && count($oExp->resources()))
                @foreach($oExp->resources() as $key=>$oRes)
                <div class="col-md-12 resources_container"
                     index="{{ $key }}">
                    <div class="col-md-6">
                        <span class="inline-block" style="margin-top: 5px;"><br/></span>
                        <input name="resources[{{ $key }}][title]"
                               type="text" class="form-control inline-block"
                               value="{{ $oRes->title }}"
                               placeholder="i.e. Entrance to Wine House">
                    </div>
                    <div class="col-md-5">
                        <span class="inline-block" style="margin-top: 5px;">Price (€)</span>
                        <input name="resources[{{ $key }}][price]"
                               type="number" step="0.01" min="0"
                               class="form-control inline-block"
                               value="{{ $oRes->cost }}"
                               placeholder="i.e. 33.5 ">
                    </div>
                    <div class="col-md-1 centered">
                        <span class="inline-block" style="margin-top: 5px;"><br/></span>
                        @if(!isset($view))
                                    <span class="remove_resource"
                                          remove="{{ $key }}"><i class="fa fa-times"
                                                                 aria-hidden="true"></i></span>
                        @endif
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-md-12 resources_container" index="0">
                    <div class="col-md-6">
                                                                <span class="inline-block"
                                                                      style="margin-top: 5px;"><br/></span>
                        <input name="resources[0][title]" type="text"
                               class="form-control inline-block"
                               placeholder="i.e. Entrance to Wine House">
                    </div>
                    <div class="col-md-5">
                        <span class="inline-block" style="margin-top: 5px;">Price (€)</span>
                        <input name="resources[0][price]" type="number"
                               step="0.01" min="0"
                               class="form-control inline-block"
                               placeholder="i.e. 33.5 ">
                    </div>
                    <div class="col-md-1 centered">
                                                                <span class="inline-block"
                                                                      style="margin-top: 5px;"><br/></span>
                            <span class="remove_resource" remove="0"><i
                                    class="fa fa-times" aria-hidden="true"></i></span>
                    </div>
                </div>
                @endif
                <div class="col-md-12">
                    @if(!isset($view))
                        <a href="#" id="addmore_resources_container"
                           class="btn btn-primary  pull-right">Add more</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).off("click", ".remove_resource").on("click", ".remove_resource", function () {
            if ($('.remove_resource').length > 1) {
                $(".resources_container[index=" + $(this).attr("remove") + "]").remove().end();
            }
        });

        $(document).off("click", "#addmore_resources_container").on("click", "#addmore_resources_container", function () {
            var clone = $(".resources_container").last().clone(true, true);
            var index = clone.attr("index");
            var newindex = parseInt(index) + 1;

            clone.attr('index', newindex);
            clone.find('input,select').each(function () {
                var name = $(this).attr("name");
                var newname = name.substr(0, name.indexOf('['));
                newname = newname + "[" + newindex + "]";
                newname = newname + name.substr(name.indexOf(']') + 1);
                $(this).attr("name", newname);
            });
            clone.find('.remove_resource').attr('remove', newindex).show();
            clone.insertAfter($(".resources_container").last());
        });
    });
</script>