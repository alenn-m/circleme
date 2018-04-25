$(document).ready(function(){
    $(".use_text_button").click(function(){
        $(".use_text_field").val(true);
        $(".site-logo").fadeOut(100).remove();

        $(this).parent().parent().next().remove();
        $(this).parent().parent().remove();
    });

});