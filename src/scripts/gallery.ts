$(() => {
    const pswp = $('.pswp')[0];
    const $galleryItems = $("#gallery-images a");
    const items: PhotoSwipe.Item[] = $galleryItems.map((_i, item) => $(item).data()).get();

    $galleryItems.on('click', (event, item) => {
        event.preventDefault();
        var options = { index: $galleryItems.index(item) };
        new PhotoSwipe(pswp, PhotoSwipeUI_Default, items, options).init();
    });
});