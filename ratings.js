$(document).ready(function(){

    //De each function voert de code per instantie van .starrating uit
    $(".starrating").each(function() {

        var starGroup = $(this);
        var productId = starGroup.data("product-id");
        var userId = starGroup.data("user-id");
        var url = "http://localhost/educom-webshop-oop-1698314754/index.php?page=ajax&action=averageRatingByProduct&productId=" + productId;
        
        $.ajax({
            url: url,
            method: "GET",
            success: function(data) {
                console.log(data);
                var response = JSON.parse(data);
                var rating = response.rating;
                
                starGroup.children('.star').each( (index, elem) => {
                    if ((index + 1) <= rating)  {                    
                        $(elem).addClass('red');
                    }
                })
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        })

        //Enkel wanneer een user is ingelogd is het mogelijk om een rating te geven
        if ($.trim(userId) !== "") {
            $(".star").click( function() {
                    const value = $(this).attr('data-value');
                    console.log('Value: ${ value }');

                    $(".star").removeClass('red');

                    //$('.star') returnt een array van de sterren
                    $('.star').each( (index, elem) => {
                        const itemValue = $(elem).attr('data-value');
                        if (itemValue <= value)  {
                            $(elem).addClass('red');
                        }
                    })
            })
        }
    })

    function storeRating(value) {
        $.ajax({
            url: "http://localhost/educom-webshop-oop-1698314754/index.php",
            method: "POST",
            data: {
                page: "ajax",
                action: "storeRating",
                rating: value
            },
            succes: function(response) {
                console.log("Success:", response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        })
    }
});