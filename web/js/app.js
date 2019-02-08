$(document).ready(function(){

    var msg = $('#message');
    var message = $("#message").attr("data-message");
    var content = `<div class="mt-30 ">\
                      <div class="col l4 offset-l8">\
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

    $('.sidenav').sidenav();

});