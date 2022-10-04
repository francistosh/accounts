// SETUP CONFIG
requirejs.config( {

	// Define paths; relative from js folder
	paths: {
		'amcharts': '//cdn.amcharts.com/lib/3/amcharts',
		'amcharts.funnel': '//cdn.amcharts.com/lib/3/funnel',
		'amcharts.gauge': '//cdn.amcharts.com/lib/3/gauge',
		'amcharts.pie': '//cdn.amcharts.com/lib/3/pie',
		'amcharts.radar': '//cdn.amcharts.com/lib/3/radar',
		'amcharts.serial': '//cdn.amcharts.com/lib/3/serial',
		'amcharts.xy': '//cdn.amcharts.com/lib/3/xy',
		'amcharts.gantt': '//cdn.amcharts.com/lib/3/gantt'
	},

	// Define dependencies
	shim: {
		'amcharts.funnel': {
			deps: [ 'amcharts' ],
			exports: 'AmCharts',
			init: function() {
				AmCharts.isReady = true;
			}
		},
		'amcharts.gauge': {
			deps: [ 'amcharts' ],
			exports: 'AmCharts',
			init: function() {
				AmCharts.isReady = true;
			}
		},
		'amcharts.pie': {
			deps: [ 'amcharts' ],
			exports: 'AmCharts',
			init: function() {
				AmCharts.isReady = true;
			}
		},
		'amcharts.radar': {
			deps: [ 'amcharts' ],
			exports: 'AmCharts',
			init: function() {
				AmCharts.isReady = true;
			}
		},
		'amcharts.serial': {
			deps: [ 'amcharts' ],
			exports: 'AmCharts',
			init: function() {
				AmCharts.isReady = true;
			}
		},
		'amcharts.xy': {
			deps: [ 'amcharts' ],
			exports: 'AmCharts',
			init: function() {
				AmCharts.isReady = true;
			}
		},
		'amcharts.gantt': {
			deps: [ 'amcharts', 'amcharts.serial' ],
			exports: 'AmCharts',
			init: function() {
				AmCharts.isReady = true;
			}
		}
	}
} );
// LOAD DEPENDENCIES; CREATE CHART
  
require( [ 'amcharts.pie' ],
//function  team(){
//    $.getJSON("../finance/json_redirect.php?action=invoiceperincome", function(data) {    
//        }); 
//},
    function( amRef ) {
    var chart = amRef.makeChart( "chartdiv", {
        "type": "pie",
        "theme": "none",
        "dataProvider": [{"accname":"Jamaat Lagat","amount":"210000.00"},{"accname":"Sabil Account","amount":"12047259.00"},{"accname":"AMS Phase 3","amount":"149700.00"}]
   ,
        "valueField": "amount",
        "titleField": "accname"
 
    } );

    // ERROR HANDLER
}, function( err ) {
    console.log( 'Something went wront: ', err );
} ); 