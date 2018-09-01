{{--@extends('layouts.app')
@section('content')--}}
<!-- Styles -->
<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }

    #chartdiv1 {
        width: 100%;
        height: 500px;
    }

	#chartmap {
        width: 100%;
        height: 500px;
		margin-bottom: 100px;
    }

</style>

{{--BootstrapCDN--}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>




<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>

<script src="https://www.amcharts.com/lib/3/pie.js"></script>

<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/worldHigh.js"></script>




<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all"/>

{{--BootstrapCDN--}}
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" type="text/css"
      media="all"/>


<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>


<!-- Chart code -->
<script>
	var map = AmCharts.makeChart( "chartmap", {
		"type": "map",
		"theme": "light",
		"dataProvider": {
			"map": "worldHigh",
			"zoomLevel": 3.5,
			"zoomLongitude": 10,
			"zoomLatitude": 52,
			"areas": <?php echo $countries ?>
		},

		"areasSettings": {
			"rollOverOutlineColor": "#FFFFFF",
			"rollOverColor": "#CC0000",
			"alpha": 0.8,
			"unlistedAreasAlpha": 0.1,
			"balloonText": "[[customData]] переходов"
		},


		"legend": {
			"width": "100%",
			"marginRight": 27,
			"marginLeft": 27,
			"equalWidths": false,
			"backgroundAlpha": 0.5,
			"backgroundColor": "#FFFFFF",
			"borderColor": "#ffffff",
			"borderAlpha": 1,
			"top": 450,
			"left": 0,
			"horizontalGap": 10,
			"data": [ {
				"title": "EU member before 2004",
				"color": "#67b7dc"
			}, {
				"title": "Joined at 2004",
				"color": "#ebdb8b"
			}, {
				"title": "Joined at 2007",
				"color": "#83c2ba"
			}, {
				"title": "Joined at 2013",
				"color": "#db8383"
			} ]
		},
		"export": {
			"enabled": true
		}

	} );


	var chart = AmCharts.makeChart("chartdiv", {
		"type": "serial",
		"theme": "light",
		"marginRight": 40,
		"marginLeft": 40,
		"autoMarginOffset": 20,
		"mouseWheelZoomEnabled": true,
		"dataDateFormat": "YYYY-MM-DD",
		"valueAxes": [{
			"id": "v1",
			"axisAlpha": 0,
			"position": "left",
			"ignoreAxisWidth": true
		}],
		"balloon": {
			"borderThickness": 1,
			"shadowAlpha": 0
		},
		"graphs": [{
			"id": "g1",
			"balloon": {
				"drop": true,
				"adjustBorderColor": false,
				"color": "#ffffff"
			},
			"bullet": "round",
			"bulletBorderAlpha": 1,
			"bulletColor": "#FFFFFF",
			"bulletSize": 5,
			"hideBulletsCount": 50,
			"lineThickness": 2,
			"title": "red line",
			"useLineColorForBulletBorder": true,
			"valueField": "value",
			"balloonText": "<span style='font-size:18px;'>[[value]]</span>"
		}],
		"chartScrollbar": {
			"graph": "g1",
			"oppositeAxis": false,
			"offset": 30,
			"scrollbarHeight": 80,
			"backgroundAlpha": 0,
			"selectedBackgroundAlpha": 0.1,
			"selectedBackgroundColor": "#888888",
			"graphFillAlpha": 0,
			"graphLineAlpha": 0.5,
			"selectedGraphFillAlpha": 0,
			"selectedGraphLineAlpha": 1,
			"autoGridCount": true,
			"color": "#AAAAAA"
		},
		"chartCursor": {
			"pan": true,
			"valueLineEnabled": true,
			"valueLineBalloonEnabled": true,
			"cursorAlpha": 1,
			"cursorColor": "#258cbb",
			"limitToGraph": "g1",
			"valueLineAlpha": 0.2,
			"valueZoomable": true
		},
		"valueScrollbar": {
			"oppositeAxis": false,
			"offset": 50,
			"scrollbarHeight": 10
		},
		"categoryField": "date",
		"categoryAxis": {
			"parseDates": true,
			"dashLength": 1,
			"minorGridEnabled": true
		},
		"export": {
			"enabled": true
		},
		"dataProvider": <?php echo $date_values?>
	});


	var chart = AmCharts.makeChart("chartdiv1", {
		"type": "pie",
		"theme": "light",
		"dataProvider": <?php echo $browsers ?>,
		"valueField": "litres",
		"titleField": "country",
		"balloon": {
			"fixedPosition": true
		},
		"export": {
			"enabled": true
		}
	});


	var map = AmCharts.makeChart( "chartmap", {
		"type": "map",
		"theme": "light",
		"dataProvider": {
			"map": "worldHigh",
			"zoomLevel": 3.5,
			"zoomLongitude": 10,
			"zoomLatitude": 52,
			"areas": [ {
				"title": "Austria",
				"id": "AT",
				"color": "#67b7dc",
				"customData": "1995",
				"groupId": "before2004"
			}, {
				"title": "Ireland",
				"id": "IE",
				"color": "#67b7dc",
				"customData": "1973",
				"groupId": "before2004"
			}, {
				"title": "Denmark",
				"id": "DK",
				"color": "#67b7dc",
				"customData": "1973",
				"groupId": "before2004"
			}, {
				"title": "Finland",
				"id": "FI",
				"color": "#67b7dc",
				"customData": "1995",
				"groupId": "before2004"
			}, {
				"title": "Sweden",
				"id": "SE",
				"color": "#67b7dc",
				"customData": "1995",
				"groupId": "before2004"
			}, {
				"title": "Great Britain",
				"id": "GB",
				"color": "#67b7dc",
				"customData": "1973",
				"groupId": "before2004"
			}, {
				"title": "Italy",
				"id": "IT",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "France",
				"id": "FR",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Spain",
				"id": "ES",
				"color": "#67b7dc",
				"customData": "1986",
				"groupId": "before2004"
			}, {
				"title": "Greece",
				"id": "GR",
				"color": "#67b7dc",
				"customData": "1981",
				"groupId": "before2004"
			}, {
				"title": "Germany",
				"id": "DE",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Belgium",
				"id": "BE",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Luxembourg",
				"id": "LU",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Netherlands",
				"id": "NL",
				"color": "#67b7dc",
				"customData": "1957",
				"groupId": "before2004"
			}, {
				"title": "Portugal",
				"id": "PT",
				"color": "#67b7dc",
				"customData": "1986",
				"groupId": "before2004"
			}, {
				"title": "Lithuania",
				"id": "LT",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Latvia",
				"id": "LV",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Czech Republic ",
				"id": "CZ",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Slovakia",
				"id": "SK",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Slovenia",
				"id": "SI",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Estonia",
				"id": "EE",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Hungary",
				"id": "HU",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Cyprus",
				"id": "CY",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Malta",
				"id": "MT",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Poland",
				"id": "PL",
				"color": "#ebdb8b",
				"customData": "2004",
				"groupId": "2004"
			}, {
				"title": "Romania",
				"id": "RO",
				"color": "#83c2ba",
				"customData": "2007",
				"groupId": "2007"
			}, {
				"title": "Bulgaria",
				"id": "BG",
				"color": "#83c2ba",
				"customData": "2007",
				"groupId": "2007"
			}, {
				"title": "Croatia",
				"id": "HR",
				"color": "#db8383",
				"customData": "2013",
				"groupId": "2013"
			}
			]
		},

		"areasSettings": {
			"rollOverOutlineColor": "#FFFFFF",
			"rollOverColor": "#CC0000",
			"alpha": 0.8,
			"unlistedAreasAlpha": 0.1,
			"balloonText": "[[title]] joined EU at [[customData]]"
		},


		"legend": {
			"width": "100%",
			"marginRight": 27,
			"marginLeft": 27,
			"equalWidths": false,
			"backgroundAlpha": 0.5,
			"backgroundColor": "#FFFFFF",
			"borderColor": "#ffffff",
			"borderAlpha": 1,
			"top": 450,
			"left": 0,
			"horizontalGap": 10,
			"data": [ {
				"title": "EU member before 2004",
				"color": "#67b7dc"
			}, {
				"title": "Joined at 2004",
				"color": "#ebdb8b"
			}, {
				"title": "Joined at 2007",
				"color": "#83c2ba"
			}, {
				"title": "Joined at 2013",
				"color": "#db8383"
			} ]
		},
		"export": {
			"enabled": true
		}

	} );


	chart.addListener("rendered", zoomChart);

	zoomChart();

	function zoomChart() {
		chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
	}
</script>


<div class="col-12 align-content-center">
    <div id="chartdiv"></div>
</div>

<div class="col-md-6">
    <div id="chartdiv1"></div>
</div>

<div class="col-md-12">
	<div id="chartmap"></div>
</div>




