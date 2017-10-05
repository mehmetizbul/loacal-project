<!--
/**
 * Created by PhpStorm.
 * User: Bugra
 * Date: 15.05.2017
 * Time: 18:06
 */
-->
@extends("layouts.app")

@section("content")
    {!! Html::style('dist/cropper/cropper.css') !!}
    {!! Html::style('dist/dropzone/dropzone.css') !!}
    <div class="row">
        <a href="/experience/{{ $oExp->id }}/edit"><button type="button" class="btn btn-primary center-block" style="margin: 20px auto;">Back to Experience Edit</button></a>

        <div class="col-md-offset-1 col-md-10">
            <div class="col-md-6">
                <div class="jumbotron">
                    <h3>Thumbnail (600x400)</h3>
                    <br />
                    <!--
                    <form method="post" action="{{ route('upload-featured') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <strong>Featured Image:</strong>
                        <input type="file" name="featured" onchange="this.form.submit()"/>
                        <input type="hidden" name="eid" value="{{ $oExp->id }}"/>
                    </form>
                    -->
                    <br />
                    @if($oExp->thumbnail())
                        <div class="featured_image centered" style="width:400px;">
                            <img id="featured" style="width:100%;" src="/{{ utf8_decode($oExp->thumbnail()->getAttribute('image_file')) }}" alt="">
                        </div>
                        <button type="button" id="crop" class="btn btn-primary center-block" style="margin: 20px auto;"><i class="fa fa-crop" aria-hidden="true"></i></button>
                    @endif
                </div>
            </div>
            <div class="col-md-6">

                <div class="jumbotron">
                    <h3>Gallery Images</h3>
                    <div class="jumbotron">
                        <ul>
                            <li>Images are uploaded as soon as you drop them</li>
                            <li>Maximum allowed size of image is 8MB</li>
                        </ul>
                    </div>
                    <br />

                    {!! Form::open(['url' => route('upload-post',$oExp->id), 'class' => 'dropzone', 'files'=>true, 'id'=>'loacaldropzone']) !!}
                    <input type="hidden" name="experience_id" value="{{ $oExp->id }}"/>
                    <div class="dz-message">

                    </div>

                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>

                    <div class="dropzone-previews" id="dropzonePreview"></div>

                    <h4 style="text-align: center;color:#428bca;">Drop images in this area  <span class="glyphicon glyphicon-hand-down"></span></h4>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>

    <!-- Dropzone Preview Template -->
    <div id="preview-template" style="display: none;">

        <div class="dz-preview dz-file-preview">
            <div class="dz-image"><img data-dz-thumbnail=""></div>

            <div class="dz-details">
                <div class="dz-size"><span data-dz-size=""></span></div>
                <div class="dz-filename"><span data-dz-name=""></span></div>
            </div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
            <div class="dz-error-message"><span data-dz-errormessage=""></span></div>

            <div class="dz-success-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>Check</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                    </g>
                </svg>
            </div>

            <div class="dz-error-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>error</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                            <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                        </g>
                    </g>
                </svg>
            </div>

        </div>

    </div>


    <!-- End Dropzone Preview Template -->


    {!! Form::hidden('csrf-token', csrf_token(), ['id' => 'csrf-token']) !!}


    {!! Html::script('dist/dropzone/dropzone.js') !!}
    {!! Html::script('dist/dropzone/dropzone.config.js') !!}
    {!! Html::script('dist/cropper/cropper.js') !!}
    <script>
        jQuery(document).ready(function($){

            $("#featured").cropper({
                aspectRatio: 6 / 4,
                autoCropArea:1
            });
            $("#crop").click(function(){
                var cropcanvas = $('#featured').cropper('getCroppedCanvas',{ width: 600,
                    height: 400});
                var cropjpg = cropcanvas.toDataURL("image/jpg");

                var path = $("#featured").attr('src');
                $.ajax({
                    type: 'POST',
                    url: '/experience/images/uploadCroppedFeatured',
                    data: {
                        experience_id: {{ $oExp->id }},
                        filepath: path,
                        jpgimageData: cropjpg,
                        _token: $('#csrf-token').val()
                    },
                    beforeSend:function(){
                        $("#crop").html("Cropping...")
                        $("#crop").removeClass("btn-primary").addClass("btn-disabled");
                    },
                    dataType: 'html',
                    success: function(data){
                        var rep = JSON.parse(data);
                        if(rep.code == 200)
                        {
                            location.reload();
                        }
                    }
                });
            });


            Dropzone.options.loacaldropzone = {
                autoDiscover:false,
                paramName: "files",
                uploadMultiple: true,
                parallelUploads: 100,
                maxFilesize: 8,
                autoProcessQueue: true,
                previewsContainer: '#dropzonePreview', // we specify on which div id we must show the files
                addRemoveLinks: true,
                dictRemoveFile: 'Remove',
                dictFileTooBig: 'Image is bigger than 8MB',
                clickable: '#dropzonePreview',
                addMakeFeaturedLinks:true,
                dictMakeFeatured: 'Make\nFeatured',
                createImageThumbnails:true,
                withCredentials:true,
                thumbnailWidth: 250,
                thumbnailHeight: 250,
                dictDefaultMessage: 'Drop files here to upload',
                accept: function(file, done) {
                    console.log("uploaded");
                    done();
                },
                init: function(){
                    var dz = this;
                    @if(isset($images))
                        var images = {!! json_encode($images) !!};
                        $.each(images, function(key,value){
                            var mockFile = { name: value.name, size: value.size }; // here we get the file name and size as response
                            dz.options.addedfile.call(dz, mockFile);
                            dz.options.thumbnail.call(dz, mockFile,value.fullpath);//uploadsfolder is the folder where you have all those uploaded files
                            dz.emit("complete", mockFile);
                            dz.files.push( mockFile ); // file must be added manually
                        });
                    @endif

                    dz.on("removedfile", function(file) {
                        var path = $(file.previewElement).find('.dz-image img').attr('src');
                        $.ajax({
                            type: 'POST',
                            url: '/experience/images/delete',
                            data: {experience_id: {{ $oExp->id }},filepath: path, _token: $('#csrf-token').val()},
                            dataType: 'html',
                            success: function(data){
                                var rep = JSON.parse(data);
                                if(rep.code == 200)
                                {
                                    console.log("deleted");
                                }
                            }
                        });

                    } );
                    dz.on("makefeatured", function(file) {
                        console.log("its working");
                        var path = $(file.previewElement).find('.dz-image img').attr('src');
                        $.ajax({
                            type: 'POST',
                            url: '/experience/images/makeFeatured',
                            data: {experience_id: {{ $oExp->id }},filepath: path, _token: $('#csrf-token').val()},
                            dataType: 'html',
                            success: function(data){
                                var rep = JSON.parse(data);
                                if(rep.code == 200)
                                {
                                    console.log("made featured");
                                    location.reload(true);
                                }
                            }
                        });
                    } );
                }
            }
        });
    </script>
@endsection