$(document).ready(function () {
    $(".likeTema").on("click", function(){
        var idTema = $(this).attr("id");
        idTema = idTema.replace(/\D/g,'');
        var vote_type = $(this).data("vote-type");
        $.ajax({
            type: "GET",
            url: "../likes.php",
            data: {idTema:idTema, vote_type:vote_type},
            dataType: "json",
            success: function (response) {
                $("#likeCount_"+response.idTema).html("  "+response.likes);
                $("#unlikeCount_"+response.idTema).html("  "+response.unlikes);  
            }
        });
    });
});
