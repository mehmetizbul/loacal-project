<h4 index="{{ $index }}" class="accordion-toggle">Category<span></span><i id="tickCategory"
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content" style="width:100%;">
        <div class="form-group">



                @if(!isset($view))
                    <div class="col-lg-12">
                @else
                    <div class="col-lg-12" style="position: relative; z-index: 101;">
                @endif


                <div class="col-lg-4 text-center" id="cat-unselected">
                    <h5>Main Categories</h5>
                    @foreach(\App\Category::main_categories() as $oCat)
                        <div cat="{{ $oCat->id }}" class="col-lg-12 main-cat">
                            <label class="btn" style="">
                                <img class='img-thumbnail img-check cat-image'
                                     src='{{ $oCat->icon() }}' alt='cat_name'/>
                                <input type="checkbox" value="{{ $oCat->id }}"
                                       class="hidden" autocomplete="off">
                                <br/>
                                {{ $oCat->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4 text-center" id="subcat-unselected">
                    <h5>Sub Categories</h5>

                </div>



                    <div class="col-lg-4 text-center" id="cat-selected">

                    <h5>Selected Categories</h5>
                    @if(old('category'))
                        @foreach(\App\Category::oldExperienceFormData(old('category')) as $oCat)
                            <div cat='{{ $oCat->id }}'
                                 class='col-lg-12 sub-cat-selected'>
                                <label class='btn'>
                                    <img class='img-thumbnail img-check cat-image'
                                         src='{{ $oCat->icon() }}' alt='cat_name'/>
                                    <input type='checkbox' checked
                                           value='{{ $oCat->id }}' name='category[]'
                                           class='hidden' autocomplete='off'>
                                    <br/>{{ $oCat->name }}
                                </label>
                            </div>
                        @endforeach
                    @elseif(isset($oExp))
                        @foreach($oExp->categories() as $oCat)
                            <div cat='{{ $oCat->id }}'
                                 class='col-lg-12 sub-cat-selected'>
                                <label class='btn'>
                                    <img class='img-thumbnail img-check cat-image'
                                         src='{{ $oCat->icon() }}' alt='cat_name'/>
                                    <input type='checkbox' checked
                                           value='{{ $oCat->id }}' name='category[]'
                                           class='hidden' autocomplete='off'>
                                    <br/>{{ $oCat->name }}
                                </label>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        @if(!isset($view))

        var selecteddiv = $('#cat-selected');
        var unselecteddiv = $('#subcat-unselected');
        $(document).off('click', '.main-cat').on('click', '.main-cat', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $('.img-check.check').toggleClass("check");
            $(this).find('.img-check').toggleClass("check");
            var self = $(this);
            if ($(this).find('.img-check').hasClass("check")) {
                $.get('/categories/' + $(this).attr('cat') + '/subs.json', function (subs) {
                    subs = $.parseJSON(subs);
                    $('.sub-cat').remove().end();


                    var item = self.clone(true, true).removeClass("main-cat").addClass("sub-cat bold");
                    if (!$('.sub-cat-selected[cat=' + self.attr("cat") + ']').length) {
                        item.find('.img-check').removeClass("check");
                        item.find('input[type=checkbox]').prop('checked', false);
                    }
                    item.prependTo(unselecteddiv);
                    if (!subs.length) {
                        return;
                    }
                    $.each(subs, function (index, sub) {
                        var checked = "";
                        if ($('.sub-cat-selected[cat=' + sub.id + ']').length) {
                            checked = " check";
                        }

                        unselecteddiv.append("<div parent='" + self.attr("cat") + "' cat='" + sub.id + "' class='col-lg-12 sub-cat'>" +
                            "<label class='btn'>" +
                            "<img class='img-thumbnail img-check cat-image" + checked + "' src='" + sub.icon + "' alt='cat_name' />" +
                            "<input type='checkbox' value='" + sub.id + "' class='hidden' autocomplete='off'>" +
                            "<br />" + sub.name +
                            "</label></div>");
                    });
                });
            } else {
                $('.sub-cat').remove().end();
            }
        });

        $(document).off('click', '.sub-cat-selected').on('click', '.sub-cat-selected', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            if (!$(this).attr("parent")) {
                if ($(".sub-cat-selected[parent=" + $(this).attr("cat") + "]").length) {
                    return;
                }
            }

            if ($('.sub-cat[cat=' + $(this).attr('cat') + ']').length) {
                $('.sub-cat[cat=' + $(this).attr('cat') + ']').trigger('click');
            } else {
                $(this).remove().end();
            }
        });

        $(document).off('click', '.sub-cat').on('click', '.sub-cat', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            if (!$(this).attr("parent") && $(this).find('.img-check').hasClass("check")) {
                if ($(".sub-cat-selected[parent=" + $(this).attr("cat") + "]").length) {
                    return;
                }
            }


            $(this).find('.img-check').toggleClass("check");

            if ($(this).find('.img-check').hasClass("check")) {
                $(this).find('input[type=checkbox]').prop('checked', true);
                var item = $(this).clone(true, true).removeClass('sub-cat').addClass('sub-cat-selected');
                item.find('.img-check').removeClass("check");
                item.find('input[type=checkbox]').prop('checked', true).attr('name', 'category[]');
                item.appendTo(selecteddiv);
                if (!$(".sub-cat[cat=" + item.attr("parent") + "]").find(".img-check").hasClass("check")) {
                    $(".sub-cat[cat=" + item.attr("parent") + "]").trigger("click");
                }
            } else {
                $(this).find('input[type=checkbox]').prop('checked', false);
                $('.sub-cat-selected[cat=' + $(this).attr('cat') + ']').remove().end();
            }

        });
        @endif
    });
</script>