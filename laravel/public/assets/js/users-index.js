$('.detail').on('click', (e) => {
    const url = $(e.currentTarget).children('a').attr('href');
    console.log(url);
    window.location.href = url;
});