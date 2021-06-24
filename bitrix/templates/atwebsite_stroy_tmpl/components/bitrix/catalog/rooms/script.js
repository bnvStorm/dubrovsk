$(function(){
    $('body').on("change", "[name=UF_STATUS]", function(){
        $("#UF_STATUS").trigger("click");
    });
});