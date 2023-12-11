$(document).ready(function(){

    getRatings();
    setRating();

    function getRatings() {
        var url = "index.php?request=ajax&action=getRatings";
        $.ajax({
            url: url,
            method: "GET",
            success: function(data) {
                var response = JSON.parse(data);

                $(".starrating").each(function() {
                    var productId = $(this).data("product-id");
                    var productRating = response.find(product => product.productId === productId);

                    if (productRating) {
                        showRatings($(this), parseFloat(productRating.rating));
                    }
                })
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
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
                updateRating($(this).parent());
            }
        })
    }

    function updateRating(starGroup) {
        var productId = starGroup.data("product-id");
        var url = "index.php?request=ajax&action=getRatingByProductId&productId=" + productId;

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
    }    

    function showRatings(starGroup, rating) {
        starGroup.children('.star').removeClass('red');

        starGroup.children('.star').each((index, elem) => {
            if ((index + 1) <= rating) {
                $(elem).addClass('red');
            }
        })
    }

    function storeRating(productId, rating) {
        $.ajax({
            url: "index.php",
            method: "POST",
            data: {
                request: "ajax",
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