$(document).ready(function(){

    showRating();
    setRating();

    function showRating() {
        //De each function voert de code per instantie van .starrating uit
        $(".starrating").each(function() {

            var starGroup = $(this);
            var productId = starGroup.data("product-id");
            var url = "http://localhost/educom-webshop-oop-1698314754/index.php?page=ajax&action=averageRatingByProduct&productId=" + productId;
            
            $.ajax({
                url: url,
                method: "GET",
                success: function(data) {
                    var response = JSON.parse(data);
                    var rating = response.rating;

                    starGroup.children('.star').removeClass('red');
                    
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
        })
    }

    function setRating() {
        //Enkel wanneer een user is ingelogd is het mogelijk om een rating te geven
        $(".star").click(function() {
            var userId = $(this).parent().data("user-id");
            if ($.trim(userId) !== "") {
                var productId = $(this).parent().data("product-id");
                var rating = $(this).attr("data-value");
                storeRating(productId, rating);
                showRating();
            }
        })
    }
    

    function storeRating(productId, rating) {
        $.ajax({
            url: "http://localhost/educom-webshop-oop-1698314754/index.php",
            method: "POST",
            data: {
                page: "ajax",
                action: "setRating",
                productId: productId,
                rating: rating
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        })
    }
});