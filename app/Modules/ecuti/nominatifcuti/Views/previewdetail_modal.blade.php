<?php
$id 	= Input::get('id');
$nip 	= Input::get('nip');
$nousul = Input::get('nousul');

$item 	= \DB::table('tr_ijin_cuti')
->leftjoin('view_kuota_cuti','tr_ijin_cuti.nip','=','view_kuota_cuti.nip')
->where('tr_ijin_cuti.nousul', $nousul)->where('tr_ijin_cuti.nip', $nip)->first();
// $view	= \DB::table('view_kuota_cuti')->where('nip', $nip)->first();
$pgw    = getDetailpegawai($nip); //Helper Detail pegawai dari tb_01
$r_besar = getRiwayatcuti($nip,2,"");
$thn_bisa_besar = ($r_besar->thn+5);//thn_bisa_besar = tahun terakhir mengajukan cuti besar ditambah rentang 5 tahun
if($thn_bisa_besar <= date('Y')){
	$besar  = (3*30.44);
}else{
	$besar = 0;
}
?>

<section class="content">
	<form id="form-verusulancuti" class="form-horizontal form-verusulancuti" method="POST" action="{!!url()!!}/ecuti/nominatifcuti/verifikasidariopd" accept-charset="UTF-8">{!!csrf_field()!!}
		<input type="hidden" name="nousul" id="nousul" value="{!!$nousul!!}">
		<input type="hidden" name="id" id="id" value="{!!$id!!}">
		<input type="hidden" name="nip" class="nip" value="{!! $nip !!}">
		<div class="row">
			<div class="col-md-5">
				<div class="box-header">
					<h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PRIBADI </h3>
				</div>
				<div class="box box-success">
					<div class="box-body">
						<table id="tabel-cuti" class="table table-hovered table-stripped" width="100%">
							<tr>
								<td width="15%">NIP</td>
								<td class="text-center" width="2%"> : </td>
								<td width="38%">
									<span class="nip">{!! $nip !!}</span>
								</td>
							</tr>
							<tr>
								<td width="15%">NAMA</td>
								<td class="text-center" width="2%"> : </td>
								<td width="38%">
									<span class="nama"> {!! $item->nama !!}</span>
								</td>
							</tr>
							<tr>
								<td width="15%">JABATAN</td>
								<td class="text-center" width="2%"> : </td>
								<td width="38%">
									<span class="jab"> {!! $item->jab !!}</span>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				<div class="box-header">
					<h3 class="box-title"><i class="fa fa-fw fa-info-circle"></i> INFORMASI KUOTA CUTI TAHUN {!! date('Y') !!}</h3>
					<a href="javascript:void(0)" class=" text-info detailriwayat" recnip="{!! $nip !!}" recnama="{!! $item->nama !!}" style="float: right;" title="Tekan Untuk Melihat Detail"><i class="fa fa-eye">&nbsp;Detail</i></a>
				</div>
				<div class="box box-info">
					<div class="box-body">
						<table id="tabel-cuti" class="table table-hovered table-stripped" width="100%" border="0">
							<tr>
								<td width="25%">Cuti Tahunan</td>
								<td class="text-center" width="2%"> : </td>
								<td>{!! getTanggalKuota(($item->kuota_tahunan_n2+$item->kuota_tahunan_n1+$item->kuota_tahunan_n)) !!}
								</td>

								<td width="30%">Cuti Besar</td>
								<td class="text-center" width="2%"> : </td>
								<td>{!! getTanggalKuota($besar) !!}</td>
								<!-- <td width="10%">{!! $item->kuota_besar !!}</td> -->
							</tr>

							<tr>
								<td>Cuti Sakit</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									{!! getTanggalKuota($item->kuota_sakit) !!}
								</td>

								<td>Cuti Melahirkan</td>
								<td class="text-center" width="2%"> : </td>
								<td>{!! ($pgw->idjenkel!=1)?getTanggalKuota($item->kuota_melahirkan):'0' !!}</td>
							</tr>

							<tr>
								<td>Cuti Alasan Penting</td>
								<td class="text-center" width="2%"> : </td>
								<td>{!! getTanggalKuota($item->kuota_penting) !!}</td>

								<td>Cuti Diluar Tanggungan Negara</td>
								<td class="text-center" width="2%"> : </td>
								<td>{!! getTanggalKuota($item->kuota_diluarnegara) !!}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT USULAN CUTI<a title="Tekan Untuk Melihat Detail" recnip="{!! $item->nip !!}" class="detailriwayat" href="javascript:void(0)"></a></h3>
			</div>
			<div class="box box-warning">
				<div class="box-body">
					<table class="table table-hovered table-stripped" width="100%">
						<tr>
							<td width="25%">Nomor Usulan</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" id="nousul" name="nousul" value="{!! $item->nousul !!}" class="form-control nousul" disabled>
							</td>
						</tr>
						<tr>
							<td width="25%">Tanggal Usulan</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<div class='input-group datepicker'>
									{!! Form::text('tgl_usul', (($item->tgl_usul!='')?date('d-m-Y', strtotime($item->tgl_usul)):date('d-m-Y')), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy',(($item->tgl_usul!='')?'disabled':''))) !!}
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</td>
						</tr>
						<tr>
							<td width="25%">Jenis Cuti</td>
							<td class="text-center" width="2%"> : </td>
							<td><!-- {!! comboJenisCuti('id_jenis_cuti',$item->id_jenis_cuti) !!} -->
								<input type="hidden" id="id_jenis_cuti" name="id_jenis_cuti" class="form-control id_jenis_cuti" value="{!!$item->id_jenis_cuti!!}">
								<input type="text" id="jenis_cuti" name="jenis_cuti" class="form-control jenis_cuti" value="{!!getJenisCuti($item->id_jenis_cuti)!!}" disabled>
							</td>
						</tr>
						<tr>
							<td width="25%">Alasan Cuti</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<textarea name="alasan" class="form-control alasan" id="alasan" rows="1" disabled>{!!$item->alasan !!}</textarea>
							</td>
						</tr>
						<tr>
							<td width="25%">Alamat Selama Cuti</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<textarea name="alamat_cuti" class="form-control alamat" id="alamat" rows="1" disabled>{!!$item->alamat_cuti!!}</textarea>
							</td>
						</tr>
						<tr>
							<td width="25%">No. Telepon</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="telepon" class="form-control telepon" value="{!!$item->telepon!!}" disabled>
							</td>
						</tr>
					</table>

					<table class="table table-hovered table-stripped" width="100%">
						<tr>
							<td width="25%">Sisa Kuota</td>
							<td class="text-center" width="2%"> : </td>
							<td colspan="3">
								<input type="text" name="kuota_cuti" class="form-control kuota_cuti" disabled>
							</td>
						</tr>
						<tr>
							<td width="25%">Tanggal Mulai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<div class='input-group datepicker'>
									{!! Form::text('tgl_mulaix', (($item->tgl_mulai!='')?date('d-m-Y', strtotime($item->tgl_mulai)):date('d-m-Y')), array('class'=> 'form-control date tgl_mulaix', 'placeholder'=>'dd-mm-yyyy',(($item->tgl_mulai!='')?'disabled':''))) !!}
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</td>
						</tr>
						<tr>
							<td width="25%">Tanggal Selesai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<div class='input-group datepicker'>
									{!! Form::text('tgl_selesaix', (($item->tgl_selesai!='')?date('d-m-Y', strtotime($item->tgl_selesai)):date('d-m-Y')), array('class'=> 'form-control date tgl_selesaix', 'placeholder'=>'dd-mm-yyyy',(($item->tgl_selesai!='')?'disabled':''))) !!}
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</td>
						</tr>

						<tr>
							<td width="25%">Jumlah Dalam Hari</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<table class="table" width="100%" style="margin-top: -10px;margin-left: -10px;">
									<tr>
										<td class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_kerjax" class="form-control jml_hari_kerjax" disabled>
											<input type="hidden" name="lama_cuti" class="form-control jml_hari_kerjax"><em>*Hari<br>Kerja</em></td>
											<td class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_sabtux" class="form-control jml_hari_sabtux" disabled><em>*Hari<br>Sabtu</em></td>
											<td class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_minggux" class="form-control jml_hari_minggux" disabled><em>*Hari<br>Minggu</em></td>
											<td width="33%" class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_liburx" class="form-control jml_hari_liburx" disabled><em>*Hari<br>Libur Nasional</em></td>
										</tr>
									</table>
								</td>
							</tr>

						</table>
						<!-- </div> -->
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box-header">
					<h3 class="box-title"><i class="fa fa-fw fa-check"></i> ATRIBUT VERIFIKASI USULAN CUTI (OPD)<a title="Tekan Untuk Melihat Detail" recnip="{!! $item->nip !!}" class="detailriwayat" href="javascript:void(0)">
					</a></h3>
				</div>
				<div class="box box-warning">
					<div class="box-body">
						<table class="table table-hovered table-stripped" width="100%">
							<tr>
								<td width="25%">Status Usulan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! getStatusUsulan($item->opd_status) !!}" readonly>
								</td>
							</tr>
							@if($item->opd_status!=1 && $item->opd_status!=0)
							<tr>
								<td width="25%">Alasan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<textarea name="opd_alasan" class="form-control opd_alasan" id="opd_alasan" rows="2" readonly>{!!$item->opd_alasan!!}</textarea>
								</td>
							</tr>
							@endif
						</table>
					</div>
				</div>
			</div>
			@if($item->wewenang_status == 1)
			<div class="col-md-6">
				<div class="box-header">
					<h3 class="box-title"><i class="fa fa-fw fa-check"></i> ATRIBUT SK CUTI (OPD)</h3>
				</div>
				<div class="box box-warning">
					<div class="box-body">
						<table class="table table-hovered table-stripped" width="100%">
							<tr>
								<td width="25%">Nomor SK</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" name="nosk_cuti" class="form-control nosk_cuti" value="{!!($item->nosk_cuti!=''?$item->nosk_cuti:'Belum Diisi')!!}" id="nosk_cuti" disabled>
								</td>
							</tr>
							<tr>
								<td width="25%">Tanggal SK</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<div class='input-group datepicker'>
										<?php echo Form::text('tglsk_cuti', (($item->tglsk_cuti!='0000-00-00')?date("d-m-Y", strtotime($item->tglsk_cuti)):''), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy','disabled')) ?>
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			@endif
			@if($item->atasan_nip!="")
			<div class="col-md-6">
				<div class="box-header">
					<h3 class="box-title"><i class="fa fa-fw fa-check"></i> ATRIBUT ATASAN LANGSUNG</h3>
				</div>
				<div class="box box-warning">
					<div class="box-body">
						<table class="table table-hovered table-stripped" width="100%">
							<tr>
								<td width="25%">NIP Atasan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! $item->atasan_nip !!}" readonly>
								</td>
							</tr>
							<tr>
								<td width="25%">Nama Atasan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! $item->atasan_nama !!}" readonly>
								</td>
							</tr>
							<tr>
								<td width="25%">Jab Atasan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! $item->atasan_jab !!}" readonly>
								</td>
							</tr>
							<tr>
								<td width="25%">Pangkat Atasan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! $item->atasan_pangkat !!}" readonly>
								</td>
							</tr>
							<tr>
								<td width="25%">Status Usulan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! getStatusUsulan($item->atasan_status) !!}" readonly>
								</td>
							</tr>
							@if($item->atasan_status!=1 && $item->atasan_status!=0)
							<tr>
								<td width="25%">Alasan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<textarea class="form-control" rows="2" readonly>{!!$item->atasan_alasan!!}</textarea>
								</td>
							</tr>
							@endif
						</table>
					</div>
				</div>
			</div>
			@endif
			@if($item->wewenang_nip!="")
			<div class="col-md-6">
				<div class="box-header">
					<h3 class="box-title"><i class="fa fa-fw fa-check"></i> ATRIBUT PEJABAT YANG BERWENANG MEMBERIKAN CUTI</h3>
				</div>
				<div class="box box-warning">
					<div class="box-body">
						<table class="table table-hovered table-stripped" width="100%">
							<tr>
								<td width="25%">NIP Wewenang</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! $item->wewenang_nip !!}" readonly>
								</td>
							</tr>
							<tr>
								<td width="25%">Nama Wewenang</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! $item->wewenang_nama !!}" readonly>
								</td>
							</tr>
							<tr>
								<td width="25%">Jab Wewenang</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! $item->wewenang_jab !!}" readonly>
								</td>
							</tr>
							<tr>
								<td width="25%">Pangkat Wewenang</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! $item->wewenang_pangkat !!}" readonly>
								</td>
							</tr>
							<tr>
								<td width="25%">Status Usulan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" class="form-control" value="{!! getStatusUsulan($item->wewenang_status) !!}" readonly>
								</td>
							</tr>
							@if($item->wewenang_status!=1 && $item->wewenang_status!=0)
							<tr>
								<td width="25%">Alasan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<textarea class="form-control" rows="2" readonly>{!!$item->wewenang_alasan!!}</textarea>
								</td>
							</tr>
							@endif
						</table>
					</div>
				</div>
			</div>
			@endif
			<div class="col-md-6 pull-right">
				<div class="form-group">
					<div class="col-md-12 text-right">
						<button class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Tutup</button>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>
			</div>
		</form>
	</section>
	<script>
		
		$(document).ready(function(){
			$('.menuselect').select2();

			/*Function Untuk Menampilkan Modal Detail Riwayat Cuti*/
			$(".detailriwayat").on('click',function(e){
				e.preventDefault();
				$.ajax({
					url: '{{url()}}/ecuti/nominatifcuti/detailcuti',
					type: 'post',
					data: {'nip':$(this).attr('recnip'),'nama':$(this).attr('recnama'),'_token':'{!!csrf_token()!!}'},
					success:function(html){
						bootbox.alert(html);
					}
				});
			});
			/*END OF*/
			/*Function Untuk Menampilkan Sisa Kuota Cuti pada id_jenis_cuti terpilih*/
			$(".id_jenis_cuti").on('change', function(e){
				e.preventDefault();
				var id = $(".id_jenis_cuti").val();
				if (id != '') {
					$.ajax({
						url: '{{url()}}/ecuti/nominatifcuti/cekkuotacuti',
						type: 'post',
						data: { 'id_jenis_cuti': id,'nip':"{!! $nip !!}",'_token':'{!!csrf_token()!!}'},
						success:function(response){
							var ret = $.parseJSON(response);
							kuota_cuti = ret.kuota_cuti;
							$(".kuota_cuti").val(kuota_cuti);
						}
					});
				}
			}).trigger('change');
			/*end*/

			/*Function untuk mengambil tanggal mulai dan selesai lalu ditung detailnya*/
			$(".tgl_mulaix, .tgl_selesaix").datetimepicker({ format: 'DD-MM-YYYY' }).on('dp.change', function (e) {
				var tgl_mulaix = $(".tgl_mulaix").val();
				var tgl_selesaix = $(".tgl_selesaix").val();
				if(tgl_mulaix != '' && tgl_selesaix !=''){
					// alert(tgl_mulaix+" - "+tgl_selesaix);
					$.ajax({
						url  : '{!!url()!!}/ecuti/nominatifcuti/hitungharikerja',
						type : 'POST',
						data: {'nip':"{!! $nip !!}", 'tgl_mulai': tgl_mulai,'tgl_selesai': tgl_selesai, '_token' : '{!!csrf_token()!!}'},
						beforeSend: function(){
							// preloader.on();
						},
						success:function(response){
							preloader.off();
							var ret = $.parseJSON(response);
							$(".jml_hari_kerjax").val(ret.jml_hari_kerja);
							$(".jml_hari_sabtux").val(ret.jml_hari_sabtu);
							$(".jml_hari_minggux").val(ret.jml_hari_minggu);
							$(".jml_hari_liburx").val(ret.jml_hari_libur);
						}
					});
				}
			}).trigger('dp.change');
			/*END*/
			$('.form-verusulancuti').on('submit',function(e){
				var $this = $(this);
				e.preventDefault();
				bootbox.confirm('Simpan data?',function(a){
					if (a == true){
						$.ajax({
                       url: '{{url()}}/ecuti/nominatifcuti/verifikasidariopd', //ganti biar gag nabrak
                       type : 'POST',
                       data : $this.serialize(),
                       beforeSend: function(){
                       	preloader.on();
                       },
                       success:function(html){
                       	preloader.off();
                       	if(html=='1'){
                       		notification('Berhasil Disimpan','success');
                       		claravel_modal_close('main_modal2');
                       		refresh_page();
                       	}else{
                       		notification(html,'danger');
                       	}
                       }
                   });
					}
				});
			});
		});
	</script>