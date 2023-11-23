$(document).ready(function(){

hallo();

function hallo() {
    alert("Hij doet het")
}

$(".star").click( function() {
    $(this).addClass("red")
})

});