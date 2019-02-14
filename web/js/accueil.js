$(document).ready(function () {

    // Bouton du premier modal
    const btnModal1 = $('#BtnModalActualMonth');
    // Bouton du second modal
    const btnModal2 = $('#BtnModalNextMonth');

    // Id de l'endroit ou les data seront ecrite dans le modal
    const data = $('#data');
    const data2 = $('#data2');
    // Id de l'endroit ou sera écrit le titre du modal
    const title = $('#title');
    const title2 = $('#title2');
    // Titre du PDF
    let titrePdf = '';
    let titre = '';

    // Url ou sera dirigé la requête Ajax
    const url = btnModal1.attr('href');
    // Url ou sera dirigé la requête Ajax
    const url2 = btnModal2.attr('href');
    // Bouton de download
    const dlBtn = $('#downloadBtn');
    const dlBtn2 = $('#downloadBtnNext');
    // tableau de la liste des ingrédients
    let tabIng = [];
    let tabIng2 = [];


    // Fonction prorpre à materialize
    $('.fixed-action-btn').floatingActionButton({
        toolbarEnabled: true,
    });
    $('.tooltipped').tooltip();
    $('.modal').modal();


    // Fonction permettant de vider le contenu du modal à sa fermeture
    function onModalClose1() {
        titre = '';
        tabIng = [];
        data.empty();
    }
    // Fonction permettant de vider le contenu du modal mois prochain à sa fermeture
    function onModalClose2() {
        titre = '';
        tabIng2 = [];
        data2.empty();
    }

    // Function de gestion de la requete ajax
    function reqAjax(modal, fonction, url, idTitre, idPara, tableau)
    {
        modal.modal('open', {
           onCloseEnd: fonction
        });
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'JSON',
            success: function(result, statut) {
                let tab = result.liste;
                titrePdf = result.titre;
                titre = `Liste des courses de ${titrePdf}`;
                for (let i = 0; i < tab.length; i++) {
                    let info = tab[i];
                    let ingredient = info.ingredient;
                    let quantite = info.quantite;
                    let unite = info.unite;

                    // Conversion des Centilitres en Litres
                    if (unite === 'Cl') {
                        if (quantite >= 100) {
                            let result = (quantite * 1) / 100;
                            quantite = `${result} L`
                        }
                    }
                    // conversion des gramme en Kg
                    if (unite === 'Gr') {
                        if (quantite >= 1000) {
                            quantite = (quantite * 1) / 1000 + ' Kg';
                        } else {
                            quantite = `${quantite} Gr`;
                        }
                    }
                    // // Affichage des info sur le modal
                    tableau.push(`${ingredient}: ${quantite}`);
                    idTitre.html(titre);
                    idPara.append(
                        `<div>
                            ${ingredient}: ${quantite}
                         </div>`);
                }
            },
            error: function(result, statut, erreur) {
                idTitre.html(statut).css('color', 'red');
                idPara.html(erreur).css('color', 'red');
                idPara.html(erreur).css('text-align', 'center');
                idPara.append('<br>' +
                    '<div>' +
                        'Si vous voyez cette erreur contactez le développeur' +
                        '<br><a href="mailto:mickael.devweb@gmail.com">à cette adresse </a>' +
                    '</div>');
            },
            complete: function() {

            }
        })

    }

    // Fonction permettant de telecharger en pdf la liste des courses du mois selectionné
    function downloadPDF(title, tab)
    {
        const doc = new jsPDF();
        doc.setFontSize(20);
        doc.text(titre, 80, 10, {
            align: 'center',
            charSpace: 1.5
        });
        doc.setFontSize(12);
        doc.text(tab, 10, 30, {
            charSpace: 1.5
        })
        doc.save(`${titrePdf}.pdf`);
    }


    // Listenner du bouton pour ouvrir le modal 1
    btnModal1.click(e => {
        e.preventDefault();
        reqAjax($('#modal1'), onModalClose1(), url, title, data, tabIng);
    });

    // Listenner du bouton pour ouvrir le modal 2
    btnModal2.click(e => {
       e.preventDefault();
        reqAjax($('#modal2'), onModalClose2(), url2, title2, data2, tabIng2);
    });

    // Bouton pour download le pdf du modal 1
    dlBtn.click(e => {
        e.preventDefault();
        downloadPDF(titre, tabIng);
    })

    // Bouton pour download le pdf du modal 2
    dlBtn2.click(e => {
        e.preventDefault();
        downloadPDF(titre, tabIng2);
    })

})