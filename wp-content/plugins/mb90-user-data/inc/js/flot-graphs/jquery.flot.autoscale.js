/**
 * Flot plugin for adding additional auto scalling modes.
 *
 * @author Joel Oughton
 */
(function ($) {
    function init(plot) {

        plot.autoScale = function (min) {
            var opts = plot.getYAxes()[0].options;
            var data = plot.getData();
            var max = 0;
            //alert(min);

            $.each(data, function (index, s) {
                max = Math.max(max, autoScale(plot, s, s.data, s.datapoints));
            });
            //alert("max2=[" + s.datapoints + "]");

            opts.min = min;
            opts.max = max;

            //plot.setupGrid();
            //plot.draw();

            return {
                min: opts.min,
                max: opts.max
            };
        }

        function autoScale(plot, series, data, datapoints) {
            var _max = Number.NEGATIVE_INFINITY;
            var options = plot.getOptions();

            // limit to visible series
            if (series.lines.show || series.points.show) {
            //if (series.lines.show) {
            //if (series.points.show) {
                var max = Number.NEGATIVE_INFINITY;
                var str = "";
                for (var i = 0; i < data.length; i++) {
                    max = Math.max(max, data[i][1]);
                    str += "---" + data[i][1];
                }

                //alert("yvals=[" + str + "]");
                //max += max * options.yaxis.autoscaleMargin * 10; 
                //return Math.max(_max, max);
                return max;
            } else {
                return 0;
            }
        }
    }

    $.plot.plugins.push({
        init: init,
        name: "autoscalemode",
        version: "0.5"
    });
})(jQuery);