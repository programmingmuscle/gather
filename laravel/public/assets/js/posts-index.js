$('.detail').on('click', (e) => {
    const url = $(e.currentTarget).children('a').attr('href');
    console.log(url);
    window.location.href = url;
});

$('.participate-button-full').on('click', (e) => {
    e.stopPropagation();
});