$(document).ready(function () {
    $("div[include]").each(function () {                
        $(this).load($(this).attr("include"));
    });
});