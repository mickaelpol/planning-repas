$(document).ready(function(){

    $('.logo a').click(function(e){
       e.preventDefault();
        let route = $(this).attr('href');
        // Requête Ajax permettant de récupérer le contenu de la page en fonction du bouton du menu cliqué
        $.ajax({
            url: route,
            cache: false,
            success: function(html) {
                // console.log(html);
                afficher(html);
            },
            error: function(XMLHttpRequest, textStatuts, errorThrown) {
                // alert(textStatuts);
            }
        });
    });

    $('#slide-out a').click(function(e) {
        e.preventDefault()
        let route = $(this).attr('href');
        console.log(route)
        // Requête Ajax permettant de récupérer le contenu de la page en fonction du bouton du menu cliqué
        $.ajax({
            url: route,
            cache: false,
            success: function(html) {
                // console.log(html);
                afficher(html);
            },
            error: function(XMLHttpRequest, textStatuts, errorThrown) {
                // alert(textStatuts);
            }
        });
    });
});

function afficher(data) {
    $('#page-content').fadeOut(500, function(){
        $('#page-content').empty();
        $('#page-content').append(data);
        $('#page-content').fadeIn(1000);
    });
}