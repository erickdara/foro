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

function modalLogin() {
    var exampleModal = document.getElementById("exampleModal");
    exampleModal.addEventListener("show.bs.modal", function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        var recipient = button.getAttribute("data-bs-whatever");
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalTitle = exampleModal.querySelector(".modal-title");
        var modalBodyInput = exampleModal.querySelector(".modal-body input");

        modalTitle.textContent = "New message to " + recipient;
        modalBodyInput.value = recipient;
    });

    var myAlert = document.getElementById("myAlert");
    var bsAlert = new bootstrap.Alert(myAlert);
}

// register USER
function loginUser() {
    $(document).ready(function() {
        // get values
        var mail = $("#correo").val();
        var password = $("#pass").val();

        $.ajax({
            type: "post",
            url: "loginUser.php",
            data: { mail: mail, password: password },

            success: function(response) {
                $("#loginModal").modal("hide");

                const result = JSON.parse(response);

                var inf =
                    `<div class="alert alert-success" id="login-info" role="alert">
    Registro con el correo: ` +
                    mail +
                    ` exitoso 
         </div>`;
                $(inf).insertBefore(".container").delay(5000).fadeOut();
                window.location.href = "http://localhost/Foro/User/index.php";
            },
        });
    });
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
        function(data, status) {
            console.log("lo que llega de data:  " + data);
            console.log("lo que llega de status:  " + status);
            // close the popup
            $("#registerModal").modal("hide");
            var dato = data;
            var response = "This e-mail is already taken.";
            var compare = response.localeCompare(dato);
            console.log(compare);
            if (compare > 0) {
                var inf =
                    `<div class="alert alert-danger" id="login-info" role="alert">
                El correo: ` +
                    mail +
                    ` ya está registrado en el sistema. 
                 </div>`;

                $(inf).insertBefore(".container").delay(5000).fadeOut();

                $("#usernames").val("");
                $("#email").val("");
                $("#password").val("");
                $("#conpassword").val("");
            } else {
                var inf =
                    `<div class="alert alert-success" id="login-info" role="alert">
            Registro con el correo: ` +
                    mail +
                    ` exitoso 
                 </div>`;

                $(inf).insertBefore(".container").delay(5000).fadeOut();
                //alert("Data: " + data + "\nStatus: " + status);

                // alert("Usuario:" + mail + "registrado con exito");

                // borrar campos
                $("#usernames").val("");
                $("#email").val("");
                $("#password").val("");
                $("#conpassword").val("");
            }
        }
    );
}

function buscar(buscar) {
    var parametros = { buscar: buscar };
    $.ajax({
        type: "GET",
        url: "../buscador.php",
        data: parametros,
        success: function(data) {
            $(data).insertBefore("#datos_buscador");
            $("#buscar").on("focusout", function() {
                location.reload();
            });
            // document.getElementById("datos_buscador").innerHTML = data;
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

    function validateUsername() {
        let usernameValue = $("#usernames").val();
        if (usernameValue.length == "") {
            $("#usercheck").show();
            usernameError = false;
            return false;
        } else if (usernameValue.length < 3 || usernameValue.length > 10) {
            $("#usercheck").show();
            $("#usercheck").html("**length of username must be between 3 and 10");
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
            $("#passcheck").html(
                "**length of your password must be between 3 and 10"
            );
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
            $("#conpasscheck").html("**Password didn't Match");
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

$("#likeTema").click(function() {
    $("#likeTema").toggleClass("bxs-like");
});

$("#unlikeTema").click(function() {
    $("#unlikeTema").toggleClass("bxs-like");
});

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

$('#validateImage').delay(5000).fadeOut();