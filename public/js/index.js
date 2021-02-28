

jQuery(function(){




    let $contactButton = $('#contactButton')
    $contactButton.click(function(e){
        e.preventDefault()
        $('#contactForm').slideDown();
        $contactButton.slideUp();
    })


});
