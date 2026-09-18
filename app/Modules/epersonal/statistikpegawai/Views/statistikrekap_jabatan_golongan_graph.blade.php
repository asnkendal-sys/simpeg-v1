
<script>
	$(document).ready(function(){
		var graphWidth = $('.tab-content').width();
		var options = {
			chart: {
				renderTo: 'graphrekap-jabatangol1',
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
			url:'{{url()}}/epersonal/statistikpegawai/graphrekapjabatangol1',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-jabatangol1').html('<i class="fa fa-spinner"></i> Looading..');
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
				renderTo: 'graphrekap-jabatangol2',
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
			url:'{{url()}}/epersonal/statistikpegawai/graphrekapjabatangol2',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-jabatangol2').html('<i class="fa fa-spinner"></i> Looading..');
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
				renderTo: 'graphrekap-jabatangol3',
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
			url:'{{url()}}/epersonal/statistikpegawai/graphrekapjabatangol3',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-jabatangol3').html('<i class="fa fa-spinner"></i> Looading..');
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

	});
</script>
<h4 align="center">GRAFIK STATISTIK REKAP PEGAWAI BERDASARKAN JABATAN DAN GOLONGAN {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4>
<div id="graphrekap-jabatangol1" style="width:100%;"></div>
<div id="graphrekap-jabatangol2" style="width:100%;"></div>
<div id="graphrekap-jabatangol3" style="width:100%;"></div>
