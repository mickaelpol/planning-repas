var collectionRecette;

jQuery(document).ready(function() {

    let locale = localStorage.getItem('language');

    var dateObj = new Date();
    var actualMonth = dateObj.getMonth();
    var year = dateObj.getUTCFullYear();
    let jour;
    let mois;

    switch (locale) {
        case 'fr': jour = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        break;
        case 'en': jour = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        break;
    }

    switch (locale) {
        case 'fr': mois = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Semptembre', 'Octobre', 'Novembre', 'Decembre'];
        break;
        case 'en': mois = ['January', 'February', 'March', 'April', 'May', 'June', 'Juily', 'August', 'September', 'October', 'November', 'December'];
        break;
    }

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
        var dDay = jour[day];
        var content = daysInMonth(nbr, year);
        let description;
        switch (locale) {
            case 'fr': description = `Le début du mois de ${mois[value]} ${year} commence un ${dDay} et contient ${content} Jours`
            break
            case 'en': description = `The beginning of ${mois[value]} ${year} starts on a ${dDay} and contains ${content} days`
            break
        }

        $('#contains').html(description)
        $('#form-blind').val(mois[value]);
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

    let popup;
    switch (locale) {
        case 'fr': popup = 'Le maximum de repas à été ajouté'
            break
        case 'en': popup = 'Maximum meal has been added'
    }

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
                        html: `<div>${popup}</div>`,
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
                        html: `<div>${popup}</div>`,
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
            let numberDay;
            switch (locale) {
                case 'fr': numberDay = 'Jour';
                break;
                case 'en': numberDay = 'Day';
                break;
            }
            var $newFormLi = $('<div class="col s12 m4 l3 mb-15 z-depth-3 card-calendar"></div>').append(newForm).prepend(`<div class="center-align mt-30 mb-30">${numberDay} ${i}</div>`);
            form.append($newFormLi)
        }

            // $newLinkLi.before($newFormLi);

            // add a delete link to the new form
            // addTagFormDeleteLink($newFormLi);

        $('select').formSelect();

    }

    /* ======== Fonction ajout du bouton delete au formulaire ================ */
    function addTagFormDeleteLink($tagFormLi) {
        var $removeFormButton = $('<div class="col s2 offset-s9 l2 offset-l9"><a class="ml-30 mt-5 btn-floating btn-small waves-effect waves-light red clear"><i class="material-icons">clear</i></a></div>');
        $tagFormLi.prepend($removeFormButton);

        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            e.preventDefault();
            $tagFormLi.remove();
        });

    }

    let mealsAndMonth;
    let errorMonth;
    let meals;

    switch (locale) {
        case 'fr': mealsAndMonth = 'Un mois et un repas minimum doit être renseigné';
        break
        case 'en': mealsAndMonth = 'One month and a minimum meal must be completed';
        break
    }
    switch (locale) {
        case 'fr': errorMonth = 'Le mois du planning doit être renseigné';
        break
        case 'en': errorMonth = 'The month of the planning must be completed';
        break
    }
    switch (locale) {
        case 'fr': meals = 'Un repas minimum doit être ajouté';
        break
        case 'en': meals = 'A minimum meal must be added';
        break
    }

    $('#btn-submit').on('click', function(e) {

        var plannings = $('.card-calendar').length;
        var title = $('#appbundle_mois_nom').val();

        if (title === "" && plannings === 0) {
            e.preventDefault();
            $('#appbundle_mois_nom').addClass('invalid');
                M.toast({
                    html: `<div>${mealsAndMonth}</div>`,
                    classes: 'rounded red'
                });
        } else if (title === "") {
            e.preventDefault();
            $('#appbundle_mois_nom').addClass('invalid');
            M.toast({
                html: `<div>${errorMonth}</div>`,
                classes: 'rounded red'
            });
        } else if (plannings === 0 && title !== "") {
            e.preventDefault();
            $('#appbundle_mois_nom').removeClass('invalid');
            $('#appbundle_mois_nom').addClass('valid');
            M.toast({
                html: `<div>${meals}</div>`,
                classes: 'rounded red'
            });
        }
    });

});