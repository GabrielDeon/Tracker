$(document).ready(function () {
    // Abrir a janela de pop-up ao clicar no botão
    $("#openPopupButton, #openPopupButton1").click(function () {
        $("#popupContainer").addClass("visible");
    });

    // Fechar a janela de pop-up ao clicar no botão de fechar
    $("#closePopupButton").click(function () {
        $("#popupContainer").removeClass("visible");
    });

    // Fechar a janela de pop-up ao clicar fora dela (no fundo escuro)
    $(document).mouseup(function (e) {
        var popupContainer = $("#popupContainer");
        if (!popupContainer.is(e.target) && popupContainer.has(e.target).length === 0) {
            popupContainer.removeClass("visible");
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
    btnColor.style.left = "110px";
});

document.querySelector('#btnSignin').addEventListener('click', () => {
    formSignin.style.left = "25px"
    formSignup.style.left = "450px"
    btnColor.style.left = "0px"    
})

document.querySelector('#btnSignup').addEventListener('click', () => {
    formSignin.style.left = "-450px"
    formSignup.style.left = "25px"
    btnColor.style.left = "110px"
})

