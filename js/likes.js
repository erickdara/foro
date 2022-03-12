$(document).ready(function () {
    $(".likeTema").on("click", function(){
        var idTema = $(this).attr("id");
        idTema = idTema.replace(/\D/g,'');
        var vote_type = $(this).data("vote-type");
        $.ajax({
            type: "GET",
            url: "../likesTema.php",
            data: {idTema:idTema, vote_type:vote_type},
            dataType: "json",
            success: function (responseT) {
                $("#likeCount_"+responseT.idTema).html("  "+responseT.likes);
                $("#unlikeCount_"+responseT.idTema).html("  "+responseT.unlikes);  
                $('.bx-like').addClass('.colorLike');
                $('.bx-dislike').addClass('.colorUnlike');

                // if(responseT.likes != 0 || responseT.unlikes != 0){
                //     var estiloLike = {"background-color":'rgba(0, 253, 93, 0.159)'};
                //     var estiloUnlike = {"background-color":'rgba(255, 22, 22, 0.152)'};
                //     $('.bx-like').css(estiloLike);
                //     $('.bx-dislike').css(estiloUnlike);
                // }
            }
        });
    });
    $(".likeComentario").on("click", function(){
        var idComentario = $(this).attr("id");
        idComentario = idComentario.replace(/\D/g,'');
        var vote_type = $(this).data("vote-type");
        $.ajax({
            type: "GET",
            url: "../likesComentario.php",
            data: {idComentario:idComentario, vote_type:vote_type},
            dataType: "json",
            success: function (responseC) {
                $("#likeCount_"+responseC.idComentario).html("  "+responseC.likes);
                $("#unlikeCount_"+responseC.idComentario).html("  "+responseC.unlikes);
            }
        });
    });
    $(".likeComment").on("click", function(){
        var idComentario = $(this).attr("id");
        idComentario = idComentario.replace(/\D/g,'');
        var vote_type = $(this).data("vote-type");
        $.ajax({
            type: "GET",
            url: "./likesComentario.php",
            data: {idComentario:idComentario, vote_type:vote_type},
            dataType: "json",
            success: function (responseC) {
                $("#likeCount_"+responseC.idComentario).html("  "+responseC.likes);
                $("#unlikeCount_"+responseC.idComentario).html("  "+responseC.unlikes);
            }
        });
    });
});
