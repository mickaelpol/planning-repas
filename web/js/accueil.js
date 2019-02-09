$(document).ready(function () {

    // Id de l'endroit ou les data seront ecrite dans le modal
    const data = $('#data');
    const data2 = $('#data2');
    // Id de l'endroit ou sera écrit le titre du modal
    const title = $('#title');
    const title2 = $('#title2');
    // Url ou sera dirigé la requête Ajax
    const url = '/actual_course';
    // Url ou sera dirigé la requête Ajax
    const url2 = '/next_course';
    // Bouton de download
    const dlBtn = $('#downloadBtn');
    // tableau de la liste des ingrédients
    let tabIng = [];
    let tabIng2 = [];

    const doc = new jsPDF();
    doc.setFontSize(20);

    // doc.text('Blabla', 40, 250, {
    //     align: 'center',
    // });

    $('.fixed-action-btn').floatingActionButton({
        toolbarEnabled: true,
    });
    $('.tooltipped').tooltip();
    $('.modal').modal();

    // Fonction permettant de vider le contenu du modal à sa fermeture
    function onModalClose() {
        title.empty();
        data.empty();
        title2.empty();
        data2.empty();
    }

    // Listenner du bouton pour ouvrir le modal
    $('#BtnModalActualMonth').click(function (e) {
        e.preventDefault();
        $('#modal1').modal('open', {
            onCloseEnd: onModalClose()
        });
        // Requête Ajax au clic sur le bouton de liste des course
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'JSON',
            success: function (result, statut) {
                let tab = result.liste;
                let ingredient;
                let info;
                let quantite;
                let unite;
                for (let i = 0; i < tab.length; i++) {
                    info = tab[i];
                    ingredient = info.ingredient;
                    quantite = info.quantite;
                    unite = info.unite;

                    // Conversion des Centilitres en Litres
                    if (unite === 'Centilitres') {
                        let result = (quantite * 1) / 100;
                        if (ingredient === 'Eau') {
                            quantite = `${result} Litres d'`;
                        } else {
                            quantite = `${result} Litres de `
                        }

                    }
                    // conversion des gramme en Kg
                    if (unite === 'Gramme') {
                        quantite = (quantite * 1) / 1000 + ' Kg de ';
                    }
                    // Affichage des info sur le modal
                    tabIng.push(`${quantite} ${ingredient}`);
                    title.html(result.titre);
                    data.append(
                        `<div>
                            ${quantite} ${ingredient}
                         </div>`);
                }
                dlBtn.click(e => {
                    e.preventDefault();
                    doc.text(`Liste des courses de ${result.titre}`, 80, 10, {
                        align: 'center',
                        charSpace: 1.5
                    });
                    doc.setFontSize(12);
                    doc.text(tabIng, 10, 30, {
                        charSpace: 1.5
                    })
                    doc.save(`${result.titre}.pdf`);
                })
            },
            error: function (result, statut, erreur) {
                title.html(statut).css('color', 'red');
                data.html(erreur).css('color', 'red');
                data.append('<br><div>Si vous voyez cette erreur contactez le développeur</div>');
            },
            complete: function (result, statut) {
            }

        });
    });

    $('#BtnModalNextMonth').click(e => {
       e.preventDefault();
        $('#modal2').modal('open', {
            onCloseEnd: onModalClose()
        });
        // Requête Ajax pour le prochain mois
        $.ajax({
            url: url2,
            type: 'GET',
            dataType: 'JSON',
            success: function (result, statut) {
                let tab = result.liste;
                let ingredient;
                let info;
                let quantite;
                let unite;
                for (let i = 0; i < tab.length; i++) {
                    info = tab[i];
                    ingredient = info.ingredient;
                    quantite = info.quantite;
                    unite = info.unite;

                    // Conversion des Centilitres en Litres
                    if (unite === 'Centilitres') {
                        let result = (quantite * 1) / 100;
                        if (ingredient === 'Eau') {
                            quantite = `${result} Litres d'`;
                        } else {
                            quantite = `${result} Litres de `
                        }

                    }
                    // conversion des gramme en Kg
                    if (unite === 'Gramme') {
                        quantite = (quantite * 1) / 1000 + ' Kg de ';
                    }
                    // Affichage des info sur le modal
                    tabIng2.push(`${quantite} ${ingredient}`);
                    title2.html(result.titre);
                    data2.append(
                        `<div>
                            ${quantite} ${ingredient}
                         </div>`);
                }
            },
            error: function (result, statut, erreur) {
                title2.html(statut).css('color', 'red');
                data2.html(erreur).css('color', 'red');
                data2.append('<br><div>Si vous voyez cette erreur contactez le développeur</div>');
            },
            complete: function (result, statut) {
            }
        })
    });

})