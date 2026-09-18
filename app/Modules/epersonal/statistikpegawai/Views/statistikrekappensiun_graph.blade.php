
<script>
	$(document).ready(function(){
		var graphWidth = $('.tab-content').width();
		var options = {
			chart: {
				renderTo: 'graphrekap-pensiun',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik Pegawai Pensiun{!!getUtility("nma_instansi")!!}'
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
			url:'{{url()}}/epersonal/statistikpegawai/graphrekappensiun',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-pensiun').html('<i class="fa fa-spinner"></i> Looading..');
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

	});
</script>
<h4 align="center">GRAFIK STATISTIK REKAP PEGAWAI PENSIUN {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4>
<div id="graphrekap-pensiun" style="width:100%;"></div>
