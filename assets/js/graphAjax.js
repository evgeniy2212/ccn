

var period = 3;
var currentTemperature = <?php echo $currentThemperature; ?>;
var maximum = 0;
var minimum = 0;
var average = 0;
function checkPeriod(){
    period = document.getElementById('period').value;
//        alert(period);
}

var json = (function () {
    var json = null;
    $.ajax({
        async: false,
        global: false,
        url: '/test/<?php echo $info['hub_id'] ?>/<?php echo $info['position'] ?>',
        type: 'POST',
        dataType: "json",
        data: {period: period},
        success: function (data) {
            json = data;
            currentTemperature = data[data.length-1].temperature;
        }
    });

    if(currentTemperature > 0){
        document.getElementById('current').className = 'fa fa-thermometer-full fa-5x pull-right plusThemperature';
    }else{
        document.getElementById('current').className = 'fa fa-thermometer-empty fa-5x pull-right minusThemperature';
    }

    document.getElementById('current').innerHTML = currentTemperature;

    return json;
})
();

var graph = Morris.Line({
    element: 'themperaturechart',
    data: json,
    xkey: 'event_time',
    ykeys: ['temperature'],
    labels: ['Value'],
    resize: true,
    smooth: true,
    pointFillColors: ['#33adff', 'red'],
    pointStrokeColors: ['white', 'blue'],
    lineColors: ['#80bfff'],
    xLabels: ['minute'],
<?php if(isset($info['setpoint_max']) or isset($info['setpoint_min'])) { ?>
    goals: [<?php if(isset($info['setpoint_max'])){ echo $info['setpoint_max'];}; ?>,
<?php if(isset($info['setpoint_min'])){ echo $info['setpoint_min'];}; ?>],
<?php } ?>
goalStrokeWidth: ['1'],
    goalLineColors: ['red'],
    fillOpacity: 0.4,
    parseTime: false,
    hideHover: true
});

function update() {
    $.ajax({
        url: '/test/<?php echo $info['hub_id'] ?>/<?php echo $info['position'] ?>',
        type: 'POST',
        dataType: 'json',
        data: {period: period},
        async: true,
        success: function (data) {
            json = data;
            currentTemperature = data[data.length-1].temperature;
        }
    });

    $.ajax({
        url: '/getStats/<?php echo $info['hub_id'] ?>/<?php echo $info['position'] ?>',
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function (data) {
            json = data;
            maximum = data[0];
            minimum = data[1];
            average = data[2];
        }
    });


    if(currentTemperature > 0){
        document.getElementById('current').className = 'fa fa-thermometer-full fa-5x pull-right plusThemperature';
    }else{
        document.getElementById('current').className = 'fa fa-thermometer-empty fa-5x pull-right minusThemperature';
    }

    document.getElementById('current').innerHTML = currentTemperature;
//    document.getElementById('average').innerHTML = average;
//    document.getElementById('maximum').innerHTML = maximum;
//    document.getElementById('minimum').innerHTML = minimum;


    graph.setData(json);
}
setInterval(update, 1500);
