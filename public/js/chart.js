$(document).ready(function(){
	var ctx = document.getElementById('myChart').getContext('2d');

	Chart.defaults.global.defaultFontColor = '#000000';
	Chart.defaults.global.defaultFontFamily = 'Arial';

	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {}
	});


	var mixedChart = new Chart(ctx, {
	    type: 'line',
	    data: {
	        datasets: [{
	            label: 'Doanh thu',
	            data: [100000, 20000, 30000, 40000, 10000, 20000, 10000, 60000, 70000, 10000, 15000, 0, 0],
	            // backgroundColor: 'rgba(34, 112, 147,1.0)',
	            borderColor: '#2c3e50',
	            borderWidth: 1
	        }, {
	            label: 'Doanh thu năm trước',
	            data: [5000, 2000, 5400, 40002, 10000, 20000, 10000, 10000, 50000, 10500, 25000, 5000, 100000],
	            // backgroundColor: 'rgba(0,0,0,.4)',
	            borderColor: '#16a085',
	            borderWidth: 1,
	            // Changes this dataset to become a line
	            type: 'line'
	        }],
	        labels: ['January', 'February', 'March', 'April', 'May', 'June', 
	        'July', 'August', 'September', 'October', 'November', 'December']
	    },

	    options: options 
	});

	var options = {

	    scales: {
	        xAxes: [{
	            barPercentage: 0.5,
	            barThickness: 6,
	            maxBarThickness: 8,
	            minBarLength: 2,
	            gridLines: {
	                offsetGridLines: false
	            }
	        }],

	         yAxes: [{
	            ticks: {
	                beginAtZero:true
	            }
	        }]
	    }
	};

});


