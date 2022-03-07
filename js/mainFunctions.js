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
}

// register USER
function registerUser() {
    // get values
    var username = $("#username").val();
    var mail = $("#mail").val();
    var password = $("#password").val();
    var confirm_password = $("#confirm_password").val();

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
            $("#modalRegisterForm").modal("hide");

            alert("Data: " + data + "\nStatus: " + status);

            // alert("Usuario:" + mail + "registrado con exito");

            // borrar campos
            $("#username").val("");
            $("#mail").val("");
            $("#password").val("");
            $("#confirm_password").val("");
        }
    );
}

// FB.getLoginStatus(function(response) {
//     statusChangeCallback(response);
// });

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}