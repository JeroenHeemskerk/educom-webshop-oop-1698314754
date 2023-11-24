$(document).ready(function(){
    const starGroup = $(".starrating");
    var productId = starGroup.data("product-id");
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
});