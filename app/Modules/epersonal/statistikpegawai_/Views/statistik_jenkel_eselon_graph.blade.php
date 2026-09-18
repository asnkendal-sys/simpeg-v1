
<script>
	$(document).ready(function(){
		var graphWidth = $('.tab-content').width();
		var options = {
			chart: {
				renderTo: 'graph-jenkelesl1',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik {!!getUtility("nma_instansi")!!} Eselon. I'
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
			url:'{{url()}}/epersonal/statistikpegawai/graphjenkelesl1',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-jenkelesl1').html('<i class="fa fa-spinner"></i> Looading..');
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
				renderTo: 'graph-jenkelesl2',
				defaultSeriesType: 'column',
				spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik {!!getUtility("nma_instansi")!!} Eselon. II'
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
			url:'{{url()}}/epersonal/statistikpegawai/graphjenkelesl2',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-jenkelesl2').html('<i class="fa fa-spinner"></i> Looading..');
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
				renderTo: 'graph-jenkelesl3',
				defaultSeriesType: 'column',
				spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik {!!getUtility("nma_instansi")!!} Eselon. III'
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
			url:'{{url()}}/epersonal/statistikpegawai/graphjenkelesl3',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-jenkelesl3').html('<i class="fa fa-spinner"></i> Looading..');
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
				renderTo: 'graph-jenkelesl4',
				defaultSeriesType: 'column',
				spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik {!!getUtility("nma_instansi")!!} Eselon. IV'
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
			url:'{{url()}}/epersonal/statistikpegawai/graphjenkelesl4',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-jenkelesl4').html('<i class="fa fa-spinner"></i> Looading..');
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

        var options5 = {
            chart: {
                renderTo: 'graph-jenkelesl5',
                defaultSeriesType: 'column',
                spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
            },
            title: {
                text: 'Grafik {!!getUtility("nma_instansi")!!} Eselon. V'
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
            url:'{{url()}}/epersonal/statistikpegawai/graphjenkelesl5',
            type:'post',
            data:{ 'idskpd':$('#idskpd').val(),'_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graph-jenkelesl5').html('<i class="fa fa-spinner"></i> Looading..');
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
                            options5.series.push(series);
                        }
                    }
                });

                var chart = new Highcharts.Chart(options5);
            }
        });
		
	});
</script>

<h4 align="center">GRAFIK STATISTIK PEGAWAI BERDASARKAN UNIT KERJA DAN JENIS KELAMIN DAN GOLONGAN {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4>
<div id="graph-jenkelesl1" style="width:100%"></div>
<div id="graph-jenkelesl2" style="width:100%"></div>
<div id="graph-jenkelesl3" style="width:100%"></div>
<div id="graph-jenkelesl4" style="width:100%"></div>
<div id="graph-jenkelesl5" style="width:100%"></div>