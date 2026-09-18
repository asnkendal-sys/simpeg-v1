<section class="content-header">
	<h1>
		Template SK Dalam OPD<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="{!!url()!!}"> Dashboard</a></li>
		<li class="active">Template SK Dalam OPD </li>
	</ol>
</section>
<section class="content">
	<div class="box box-primary">

		<div class="table-responsive">
			<div class="box-body nav-tabs-custom">

				<ul class="nav nav-tabs" id="myTab">
					<li class="active"><a href="#perintah" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Perintah </a></li>
					<li class=""><a href="#perintahkolektif" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Perintah Kolektif</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="perintah"></div>
					<div class="tab-pane" id="perintahkolektif"></div>
				</div>

			</div>
		</div>

	</div>
</section>

<script>
	var xhr = $.ajax();        
	$(document).ready(function(){
		getPerintah();
		$('#myTab li a').each(function(index,item){
			$(item).click(function(){
				switch(index){
					case 0 : getPerintah(); break;
					case 1 : getPerintahkolektif(); break;
				}
			});
		});                
	});

	function getPerintah(){
		xhr.abort();
		$.ajax({
			type:'post',
			url:'{!!url()!!}/emutasi/templateskmutasi/data/perintah',
			data: {'_token': '{!!csrf_token()!!}'},
			beforeSend:function(){
				preloader.on();
			},
			success:function(response){
				preloader.off();
				$('#perintah').html(response);
			}
		});
	}
	function getPerintahkolektif(){
		xhr.abort();
		$.ajax({
			type:'post',
			url:'{!!url()!!}/emutasi/templateskmutasi/data/perintahkolektif',
			data: {'_token': '{!!csrf_token()!!}'},
			beforeSend:function(){
				preloader.on();
			},
			success:function(response){
				preloader.off();
				$('#perintahkolektif').html(response);
			}
		});
	}
</script>
