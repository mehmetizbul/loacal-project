{{ csrf_field() }}

<div class="row">
    <div class="col-md-12">
        <div class="col-md-8">
            <div class="form-group">
                <textarea style="resize:none;" name="message" id="message_area" class="form-control">{{ old('message') }}</textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group padding-top-bottom-10">
                <button id="send_msg" type="button" class="btn btn-primary form-control">Send</button>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#messages").scrollTop($("#messages").prop("scrollHeight"));

        var sendmessage = function(){
            var newmsg = $("#message_area").val();
            var thread_id = "{{ $thread->id }}";
            $.ajax({
                url: '/bookingrequest/{{ $oBooking->id }}',
                type: 'PUT',
                data: {
                    message:newmsg,
                    thread_id:thread_id,
                    _token: $("[name=_token]").val()
                },
                beforeSend:function(){
                    $("#message_area").val("");
                },
                success: function(msg) {
                    $("#messages").html(msg);
                    $("#messages").animate({ scrollTop: $('#messages').prop("scrollHeight")});
                }
            });
            return false;
        };

        $(document).off("click","#send_msg").on("click","#send_msg",function(e) {
            sendmessage();
        });

        $(document).off("keydown","#message_area").on("keydown","#message_area",function(e){
            if (e.keyCode == 13)
            {
                if (e.shiftKey === false)
                {
                    e.preventDefault();

                    sendmessage();
                }
            }
        });
    });
</script>