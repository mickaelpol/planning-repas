$(document).ready(function(){

    // Id de l'endroit ou les data seront ecrite dans le modal
    const data = $('#data');
    // Id de l'endroit ou sera écrit le titre du modal
    const title = $('#title');
    // Url ou sera dirigé la requête Ajax
    const url = '/actual_course';

    $('.fixed-action-btn').floatingActionButton({
        toolbarEnabled: true,
    });
    $('.tooltipped').tooltip();
    $('.modal').modal();

    // Fonction permettant de vider le contenu du modal à sa fermeture
    function onModalClose()
    {
        title.empty();
        data.empty();
    }

    // Listenner du bouton pour ouvrir le modal
    $('#Btnmodal').click(function(e){
        e.preventDefault();
        $('#modal1').modal('open', {
            onCloseEnd: onModalClose()
        });
        // Requête Ajax au clic sur le bouton de liste des course
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'JSON',
            success: function(result, statut){
                let tab = result.title;
                let info;
                for (let i = 0; i < tab.length; i++){
                    info = tab[i];
                    title.html(tab[0]);
                    data.append(`<div>${info}</div><br>`);
                }
            },
            error: function(result, statut, erreur) {
                title.html(statut).css('color', 'red');
                data.html(erreur).css('color', 'red');
                data.append('<br><div>Si vous voyez cette erreur contactez le développeur</div>');
            },
            complete: function(result, statut){}

        });
    });

})