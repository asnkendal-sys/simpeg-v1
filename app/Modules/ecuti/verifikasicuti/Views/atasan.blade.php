<style type="text/css">table.tableheader td{padding: 5px;}</style>
<div class="box-header with-border">
	{!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cariatasan' )) !!}
	{!!csrf_field()!!}
	<table width="100%" id="tables" class="tableheader">
		<tr>
			<td>Jenis Cuti</td>
			<td width="1%">:</td>
			<td>{!! comboJenisCuti('id_jenis_cuti',Input::get('id_jenis_cuti')) !!}</td>
			<td>OPD</td>
			<td width="1%">:</td>
			<td>
				<!-- function comboSkpd2($id="idskpd",$sel="",$required=""){ -->
				{!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
				<!-- {!! comboSkpd("idskpd",(session('role_id')>=4)?session('idskpd'):'')!!} -->
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
	<input type="hidden" name="atasankhusus" value="{!! \Input::get('atasankhusus')!!}">
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
				@foreach ($atasans as $no => $atasan)
				<?php
				$n++;
				$arr[$n] = $atasan->nousul;
				if($arr[$n]!=$arr[$n-1]){
					?>
					<tr>
						<th style="position:relative;" colspan="8">
							<div class="text-left">
								NOMOR USULAN : {{$atasan->nousul}}&nbsp;
								<i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($atasan->tgl_usul))?>
								&nbsp;
								<?php echo "||&nbsp;".getskpdgroup(substr($atasan->idskpd, 0,2)); ?>&nbsp;
								<br>
							</div>
						</th>
						<th style="position:relative;" colspan="6">
							<div class="text-right">
								<!-- &nbsp;<a href="javascript::void(0)" title="Verifikasi Nominatif Usulan Cuti" class="verifikasinomi btn btn-success" 
								recnousul="{!!$atasan->nousul!!}" 
								rectglusul="{!!$atasan->tgl_usul!!}"><i class="fa fa-check"> Verifikasi Semua</i></a> -->

							</div>
						</th>
					</tr>
				<?php } ?>
				<tr>
					<td><center>{!! (($no+1)+((Input::get('page')!=0)?(Input::get('page')-1):Input::get('page'))*25) !!}</center></td>
					<td>{!!$atasan->nip!!}<br>{!!$atasan->nama!!}</td>
					<td>{!!$atasan->golru!!}<br>{!!$atasan->pangkat!!}</td>
					<td style="vertical-align: middle;">{!!$atasan->jab!!}</td>
					<td style="vertical-align: middle;">{!!getJenisCuti($atasan->id_jenis_cuti)!!}</td>
					<td style="vertical-align: middle;">{!!date('d-m-y',strtotime($atasan->tgl_mulai))!!}</td>
					<td style="vertical-align: middle;">{!!date('d-m-y',strtotime($atasan->tgl_selesai))!!}</td>
					<td class="text-center" style="vertical-align: middle;">{!!$atasan->lama_cuti!!}</td>

					<td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($atasan->opd_status) !!}</td>

					<td class="text-center atasanverusulanx" recidusul="{!!$atasan->id!!}" 
						recnip="{!!$atasan->nip!!}" 
						recnousul="{!!$atasan->nousul!!}" style="vertical-align: middle;">{!! getStatusCuti($atasan->atasan_status) !!}</td>
						<td class="text-center" style="vertical-align: middle;">{!! getStatusCuti($atasan->wewenang_status) !!}</td>
						<td style="vertical-align: middle;">
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
									<span class="caret"></span> Aksi
								</button>
								<ul class="dropdown-menu pull-right">
									<li>
										@if($atasan->atasan_nip == \Session::get('user_id') || (\Session::get('role_id') == 1 || \Session::get('role_id') == 2) && $atasan->wewenang_status != 1)
										<a href="javascript:void(0)" class="text-info atasanverusulan"
										recidusul="{!!$atasan->id!!}" 
										recnip="{!!$atasan->nip!!}" 
										recnousul="{!!$atasan->nousul!!}">
										<i class="fa fa-check"></i>Verifikasi Usulan
									</a>
									@elseif($atasan->nip == \Session::get('user_id'))

									@else
									<a href="javascript:void(0)" class="text-info sudahdiverwewenang" style="color: red; cursor: not-allowed;">
										<i class="fa fa-check"></i>Verifikasi Usulan
									</a>
									@endif
								</li>
								<li>
									<a href="javascript:void(0)" class="text-info detailcuti"
									recidusul="{!!$atasan->id!!}" 
									recnip="{!!$atasan->nip!!}" 
									recnousul="{!!$atasan->nousul!!}">
									<i class="fa fa-search"></i>Preview Detail
								</a>
							</li>
							<li>{!! ClaravelHelpers::btnDelete($atasan->id) !!}</li>
						</ul>
					</div>
				</td>
			</tr>
			@if($atasan->atasan_status != 1 && $atasan->atasan_status != 0)
			<tr style="background-color: {!! getWarnaBgStatusCuti($atasan->atasan_status) !!};">
				<td></td>
				<td colspan="12"><b>Keterangan :</b> {!! $atasan->atasan_alasan !!}</td>
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
		// echo $atasans->appends(array(
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
		// $('.pagination').addClass('pagination-sm no-margin pull-right');
		<?php
		echo 'var index_page=laravel_base + "/'.\Request::path().'";';
		?>

		$('.atasanverusulan').on('click', function(e){
			e.preventDefault();
			claravel_modal('Verifikasi Atasan Langsung','Loading...','main_modal2');
			$.ajax({
				type:'post',
				url : '{!!url()!!}/ecuti/verifikasicuti/modal/atasanverifikasi',
				data: {'id': $(this).attr('recidusul'), 'nip': $(this).attr('recnip'), 'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
				success:function(html){
					$('#main_modal2 .modal-body').html(html);
				}
			});
		});

		$('.sudahdiverwewenang').on('click', function(e){
			e.preventDefault();
			bootbox.alert("Perhatian : <br> Usulan Sudah diverifikasi oleh Pejabat Yang Berwenang");
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

		$('.verifikasinomi').on('click', function(e){
			e.preventDefault();
			claravel_modal('Verifikasi Atasan Langsung (NOMINATIF)','Loading...','main_modal');
			$.ajax({
				type:'post',
				url : '{!!url()!!}/ecuti/verifikasicuti/modal/atasanvernomi',
				data: {'nousul': $(this).attr('recnousul'), '_token' : '{!!csrf_token()!!}'},
				success:function(html){
					$('#main_modal .modal-body').html(html);
				}
			});
		});

		$('#cariatasan').on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url:'{!!url()!!}/ecuti/verifikasicuti/atasan',
				data:$(this).serialize(),
				type : 'GET',
				beforeSend: function(){
					preloader.on();
				},
				success:function(html){
					preloader.off();
					$('#atasan').html(html);
				}
			});
		});
	});
</script>
