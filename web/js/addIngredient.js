var $collectionHolder;
var $addTagButton = $('<div class="col mt-10 s2 offset-s5 l2 offset-l5 xl2 offset-xl5"><a class="btn-floating btn-large waves-effect waves-light deep-orange hoverable"><i class="material-icons">add</i></a></div>');
var $newLinkLi = $('<li></li>').append($addTagButton);

var etapes;
var $addEtapesButton = $('<div class="col s2 offset-s5 l2 offset-l5 xl2 offset-xl5"><a class="btn-floating btn-large waves-effect waves-light deep-orange hoverable"><i class="material-icons">add</i></a></div>');
var $newLinkLiEtapes = $('<li></li>').append($addEtapesButton);

// setup an "add a tag" link

$(document).ready(function() {

    /* ======= Partie ajout d'ingrédient ============ */
    // Get the ul that holds the collection of tags
    var $collectionHolder = $('ul.tags');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        e.preventDefault();
        addTagForm($collectionHolder, $newLinkLi);
    });

    /* ======== Partie ajout d'etapes ================== */

    // Get the ul that holds the collection of tags
    var etapes = $('ul.etapes');

    // add the "add a tag" anchor and li to the tags ul
    etapes.append($newLinkLiEtapes);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    etapes.data('index', etapes.find(':input').length);

    $addEtapesButton.on('click', function(e) {
        // add a new tag form (see next code block)
        e.preventDefault();
        addTagForm(etapes, $newLinkLiEtapes);
    });

    /* =========== Fonction ajout du bouton "ajouter" au formulaire ========== */
    function addTagForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        //console.log($collectionHolder);
        var prototype = $collectionHolder.data('prototype');

        //console
        // get the new index
        var index = $collectionHolder.data('index');

        var newForm = prototype;
        // You need this only if you didn't set 'label' => false in your tags field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, 'Ingredient n° '+ index);

        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1 );

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<li class="collection-item"></li>').append(newForm);
        $newLinkLi.before($newFormLi);

        // add a delete link to the new form
        addTagFormDeleteLink($newFormLi);
        $('select').formSelect();
    }


    /* ======== Fonction ajout du bouton delete au formulaire ================ */
    function addTagFormDeleteLink($tagFormLi) {
        var $removeFormButton = $('<div class="row"><div class="col s2 offset-s8 m2 offset-m7 l2 offset-l9"><a class="btn-floating btn-large waves-effect waves-light red hoverable"><i class="material-icons">clear</i></a></div></div>');
        $tagFormLi.prepend($removeFormButton);

        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            e.preventDefault();
            $tagFormLi.remove();
        });

    }

    $('#btnOpen').on('click', function(e) {
        $('.image-upload').click();
    });
    let $val = $('.image-uload').val();

    $('.image-uload').on('change', function(e) {
        console.log($val);
    })

    // function openImageInput(firstBtn, secondBtn) {
    //
    // }

});
