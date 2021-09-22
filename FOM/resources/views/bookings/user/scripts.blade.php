<script type="text/javascript">
    window.onload = init;

    function init(){

    }

    //Adjust height of textarea for chat
    function textAreaAdjust(o) {
        o.style.height = "1px";
        o.style.height = (25+o.scrollHeight)+"px";
    }

    //On Focus on textarea for chat make other rows unsticky
    var $width = $(window).width();
    $( "#chat-textarea" ).focus(function() {
        $( '.delete-fixed-bottom' ).removeClass( "fixed-bottom" );
        //add sticky to textarea in mobile
        if($width < 960){
            $( '.add-fixed-bottom' ).addClass( "fixed-bottom" );
        }
    });

    //On Focus Out on textarea for chat make other rows sticky
    $( "#chat-textarea" ).focusout(function() {
        $( '.delete-fixed-bottom' ).addClass( "fixed-bottom" );
        //add sticky to textarea in mobile
        if($width < 960){
            $( '.add-fixed-bottom' ).removeClass( "fixed-bottom" );
        }
    });

    $(".AcceptButton").each(function(){
        $(this).on('click',function () {
            let valueForm=$(this).attr('value-form');
            $("."+valueForm).submit();
            $("#loader_modal").modal('show');
        });
    });

    $(".CancelButton").each(function(){
        $(this).on('click',function () {
            let valueForm=$(this).attr('value-form');
            $("."+valueForm).submit();
            $("#loader_modal").modal('show');
        });
    });

</script>
