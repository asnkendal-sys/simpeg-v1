<style>table.tb td{padding:5px;}.grad {-moz-box-shadow: inset 0 0 50px #888;-webkit-box-shadow: inset 0 0 50px#888;box-shadow: inner 0 0 50px #888;}.kedip {animation: blinker 1s linear infinite;}@keyframes blinker {50% {opacity: 0;}}</style>
<?php
$id 	= Input::get('id');
$nip 	= Input::get('nip');
$nousul = Input::get('nousul');

$item 	= \DB::table('tr_ijin_cuti')
->leftjoin('view_kuota_cuti','tr_ijin_cuti.nip','=','view_kuota_cuti.nip')
->where('tr_ijin_cuti.nousul', $nousul)->where('tr_ijin_cuti.nip', $nip)->first();
// $view	= \DB::table('view_kuota_cuti')->where('nip', $nip)->first();
?>

<section class="content">
	<form id="form-editusulancuti" class="form-horizontal form-editusulancuti" method="POST" action="{!!url()!!}/ecuti/nominatifcuti/verifikasidariopd" accept-charset="UTF-8">{!!csrf_field()!!}
		<!-- <input type="hidden" name="nousul" id="nousul" value="{!!$nousul!!}"> -->
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
								<td>{!! getTanggalKuota($item->kuota_besar) !!}</td>
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
								<td>{!! getTanggalKuota($item->kuota_melahirkan) !!}</td>
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
		<div class="col-md-12">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT USULAN CUTI<a title="Tekan Untuk Melihat Detail" recnip="{!! $item->nip !!}" class="detailriwayat" href="javascript:void(0)"></a></h3>
				<!-- Tanda Jika Usulan menyalahi aturan -->
				<h3 class="box-title"><span class="tidak_valid"></span></h3>
				<!-- Tanda Jika Usulan menyalahi aturan -->
			</div>
			<div class="box box-warning">
				<div class="box-body">
					<div class="col-md-6" style="margin-left: -10px;">
						<table class="table table-hovered table-stripped" width="100%">
							<tr>
								<td width="25%">Nomor Usulan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" id="nousul" name="nousul" value="{!! $nousul !!}" class="form-control nousul" disabled>
								</td>
							</tr>
							<tr>
								<td width="25%">Tanggal Usulan</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<div class='input-group datepicker'>
										{!! Form::text('tgl_usul', (($item->tgl_usul!='')?date('d-m-Y', strtotime($item->tgl_usul)):date('d-m-Y')), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy','readonly')) !!}
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</td>
							</tr>
							<tr>
								<td width="25%">Jenis Cuti</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									{!! comboJenisCuti('id_jenis_cuti',$item->id_jenis_cuti) !!}
								</td>
							</tr>
							<tr>
								<td width="25%">Alasan Cuti</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<textarea name="alasan" class="form-control alasan" id="alasan" rows="1" required>{!!$item->alasan !!}</textarea>
								</td>
							</tr>
							<tr>
								<td width="25%">Alamat Selama Cuti</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<textarea name="alamat_cuti" class="form-control alamat" id="alamat" rows="1" required>{!!$item->alamat_cuti!!}</textarea>
								</td>
							</tr>
							<tr>
								<td width="25%">No. Telepon</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<input type="text" name="telepon" class="form-control telepon" value="{!!$item->telepon!!}" required>
									<em>*Pastikan Nomor Yang Dapat Di Hubungi</em>
								</td>
							</tr>
						</table>
					</div>
					<div class="col-md-6" style="margin-left: -10px;">
						<table class="table table-hovered table-stripped" width="100%">
							<tr>
								<td width="25%">Sisa Kuota</td>
								<td class="text-center" width="2%"> : </td>
								<td colspan="3">
									<input type="text" name="kuota_cuti" class="form-control kuota_cuti" value="{!! Ceksisakuotacuti($item->nip,$item->id_jenis_cuti) !!}" disabled>
								</td>
							</tr>
							<tr>
								<td width="25%">Tanggal Mulai</td>
								<td class="text-center" width="2%"> : </td>
								<td>
									<div class="input-group tgldinamis datepicker1">
										<input name="tgl_mulai" value="{!! ($item->tgl_mulai!='')?date('d-m-Y', strtotime($item->tgl_mulai)):date('d-m-Y')!!}" maxlength="10" class="date tglreset form-control tgl_mulai" placeholder="dd-mm-yyyy" type="text" required>
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
									<div class="input-group datepicker2">
										<input name="tgl_selesai" value="{!! ($item->tgl_selesai!='')?date('d-m-Y', strtotime($item->tgl_selesai)):date('d-m-Y')!!}" maxlength="10" class="date tglreset form-control tgl_selesai" placeholder="dd-mm-yyyy" type="text" required>
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</td>
							</tr>
							<tr>
								<td width="25%">Sisa Kuota Setelah Hitung</td>
								<td class="text-center" width="2%"> : </td>
								<td colspan="3">
									<input type="text" name="sisacuti" class="form-control sisacuti" disabled>
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
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-offset-1 col-sm-3 pull-right">
				<button class="btn btn-success form-editusulancuti" type="submit"><i class='fa fa-floppy-o'></i> Simpan</button>
				&nbsp;
				&nbsp;
				<a class="btn btn-warning kembali" href="javascript::void(0)"> Batalkan</a>
			</div>

			<div class="box-footer">
				<div class="form-group">
					
				</div>
			</div>
		</form>
	</section>
	<script>
		$(document).ready(function(){
			var xedit = "{!! $item->id_jenis_cuti !!}";
			$('select').select2();
			$(".datepicker").datetimepicker({
				format: 'DD-MM-YYYY',
				locale: 'id',
				useCurrent: false
			});
			$(".datepicker1").datetimepicker({
				format: 'DD-MM-YYYY',
				locale: 'id',
				useCurrent: false
			});

			$(".datepicker2").datetimepicker({
				format: 'DD-MM-YYYY',
				locale: 'id',
				useCurrent: false
			});
			$(".datepicker1").on("dp.change", function (e) {
				$('.datepicker2').data("DateTimePicker").minDate($('.tgl_mulai').val());
			});
			$(".date").mask("99-99-9999");
			/*get maksimal kuota cuti pegawai terpilih pada list nominatif */
			$(".id_jenis_cuti").on('change', function(e){
				e.preventDefault();
				var id = $(".id_jenis_cuti").val();
				if (id != '') {
					$.ajax({
						url: '{{url()}}/ecuti/nominatifcuti/cekkuotaedit',
						type: 'post',
						data: { 'id_jenis_cuti': id,'nip':"{!! $nip !!}",'tgl_mulai': 0,'_token':'{!!csrf_token()!!}'},
						beforeSend: function(){
							preloader.on();
							$(".kuota_cuti").val("Loading....");
							// $(".tgl_mulai").val("Loading....");
							// $(".tgl_selesai").val("Loading....");
							// loadingnyareza('box_kuota_cuti');
						},
						success:function(response){
							preloader.off();
							var ret = $.parseJSON(response);
							kuota_cuti = ret.kuota_cuti;
							var lama_cutix = "{!!$item->lama_cuti!!}";

							if (id == {!! $item->id_jenis_cuti !!}) {
								$(".kuota_cuti").val(Number(kuota_cuti)+Number(lama_cutix) );
							}else{
								$(".kuota_cuti").val(kuota_cuti);
							}
							if (xedit != id) {
								$(".tgl_mulai").val('');
								$(".tgl_selesai").val('');
								$(".sisacuti").val('');
								$(".jml_hari_kerja").val('');
								$(".jml_hari_sabtu").val('');
								$(".jml_hari_minggu").val('');
								$(".jml_hari_libur").val('');
							}
							xedit = id;

							if (ret.notif == 1) {
								bootbox.alert(ret.feedback);
								$(".tidak_valid").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i>");
								// $(".tidak_valid").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i><audio controls autoplay style='display:none;'><source src='{!!url()!!}/packages/tugumuda/mp3/danger.mp3' type='audio/ogg'><source src='{!!url()!!}/packages/tugumuda/mp3/danger.mp3' type='audio/mpeg'>Your browser does not support the audio element.</audio>");
							}else{
								$(".tidak_valid").html("");
							}
							if (ret.dis_mulai == 1) {
								$(".id_jenis_cuti").val('').trigger('change');
								$(".tgl_mulai").attr('disabled', 'disabled');
							}else{
								$(".tgl_mulai").removeAttr("disabled", "disabled");
							}
							if (ret.dis_selesai == 1) {
								$(".tidak_valid").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i>");
								$(".tgl_selesai").attr('disabled', 'disabled');
							}else{
								$(".tgl_selesai").removeAttr("disabled", "disabled");									
							}
							if (ret.dis_mulai == 1 || ret.dis_selesai == 1) {
								$(".tidak_valid").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i>");
							}else{
								$(".tidak_valid").html("");
							}

							// $(".tgl_mulai").val("");
							// $(".tgl_selesai").val("");
							// $(".kuota_cuti").val(kuota_cuti);
						}
					});
				}
			}).trigger('change');
			/*end*/
			
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
			<?php
			echo 'var index_page=laravel_base + "/'.\Request::path().'";';
			?>
			$('.kembali').on('click', function(e){
				e.preventDefault();
				claravel_modal_close('main_modal2');
				refresh_page();
			});

			$('.form-editusulancuti').on('submit',function(e){
				var $this = $(this);
				e.preventDefault();
				bootbox.confirm('Simpan data?',function(a){
					if (a == true){
						if ($(".unvalid")[0]){
							bootbox.alert("<center><b>.: PERHATIAN :.</b> <br>Periksa Ulang Usulan Nominatif Cuti <i class='glyphicon glyphicon-exclamation-sign kedip' style='color:red;' title='Tidak Dapat Disimpan'></i></center>");
						}else{
							$.ajax({
								url: '{{url()}}/ecuti/nominatifcuti/edit',
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
					}
				});
			});
			/*Function untuk mengambil tanggal mulai dan selesai lalu ditung detailnya*/
			$(".datepicker1, .datepicker2").on('dp.change', function (e) {
				e.preventDefault();
				var tgl_mulai = $(".tgl_mulai").val();
				var tgl_selesai = $(".tgl_selesai").val();
				// alert(tgl_mulai+" - "+tgl_selesai);
				if($(".id_jenis_cuti").val() != "" && tgl_mulai !="" && tgl_selesai !=""){
					$.ajax({
						url  : '{!!url()!!}/ecuti/nominatifcuti/hitungharikerja',
						type : 'POST',
						data: {'nip':"{!! $nip !!}", 'tgl_mulai': tgl_mulai,'tgl_selesai': tgl_selesai, '_token' : '{!!csrf_token()!!}'},
						success:function(response){
							var ret = $.parseJSON(response);
							var jml_hari_cuti = ret.jml_hari_kerja;
							lama_cutix = "{!!$item->lama_cuti!!}";
							sisacuti = Number(lama_cutix)+Number(kuota_cuti)-Number(jml_hari_cuti);
							// alert("SC : "+sisacuti+" - KC : "+kuota_cuti+" - JMC : "+jml_hari_cuti);
							if (sisacuti < 0 && sisacuti != "") {
								bootbox.alert("Mohon Maaf Kuota Tidak Mencukupi, Periksa Ulang Sisa Kuota Anda");
								$(".tgl_selesai").val('');
								$(".sisacuti").val('');
								$(".jml_hari_kerja").val('');
								$(".jml_hari_sabtu").val('');
								$(".jml_hari_minggu").val('');
								$(".jml_hari_libur").val('');
							}else{
								$(".jml_hari_kerja").val(jml_hari_cuti);
								$(".jml_hari_sabtu").val(ret.jml_hari_sabtu);
								$(".jml_hari_minggu").val(ret.jml_hari_minggu);
								$(".jml_hari_libur").val(ret.jml_hari_libur);
								$(".sisacuti").val(sisacuti);
							}

						}
					});
				}
			}).trigger('dp.change');
			/*END*/
			/*get maksimal kuota cuti pegawai terpilih pada list nominatif */
			$(".datepicker1").on('dp.change', function (e) {
				e.preventDefault();
				var tgl_mulai = $(".tgl_mulai").val();
				var jencuti   = $(".id_jenis_cuti").val();
				$.ajax({
					url: '{{url()}}/ecuti/nominatifcuti/cekkuotaedit',
					type: 'post',
					data: { 'nip':"{!! $nip !!}",'tgl_mulai': tgl_mulai,'id_jenis_cuti':$(".id_jenis_cuti").val(),'_token':'{!!csrf_token()!!}'},
					success:function(response){
						var ret = $.parseJSON(response);
						kuota_cuti = ret.kuota_cuti;
						$(".kuota_cuti").val(kuota_cuti);
						if (ret.notif == 1) {
							bootbox.alert(ret.feedback);
						}
						if (ret.dis_mulai == 1) {
							$(".tgl_mulai").attr('disabled', 'disabled');
						}else{
							$(".tgl_mulai").removeAttr("disabled", "disabled");
						}
						if (ret.dis_selesai == 1) {
							$(".tidak_valid").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i>");
							$(".tgl_selesai").attr('disabled', 'disabled');
						}else{
							$(".tgl_selesai").removeAttr("disabled", "disabled");									
						}
					}
				});
			}).trigger('dp.change');
			/*end*/
		});
	</script>