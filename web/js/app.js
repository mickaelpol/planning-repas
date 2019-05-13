
    // fonction permettant de changer le type d'un input de type "password"
    // Avec en paramètres le bouton qui permet de changer le type et en second l'input ou les input à modifiers
    // peut prendre plusieurs input
    function showPassword(button, inputPassword){
        button.on('click', function(e) {
            e.preventDefault();
            for (let i = 0; i < inputPassword.length; i++) {
                if (inputPassword[i].type === 'password') {
                    inputPassword[i].setAttribute('type', 'text');
                } else {
                    inputPassword[i].setAttribute('type', 'password');
                }
            }
        });
    }

$(document).ready(function(){

    let locale = $('#language').data('locale');

    Turbolinks.start();
    Turbolinks.clearCache();

    localStorage.setItem('language', locale);

    var msg = $('#message');
    var message = $("#message").attr("data-message");
    var content = `<div class="mt-30 ">\
                      <div class="col s12 m12 l6 offset-l6 xl4 offset-xl8">\
                            <div id="flashMessage" class="green z-depth-4 pulse">\
                                <div class="white-text center-align">\
                                    <strong class="center-align">\
                                        ${message}\
                                    </strong>\
                                </div>\
                            </div>\
                        </div>\
                    </div>`;

    if (msg) {
        msg.html(content).hide().velocity("slideDown", { duration: 500 }).velocity("slideUp", { delay: 4000, duration: 500 });
    }


    $('.sidenav-trigger').on('click', function(e) {
        e.preventDefault();
        $('.sidenav').sidenav();
        $('.collapsible').collapsible();
    });

    $('.materialboxed').materialbox();

    $('.tap-target').tapTarget();

    if (window.innerWidth < 769) {
        $('#menu').click(() => {
           $('.tap-target').tapTarget('open');
        });
    } else {
        $('#menu').mouseover(() => {
            $('.tap-target').tapTarget('open');
        });

        $('.tapmenu').mouseleave(() => {
            $('.tap-target').tapTarget('close');
        });
    }
});
