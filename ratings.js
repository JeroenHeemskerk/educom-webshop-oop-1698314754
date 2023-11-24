$(document).ready(function(){


    $(".star").click( function() {
        const value = $(this).attr('data-value')
        console.log('Value: ${ value }')

        $(".star").removeClass('red');

        //$('.star') returnt een array van de sterren
        $('.star').each( (index, elem) => {
            const itemValue = $(elem).attr('data-value')
            if (itemValue <= value)  {
                $(elem).addClass('red')
            }
        })
    })

    $.ajax({
        //Er wordt nog enkel statisch de rating van productId 1 opgevraagd
        url: "http://localhost/educom-webshop-oop-1698314754/index.php?page=ajax&action=averageRatingByProduct&productId=1",
        method: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);
            
            $('.star').each( (index, elem) => {
                const itemValue = rating
                if (itemValue <= value)  {
                    $(elem).addClass('red')
                }
            })
        },
        error: function(xhr, status, error) {
            console.error('Error:', status, error);
        }

    })
});