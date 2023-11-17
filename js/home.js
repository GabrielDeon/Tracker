$(document).ready(function () {
    //ABERTURA DE CADASTROS
    $("#openCadInvestment").click(function () {
        $("#cadInvestment").fadeIn();
    });
    $("#openCadType").click(function () {
        $("#cadType").fadeIn();
    });
    $("#openCadTag").click(function () {
        $("#cadTag").fadeIn();
    });

    $("#openCadMov").click(function () {
        $("#cadMov").fadeIn();
    });

    $("#openDel").click(function () {
        $("#cadDel").fadeIn();
    });

    //FECHAMENTO DE CADASTROS   
    $(document).keydown(function (e) {
        if (e.keyCode === 27) { // Código da tecla "ESC"
            $("#cadInvestment, #cadType, #cadTag, #cadMov").fadeOut();
        }
    });    

    $("#closeCadInvestment").click(function () {
        $("#cadInvestment").fadeOut();
    });
    $("#closeCadType").click(function () {
        $("#cadType").fadeOut();
    });
    $("#closeCadTag").click(function () {
        $("#cadTag").fadeOut();
    });
    $("#closeCadMov").click(function () {
        $("#cadMov").fadeOut();
    });     

    $("#closeCadDel").click(function () {
        $("#cadDel").fadeIn();
    });
    
});
