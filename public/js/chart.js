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
	            data: [1, 5, 5, 5, 10, 10, 10, 12.5, 15, 20, 20 , 25],
	            // backgroundColor: 'rgba(34, 112, 147,1.0)',
	            borderColor: '#2c3e50',
	            borderWidth: 1
	        }, {
	            label: 'Doanh thu năm trước',
	            data: [],
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


