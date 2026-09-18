
<script>
	$(document).ready(function(){
		var graphWidth = $('.tab-content').width();
		var options = {
			chart: {
				renderTo: 'graphrekap-gol',
				defaultSeriesType: 'column',
	            spacingLeft: 0,
	            spacingRight: 0,
	            width: graphWidth
			},
			title: {
				text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Golongan'
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
			url:'{{url()}}/epersonal/statistikpegawai/graphrekapgol',
			type:'post',
			data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-gol').html('<i class="fa fa-spinner"></i> Looading..');
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
        renderTo: 'graphrekap-pendidikan',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!}Menurut Tingkat Pendidikan'
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
      url:'{{url()}}/epersonal/statistikpegawai/graphrekappendidikan',
      type:'post',
      data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-pendidikan').html('<i class="fa fa-spinner"></i> Looading..');
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
        renderTo: 'graphrekap-jabstru',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Jabatan Struktural'
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
      url:'{{url()}}/epersonal/statistikpegawai/graphrekapjabstru',
      type:'post',
      data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-jabstru').html('<i class="fa fa-spinner"></i> Looading..');
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
        renderTo: 'graphrekap-tenagapendidik',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Jabatan Fungsional Tenaga Pendidikan'
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
      url:'{{url()}}/epersonal/statistikpegawai/graphrekaptenagapendidik',
      type:'post',
      data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-tenagapendidik').html('<i class="fa fa-spinner"></i> Looading..');
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
        renderTo: 'graphrekap-tenagakesehatan',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Jabatan Fungsional Tenaga Kesehatan'
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
      url:'{{url()}}/epersonal/statistikpegawai/graphrekaptenagakesehatan',
      type:'post',
      data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-tenagakesehatan').html('<i class="fa fa-spinner"></i> Looading..');
            },
      success:function(data){
        var lines = data.split('\n');
        $.each(lines, function(lineNo, line) {
          var items = line.split(',');
          if(line!=''){
            if (lineNo == 0) {
              $.each(items, function(itemNo, item) {
                if (itemNo > 0) options5.xAxis.categories.push(item);
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

    var options6 = {
      chart: {
        renderTo: 'graphrekap-tenagateknis',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Jabatan Fungsional Tenaga Teknis'
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
      url:'{{url()}}/epersonal/statistikpegawai/graphrekaptenagateknis',
      type:'post',
      data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-tenagateknis').html('<i class="fa fa-spinner"></i> Looading..');
            },
      success:function(data){
        var lines = data.split('\n');
        $.each(lines, function(lineNo, line) {
          var items = line.split(',');
          if(line!=''){
            if (lineNo == 0) {
              $.each(items, function(itemNo, item) {
                if (itemNo > 0) options6.xAxis.categories.push(item);
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
              options6.series.push(series);
            }
          }
        });

        var chart = new Highcharts.Chart(options6);
      }
    });

    var options7 = {
      chart: {
        renderTo: 'graphrekap-diklatstruktural',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Diklat Struktural'
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
      url:'{{url()}}/epersonal/statistikpegawai/graphrekapdiklatstruktural',
      type:'post',
      data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-diklatstruktural').html('<i class="fa fa-spinner"></i> Looading..');
            },
      success:function(data){
        var lines = data.split('\n');
        $.each(lines, function(lineNo, line) {
          var items = line.split(',');
          if(line!=''){
            if (lineNo == 0) {
              $.each(items, function(itemNo, item) {
                if (itemNo > 0) options7.xAxis.categories.push(item);
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
              options7.series.push(series);
            }
          }
        });

        var chart = new Highcharts.Chart(options7);
      }
    });

    var options8 = {
      chart: {
        renderTo: 'graphrekap-jeniskelamin',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Jenis Kelamin'
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
      url:'{{url()}}/epersonal/statistikpegawai/graphrekapjeniskelamin',
      type:'post',
      data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-jeniskelamin').html('<i class="fa fa-spinner"></i> Looading..');
            },
      success:function(data){
        var lines = data.split('\n');
        $.each(lines, function(lineNo, line) {
          var items = line.split(',');
          if(line!=''){
            if (lineNo == 0) {
              $.each(items, function(itemNo, item) {
                if (itemNo > 0) options8.xAxis.categories.push(item);
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
              options8.series.push(series);
            }
          }
        });

        var chart = new Highcharts.Chart(options8);
      }
    });

    var options9 = {
      chart: {
        renderTo: 'graphrekap-usia',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Usia'
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
      url:'{{url()}}/epersonal/statistikpegawai/graphrekapusia',
      type:'post',
      data:{ 'idskpd':$('#idskpd').val(), '_token':'{!!csrf_token()!!}' },
            beforeSend:function(){
                $('#graphrekap-usia').html('<i class="fa fa-spinner"></i> Looading..');
            },
      success:function(data){
        var lines = data.split('\n');
        $.each(lines, function(lineNo, line) {
          var items = line.split(',');
          if(line!=''){
            if (lineNo == 0) {
              $.each(items, function(itemNo, item) {
                if (itemNo > 0) options9.xAxis.categories.push(item);
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
              options9.series.push(series);
            }
          }
        });

        var chart = new Highcharts.Chart(options9);
      }
    });

    var options10 = {
      chart: {
        renderTo: 'graphrekap-pensiun',
        defaultSeriesType: 'column',
              spacingLeft: 0,
              spacingRight: 0,
              width: graphWidth
      },
      title: {
        text: 'Grafik Pegawai {!!getUtility("nma_instansi")!!} Menurut Pensiun PNS'
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
                if (itemNo > 0) options10.xAxis.categories.push(item);
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
              options10.series.push(series);
            }
          }
        });

        var chart = new Highcharts.Chart(options10);
      }
    });

	});
</script>
<h4 align="center">GRAFIK STATISTIK REKAP PROFIL PNS {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4>
<div id="graphrekap-gol" style="width:100%;"></div>
<div id="graphrekap-pendidikan" style="width:100%;"></div>
<div id="graphrekap-jabstru" style="width:100%;"></div>
<div id="graphrekap-tenagapendidik" style="width:100%;"></div>
<div id="graphrekap-tenagakesehatan" style="width:100%;"></div>
<div id="graphrekap-tenagateknis" style="width:100%;"></div>
<div id="graphrekap-diklatstruktural" style="width:100%;"></div>
<div id="graphrekap-jeniskelamin" style="width:100%;"></div>
<div id="graphrekap-usia" style="width:100%;"></div>
<div id="graphrekap-pensiun" style="width:100%;"></div>
