var collectionRecette;

jQuery(document).ready(function() {

    var dateObj = new Date();
    var actualMonth = dateObj.getMonth();
    var year = dateObj.getUTCFullYear();
    var weeks = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    var months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Semptembre', 'Octobre', 'Novembre', 'Decembre'];

    if (actualMonth === 11) {
        year = dateObj.getUTCFullYear() + 1;
    }

    var days;
    var s = $('#select');
    var emplacement = $('#form');

    // Retourne le nombre de jour dans le mois
    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    collectionRecette = $('div.recettes');
    collectionRecette.data('index', collectionRecette.find(':input').length);

    s.on('change', function(e){
        var div = emplacement.find('div.card-calendar');
        div.remove();
        e.preventDefault();
        addRecetteForm(collectionRecette, emplacement);
        var value = $('#select').val()-1;
        var nbr = $('#select').val();
        var day = new Date(year + "-"+ nbr + "-01").getDay();
        var dDay = weeks[day];
        var content = daysInMonth(nbr, year);

        $('#contains').html(`Le début du mois de ${months[value]} ${year} commence un ${dDay} et contient ${content} Jours`)
        $('#form-blind').val(months[value]);
        $('#form-blind-days').val(content);
        $('#form-blind-number').val(value);
        $('#form-blind-years').val(year);

    })

    $('select').formSelect();

    if ($('.clear')) {
        $('.clear').click(function(){
            var parent = $(this).parent();
            var grandParent = parent.parent();
            grandParent.remove();
        })
    }


    // add the "add a tag" anchor and li to the tags ul
    // collectionRecette.append($newLinkLiRecette);
    var max = $('.planning-titre').data('max');

    if ($('.erreur').children().length > 0) {
        var length = $('.card-calendar').length;
        if (length === max) {
            $('.button-add').hide();
        }

        $(this).click(function(e) {

            var btn = e.target.classList;

            if (btn[0] === 'material-icons' || btn[0] === 'btn-floating') {
                length = $('.card-calendar').length;
                if (length === max) {
                    $('.button-add').hide()
                    M.toast({
                        html: '<div>Le maximum de repas à été ajouté</div>',
                        classes: 'rounded red'
                    });
                } else if (length < max) {
                    $('.button-add').show();
                }
            }
        });

    }

    if ($('.erreur').children().length === 0) {
        // Compte le nombre d'encadré représentant un repas
        var length = $('.card-calendar').length;

        // S'ils on en compte un nombre égal à la variable max on cache le bouton ajouter
        if (length === max) {
            $('.button-add').hide();
        }
        $(this).click(function(e) {

            var btn = e.target.classList;

            if (btn[0] === 'material-icons' || btn[0] === 'btn-floating') {
                length = $('.card-calendar').length;
                if (length === max) {
                    $('.button-add').hide()
                    M.toast({
                        html: '<div>Le maximum de repas à été ajouté</div>',
                        classes: 'rounded red'
                    });
                } else if (length < max) {
                    $('.button-add').show();
                }
            }
        });

    }





    function addRecetteForm($collectionHolder, form) {
        // emplacement.remove();
        var jours = daysInMonth(s.val(), year);
        for (var i = 1; i <= jours; i++) {
            // Get the data-prototype explained earlier
            // Display the form in the page in an li, before the "Add a tag" link li
            var prototype = $collectionHolder.data('prototype');

            // get the new index
            var index = $collectionHolder.data('index');

            var newForm = prototype;
            // You need this only if you didn't set 'label' => false in your tags field in TaskType
            // Replace '__name__label__' in the prototype's HTML to
            // instead be a number based on how many items we have
            // newForm = newForm.replace(/__name__label__/g, index);

            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            newForm = newForm.replace(/__name__/g, index);
            // increase the index with one for the next item
            $collectionHolder.data('index', index + 1);
            var $newFormLi = $('<div class="col l3 mb-15 z-depth-3 card-calendar"></div>').append(newForm);
            form.append($newFormLi)
        }

            // $newLinkLi.before($newFormLi);

            // add a delete link to the new form
            // addTagFormDeleteLink($newFormLi);

        $('select').formSelect();

    }

    /* ======== Fonction ajout du bouton delete au formulaire ================ */
    function addTagFormDeleteLink($tagFormLi) {
        var $removeFormButton = $('<div class="col l2 offset-l9"><a class="ml-30 mt-5 btn-floating btn-small waves-effect waves-light red clear"><i class="material-icons">clear</i></a></div>');
        $tagFormLi.prepend($removeFormButton);

        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            e.preventDefault();
            $tagFormLi.remove();
        });

    }

    $('#btn-submit').on('click', function(e) {

        var plannings = $('.card-calendar').length;
        var title = $('#appbundle_mois_nom').val();

        if (title === "" && plannings === 0) {
            e.preventDefault();
            $('#appbundle_mois_nom').addClass('invalid');
                M.toast({
                    html: '<div>Un mois et un repas minimum doit être renseigné</div>',
                    classes: 'rounded red'
                });
        } else if (title === "") {
            e.preventDefault();
            $('#appbundle_mois_nom').addClass('invalid');
            M.toast({
                html: '<div>Le mois du planning doit être renseigné</div>',
                classes: 'rounded red'
            });
        } else if (plannings === 0 && title !== "") {
            e.preventDefault();
            $('#appbundle_mois_nom').removeClass('invalid');
            $('#appbundle_mois_nom').addClass('valid');
            M.toast({
                html: '<div>Un repas minimum doit être ajouté</div>',
                classes: 'rounded red'
            });
        }
    });

});

// $(document).ready(function(){
//     $('select').formSelect();
//
//     $('#select').on('change', function(e){
//         // addRecetteForm(collectionRecette, $newLinkLiRecette);
//         $('#test').empty();
//         for (var i = 1; i <= 21; i++) {
//             $('#test').append('<div class="col l3 mb-15 z-depth-3 card-calendar">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus adipisci atque dolor ea enim esse est fuga iure, maxime molestias nobis obcaecati, optio placeat possimus quibusdam rem similique unde voluptates?</div>');
//         }
//         $('#test').append($('#select').val())
//     })
//
// })