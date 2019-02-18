Turbolinks.start();

document.addEventListener("turbolinks:load", function(){
    Turbolinks.clearCache();
});