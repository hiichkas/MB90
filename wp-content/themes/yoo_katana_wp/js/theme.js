/* Copyright (C) YOOtheme GmbH, YOOtheme Proprietary Use License (http://www.yootheme.com/license) */

jQuery(function($) {

    var config = $('html').data('config') || {};

    // fix old iOS
    if($.UIkit.support.touch && navigator.userAgent.match(/(ipad|iphone|ipod);.*OS (7|6)_/gi)){

        $.UIkit.$win.bind('resize', (function(){

            // Fix fullscreen slideshow issue on IOS
            var iosVHeight = function() {
                var height = $(window).height();
                $(".tm-slideshow-fullscreen .tm-slideshow-background").css('min-height', height).css('height', 'auto');
                return iosVHeight;
            };

            return iosVHeight();

        })());
    }

    // fullscreen-slideshow if toolbar
    var toolbar = $('.tm-toolbar');

    if (toolbar.length > 0) {
        var margin = $('header').outerHeight() * -1;
        $('.tm-slideshow-background').css('margin-top', margin);
    }

    // Social buttons
    $('article[data-permalink]').socialButtons(config);

    // Custom grid
    $('[data-tm-grid-tile]').each(function(){

        var ele          = $(this),
            columnSize   = ele.attr("data-tm-grid-tile"),
            columnWidth  = columnSize.split('x')[0],
            columnHeight = columnSize.split('x')[1],
            canvas       = $('<canvas></canvas>').attr({'width': columnWidth * 1000, 'height': columnHeight * 1000}),
            placeholder  = $('<img>').attr('src', canvas[0].toDataURL());

            var img = ele.find(' > img, > .uk-overlay > img');

        img.each(function(){

            var src     = ele.find(' > img').attr('src'),
                wrapper = $('<div class="uk-position-cover uk-cover-background"></div>').css({"background-image":"url("+ img.attr('src') + ")"});

            img.hide();
            ele.children().wrapAll(wrapper);

        });

        ele.prepend(placeholder);

    });

    // Chart
    var colorPlaceholder = $('<div></div>').hide().appendTo('body'),
        colors           = ['tm-primary-background','tm-secondary-background','tm-tertiary-background', 'tm-danger-background', 'tm-success-background', 'tm-warning-background'], // classes with background-color
        getChartColor    = function(index) {

            var color;

            if (!colors[index]) {
                index = index % colors.length;
            }

            color = colorPlaceholder.addClass(colors[index]).css('background-color');
            colorPlaceholder.removeClass(colors[index]);

            return color;
        },
        canvas, chartData;

    $('chart').each(function(){

        var chart  = $(this),
            border = chart.closest('.tm-block').css('background-color'),
            type   = chart.attr('type');

        canvas    = $('<canvas></canvas>').attr('width', chart.attr('width')).attr('height', chart.attr('height'));
        chartData = [];

        chart.children().each(function(i){

            var ele = $(this),
                opt = $.UIkit.Utils.options(ele.attr("data-tm-chart")),
                rec = {
                    value     : opt.value || 0,
                    color     : opt.color || getChartColor(i),
                    highlight : opt.highlight || '',
                    label     : opt.label || ''
                };

            chartData.push(rec);

        }).end().after(canvas);

        if(!type) {
            type = 'Doughnut';
        }

        (new Chart(canvas[0].getContext("2d")))[type](chartData, {responsive : true, segmentStrokeColor: border});

        chart.remove();
    });

    // Focus Search
    $('#js-search-toggle').on('click', function(){
        setTimeout(function(){
            $('.tm-search-bar input:first').focus();
        }, 50);
    });

});