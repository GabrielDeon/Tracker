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

    //FECHAMENTO DE CADASTROS   
    $(document).keydown(function (e) {
        if (e.keyCode === 27) { // Código da tecla "ESC"
            $("#cadInvestment, #cadType, #cadTag").fadeOut();
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

    // Fechar a janela de pop-up ao clicar fora dela (no fundo escuro)
    $(document).mouseup(function (e) {
        var cadInvestment = $("#cadInvestment");
        if (!cadInvestment.is(e.target) && cadInvestment.has(e.target).length === 0) {
            cadInvestment.fadeOut();
        }
        var cadType = $("#cadType");
        if (!cadType.is(e.target) && cadType.has(e.target).length === 0) {
            cadType.fadeOut();
        }
        var cadTag = $("#cadTag");
        if (!cadTag.is(e.target) && cadTag.has(e.target).length === 0) {
            cadTag.fadeOut();
        }
    });
});
