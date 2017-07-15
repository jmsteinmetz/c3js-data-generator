// global variables 
var palette = ['#D68198', '#F0953F', '#5E6570', '#D85886', '#BFB5B6'];

// create a chart
// target   = Div to place chart
// type     = type of c3js chart
// data     = url of data "/data/standard/?items=3&values=30&min=100&max=1900&trend=false&shape=stackedbar&names=item1, item2, item3"
function createChart(target, type, data) {

    console.log("Load: " + target + " " + type);

    if (type === 'line' || type === 'bar' || type === 'area' || type === 'pie' || type === 'spline' || type === 'area-spline') {

        $.getJSON(data, function(obj) {

        	//console.log(obj);

            window[target] = c3.generate({
                bindto: target,
                data: {
                    json: obj,
                    type: type
                }
            });
        })
    }

    if (type === 'stackedBar') {

        $.getJSON(data, function(obj) {

            var groups = [];
            var buildSet = [];

            $.each(obj, function(index, value) {
                groups.push(value[0]);
            });

            window[target] = c3.generate({
                bindto: target,
                data: {
                    columns: obj,
                    type: 'bar',
                    groups: [
                        groups
                    ]
                },
                grid: {
                    y: {
                        lines: [{ value: 0 }]
                    }
                },
                color: {
                    pattern: palette
                }
            });

        })


    };
}