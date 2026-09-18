<section class="content-header">
	<h1>
		Template SK Pengangkatan Pelaksana<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="{!!url()!!}"> Dashboard</a></li>
		<li class="active">Template SK Pengangkatan Pelaksana </li>
	</ol>
</section>
<section class="content">
	<div class="box box-primary">

		<div class="table-responsive">
			<div class="box-body nav-tabs-custom">

				<ul class="nav nav-tabs" id="myTab">
					@if(session::get('role_id')<=2)
					<li class="active"><a href="#pengantar" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Pengantar </a></li>
					<li class=""><a href="#petikan" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Petikan </a></li>
					<li class=""><a href="#kolektif" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Kolektif</a></li>
					@else
					<li class="active"><a href="#pengantar" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Pengantar </a></li>
					@endif
				</ul>

				<div class="tab-content">
					@if(session::get('role_id')<=2)
					<div class="tab-pane active" id="pengantar"></div>
					<div class="tab-pane" id="petikan"></div>
					<div class="tab-pane" id="kolektif"></div>
					@else
					<div class="tab-pane active" id="pengantar"></div>
					@endif
				</div>

			</div>
		</div>

	</div>
</section>

<script>
	// var xhr = $.ajax(); 
	<?php if(session::get('role_id')<=2) {  ?>

	$(document).ready(function(){
		getPengantar();
		$('#myTab li a').each(function(index,item){
			$(item).click(function(){
				switch(index){
					case 0 : getPengantar(); break;
					case 1 : getPetikan(); break;
					case 2 : getKolektif(); break;
				}
			});
		});                
	});

	<?php } else{ ?>

	$(document).ready(function(){
		getPengantar();
		$('#myTab li a').each(function(index,item){
			$(item).click(function(){
				switch(index){
					case 0 : getPengantar(); break;
				}
			});
		});                
	});

	<?php } ?>

	function getPengantar(){
		xhr.abort();
		$.ajax({
			type:'post',
			url:'{!!url()!!}/emutasi/templateskpengangkatan/data/pengantar',
			data: {'_token': '{!!csrf_token()!!}'},
			beforeSend:function(){
				preloader.on();
			},
			success:function(response){
				preloader.off();
				$('#pengantar').html(response);
			}
		});
	}

	function getPetikan(){
		xhr.abort();
		$.ajax({
			type:'post',
			url:'{!!url()!!}/emutasi/templateskpengangkatan/data/petikan',
			data: {'_token': '{!!csrf_token()!!}'},
			beforeSend:function(){
				preloader.on();
			},
			success:function(response){
				preloader.off();
				$('#petikan').html(response);
			}
		});
	}
	function getKolektif(){
		xhr.abort();
		$.ajax({
			type:'post',
			url:'{!!url()!!}/emutasi/templateskpengangkatan/data/kolektif',
			data: {'_token': '{!!csrf_token()!!}'},
			beforeSend:function(){
				preloader.on();
			},
			success:function(response){
				preloader.off();
				$('#kolektif').html(response);
			}
		});
	}
</script>
