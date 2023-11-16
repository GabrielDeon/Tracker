$(document).ready(function () {
    // Abrir a janela de pop-up ao clicar no botão
    $("#openPopupButton, #openPopupButton1").click(function () {
        $("#popup").fadeIn();
        $("#popupContainer").addClass("visible");
    });

    // Fechar a janela de pop-up ao clicar no botão de fechar
    $("#closePopupButton").click(function () {
        $("#popup").fadeOut();
        $("#popupContainer").removeClass("visible");
    });

    // Fechar a janela de pop-up ao clicar fora dela (no fundo escuro)
    $(document).mouseup(function (e) {
        var backgound = $("#popup");
        if (!backgound.is(e.target) && backgound.has(e.target).length === 0) {
            backgound.fadeOut();
            $("#popupContainer").removeClass("visible");
        }
    });
});

var formSignin = document.querySelector('#signin')
var formSignup = document.querySelector('#signup')
var btnColor = document.querySelector('.btnColor')

// Adicionando novo código para abrir diretamente um dos formulários
document.querySelector('#openPopupButton').addEventListener('click', () => {
    formSignin.style.left = "25px";
    formSignup.style.left = "450px";
    btnColor.style.left = "0px";
});

document.querySelector('#openPopupButton1').addEventListener('click', () => {
    formSignin.style.left = "-450px";
    formSignup.style.left = "25px";
    btnColor.style.left = "100px";
});

document.querySelector('#btnSignin').addEventListener('click', () => {
    formSignin.style.left = "25px"
    formSignup.style.left = "450px"
    btnColor.style.left = "0px"    
})

document.querySelector('#btnSignup').addEventListener('click', () => {
    formSignin.style.left = "-450px"
    formSignup.style.left = "25px"
    btnColor.style.left = "100px"
})

