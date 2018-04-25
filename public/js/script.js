var selected_filter_checker = false;
var selected_items = "";

function showResults(data){
    if(data.response == "error"){
        $(".errorMessages").html("");

        $.each(data.errors, function(key, value){
            $(".errorMessages").append("<label>"+value+"</label><br>");
        });

        $(".errorMessages").fadeIn(200);
    }else if(data.response == "ok"){

        $(".errorMessages").hide();
        $(".errorMessages").html("");

        $(".successMessage").html(data.message);
        $(".successMessage").fadeIn(200);
        setInterval(function(){
            $("#addEvent").modal("hide");

            window.location.reload();
        }, 1000);
    }
}

function checkSize(width){
    if(width < 1100){
        $(".image-message").html("Image width must be at least 1100px");
        $(".image-message").css("background-color", "red");

        $(".update-btn").attr("disabled", true);
    }else{
        $(".image-message").html("Drag to reposition Cover");
        $(".image-message").css("background-color", "rgba(0,0,0,0.2)");
        $(".update-btn").attr("disabled", false);
    }
}

function circleSuccess(data){
    if(data.response == "ok"){
        window.location.reload();
    }
}

function postFormProcess(data, a, b, c){
    var t = c[0];

    $(".event-post-form input[type=text]").val("");

    if(data.response == "ok"){
        if(data.type == "store"){
            window.location.reload();
        }else if(data.type == "update"){
            var post = $("#"+data.id);
            var txt = post.find(".event-body-edit").val();

            post.find(".event-body-original").html("<p>" + txt + "</p>");

            post.find(".event-body-new").hide();
            post.find(".event-body-original").fadeIn(100);
        }
    }
}

function commentFormProcess(data, a, b, c){
    var t = c[0];
    if(data.response == "ok"){
        if(data.type == "store"){
            $(".list-comments").append(data.view);

            $(".comment-edit-form").ajaxFormUnbind();

            $(".comment-edit-form").ajaxForm({
                success: commentFormProcess
            });

            $(".comment-input").val("");
        }else if(data.type == "update"){
            var comment = $("#"+data.id);
            var txt = comment.find(".comment-edit-input").val();

            comment.find(".comment-text div").html(txt);

            comment.find(".comment-edit-form").hide();
            comment.find(".comment-text").fadeIn(100);
        }
    }
}

function highlightUser(){
    ids = $(".selected-users").val().split(",");

    $(ids).each(function(key, value){
        value = $.trim(value);

        $(".singleInviteUser").each(function(){
            var temp = $(this);
            if(!temp.hasClass("selected") && temp.attr("data-id") == value){
                temp.addClass("selected");
            }
        });
    });

    var num1 = $(".singleInviteUser").length;
    var num2 = $(".singleInviteUser.selected").length;

    if(num1 == num2){
        $(".singleInviteUser").removeClass("selected").addClass("selected");
        $(".select-circle-btn").removeClass("btn-primary").addClass("btn-danger selected").html(Lang.get("front.deselectAll"));
    }
}


$(document).ready(function(){
    $(".showMap").click(function(){
        $('#us3').locationpicker('autosize');
        $(".event-map").fadeIn(200);
    });

    $(".eventClose").click(function(){
        $(".errorMessages").fadeOut(300);
        $(".errorMessages").html("");
    });

    $(".event-post-form").ajaxForm({
        success: function(){
            $(".event-post-form input[type=text]").val("");
            window.location.reload();
        }
    });

    $(".event-update-form").ajaxForm({
        success: postFormProcess
    });

    $(".comment-form").ajaxForm({
        success: commentFormProcess
    });

    $(".event-post-edit").click(function(){
        $(this).closest(".white-box").find(".event-body-original").hide();

        $(this).closest(".white-box").find(".event-body-edit").val($.trim($(this).closest(".white-box").find(".event-body-original").text()));

        $(this).closest(".white-box").find(".event-body-new").fadeIn(200);
    });

    $(".comment-input").focus(function(){
        $(this).closest(".postBottom").find(".comment-buttons").fadeIn(200);
    });

    $(".comment-cancel").click(function(){
        $(this).closest(".postBottom").find(".comment-buttons").fadeOut(100);
        $(".comment-input").val("");
    });

    $(".comment-input").keyup(function(){
        if($(this).val().length > 0){
            $(".comment-submit").attr("disabled", false);
        }else{
            $(".comment-submit").attr("disabled", true);
        }
    });

    $(".comment-edit-input").keyup(function(){
        if($(this).val().length > 0){
            $(".comment-update").attr("disabled", false);
        }else{
            $(".comment-update").attr("disabled", true);
        }
    });

    $(".post-input").focus(function(){
        $(this).parent().removeClass("col-xs-7").addClass("col-xs-10");
        $(this).closest(".white-box").find(".comment-buttons").fadeIn(200);
        $(".upload-image").hide();
    });

    $(".post-cancel").click(function(){
        $(this).parent().parent().removeClass("col-xs-10").addClass("col-xs-7");
        $(this).closest(".white-box").find(".comment-buttons").fadeOut(100);
        $(".post-input").val("");
        $(".upload-image").show();

        $(".image-path").val("");
        $(".event-image-holder div").html("");
    });

    $(".post-input").keyup(function(){
        if($(this).val().length > 0){
            $(".post-submit").attr("disabled", false);
            $(".post-update").attr("disabled", false);
        }else{
            if($(".image-path").val().length == 0){
                $(".post-submit").attr("disabled", true);
                $(".post-update").attr("disabled", true);
            }
        }
    });

    $(".post-update-cancel").click(function(){
        $(".event-body-new").hide();

        $(".event-body-original").fadeIn(100);
    });

    $(".edit-event-trigger").click(function(){
        $("#editEvent").modal("show");

    });

    $(".new-circle-form").ajaxForm({
        success: circleSuccess,
        clearForm: true
    });

    $(".circle").click(function(){
        var url = $(this).attr("data-url");


        $(".list-profiles").hide();

        if(!$(this).hasClass("active")){
            $.get(url, null, function(data){
                $(".list-profiles").html(data.view);
                $(".list-profiles").fadeIn(300);
            }, "json");
        }else{
            window.location.reload();
        }

        $(".circle").removeClass("active");
        $(this).addClass("active");
    });

    $(document).on("click", ".exit-user", function(){
        var url = $(this).attr("data-url");
        var t = $(this);
        var circle = $("#circle_id").val();
        $.post(url, null, function(data){
            t.closest(".single-profile").fadeOut(200);

            $("#" + circle).find("label").html(data.count);
        });
    });

    $(document).on("click", ".comment-delete", function(){
        var url = $(this).attr("data-url");
        var t = $(this);

        $.post(url, null, function(data){
            if(data.response == "ok"){
                t.closest(".singleComment").fadeOut(100);
                t.closest(".singleComment").next().fadeOut(100);
                setTimeout(function(){
                    t.closest(".singleComment").remove();
                }, 300);
            }
        }, "json");
    });

    $(document).on("click", ".comment-edit", function(){

        console.log($.trim($(this).closest(".singleComment").find(".comment-text").text()));

        $(this).closest(".singleComment").find(".comment-text").hide();

        $(this).closest(".singleComment").find(".comment-edit-form .comment-edit-input").val($.trim($(this).closest(".singleComment").find(".comment-text").text()));

        $(this).closest(".singleComment").find(".comment-edit-form").fadeIn(100);
    });

    $(document).on("click", ".comment-edit-cancel", function(e){
        e.stopPropagation();
        $(this).closest(".singleComment").find(".comment-edit-form").hide();

        $(this).closest(".singleComment").find(".comment-text").fadeIn(100);
    });

    $(".comment-edit-form").ajaxForm({
        success: commentFormProcess
    });

    $(".invite-users-button").click(function(){
        $(".selected-users").val("");
        var url = $(this).attr("data-url");
        $.post(url, null, function(data){
            if(data.response == "ok"){
                $("#inviteUsers .modal-body").html(data.view);
            }
        }, "json");

        $("#inviteUsers").modal("show");
    });

    $(document).on("click", ".singleCircle", function(){

        var id = $(this).attr("data-id");
        $(".inviteUsersList").fadeOut(100);

        var url = $(".selected-number").attr("data-url");

        $.post(url, {"circle" : id}, function(data){
            if(data.response == "ok"){
                list = data.view;
            }
        }, "json");

        setTimeout(function(){
            $(".inviteUsersList").html(list);
            highlightUser();

            $(".inviteUsersList").fadeIn(100);
        }, 100);

        $(".singleCircle").removeClass("active");
        $(this).addClass("active");


    });



    $(document).on("click", ".singleInviteUser", function(){
        var t = $(this);

        if(t.hasClass("selected-filter")){
            t.parent().fadeOut(100, function(){
                $(this).remove();
            });
        }

        var removeItem = null;
        if(t.hasClass("selected")){
            removeItem = t.attr("data-id");
        }

        t.toggleClass("selected");

        var temp = "";
        $(".singleInviteUser").each(function(){
            if($(this).hasClass("selected")){
                var id = $(this).attr("data-id");
                temp = temp + (!temp ? '' : ',') + id;
            }
        });

        if(selected_items.length == 0){
            selected_items = temp;
        }else{
            selected_items = selected_items + "," + temp;
        }

        selected_items = selected_items.split(",");

        var unique = selected_items.filter(function(itm,i,a){
            return $.trim(i) == $.trim(a.indexOf(itm));
        });

        unique = jQuery.grep(unique, function(value) {
            return $.trim(value) != removeItem;
        });

        unique = $.grep(unique,function(n){ return($.trim(n)) });

        selected_items = unique;

        $(".selected-users").val(selected_items);

        if(selected_items.length > 0){
            $(".selected-number span").html(selected_items.length);
            $(".selected-number").fadeIn(200);
        }else{
            $(".selected-number").fadeOut(100);
        }

        if(selected_filter_checker){
            if($(".selected-filter").length-1 == 0){
                var url = $(".invite-users-button").attr("data-url");
                $.post(url, null, function(data){
                    if(data.response == "ok"){
                        $("#inviteUsers .modal-body").html(data.view);
                        highlightUser();
                    }
                }, "json");
            }
        }

        var num1 = $(".singleInviteUser").length;
        var num2 = $(".singleInviteUser.selected").length;

        if(num1 == num2){
            $(".singleInviteUser").removeClass("selected").addClass("selected");
            $(".select-circle-btn").removeClass("btn-primary").addClass("btn-danger selected").html(Lang.get("front.deselectAll"));
        }
    });

    $(document).on("click", ".select-circle-btn", function(){

        var t = $(this);

        if(t.hasClass("selected-filter")){
            t.parent().fadeOut(100, function(){
                $(this).remove();
            });
        }

        var removeItem = new Array();
        if(t.hasClass("selected")){
            $.each($(".singleInviteUser.selected"), function(key, value){
                var data_id = $(this).attr("data-id");
                removeItem.push(data_id);
            });
        }

        if($(this).hasClass("selected")){
            $(".singleInviteUser").removeClass("selected");
            $(".select-circle-btn").removeClass("btn-danger selected").addClass("btn-primary").html(Lang.get("front.selectAll"));
        }else{
            $(".singleInviteUser").removeClass("selected").addClass("selected");
            $(".select-circle-btn").removeClass("btn-primary").addClass("btn-danger selected").html(Lang.get("front.deselectAll"));
        }

        var temp = "";
        $(".singleInviteUser").each(function(){
            if($(this).hasClass("selected")){
                var id = $(this).attr("data-id");
                temp = temp + (!temp ? '' : ',') + id;
            }
        });

        if(selected_items.length == 0){
            selected_items = temp;
        }else{
            selected_items = selected_items + "," + temp;
        }

        selected_items = selected_items.split(",");

        var unique = selected_items.filter(function(itm,i,a){
            return $.trim(i) == $.trim(a.indexOf(itm));
        });

        if(removeItem.length > 0){
            unique = $(unique).not(removeItem).get();
        }

        unique = $.grep(unique,function(n){ return($.trim(n)) });

        selected_items = unique;

        $(".selected-users").val(selected_items);

        if(selected_items.length > 0){
            $(".selected-number span").html(selected_items.length);
            $(".selected-number").fadeIn(200);
        }else{
            $(".selected-number").fadeOut(100);
        }

        if(selected_filter_checker){
            if($(".selected-filter").length-1 == 0){
                var url = $(".invite-users-button").attr("data-url");
                $.post(url, null, function(data){
                    if(data.response == "ok"){
                        $("#inviteUsers .modal-body").html(data.view);
                        highlightUser();
                    }
                }, "json");
            }
        }


    });

    $(document).on("click", ".selected-number", function(){

        selected_filter_checker = true;

        $(".inviteUsersList").fadeOut(100);

        var list = "";
        var ids = $(".selected-users").val();

        var url = $(this).attr("data-url");

        $.post(url, {"ids" : ids}, function(data){
            if(data.response == "ok"){
                list = data.view;
            }
        }, "json");

        setTimeout(function(){
            $(".inviteUsersList").html(list);
            $(".singleInviteUser").removeClass("selected").removeClass("selected-filter").addClass("selected").addClass("selected-filter");
            $(".inviteUsersList").fadeIn(100);
        }, 100);
    });

    var current_circle = null;

    $(document).on("keyup", ".event_search_input", function(){
        var url = $(".searchUrl").attr("data-url");
        var circle = $(".singleCircle.active").attr("data-id");
        if(circle){
            current_circle = circle;
        }

        var txt = $(this).val();

        if(txt.length > 2){

            $(".select-circle-btn").attr("disabled", true);
            $(".singleCircle").removeClass("active");

            setTimeout(function(){
                $.post(url, {"search" : txt}, function(data){
                    if(data.response == "ok"){
                        $(".usersGrid").html(data.view);
                        highlightUser();
                    }
                }, "json");
            }, 300);
        }else if(txt.length == 0){

            $(".select-circle-btn").attr("disabled", false);
            $(".singleCircle[data-id='" + current_circle + "']").addClass("active");

            setTimeout(function(){
                $.post(url, {"search" : "::all::", "circle" : current_circle}, function(data){
                    if(data.response == "ok"){
                        $(".usersGrid").html(data.view);
                        highlightUser();
                    }
                }, "json");
            }, 300);
        }
    });

    $(document).on("click", ".circle-edit", function(e){
        e.stopPropagation();
        var url = $(this).attr("data-href");

        $.get(url, null, function(data){
            if(data.response == "ok"){
                $(".editCircleContent").html(data.view);
                $("#editCircle").modal("show");
            }
        }, "json");
    });

    $("#emailChangeButton").click(function(){
        var email = $("#settingsCurrentEmail").html();
        $("#newEmail").val(email);
        $("#settingsCurrentEmail").hide();
        $(this).hide();

        $("#newEmail").fadeIn(100);
        $("#settingsMailSubmit").fadeIn(100);
    });

    $(".settingsForm").submit(function(){
        return false;
    });

    $("#settingsMailSubmit").click(function(){
        var t = $(this);
        $.ajax({
            type: "POST",
            url: $(".settingsForm").attr("action"),
            data: {"email" : $("#newEmail").val()},
            beforeSend: function(){
                $("#settingsMailSubmit").val(Lang.get("front.saving"));
            },
            success: function(data){
                if(data.response == 'ok' && data.changed){
                    $("#settingsEmailMessage").text(Lang.get("front.confirmationEmailSent") + " " + $("#newEmail").val());
                    $("#settingsCurrentEmail").fadeIn(200);
                    $("#emailChangeButton").fadeIn(200);
                    $("#settingsMailSubmit").hide();
                    $("#newEmail").hide();

                    $("#settingsEmailMessage").fadeIn(200);
                }else if(data.response == "ok" && !data.changed){
                    $("#settingsEmailMessage").text("");
                    $("#settingsCurrentEmail").fadeIn(200);
                    $("#emailChangeButton").fadeIn(200);
                    $("#settingsMailSubmit").hide();
                    $("#newEmail").hide();
                }else{
                    $("#settingsEmailMessage").text(data);
                    $("#settingsEmailMessage").fadeIn(200);
                    $("#settingsMailSubmit").val(Lang.get("front.save"));
                }
            }
        });
    });

    $(".notif-dropdown").click(function(){
        var t = $(this);
        var url = t.attr("data-url");

        $.post(url, null, function(data){
            if(data.response == "ok"){
                t.find(".badge-label").fadeOut(200).remove();
            }
        }, "json");
    });

    jQuery.each(jQuery('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;

        var resizeTextarea = function(el) {
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
    });

    $(".event-title").keyup(function(){
        $(".text-length").html(80 - $(".event-title").val().length);
    });

    $(".event-description").readmore({
        moreLink: "<a>"+Lang.get("front.readMore")+"</a>",
        lessLink: "<a>"+Lang.get("front.readLess")+"</a>",
        collapsedHeight: 150
    });

    $(".comment-text").readmore({
        moreLink: "<a>"+Lang.get("front.readMore")+"</a>",
        lessLink: "<a>"+Lang.get("front.readLess")+"</a>",
        collapsedHeight: 150
    });

    $(".post-body").readmore({
        moreLink: "<a>"+Lang.get("front.readMore")+"</a>",
        lessLink: "<a>"+Lang.get("front.readLess")+"</a>",
        collapsedHeight: 150
    });

    $(".about").readmore({
        moreLink: "<a>"+Lang.get("front.readMore")+"</a>",
        lessLink: "<a>"+Lang.get("front.readLess")+"</a>",
        collapsedHeight: 50
    });

    $(".clear-account").click(function(){
        $(".has-cookie").hide();
        $(".no-cookie").html("\
            <img class='profile-img' src='/img/nouser.png'>\
            <input type='text' name='username' class='form-control' placeholder='"+Lang.get('front.username')+"'>\
        ");

        $(".rememberBox").fadeIn(200);

        var url = $(this).attr("data-url");
        $(this).fadeOut(200).remove();

        $.post(url);
    });

    $(".repositionTrigger").click(function(){
        var img = $(".user-info-background").css('background-image').replace('url(','').replace(')','').replace(/['"]+/g, '');
        var position = $(".user-info-background").css("background-position").split(" ")[1];
        $(".reposition-cover").attr("src", img);
        $(".reposition-cover").css("top", position);
        $(".cover-wrap").fadeIn(200);

        $(".user-info-background").hide();

        $(".reposition-cover").draggable({
            scroll: false,
            axis: "y",
            drag: function (event, ui) {
                y1 = $('.cover-wrap').height();
                y2 = $('.reposition-cover').height();

                if (ui.position.top >= 0) {
                    ui.position.top = 0;
                }
                else
                    if (ui.position.top <= (y1-y2)) {
                        ui.position.top = y1-y2;
                    }
                },

                stop: function(event, ui) {
                    $('.cover-position').val(ui.position.top);
                    //checkSize($(".coverImage").get(0).naturalWidth);
                }
        });

        $(".updatePositionCancel").css("display", "inline-block");
    });


});