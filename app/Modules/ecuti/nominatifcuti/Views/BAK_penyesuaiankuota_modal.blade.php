<style type="text/css">.tablex td{ padding: 2px; }</style>
<?php
$nip 	= Input::get('nip');
$nama 	= Input::get('nama');
$nomike	= Input::get('nomor');

$vitem 	= \DB::table('view_kuota_cuti')->where('nip', $nip)->first();
$titem 	= \DB::table('tb_01')->select('hari_kerja')->where('nip', $nip)->first();

?>
<section class="content">
	<form id="form-penyesuaiankuota" class="form-horizontal form-penyesuaiankuota" method="POST" action="{!!url()!!}/ecuti/nominatifcuti/penyesuaiankuota" accept-charset="UTF-8">{!!csrf_field()!!}
		<input type="hidden" name="nip" class="nip" value="{!! $nip !!}">
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
							<span class="nama"> {!! $nama !!}</span>
						</td>
					</tr>

					<tr>
						<td width="15%">Hari Kerja</td>
						<td class="text-center" width="2%"> : </td>
						<td width="38%">
							<label class="radio-inline">
								<input type="radio" id="hari_kerja1" {!!($titem->hari_kerja==5)?"checked":""!!} value="5" name="hari_kerja"> 5 Hari
							</label>
							<label class="radio-inline">
								<input type="radio" id="hari_kerja2" {!!($titem->hari_kerja==6)?"checked":""!!} value="6" name="hari_kerja"> 6 Hari
							</label>
							<label class="radio-inline">
								<input type="radio" id="hari_kerja3" {!!($titem->hari_kerja==7)?"checked":""!!} value="7" name="hari_kerja"> 7 Hari
							</label>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-fw fa-info-circle"></i> INFORMASI KUOTA CUTI TAHUN {!! date('Y') !!}</h3>
			<a href="javascript:void(0)" class=" text-info detailriwayat" recnip="{!! $nip !!}" recnama="{!! $nama !!}" style="float: right;" title="Tekan Untuk Melihat Detail"><i class="fa fa-eye">&nbsp;Detail</i></a>
		</div>
		<div class="box box-info">
			<div class="box-body">
				<table id="tabel-cuti" class="table table-hovered table-stripped" width="100%" border="0">
					<tr>
						<td width="40%">Cuti Tahunan N-2</td>
						<td class="text-center" width="2%"> : </td>
						<td><input type="text" name="k_tahunan_n2" class="form-control num maxtahunan6"></td>
						<td>Hari</td>
					</tr>
					<tr>
						<td width="40%">Cuti Tahunan N-1</td>
						<td class="text-center" width="2%"> : </td>
						<td><input type="text" name="k_tahunan_n1" class="form-control num maxtahunan6"></td>
						<td>Hari</td>
					</tr>
					<tr>
						<td width="40%">Cuti Tahunan N</td>
						<td class="text-center" width="2%"> : </td>
						<td><input type="text" name="k_tahunan_n" class="form-control num maxtahunan12"></td>
						<td>Hari</td>
					</tr>
					<tr>
						<td>Cuti Besar</td>
						<td class="text-center" width="2%"> : </td>
						<td>
							<table class="tablex" border="0" width="100%">
								<tr>
									<td><input type="text" class="form-control num" size=4 disabled></td>
									<td>Tahun</td>

									<td><input type="text" name="k_besar_bulan" class="form-control num" size=4></td>
									<td>Bulan</td>

									<td><input type="text" name="k_besar_hari" class="form-control num" size=4></td>
									<td>Hari</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>Cuti Sakit</td>
						<td class="text-center" width="2%"> : </td>
						<td>
							<table class="tablex" border="0" width="100%">
								<tr>
									<td><input type="text" name="k_sakit_tahun" class="form-control num" size=4></td>
									<td>Tahun</td>

									<td><input type="text" name="k_sakit_bulan" class="form-control num" size=4></td>
									<td>Bulan</td>

									<td><input type="text" name="k_sakit_hari" class="form-control num" size=4 ></td>
									<td>Hari</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>Cuti Melahirkan</td>
						<td class="text-center" width="2%"> : </td>
						<td>
							<table class="tablex" border="0" width="100%">
								<tr>
									<td><input type="text" class="form-control num" size=4 disabled></td>
									<td>Tahun</td>

									<td><input type="text" name="k_lahir_bulan" class="form-control num" value="3" size=4 readonly></td>
									<td>Bulan</td>

									<td><input type="text" name="k_lahir_hari" class="form-control num" size=4 value="0" readonly></td>
									<td>Hari</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>Cuti Alasan Penting</td>
						<td class="text-center" width="2%"> : </td>
						<td>
							<table class="tablex" border="0" width="100%">
								<tr>
									<td><input type="text" class="form-control num" size=4 disabled></td>
									<td>Tahun</td>

									<td><input type="text" name="k_penting_bulan" class="form-control num" size=4></td>
									<td>Bulan</td>

									<td><input type="text" name="k_penting_hari" class="form-control num" size=4 ></td>
									<td>Hari</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>Cuti Diluar Tanggungan Negara</td>
						<td class="text-center" width="2%"> : </td>
						<td>
							<table class="tablex" border="0" width="100%">
								<tr>
									<td><input type="text" name="k_cltn_tahun" class="form-control num" size=4></td>
									<td>Tahun</td>

									<td><input type="text" name="k_cltn_bulan" class="form-control num" size=4></td>
									<td>Bulan</td>

									<td><input type="text" name="k_cltn_hari" class="form-control num" size=4 ></td>
									<td>Hari</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="3" class="text-right">
							<button class="btn btn-success form-penyesuaiankuota" type="submit"><i class='fa fa-floppy-o'></i> Simpan</button>
						</td>
					</tr>
				</table>
			</div>
		</div>

	</form>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$('select').select2();
		$('.num').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
				this.value = this.value.replace(/[^0-9\.]/g, '');}
			});

		$('.maxtahunan6').keyup(function () {
			if ($(this).val() > 6) {
				$(this).val(6);
			}
		});
		$('.maxtahunan12').keyup(function () {
			if ($(this).val() > 12) {
				$(this).val(12);
			}
		});


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

		$('.form-penyesuaiankuota').on('submit',function(e){
			var $this = $(this);
			e.preventDefault();
			bootbox.confirm('Simpan data?',function(a){
				if (a == true){
					$.ajax({
                       url: '{{url()}}/ecuti/nominatifcuti/penyesuaiankuota', //ganti biar gag nabrak
                       type : 'POST',
                       data : $this.serialize(),
                       beforeSend: function(){
                       	preloader.on();
                       },
                       success:function(html){
                       	preloader.off();
                       	if(html=='1'){
                       		notification('Berhasil Disimpan','success');
                       		$(".adariwayat{!!$nomike!!}").fadeIn();
                       		$(".belumriwayat{!!$nomike!!}").fadeOut();
                       		claravel_modal_close('main_modal');
                       		// refresh_page();
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