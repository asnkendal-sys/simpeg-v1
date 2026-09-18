<!-- input:disabled //Selector Css untuk input disabled -->
<?php

// getJarakDuaTanggal3($item->tgl_mulai,$item->tgl_selesai)

$id 	= Input::get('id');
$nip 	= Input::get('nip');
$nousul = Input::get('nousul');
$pgw    = getDetailpegawai($nip); //Helper Detail pegawai dari tb_01
$item 	= \DB::table('tr_ijin_cuti')
->leftjoin('view_kuota_cuti','tr_ijin_cuti.nip','=','view_kuota_cuti.nip')
->where('tr_ijin_cuti.nousul', $nousul)->where('tr_ijin_cuti.nip', $nip)->first();
// $view	= \DB::table('view_kuota_cuti')->where('nip', $nip)->first();

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
		<div class="row">
			<div class="col-md-6">
				<div class="box-header">
					<h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT USULAN CUTI<a title="Tekan Untuk Melihat Detail" recnip="{!! $item->nip !!}" class="detailriwayat" recnama="{!! $item->nama !!}" href="javascript:void(0)"></a></h3>
				</div>
				<div class="box box-warning">
					<div class="box-body">
						<table class="table table-hovered table-stripped" width="100%">
							<tr>
								<td width="25%">Nomor Usulan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" id="nousul" name="nousul" value="{!! $nousul !!}" class="form-control nousul" readonly>
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
									<input type="hidden" id="id_jenis_cuti" name="id_jenis_cuti" class="form-control id_jenis_cuti" value="{!!$item->id_jenis_cuti!!}" readonly>
									<input type="text" id="jenis_cuti" name="jenis_cuti" class="form-control jenis_cuti" value="{!!getJenisCuti($item->id_jenis_cuti)!!}" disabled>
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
								<!-- <tr>
									<td width="25%">Sisa Kuota</td>
									<td class="text-center" width="2%"> : </td>
									<td colspan="3">
										<input type="text" name="kuota_cuti" class="form-control kuota_cuti" value="{!! Ceksisakuotacuti($item->nip,$item->id_jenis_cuti) !!}" disabled>
									</td>
								</tr> -->
								<tr>
									<td width="25%">Tanggal Mulai</td>
									<td class="text-center" width="2%"> : </td>
									<td>
										<div class='input-group datepicker'>
											{!! Form::text('tgl_mulai', (($item->tgl_mulai!='')?date('d-m-Y', strtotime($item->tgl_mulai)):date('d-m-Y')), array('class'=> 'form-control date tgl_mulai', 'placeholder'=>'dd-mm-yyyy',(($item->tgl_mulai!='')?'disabled':''))) !!}
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
											{!! Form::text('tgl_selesai', (($item->tgl_selesai!='')?date('d-m-Y', strtotime($item->tgl_selesai)):date('d-m-Y')), array('class'=> 'form-control date tgl_selesai', 'placeholder'=>'dd-mm-yyyy',(($item->tgl_selesai!='')?'disabled':''))) !!}
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
												<td class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_kerja" class="form-control jml_hari_kerja" disabled>
													<input type="hidden" name="lama_cuti" class="form-control jml_hari_kerja"><em>*Hari<br>Kerja</em></td>
													<td class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_sabtu" class="form-control jml_hari_sabtu" disabled><em>*Hari<br>Sabtu</em></td>
													<td class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_minggu" class="form-control jml_hari_minggu" disabled><em>*Hari<br>Minggu</em></td>
													<td width="33%" class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_libur" class="form-control jml_hari_libur" disabled><em>*Hari<br>Libur Nasional</em></td>
												</tr>
											</table>
										</td>
									</tr>

								</table>
								<!-- </div> -->
							</div>
						</div>
						<p style="height: 200px;"></p>
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
											{!! comboStatususulan('opd_status',$item->opd_status) !!}
											<!-- {!! comboStatususulan('opd_status',1) !!} -->
										</td>
									</tr>
									<tr class="ketstatusopd">
										<td width="25%">Alasan</td>
										<td class="text-center" width="2%"> : </td>
										<td>
											<textarea name="opd_alasan" class="form-control opd_alasan" id="opd_alasan" rows="2">{!!$item->opd_alasan!!}</textarea>
										</td>
									</tr>
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
											<input type="text" id="nosk_cuti" name="nosk_cuti" value="{!! $item->nosk_cuti !!}" class="form-control nosk_cuti">
										</td>
									</tr>
									<tr>
										<td width="25%">Tanggal SK</td>
										<td class="text-center" width="2%"> : </td>
										<td>
											<div class='input-group datepicker'>
												<?php echo Form::text('tglsk_cuti', (($item->tglsk_cuti!="")?date("d-m-Y", strtotime($item->tglsk_cuti)):''), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy')) ?>
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
					<div class="menu_input_atasan">
						<div class="col-md-6">
							<div class="box-header">
								<h3 class="box-title"><i class="fa fa-fw fa-check"></i> ATRIBUT ATASAN LANGSUNG<a title="Tekan Untuk Melihat Detail" recnip="{!! $item->nip !!}" class="detailriwayat" href="javascript:void(0)">
								</a></h3>
							</div>
							<div class="box box-warning">
								<div class="box-body">
									<table class="table table-hovered table-stripped" width="100%">
										<tr>
											<td width="25%">NIP Atasan</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<select name="atasan_nip" class="form-control atasan_nip" id="atasan_nip" style="width: 100%"></select>
											</td>
										</tr>
										<tr>
											<td width="25%">Nama Atasan</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="atasan_nama" class="form-control atasan_nama" id="atasan_nama">
											</td>
										</tr>
										<tr>
											<td width="25%">Jab Atasan</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="atasan_jab" class="form-control atasan_jab" id="atasan_jab">
											</td>
										</tr>
										<tr>
											<td width="25%">Status Jabatan</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<div class="radio">
													<label><input type="radio" value="1" name="atasan_sts_plt" {!! (($item->atasan_sts_plt==1 || $item->atasan_sts_plt==0 || $item->atasan_sts_plt=='')?"checked":'' ) !!}> Aktif </label>
													&nbsp;
													<label><input type="radio" value="2" name="atasan_sts_plt" {!! ($item->atasan_sts_plt==2?"checked":'' ) !!}> PLT </label>
													&nbsp;
													<label><input type="radio" value="3" name="atasan_sts_plt" {!! ($item->atasan_sts_plt==3?"checked":'' ) !!}> PLH </label>
												</div>
											</td>
										</tr>
										<tr class="plt_jab_box_atasan">
											<td width="25%">Jab PLT</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="atasan_jab_plt" class="form-control atasan_jab_plt" value="{!! $item->atasan_jab_plt !!}" id="atasan_jab_plt">
											</td>
										</tr>
										<tr>
											<td width="25%">Pangkat Atasan</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="atasan_pangkat" class="form-control atasan_pangkat" id="atasan_pangkat">
											</td>
											<!-- LIST INPUT TYPE HIDDEN UNTUK ATASAN -->
											<input class="atasan_idjenjab" name="atasan_idjenjab" type="hidden">
											<input class="atasan_idjab" name="atasan_idjab" type="hidden">
											<input class="atasan_idskpd" name="atasan_idskpd" type="hidden">
											<input class="atasan_skpd" name="atasan_skpd" type="hidden">
											<!-- LIST INPUT TYPE HIDDEN UNTUK ATASAN -->
										</tr>
									</table>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="box-header">
								<h3 class="box-title"><i class="fa fa-fw fa-check"></i> ATRIBUT PEJABAT YANG BERWENANG MEMBERIKAN CUTI<a title="Tekan Untuk Melihat Detail" recnip="{!! $item->nip !!}" class="detailriwayat" href="javascript:void(0)">
								</a></h3>
							</div>
							<div class="box box-warning">
								<div class="box-body">
									<table class="table table-hovered table-stripped" width="100%">
										<tr>
											<td width="25%">NIP Wewenang</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<select name="wewenang_nip" class="form-control wewenang_nip" id="wewenang_nip" style="width: 100%"></select>
											</td>
										</tr>
										<tr>
											<td width="25%">Nama Wewenang</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="wewenang_nama" class="form-control wewenang_nama" id="wewenang_nama">
											</td>
										</tr>
										<tr>
											<td width="25%">Jab Wewenang</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="wewenang_jab" class="form-control wewenang_jab" id="wewenang_jab">
											</td>
										</tr>
										<tr>
											<td width="25%">Status Jabatan</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<div class="radio">
													<label><input type="radio" value="1" name="wewenang_sts_plt" {!! (($item->wewenang_sts_plt==1 || $item->wewenang_sts_plt==0 || $item->wewenang_sts_plt=='')?"checked":'' ) !!}> Aktif </label>
													&nbsp;
													<label><input type="radio" value="2" name="wewenang_sts_plt" {!! ($item->wewenang_sts_plt==2?"checked":'' ) !!}> PLT </label>
													&nbsp;
													<label><input type="radio" value="3" name="wewenang_sts_plt" {!! ($item->wewenang_sts_plt==3?"checked":'' ) !!}> PLH </label>
												</div>
											</td>
										</tr>
										<tr class="plt_jab_box_wewenang">
											<td width="25%">Jab PLT</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="wewenang_jab_plt" class="form-control wewenang_jab_plt" value="{!! $item->wewenang_jab_plt !!}" id="wewenang_jab_plt">
											</td>
										</tr>
										<tr>
											<td width="25%">Pangkat Wewenang</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="wewenang_pangkat" class="form-control wewenang_pangkat" id="wewenang_pangkat">
											</td>
											<!-- LIST INPUT TYPE HIDDEN UNTUK ATASAN -->
											<input class="wewenang_idjenjab" name="wewenang_idjenjab" type="hidden">
											<input class="wewenang_idjab" name="wewenang_idjab" type="hidden">
											<input class="wewenang_idskpd" name="wewenang_idskpd" type="hidden">
											<input class="wewenang_skpd" name="wewenang_skpd" type="hidden">
											<!-- LIST INPUT TYPE HIDDEN UNTUK ATASAN -->
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-offset-1 col-sm-3 pull-right">
						<button class="btn btn-success form-verusulancuti" type="submit"><i class='fa fa-floppy-o'></i> Simpan</button>
						&nbsp;
						&nbsp;
						<button class="btn btn-warning" data-dismiss="modal" aria-hidden="true"> Batalkan</button>
					</div>
				</div>
				<div class="box-footer" style="margin-top: -90px;">
					<div class="form-group">
						
					</div>
				</div>
			</form>
		</section>
		<script>
			var jikaAtasanNip = "{!! ($item->atasan_nip!='')?$item->atasan_nip:'' !!}";
			var jikaWewenangNip = "{!! ($item->wewenang_nip!='')?$item->wewenang_nip:'' !!}";
			$(document).ready(function(){
				$('.menuselect').select2();
				$('.ketstatusopd').hide();
				$('.menu_input_atasan').hide();
				$(".datepicker").datetimepicker({format: 'DD-MM-YYYY',locale: 'id'});

				var atasan_sts_plt = "{!! $item->atasan_sts_plt !!}";
				if (atasan_sts_plt == 2) {
					$('.plt_jab_box_atasan').show();
				}else{
					$('.plt_jab_box_atasan').hide();
				}
				var wewenang_sts_plt = "{!! $item->wewenang_sts_plt !!}";
				if (wewenang_sts_plt == 2) {
					$('.plt_jab_box_wewenang').show();
				}else{
					$('.plt_jab_box_wewenang').hide();
				}

			// alert(jikaAtasanNip+" - "+jikaWewenangNip);
			/*Function AUTOCOMPLETE untuk atasan dan wewenang*/
			autoCompleteimg('.atasan_nip', '{{url()}}/ecuti/nominatifcuti/caripegawai', 'Ketikkan NIP atau Nama', null, jikaAtasanNip, jikaAtasanNip, '');
			autoCompleteimg('.wewenang_nip', '{{url()}}/ecuti/nominatifcuti/caripegawai', 'Ketikkan NIP atau Nama', null, jikaWewenangNip, jikaWewenangNip, '');
			/*ENDOF*/

			/*Function Untuk Menampilkan Detail Atasan*/
			$(".atasan_nip").on('change', function(e){
				e.preventDefault();
				var nipatasan = $(".atasan_nip").val();
				if (nipatasan != null) {
					$.ajax({
						url: '{{url()}}/ecuti/nominatifcuti/detailpegawai',
						type: 'post',
						data: { 'nip':nipatasan,'_token':'{!!csrf_token()!!}'},
						success:function(response){
							var ret = $.parseJSON(response);

							$(".atasan_nama").val(ret.nama);
							$(".atasan_jab").val(ret.jab);
							$(".atasan_pangkat").val(ret.pangkat);

							$(".atasan_idjenjab").val(ret.idjenjab);
							$(".atasan_idjab").val(ret.idjab);
							$(".atasan_idskpd").val(ret.idskpd);
							$(".atasan_skpd").val(ret.skpd);
						}
					});
				}
			}).trigger('change');
			/*end*/

			$('input[type="radio"][name="atasan_sts_plt"]').click(function() {
				if($(this).val() == 1)
				{
					$('.plt_jab_box_atasan').fadeOut();
				}
				else if($(this).val() == 2)
				{
					$('.plt_jab_box_atasan').fadeIn();
				}else{
					$('.plt_jab_box_atasan').fadeOut();
				}
			}).trigger('change');

			$('input[type="radio"][name="wewenang_sts_plt"]').click(function() {
				// alert($(this).val());
				
				if($(this).val() == 1)
				{
					$('.plt_jab_box_wewenang').fadeOut();
				}
				else if($(this).val() == 2)
				{
					$('.plt_jab_box_wewenang').fadeIn();
				}else{
					$('.plt_jab_box_wewenang').fadeOut();
				}
			}).trigger('change');

			

			/*Function Untuk Menampilkan Detail Atasan*/
			$(".wewenang_nip").on('change', function(e){
				e.preventDefault();
				var nipatasan = $(".wewenang_nip").val();
				if (nipatasan != null) {
					$.ajax({
						url: '{{url()}}/ecuti/nominatifcuti/detailpegawai',
						type: 'post',
						data: { 'nip':nipatasan,'_token':'{!!csrf_token()!!}'},
						success:function(response){
							var ret = $.parseJSON(response);

							$(".wewenang_nama").val(ret.nama);
							$(".wewenang_jab").val(ret.jab);
							$(".wewenang_pangkat").val(ret.pangkat);

							$(".wewenang_idjenjab").val(ret.idjenjab);
							$(".wewenang_idjab").val(ret.idjab);
							$(".wewenang_idskpd").val(ret.idskpd);
							$(".wewenang_skpd").val(ret.skpd);
						}
					});
				}
			}).trigger('change');
			/*end*/

			$('#opd_status').change(function(){
				var status = $('#opd_status').val();
				if(status == 1){
					$('.menu_input_atasan').fadeIn();
					$('.ketstatusopd').fadeOut();
				}else if(status == 2 || status == 3 || status == 4){
					$('.menu_input_atasan').fadeOut();
					$('.ketstatusopd').fadeIn();
				}else{
					$('.menu_input_atasan').fadeOut();
					$('.ketstatusopd').fadeOut();
				}
			}).trigger('change');

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
			// $("#id_jenis_cuti").on('change', function(e){
			// 	e.preventDefault();
			// 	var id = $("#id_jenis_cuti").val();
			// 	if (id != '') {
			// 		$.ajax({
			// 			url: '{{url()}}/ecuti/nominatifcuti/cekkuotacuti',
			// 			type: 'post',
			// 			data: { 'id_jenis_cuti': id,'nip':"{!! $nip !!}",'_token':'{!!csrf_token()!!}'},
			// 			success:function(response){
			// 				var ret = $.parseJSON(response);
			// 				kuota_cuti = ret.kuota_cuti;
			// 				$(".kuota_cuti").val(kuota_cuti);
			// 			}
			// 		});
			// 	}
			// }).trigger('change');
			/*end*/

			/*Function untuk mengambil tanggal mulai dan selesai lalu ditung detailnya*/
			$(".tgl_mulai, .tgl_selesai").datetimepicker({ format: 'DD-MM-YYYY' }).on('dp.change', function (e) {
				e.stopImmediatePropagation();
				var tgl_mulai = $(".tgl_mulai").val();
				var tgl_selesai = $(".tgl_selesai").val();
				if(tgl_mulai != '' && tgl_selesai !=''){
					// alert(tgl_mulai+" - "+tgl_selesai);
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
							$(".jml_hari_kerja").val(ret.jml_hari_kerja);
							$(".jml_hari_sabtu").val(ret.jml_hari_sabtu);
							$(".jml_hari_minggu").val(ret.jml_hari_minggu);
							$(".jml_hari_libur").val(ret.jml_hari_libur);
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
                       	if(html==1){
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