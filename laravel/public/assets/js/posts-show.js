$('.accordion-title').on('click', () => {

    if (!$('.accordion-content').is(':visible')) {
        $('.accordion-content').slideDown();
    } else {
        $('.accordion-content').slideUp();
    }
});