//Global Variables
let loggedUser;
let provider;

$("#nav-bar").mouseover(function() {
    //alert("Estoy entrando al evento mouseover");
    $("#nav-bar").toggleClass("showMenu").delay(1000);
    // change icon
    $("#header-toggle").toggleClass("bx-x").delay(1000);
    // add padding to body
    $("#body-pd").toggleClass("body-pd").delay(1000);
    // add padding to header
    $("#header").toggleClass("body-pd").delay(1000);
});

$("#nav-bar").mouseout(function() {
    //alert("Estoy entrando al evento mouseover");
    $("#nav-bar").toggleClass("showMenu").delay(1000);
    // change icon
    $("#header-toggle").toggleClass("bx-x").delay(1000);
    // add padding to body
    $("#body-pd").toggleClass("body-pd").delay(1000);
    // add padding to header
    $("#header").toggleClass("body-pd").delay(1000);
});

// login USER
function loginUser() {
    // get values
    var mail = $("#correo").val();
    var password = $("#pass").val();

    let inf =
        `<div class="alert alert-success" id="login-info" role="alert">
                Registro con el correo: ` +
        mail +
        ` exitoso </div>`;
    $.ajax({
        type: "post",
        url: "loginUser.php",
        //contentType: "application/json; charset=utf-8",
        global: true,
        data: { mail: mail, password: password },
        success: function(response) {
            loggedUser = true;
            console.log(response);

            //var json = JSON.parse(data);

            let result = JSON.parse(response);
            console.log(result.mail);
            console.log(
                "si trae o no trae: " + (result.mail === undefined ? true : false)
            );

            let err = "Invalid username or password.";
            let contain = "Invalid";

            if (result.mail === undefined) {
                $("#validation")
                    .empty()
                    .append("Usuario o Contraseña no válido")
                    .css("color", "red");

                $("#loginModal").find("form").trigger("reset");

                $("#loginModal").on("hidden.bs.modal", function() {
                    $("#validation").empty();
                    $(this).find("form").trigger("reset");
                });

                //alert("Usuario o contraseña no válido");
            } else {
                $("#loginModal").modal("hide");

                const result = JSON.parse(response);

                var url = "/foro/User/index.php";
                $(location).attr("href", url);

                // window.location.href =
                //     "http://localhost/Foro/User/index.php?success=true";

                $(inf).insertBefore(".container");
            }
        },
        error: function() {
            console.log("error");
        },
    });
}

$(document).bind("ajaxSuccess", function() {
    $(document).on("load", function() {
        $("#login-info").fadeOut(10000);
    });
});

function renderAlertLogin(inf) {
    let a = inf;
    alert(a);
}

// register USER
function registerUser() {
    // get values
    var username = $("#usernames").val();
    var mail = $("#email").val();
    var password = $("#password").val();
    var confirm_password = $("#conpassword").val();

    // agregar registros
    $.post(
        "registerUser.php", {
            username: username,
            mail: mail,
            password: password,
            confirm_password: confirm_password,
        },
        function(data) {
            let res = data.response;
            console.log(data.response);

            //TODO: Si contiene This e-mail is already taken.
            if (res.includes("taken")) {
                $("#registerModal").modal("hide");

                var inf =
                    `<div class="alert alert-danger" id="login-info" role="alert">
            Este correo: ` +
                    mail +
                    ` ya se encuentra Registrado
                 </div>`;

                $(inf).insertBefore(".container").fadeOut(12000);

                $("#usernames").val("");
                $("#email").val("");
                $("#password").val("");
                $("#conpassword").val("");
            } else {
                // close the popup
                $("#registerModal").modal("hide");

                var inf =
                    `<div class="alert alert-success" id="login-info" role="alert">
                Registro con el correo: ` +
                    mail +
                    ` exitoso 
                     </div>`;

                $(inf).insertBefore(".container").fadeOut(7000);
                //alert("Data: " + data + "\nStatus: " + status);

                // alert("Usuario:" + mail + "registrado con exito");

                // borrar campos
                $("#usernames").val("");
                $("#email").val("");
                $("#password").val("");
                $("#conpassword").val("");
            }
        },
        "json"
    );
}

$.get(
    "http://localhost/Foro/App/Auth/callback.php?provider=Google",
    function(data, textStatus, jqXHR) {
        console.log("Lo que llega de registerSocial".data.response);
    },
    "json"
);

function buscar(buscar) {
    var parametros = { buscar: buscar };
    $.ajax({
        type: "GET",
        url: "../buscador.php",
        data: parametros,
        success: function(data) {
            // $(data).insertBefore("#datos_buscador");

            document.getElementById("datos_buscador").innerHTML = data;
            // $("#buscar").on("focusout", function() {
            //     location.reload();
            // });
        },
    });
}

function strangeBuscar(buscar) {
    var parametros = { buscar: buscar };
    $.ajax({
        type: "GET",
        url: "buscador.php",
        data: parametros,
        success: function(data) {
            // $(data).insertBefore("#datos_buscador");
            document.getElementById("datos_buscador").innerHTML = data;

            // $("#buscar").on("focusout", function() {
            //     location.reload();
            // });
        },
    });
}

$("#loginAlert").click(function() {
    $("#registerModal").modal("show");
});

// Document is ready
$(document).ready(function() {
    // Validate Username
    $("#usercheck").hide();
    let usernameError = true;
    $("#usernames").keyup(function() {
        validateUsername();
    });

    // function validateTituloTema(){
    //     let titulotema = $("#tituloTema").val();
    //     if(titulotema.length == ""){

    //     }
    // }

    $("#describeTema").keyup(function() {
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
            $("#charNum").text("Ha llegado usted al límite máximo.");
        } else {
            var char = max - len;
            $("#charNum").text(char + " caracteres restantes");
        }
    });

    function validateUsername() {
        let usernameValue = $("#usernames").val();
        if (usernameValue.length == "") {
            $("#usercheck").show();
            usernameError = false;
            return false;
        } else if (usernameValue.length < 3 || usernameValue.length > 10) {
            $("#usercheck").show();
            $("#usercheck").html("longitud de usuario debe estar entre 3 y 20");
            usernameError = false;
            return false;
        } else {
            $("#usercheck").hide();
            usernameError = true;
            return true;
        }
    }

    // Validate Email

    $("#email").blur(function(e) {
        e.preventDefault();
        let regex = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
        let s = email.value;
        if (regex.test(s)) {
            email.classList.remove("is-invalid");
            emailError = true;
        } else {
            email.classList.add("is-invalid");
            emailError = false;
        }
    });

    // Validate Password
    $("#passcheck").hide();
    let passwordError = true;
    $("#password").keyup(function() {
        validatePassword();
    });

    function validatePassword() {
        let passwordValue = $("#password").val();
        if (passwordValue.length == "") {
            $("#passcheck").show();
            passwordError = false;
            return false;
        }
        if (passwordValue.length < 3 || passwordValue.length > 10) {
            $("#passcheck").show();
            $("#passcheck").html("*longitud de contraseña debe estar entre 3 y 10");
            $("#passcheck").css("color", "red");
            passwordError = false;
            return false;
        } else {
            $("#passcheck").hide();
            passwordError = true;
            return true;
        }
    }

    // Validate Confirm Password
    function validateConfirmPassword() {
        let confirmPasswordValue = $("#conpassword").val();
        let passwordValue = $("#password").val();
        if (passwordValue != confirmPasswordValue) {
            $("#conpasscheck").show();
            $("#conpasscheck").html("*Contraseña no coincide");
            $("#conpasscheck").css("color", "red");
            confirmPasswordError = false;
            return false;
        } else {
            $("#conpasscheck").hide();
            confirmPasswordError = true;
            return true;
        }
    }
    $("#conpasscheck").hide();
    let confirmPasswordError = true;
    $("#conpassword").keyup(function() {
        validateConfirmPassword();
    });

    // Submit button
    $("#submitbtn").click(function() {
        validateUsername();
        validatePassword();
        validateConfirmPassword();
        // validateEmail();
        if (
            usernameError == true &&
            passwordError == true &&
            confirmPasswordError == true
        ) {
            registerUser();
            return true;
        } else {
            alert("no registra");
            return false;
        }
    });
});

// $("#likeTema").click(function() {
//     $("#likeTema").toggleClass("bxs-like");
// });

// $("#unlikeTema").click(function() {
//     $("#unlikeTema").toggleClass("bxs-like");
// });

// $("#logModal").click(function() {
//     $("#loginModal").modal("show");
//     setTimeout(function() {
//         createRecaptcha();
//     }, 100);
// });

function createRecaptcha() {
    grecaptcha.render("captcha", {
        sitekey: "6LfZh9UeAAAAAGoCYH8PZoqKbYpo6lKDLqhWPDei",
        theme: "light",
    });
}

$(".provider").each(function(index, element) {
    // element == this
    $(element).attr("id", "provider" + index);
});

$("#validateImage").delay(5000).fadeOut();

$(function() {
    $("#correo").blur(function(e) {
        e.preventDefault();
        let regex = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
        let s = this.value;
        if (regex.test(s)) {
            this.classList.remove("is-invalid");
        } else {
            this.classList.add("is-invalid");
        }
    });

    $("#passcheckLogin").hide();

    $("#loginModal").on("shown.bs.modal", function() {
        $("#pass").keyup(function(e) {
            e.preventDefault();
            $("#passcheckLogin").hide();
            let passwordValue = this.value;
            if (passwordValue.length == "") {
                $("#passcheckLogin").show();
            }
            if (passwordValue.length < 3 || passwordValue.length > 10) {
                $("#passcheckLogin").show();
                $("#passcheckLogin").html(
                    "*longitud de contraseña debe estar entre 3 y 10"
                );
                $("#passcheckLogin").css("color", "red");
            } else {
                $("#passcheckLogin").hide();
            }
        });
    });
});

$(window).on("load", function() {
    let searchParams = new URLSearchParams(window.location.search);
    searchParams.has("logged"); // true
    let param = searchParams.get("logged");
    if (param == "false") {
        console.log("Ingresa a la validación por false");
        $("#validateModal").modal("show");
    } else {
        let template1 = `<a href="#" class="nav_logo" data-bs-toggle="modal" data-bs-target="#loginModal" id="logModal"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">Iniciar Sesion</span> </a>`;
        $("#imageProfile").replaceWith(template1);
        $("#renderImage").remove();
        // <a href="#" class="nav_link active" data-bs-toggle="modal" data-bs-target="#registerModal"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Registrarse</span> </a>
        // <a href="#" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
    }
});

$(window).on("load", function() {
    let searchParams = new URLSearchParams(window.location.search);
    searchParams.has("success"); // true
    let param = searchParams.get("success");
    if (param == true) {
        let inf = `<div class="alert alert-success" id="login-info" role="alert">
                        Registro con el correo: `
        ` exitoso </div>`;
        $(inf).insertBefore(".container").fadeOut(7000);
    }
});

$.get("/Foro/User/index.php", "provider=", function(data, textStatus, jqXHR) {
    const urlParams = new URLSearchParams(window.location.search);
    const param = urlParams.get("provider");
    provider = param;
});

function showModalLogin() {
    window.location.href = "index.php?login";
}

function showRegisterModal() {
    window.location.href = "index.php?register";
}

$(document).ready(function() {
    var location = document.location.href;
    console.log(location.href);
    if (location == "http://localhost/Foro/index.php?login") {
        $("#loginModal").modal("show");
    } else if (location == "http://localhost/Foro/index.php?register") {
        $("#registerModal").modal("show");
    }
    if(getCountNotifications > 0){
        $('#notification_count').text(getCountNotifications);
    }else{
        $('#notification_count').hide();
    }
});

function logoutSocial(provider) {
    console.log('la variale provider: ' + provider);
    let location = "http://localhost/Foro/App/Auth/callback.php";
    window.location.href = location + "?logout=" + provider;
}

$('#notification_count').click(function (e) { 
    e.preventDefault();
    $("#notification_count").fadeOut("slow");
});

$('.bx bx-grid-alt nav_icon').click(function (e) { 
    e.preventDefault();
    $("#notification_count").fadeOut("slow");
});

$('#notification').click(function (e) { 
    e.preventDefault();
    $("#notification_count").fadeOut("slow");
});

$('#collapseNotificacion').on('hidden.bs.collapse', function () {
    $('#notification_count').text(getCountNotifications);
  })



// $("#login-info").fadeIn(7000, function() {
//     $("#login-info").fadeOut(7000);
// });

// $(window).on("beforeunload", function() {
//     let searchParams = new URLSearchParams(window.location.search);
//     searchParams.has("success"); // true
//     let param = searchParams.get("success");
//     if (param == true) {
//         let inf =
//             `<div class="alert alert-success" id="login-info" role="alert">
//                         Registro con el correo: ` +
//             mail +
//             ` exitoso </div>`;
//         $(inf).insertBefore(".container").fadeOut(7000);
//     }
//     //your code goes here on location change
// });

// $(document).on("ajaxComplete", function() {
//     let inf =
//         `<div class="alert alert-success" id="login-info" role="alert">
//                         Registro con el correo: ` +
//         mail +
//         ` exitoso </div>`;
//     $(inf).insertBefore(".container").fadeOut(7000);
// });