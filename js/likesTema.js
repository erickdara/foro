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


// $(document).ready(function(){
//     $('.likeTema').click(function(){
//         var id = $(this).attr('id');


//         $.ajax({
//             type: 'POST',
//             url:'../likes.php',
//             data:{id:id},
//             dataType: 'json',

//             success:function(data){
//                 var totalLikes = datoLikeTema['likes'];
//                 $("#likeTema_"+id).text(totalLikes);
//             },

//             beforeSend: function(xhr){xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")}
//         });

        
          

//     });
// });
