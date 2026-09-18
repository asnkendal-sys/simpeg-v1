
<script>
	$(document).ready(function(){
		var graphWidth = $('.tab-content').width();
		var options = {
			chart: {
				renderTo: 'graph-perkawinan1',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik {!!getUtility("nma_instansi")!!} Gol. I'
			},
			subtitle: {
				text: 'Source: {!!getUtility("link_instansi")!!}'
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				min:0,
				title: {
					text: 'Jumlah'
				}
			},
			legend: {
				/*layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,*/
				shadow: true
			},
			series: []
		};
		
		$.ajax({
			url:'{{url()}}/epersonal/statistikpegawai/graphperkawinan1',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-perkawinan1').html('<i class="fa fa-spinner"></i> Looading..');
            },
			success:function(data){
				var lines = data.split('\n');
				$.each(lines, function(lineNo, line) {
					var items = line.split(',');
					if(line!=''){
						if (lineNo == 0) {
							$.each(items, function(itemNo, item) {
								if (itemNo > 0) options.xAxis.categories.push(item);
							});
						}else {
							var series = { 
								data: []
							};
							$.each(items, function(itemNo, item) {
								if (itemNo == 0) {
									series.name = item;
								} else {
									series.data.push(parseFloat(item));
								}
							});
							options.series.push(series);
						}
					}
				});
				
				var chart = new Highcharts.Chart(options);
			}
		});
		
		var options2 = {
			chart: {
				renderTo: 'graph-perkawinan2',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik {!!getUtility("nma_instansi")!!} Gol. II'
			},
			subtitle: {
				text: 'Source: {!!getUtility("link_instansi")!!}'
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				min:0,
				title: {
					text: 'Jumlah'
				}
			},
			legend: {
				/*layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,*/
				shadow: true
			},
			series: []
		};
	
		$.ajax({
			url:'{{url()}}/epersonal/statistikpegawai/graphperkawinan2',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-perkawinan2').html('<i class="fa fa-spinner"></i> Looading..');
            },
			success:function(data){
				var lines = data.split('\n');
				$.each(lines, function(lineNo, line) {
					var items = line.split(',');
					if(line!=''){
						if (lineNo == 0) {
							$.each(items, function(itemNo, item) {
								if (itemNo > 0) options2.xAxis.categories.push(item);
							});
						}else {
							var series = { 
								data: []
							};
							$.each(items, function(itemNo, item) {
								if (itemNo == 0) {
									series.name = item;
								} else {
									series.data.push(parseFloat(item));
								}
							});
							options2.series.push(series);
						}
					}
				});
				
				var chart = new Highcharts.Chart(options2);
			}
		});
	
		
		var options3 = {
			chart: {
				renderTo: 'graph-perkawinan3',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik {!!getUtility("nma_instansi")!!} Gol. III'
			},
			subtitle: {
				text: 'Source: {!!getUtility("link_instansi")!!}'
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				min:0,
				title: {
					text: 'Jumlah'
				}
			},
			legend: {
				/*layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,*/
				shadow: true
			},
			series: []
		};
	
		$.ajax({
			url:'{{url()}}/epersonal/statistikpegawai/graphperkawinan3',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-perkawinan3').html('<i class="fa fa-spinner"></i> Looading..');
            },
			success:function(data){
				var lines = data.split('\n');
				$.each(lines, function(lineNo, line) {
					var items = line.split(',');
					if(line!=''){
						if (lineNo == 0) {
							$.each(items, function(itemNo, item) {
								if (itemNo > 0) options3.xAxis.categories.push(item);
							});
						}else {
							var series = { 
								data: []
							};
							$.each(items, function(itemNo, item) {
								if (itemNo == 0) {
									series.name = item;
								} else {
									series.data.push(parseFloat(item));
								}
							});
							options3.series.push(series);
						}
					}
				});
				
				var chart = new Highcharts.Chart(options3);
			}
		});
	
		var options4 = {
			chart: {
				renderTo: 'graph-perkawinan4',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik {!!getUtility("nma_instansi")!!} Gol. IV'
			},
			subtitle: {
				text: 'Source: {!!getUtility("link_instansi")!!}'
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				min:0,
				title: {
					text: 'Jumlah'
				}
			},
			legend: {
				/*layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,*/
				shadow: true
			},
			series: []
		};
	
		$.ajax({
			url:'{{url()}}/epersonal/statistikpegawai/graphperkawinan4',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-perkawinan4').html('<i class="fa fa-spinner"></i> Looading..');
            },
			success:function(data){
				var lines = data.split('\n');
				$.each(lines, function(lineNo, line) {
					var items = line.split(',');
					if(line!=''){
						if (lineNo == 0) {
							$.each(items, function(itemNo, item) {
								if (itemNo > 0) options4.xAxis.categories.push(item);
							});
						}else {
							var series = { 
								data: []
							};
							$.each(items, function(itemNo, item) {
								if (itemNo == 0) {
									series.name = item;
								} else {
									series.data.push(parseFloat(item));
								}
							});
							options4.series.push(series);
						}
					}
				});
				
				var chart = new Highcharts.Chart(options4);
			}
		});
	
	});
</script>

<h4 align="center">GRAFIK STATISTIK PEGAWAI BERDASARKAN PERKAWINAN {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4>
<div id="graph-perkawinan1" style="width:100%"></div>
<div id="graph-perkawinan2" style="width:100%"></div>
<div id="graph-perkawinan3" style="width:100%"></div>
<div id="graph-perkawinan4" style="width:100%"></div>