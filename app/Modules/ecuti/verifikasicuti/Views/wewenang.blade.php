<style type="text/css">table.tableheader td{padding: 5px;}</style>
<div class="box-header with-border">
	{!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cariwewenang' )) !!}
	{!!csrf_field()!!}
	<table width="100%" id="tables" class="tableheader">
		<tr>
			<td>Jenis Cuti</td>
			<td width="1%">:</td>
			<td>{!! comboJenisCuti('id_jenis_cuti',Input::get('id_jenis_cuti')) !!}</td>
			<td>OPD</td>
			<td width="1%">:</td>
			<td>
				{!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
			</td>
		</tr>
		<tr>
			<td>Bulan</td>
			<td width="1%">:</td>
			<td>{!! comboBulan("bulan",Input::get('bulan'),"",".: Bulan :.") !!}</td>
			<td>Cari</td>
			<td>:</td>
			<td><input type="text" class="form-control" name="search" value="{!! \Input::get('search')!!}"></td>
		</tr>
		<tr>
			<td colspan="5"></td>
			<td class="pull-right">
				<button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
			</td>
		</tr>
	</table>
	<input type="hidden" name="wewenangkhusus" value="{!! \Input::get('wewenangkhusus')!!}">
	{!! Form::close() !!}
</div>
<div class="table">
	<div class="box-body no-padding">
		<table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
			<thead class="bg-primary">
				<tr>
					<th style="vertical-align: middle;" rowspan="2" width="3%">NO</th>
					<th style="vertical-align: middle;" rowspan="2"><div class="text-center">NIP<br>NAMA LENGKAP</div></th>
					<th style="vertical-align: middle;" rowspan="2"><div class="text-center">GOL.<br>PANGKAT</div></th>
					<th style="vertical-align: middle;" rowspan="2"><div class="text-center">JABATAN</div></th>
					<th style="vertical-align: middle;" rowspan="2"><div class="text-center">JENIS CUTI</div></th>
					<th style="vertical-align: middle;" colspan="3"><div class="text-center">TANGGAL</div></th>
					<th style="vertical-align: middle;" colspan="3"><div class="text-center">STATUS</div></th>
					<th style="vertical-align: middle;" rowspan="2" width="7%"><div class="text-center">AKSI</div></th>
				</tr>
				<tr>
					<th><div class="text-center">MULAI</div></th>
					<th><div class="text-center">SELESAI</div></th>
					<th><div class="text-center">LAMA</div></th>

					<th><div class="text-center">USULAN</div></th>
					<th><div class="text-center">ATASAN</div></th>
					<th><div class="text-center">WEWENANG</div></th>
				</tr>
			</thead>   

			<tbody>
				<?php
				$arr[0]= "";
				$n = 0;
				?>
				@foreach ($wewenangs as $no => $wewenang)
				<?php
				$n++;
				$arr[$n] = $wewenang->nousul;
				if($arr[$n]!=$arr[$n-1]){
					?>
					<tr>
						<th style="position:relative;" colspan="8">
							<div class="text-left">
								NOMOR USULAN : {{$wewenang->nousul}}&nbsp;
								<i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($wewenang->tgl_usul))?>
								&nbsp;
								<?php echo "||&nbsp;".getskpdgroup(substr($wewenang->idskpd, 0,2)); ?>&nbsp;
								<br>
							</div>
						</th>
						<th style="position:relative;" colspan="6">
							<div class="text-right">
								<!-- &nbsp;<a href="javascript::void(0)" title="Verifikasi Nominatif Usulan Cuti" class="verifikasinomi btn btn-success" 
								recnousul="{!!$wewenang->nousul!!}" 
								rectglusul="{!!$wewenang->tgl_usul!!}"><i class="fa fa-check"> Verifikasi Semua</i></a> -->

							</div>
						</th>
					</tr>
				<?php } ?>
				<tr>
					<td><center>{!! (($no+1)+((Input::get('page')!=0)?(Input::get('page')-1):Input::get('page'))*25) !!}</center></td>
					<td>{!!$wewenang->nip!!}<br>{!!$wewenang->nama!!}</td>
					<td>{!!$wewenang->golru!!}<br>{!!$wewenang->pangkat!!}</td>
					<td style="vertical-align: middle;">{!!$wewenang->jab!!}</td>
					<td style="vertical-align: middle;">{!!getJenisCuti($wewenang->id_jenis_cuti)!!}</td>
					<td style="vertical-align: middle;">{!!date('d-m-y',strtotime($wewenang->tgl_mulai))!!}</td>
					<td style="vertical-align: middle;">{!!date('d-m-y',strtotime($wewenang->tgl_selesai))!!}</td>
					<td class="text-center" style="vertical-align: middle;">{!!$wewenang->lama_cuti!!}</td>

					<td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($wewenang->opd_status) !!}</td>

					<td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($wewenang->atasan_status) !!}</td>
					<td class="text-center wewenangverusulanx" recidusul="{!!$wewenang->id!!}" 
						recnip="{!!$wewenang->nip!!}" 
						recnousul="{!!$wewenang->nousul!!}" style="vertical-align: middle;">{!! getStatusCuti($wewenang->wewenang_status) !!}</td>
						<td style="vertical-align: middle;">
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
									<span class="caret"></span> Aksi
								</button>
								<ul class="dropdown-menu pull-right">
									<li>
										@if($wewenang->wewenang_nip == \Session::get('user_id') || (\Session::get('role_id') == 1 || \Session::get('role_id') == 2) )
										<a href="javascript:void(0)" class="text-info wewenangverusulan"
										recidusul="{!!$wewenang->id!!}" 
										recnip="{!!$wewenang->nip!!}" 
										recnousul="{!!$wewenang->nousul!!}">
										<i class="fa fa-check"></i>Verifikasi Usulan
									</a>
									@else
									@endif
									<a href="javascript:void(0)" class="text-info detailcuti"
									recidusul="{!!$wewenang->id!!}" 
									recnip="{!!$wewenang->nip!!}" 
									recnousul="{!!$wewenang->nousul!!}">
									<i class="fa fa-search"></i>Preview Detail
								</li>
								<li>{!! ClaravelHelpers::btnDelete($wewenang->id) !!}</li>
							</ul>
						</div>
					</td>
				</tr>
				@if($wewenang->wewenang_status != 1 && $wewenang->wewenang_status != 0)
				<tr style="background-color: {!! getWarnaBgStatusCuti($wewenang->wewenang_status) !!};">
					<td></td>
					<td colspan="12"><b>Keterangan :</b> {!! $wewenang->wewenang_alasan !!}</td>
				</tr> 
				@endif
				@endforeach
			</tbody>
		</table>
		<table border="0" class="table">
			<tr>
				<td colspan="11">Keterangan :<br></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<span style="color:green;"><i class="fa fa-check-circle" title="Selesai diproses"/></span> - Disetujui
				</td>
				<td>
					<span style="color:orange;"><i class="fa fa-pencil-square-o" title="Perubahan"/></span> - Perubahan
				</td>
				<td>
					<span style="color:red;"><i class="fa fa-clock-o" title="Ditangguhkan"/></span> - Ditangguhkan
				</td>
				<td>
					<span style="color:red;"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span> - Tidak Disetujui
				</td>
				<td>
					<span style="color:orange;"><i class="fa fa-clock-o" title="Sedang diproses"/></span> - Sedang Diproses
				</td>
				<td>
					<span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> - Sudah Cetak SK
				</td>
				<td>
					<span style="color:#000000"><i class="fa fa-star" title="SK Dibatalkan"/></span> - SK Dibatalkan
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="box-footer clearfix">
	<div class="col-sm-6">
	</div>
	<div class="col-sm-6">
		<?php 
		// echo $wewenangs->appends(array(
		// 	'id_jenis_cuti' => Input::get('id_jenis_cuti'),
		// 	'bulan' => Input::get('bulan'),
		// 	'idskpd' => Input::get('idskpd'),
		// 	'search' => Input::get('search')
		// ))->render(); 
		?>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('select').select2();
		$('.pagination').addClass('pagination-sm no-margin pull-right');
		<?php
		echo 'var index_page=laravel_base + "/'.\Request::path().'";';
		?>

		$('.wewenangverusulan').on('click', function(e){
			e.preventDefault();
			claravel_modal('Verifikasi Wewenang','Loading...','main_modal2');
			$.ajax({
				type:'post',
				url : '{!!url()!!}/ecuti/verifikasicuti/modal/wewenangverifikasi',
				data: {'id': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
				success:function(html){
					$('#main_modal2 .modal-body').html(html);
				}
			});
		});

		$('.verifikasinomi').on('click', function(e){
			e.preventDefault();
			claravel_modal('Verifikasi Wewenang (NOMINATIF)','Loading...','main_modal');
			$.ajax({
				type:'post',
				url : '{!!url()!!}/ecuti/verifikasicuti/modal/wewenangvernomi',
				data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
				success:function(html){
					$('#main_modal .modal-body').html(html);
				}
			});
		});

		$('.detailcuti').on('click', function(e){
			e.preventDefault();
			claravel_modal('Preview Usulan Cuti','Loading...','main_modal2');
			$.ajax({
				type:'post',
				url : '{!!url()!!}/ecuti/nominatifcuti/modal/previewdetail',
				data: {'id': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
				success:function(html){
					$('#main_modal2 .modal-body').html(html);
				}
			});
		});

		$('#cariwewenang').on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url:'{!!url()!!}/ecuti/verifikasicuti/wewenang',
				data:$(this).serialize(),
				type : 'GET',
				beforeSend: function(){
					preloader.on();
				},
				success:function(html){
					preloader.off();
					$('#wewenang').html(html);
				}
			});
		});
	});
</script>
