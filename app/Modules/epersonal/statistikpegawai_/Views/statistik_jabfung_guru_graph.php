
<script>
	$(document).ready(function(){
		var graphWidth = $('.tab-content').width();
		var options = {
			chart: {
				renderTo: 'graph-pendformal1',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik PEGAWAI BKD Kendal Gol. I'
			},
			subtitle: {
				text: 'Source: bkd.kendalkab.go.id'
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
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			},
			series: []
		};
		
		$.ajax({
			url:'<?=base_url()?>epersonal/graphJabfungguru1',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val() },
			beforeSend:function(){},
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
				renderTo: 'graph-pendformal2',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik PEGAWAI BKD Kendal Gol. II'
			},
			subtitle: {
				text: 'Source: bkd.kendalkab.go.id'
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
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			},
			series: []
		};
	
		$.ajax({
			url:'<?=base_url()?>epersonal/graphJabfungguru2',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val() },
			beforeSend:function(){},
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
				renderTo: 'graph-pendformal3',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik PEGAWAI BKD Kendal Gol. III'
			},
			subtitle: {
				text: 'Source: bkd.kendalkab.go.id'
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
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			},
			series: []
		};
	
		$.ajax({
			url:'<?=base_url()?>epersonal/graphJabfungguru3',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val() },
			beforeSend:function(){},
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
				renderTo: 'graph-pendformal4',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik PEGAWAI BKD Kendal Gol. IV'
			},
			subtitle: {
				text: 'Source: bkd.kendalkab.go.id'
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
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			},
			series: []
		};
	
		$.ajax({
			url:'<?=base_url()?>epersonal/graphJabfungguru4',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val() },
			beforeSend:function(){},
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
<?php
$item = $this->epersonal_list->getSkpd($this->input->post('idskpd'));
?>
<h4 align="center">GRAFIK STATISTIK PEGAWAI BERDASARKAN JABATAN FUNGSIONAL TERTENTU GURU FORMAL PADA <?=strtoupper($item->skpd)?></h4>
<div id="graph-pendformal1" style="width:100%"></div>
<div id="graph-pendformal2" style="width:100%"></div>
<div id="graph-pendformal3" style="width:100%"></div>
<div id="graph-pendformal4" style="width:100%"></div>