/**
 Athour : @nup
 Date:26102014
 */
;
(function ($) {
    $(document).ready(function () {
        $('.badge', '.event-collapse').click(function () {
            var badge = $(this);
            var collapseEvent = badge.parents('.event-collapse');
            var desc = $('.event-desc', collapseEvent);
            if (desc.hasClass('expended')) {
                $('.fa', badge).addClass('fa-angle-up').removeClass('fa-angle-down');
                desc.removeClass('expended');
            } else {
                desc.addClass('expended');
                $('.fa', badge).addClass('fa-angle-down').removeClass('fa-angle-up');
            }

        });
        $('.list-msg-item', '#messager-conatiner').click(function () {
            if ($(this).hasClass('active'))
                return;
            $('.list-msg-item', '#messager-conatiner').removeClass('active');
            $(this).addClass('active');
            var userResidence = $(this).attr('data-id');
            //showMessage(userResidence);
        });
        $('a.list-group-item-toggle').click(function () {
            toggleCollapse();
        });
        $('#load-more-message').click(function(){
            $('.short-messages > li.sms','#message-conatiner').each(function(){
                var $index = $(this).index();
                $('.sms-by',$(this)).text('Message'+ (++$index));
                $(this).clone().appendTo('#message-conatiner .short-messages');
            });
            return false;
        });
        
        $("select").each(function(){
            $(this).wrap( "<span class='select-wrapper'></span>" );
            $(this).after("<span class='holder'></span>");
        });

        $("select").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);                    	
        }).trigger('change');
    });
//    function showMessage(userResidence) {
//        var msgContainer = $('#message-conatiner');
//        var messages = msgContainer.html();
//        msgContainer.slideUp('slow', function () {
//           
//            msgContainer.html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
//            msgContainer.fadeIn();
//            setTimeout(function () {
//                loadMessage(messages);
//            }, 3000);
//        });
//
//    }
//    ;
//    function loadMessage(msg) {
//        var msgContainer = $('#message-conatiner');
//        msgContainer.fadeOut('slow', function () {
//            msgContainer.html(msg)
//                    .slideDown()
//                    .mCustomScrollbar("update");
//        });
//    }
    ;
    function toggleCollapse() {
        $('.list-group-item-toggle', '#messager-conatiner').toggleClass('double-down');
        $('.list-group', '#messager-conatiner').toggleClass('toggleCollapse');

    }
    $(window).load(function () {
        $("#message-conatiner").mCustomScrollbar({
            theme: "3d-thick-dark",
            scrollButtons: {
                enable: true,
            },
            scrollTo:"bottom"
        });
        $("#service-lists-container").mCustomScrollbar({
            theme: "3d-thick-dark",
            scrollButtons: {
                enable: true,
            }
        });
        //$("#message-conatiner").mCustomScrollbar('scrollTo','bottom');
    });
})(jQuery);

//$(selector).mCustomScrollbar("scrollTo",position);