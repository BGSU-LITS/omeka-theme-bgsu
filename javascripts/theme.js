jQuery(function($) {
    $('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6').each(function() {
        $(this).html(typogr.typogrify($(this)));
    });

    $('.dropdown-menu').click(function(event) {
        event.stopPropagation();
    });

    $(window).load(function() {
        var height = $('#public-nav-main').outerHeight();

        if ($('main').height() < height) {
            $('main').css('min-height', height + 'px');
        }
    });

    var pswp = $('.pswp').get(0);

    if (pswp) {
        var pswp_items = [];
        var pswp_quick = false;

        $('.pictures .picture').each(function() {
            var item = {
                el: this,
                src: $('a', this).attr('href'),
                msrc: $('img', this).attr('src'),
                w: $(this).data('w'),
                h: $(this).data('h')
            };

            if (item.src && item.msrc && item.w && item.h) {
                var pswp_options = {
                    index: pswp_items.length,
                    bgOpacity: 0.7,
                    showHideOpacity: true,

                    getThumbBoundsFn: function(index) {
                        var thumbnail = $('img', pswp_items[index].el);
                        var offset = thumbnail.offset();

                        return {
                            x: offset.left,
                            y: offset.top,
                            w: thumbnail.width()
                        };
                    }
                };

                pswp_items.push(item);

                $('a:has(img)', this).click(function() {
                    var gallery = new PhotoSwipe(
                        pswp, PhotoSwipeUI_Default, pswp_items, pswp_options
                    );

                    gallery.listen('imageLoadComplete', function(index, item) {
                        var w = item.container.lastChild.naturalWidth;
                        var h = item.container.lastChild.naturalHeight;

                        if (item.w !== w || item.h !== h) {
                            item.w = w;
                            item.h = h;
                            gallery.invalidateCurrItems();
                            gallery.updateSize(true);
                        }
                    });

                    var duration = gallery.options.showAnimationDuration;

                    if (pswp_quick) {
                        gallery.options.showAnimationDuration = 0;
                    }

                    gallery.init();
                    gallery.options.showAnimationDuration = duration;

                    return false;
                });
            }
        });

        var matches = window.location.hash.match(/^#&gid=(\d+)&pid=(\d+)$/);

        if (matches) {
            pswp_quick = true;
            $('.pictures .picture').eq(matches[2] - 1).find('a').click();
            pswp_quick = false;
        }
    }

    if (jQuery.isFunction(jQuery.fn.jcarousel)) {
        $('.carousel-display,.featured-carousel-display')
            .jcarousel({wrap: 'both'})
            .jcarouselAutoscroll({interval:5000});
        $('.carousel-control-prev,.featured-carousel-control-prev')
            .jcarouselControl({target: '-=1'});
        $('.carousel-control-next,.featured-carousel-control-next')
            .jcarouselControl({target: '+=1'});
        $('.carousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselPagination({
                perPage: 1,
                item: function(page) {
                    return '<a href="#' + page + '"></a>';
                }
            });
    }
});
