
<script>
	$(document).ready(function(){
		var graphWidth = $('.tab-content').width();
		var options = {
			chart: {
				renderTo: 'graph-ukerjagol1',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Gol. I'
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
                /*layout: 'horizontal',
                backgroundColor: '#FFFFFF',
                align: 'center',
                verticalAlign: 'bottom',
                x: 100,
                y: 5,
                floating: false,*/
                shadow: true,
                /*enabled: true*/
			},
			series: []
		};
		
		$.ajax({
			url:'{{url()}}/epersonal/statistikpegawai/graphukerjagol1',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-ukerjagol1').html('<i class="fa fa-spinner"></i> Looading..');
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
				renderTo: 'graph-ukerjagol2',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Gol. II'
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
                /*layout: 'horizontal',
                backgroundColor: '#FFFFFF',
                align: 'center',
                verticalAlign: 'bottom',
                x: 100,
                y: 5,
                floating: false,*/
                shadow: true,
                /*enabled: true*/
			},
			series: []
		};

		$.ajax({
			url:'{{url()}}/epersonal/statistikpegawai/graphukerjagol2',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-ukerjagol2').html('<i class="fa fa-spinner"></i> Looading..');
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
				renderTo: 'graph-ukerjagol3',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Gol. III'
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
                /*layout: 'horizontal',
                backgroundColor: '#FFFFFF',
                align: 'center',
                verticalAlign: 'bottom',
                x: 100,
                y: 5,
                floating: false,*/
                shadow: true,
                /*enabled: true*/
			},
			series: []
		};

		$.ajax({
			url:'{{url()}}/epersonal/statistikpegawai/graphukerjagol3',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-ukerjagol3').html('<i class="fa fa-spinner"></i> Looading..');
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
				renderTo: 'graph-ukerjagol4',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Gol. IV'
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
                /*layout: 'horizontal',
                backgroundColor: '#FFFFFF',
                align: 'center',
                verticalAlign: 'bottom',
                x: 100,
                y: 5,
                floating: false,*/
                shadow: true,
                /*enabled: true*/
			},
			series: []
		};

		$.ajax({
			url:'{{url()}}/epersonal/statistikpegawai/graphukerjagol4',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-ukerjagol4').html('<i class="fa fa-spinner"></i> Looading..');
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
<h4 align="center">GRAFIK STATISTIK PEGAWAI BERDASARKAN UNIT KERJA DAN GOLONGAN {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4>
<div id="graph-ukerjagol1" style="width:100%;"></div>
<div id="graph-ukerjagol2" style="width:100%;"></div>
<div id="graph-ukerjagol3" style="width:100%;"></div>
<div id="graph-ukerjagol4" style="width:100%;"></div>