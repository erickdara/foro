/* document.addEventListener("DOMContentLoaded", function(event) {
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);

        // Validate that all variables exist
        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener("click", () => {
                // show navbar
                nav.classList.toggle("showMenu");
                // change icon
                toggle.classList.toggle("bx-x");
                // add padding to body
                bodypd.classList.toggle("body-pd");
                // add padding to header
                headerpd.classList.toggle("body-pd");
            });
        }
    }; */

/*     showNavbar("header-toggle", "nav-bar", "body-pd", "header");

    /*===== LINK ACTIVE =====*/
/* const linkColor = document.querySelectorAll(".nav_link");

    function colorLink() {
        if (linkColor) {
            linkColor.forEach((l) => l.classList.remove("active"));
            this.classList.add("active");
        }
    }
    linkColor.forEach((l) => l.addEventListener("click", colorLink));

    // Your code to run since DOM is loaded and ready
}); */

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
            // close the popup
            $("#registerModal").modal("hide");

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
            $('#buscar').on("focusout", function () {
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
$(document).ready(function () {
	
    // Validate Username
        $('#usercheck').hide();
        let usernameError = true;
        $('#usernames').keyup(function () {
            validateUsername();
        });
        
        function validateUsername() {
        let usernameValue = $('#usernames').val();
        if (usernameValue.length == '') {
        $('#usercheck').show();
            usernameError = false;
            return false;
        }
        else if((usernameValue.length < 3)||
                (usernameValue.length > 10)) {
            $('#usercheck').show();
            $('#usercheck').html
    ("**length of username must be between 3 and 10");
            usernameError = false;
            return false;
        }
        else {
            $('#usercheck').hide();
        }
        }
    
    // Validate Email
       
        $('#email').blur(function (e) { 
            e.preventDefault();
            let regex =
        /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
        let s = email.value;
        if(regex.test(s)){
            email.classList.remove(
                    'is-invalid');
            emailError = true;
            }
            else{
                email.classList.add(
                    'is-invalid');
                emailError = false;
            }
        });
        

        
        
    // Validate Password
        $('#passcheck').hide();
        let passwordError = true;
        $('#password').keyup(function () {
            validatePassword();
        });

        function validatePassword() {
            let passwordValue =
                $('#password').val();
            if (passwordValue.length == '') {
                $('#passcheck').show();
                passwordError = false;
                return false;
            }
            if ((passwordValue.length < 3)||
                (passwordValue.length > 10)) {
                $('#passcheck').show();
                $('#passcheck').html
    ("**length of your password must be between 3 and 10");
                $('#passcheck').css("color", "red");
                passwordError = false;
                return false;
            } else {
                $('#passcheck').hide();
            }
        }
            
    // Validate Confirm Password
    function validateConfirmPassword() {
        let confirmPasswordValue =
            $('#conpassword').val();
        let passwordValue =
            $('#password').val();
        if (passwordValue != confirmPasswordValue) {
            $('#conpasscheck').show();
            $('#conpasscheck').html(
                "**Password didn't Match");
            $('#conpasscheck').css(
                "color", "red");
            confirmPasswordError = false;
            return false;
        } else {
            $('#conpasscheck').hide();
        }
    }
        $('#conpasscheck').hide();
        let confirmPasswordError = true;
        $('#conpassword').keyup(function () {
            validateConfirmPassword();
        });

        
    // Submit button
        $('#submitbtn').click(function () {
            validateUsername();
            validatePassword();
            validateConfirmPassword();
            // validateEmail();
            if ((usernameError == true) &&
                (passwordError == true) &&
                (confirmPasswordError == true)) {
                registerUser();
                return true;
            } else {
                return false;
            }
        });
    });

    