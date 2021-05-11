$(() => {
    
    function* range(start: number, end: number, step = 1) {
        let x = start - step;
        while(x < end - step) yield x += step;
    }

    const isOverflowing = ($el: JQuery) => $el.prop('scrollWidth') > $el.width()!;
    const $h1 = $('.jumbotron h1');
    const maxFontSize = parseInt($h1.css('font-size'), 10);

    $(window).on('resize', () => {
        for (const fontSize of range(maxFontSize, 0, -1)) {
            $h1.css('font-size', fontSize + 'px');
            if (!isOverflowing($h1)) {
                break;
            }
        }
    }).trigger('resize');
});