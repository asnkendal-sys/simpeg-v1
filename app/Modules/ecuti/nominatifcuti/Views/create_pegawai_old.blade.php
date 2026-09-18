<style>table.tb td{padding:5px;}.grad {-moz-box-shadow: inset 0 0 50px #888;-webkit-box-shadow: inset 0 0 50px#888;box-shadow: inner 0 0 50px #888;}.kedip {animation: blinker 1s linear infinite;}@keyframes blinker {50% {opacity: 0;}}</style>
<?php
$nip 	= \Session::get('user_id');
$item 	= \DB::table('tb_01 as a')
->select(
	'a.nip','a.idjenjab','a.idskpd','a.idjenjab',
	\DB::raw('a.hp as telepon'),
	'v.*',
	'a.alm','a.almrt','a.almrw','a.almdesa','a.almkec','a.almkab','a.almprov','a.almkdpos','a.photo','b.jab',
	'a.idgolrupkt',
	'b.skpd','a_golruang.golru','a_golruang.pangkat',
	\DB::raw('IF(LENGTH(a.alm)>0,CONCAT(a.alm,", ",a.almdesa,", ",a.almkec,", ",a.almprov,", ",a.almkdpos),"") AS alamat'),
	\DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
	\DB::raw('IF(a.idjenjab>4,b.idskpd,IF(a.idjenjab=2,c.idjabfung,IF(a.idjenjab=3,d.idjabfungum,IF(a.idjenjab=4,e.idjabnonjob,"-")))) as idjab'),
	\DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap'),

	\DB::raw("CONCAT(IF((LEFT(a.idgolrupkt,1) != LEFT(idgolrucpn,1)),(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0,1,(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0)-2))-(IF((LEFT(a.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - a.mkthncpn,IF((LEFT(a.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - a.mkthncpn,IF((LEFT(a.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - a.mkthncpn, 0 ))))),(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0,1,(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0)-2))+ a.mkthncpn)),RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0, 2)) AS mkskr"),
	\DB::raw("
		FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(a.tmtcpn, '%Y%m')) / 12) AS thn_cpns, 
		PERIOD_DIFF(DATE_FORMAT(DATE_ADD((CASE WHEN DAY(NOW()) >= DAY(a.tmtcpn) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), INTERVAL -(FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(a.tmtcpn, '%Y%m')) / 12)) YEAR), '%Y%m'), DATE_FORMAT(a.tmtcpn, '%Y%m')) AS bln_cpns,
		DATEDIFF(NOW(), a.tmtcpn) - DATEDIFF(DATE_ADD(CONVERT(CONCAT(DATE_FORMAT((CASE WHEN DAY(NOW()) >= DAY(a.tmtcpn) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), '%Y-%m-'), RIGHT('0' + DAY(a.tmtcpn), 2)), DATE), INTERVAL -1 DAY), a.tmtcpn) AS hari_cpns")
)
->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
->leftjoin('a_golruang', 'a.idgolrupkt', '=', 'a_golruang.idgolru')
->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
->leftjoin('view_kuota_cuti as v','a.nip','=','v.nip')
->where('a.nip', $nip)
->first();
?>
<section class="content-header">
	<h1>
		Buat Usulan Cuti Baru<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="{!!url()!!}"> Dashboard</a></li>
		<li><a href="#" id="back"> Nominatifcuti</a></li>
		<li class="active">Buat Nominatif Cuti Baru</li>
	</ol>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="row">
			<div class="col-md-12">
				<!-- <div class="callout callout-success">
					<h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
					<ul style="padding-left: 15px">
						<li>Isiakan tanggal usulan</li>
						<li>Ketikkan Nama / Nip Pegawai yang akan diusulkan cuti</li>
						<li>Isikan antribut usulan cuti pada form pegawai yang diusulkan</li>
						<li>Periksa biodata dengan seksama. Jika menemukan adanya kesalahan harap lakukan perubahan melalui menu E-Personal</li>
						<li>Isian Nominatif dapat lebih dari 1 orang</li>
						<li>Klik tombol simpan untuk menyimpan usulan</li>
					</ul>
				</div> -->
				{!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-nominatifpegawai form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
				<!-- Deretan Input Type Hidden -->
				<input type="hidden" name="nip" class="form-control" value="{!! $nip !!}">
				<input type="hidden" name="nama" class="form-control" value="{!! $item->namalengkap !!}">
				<input type="hidden" name="idskpd" class="form-control" value="{!! $item->idskpd !!}">
				<input type="hidden" name="skpd" class="form-control" value="{!! $item->skpd !!}">
				<input type="hidden" name="idjenjab" class="form-control" value="{!! $item->idjenjab !!}">
				<input type="hidden" name="idjab" class="form-control" value="{!! $item->idjab !!}">
				<input type="hidden" name="jab" class="form-control" value="{!! $item->jabatan !!}">
				<input type="hidden" name="msk_thn" value="{!!substr($item->mkskr,0,-2)!!}">
				<input type="hidden" name="msk_bln" value="{!!substr($item->mkskr,-2)!!}">

				<input type="hidden" name="mscpn_thn" value="{!!$item->thn_cpns!!}">
				<input type="hidden" name="mscpn_bln" value="{!!$item->bln_cpns!!}">
				<input type="hidden" name="mscpn_hari" value="{!!$item->hari_cpns!!}">

				<div class="col-md-4">
					<div class="box-header">
						<h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA</h3>
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
										<span class="nama">{!! $item->namalengkap !!}</span>
									</td>
								</tr>
								<tr>
									<td width="15%">JABATAN</td>
									<td class="text-center" width="2%"> : </td>
									<td width="38%">
										
										<span class="jab">{!! $item->jabatan !!}</span>
									</td>
								</tr>
								<tr>
									<td width="15%">MASA KERJA</td>
									<td class="text-center" width="2%"> : </td>
									<td width="38%">
										<!-- <span class="masa_kerja">{!!substr($item->mkskr,0,-2)!!} Tahun - {!!ltrim(substr($item->mkskr,-2),'0')!!} Bulan</span> -->
										<span class="masa_kerja">{!!$item->thn_cpns!!} Tahun - 
											{!!$item->bln_cpns!!} Bulan -
											{!!$item->hari_cpns!!} Hari</span>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="box-header">
							<h3 class="box-title"><i class="fa fa-fw fa-info-circle"></i> INFORMASI KUOTA CUTI TAHUN {!! date('Y') !!}</h3>
							<a href="javascript:void(0)" class="text-info detail_cuti" style="float: right;" title="Tekan Untuk Melihat Detail"><i class="fa fa-eye">&nbsp;Detail</i></a>
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

					<div class="col-md-12">
						<div class="box-header">
							<h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT USULAN CUTI </h3>
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
												<!-- <input type="text" id="nousul" name="nousul" value="" class="form-control nousul" readonly> -->
												<input type="text" name="" value="Automatis" class="form-control" disabled>
											</td>
										</tr>
										<tr>
											<td width="25%">Tanggal Usulan</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<div class='input-group datepicker'>
													<input name="tgl_usul" id="tgl_usul" maxlength="10" class="date form-control tgl_usul" placeholder="dd-mm-yyyy" type="text" required>
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</td>
										</tr>
										<tr class="adariwayat">
											<td width="25%">Jenis Cuti</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												{!!comboJenisCuti('id_jenis_cuti')!!}
											</td>
										</tr>
										<tr class="belumriwayat">
											<td width="25%">Jenis Cuti</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<button title="Tekan Untuk isi Kuota" 
												recnip="{!! $item->nip !!}"
												recnama="{!! $item->namalengkap !!}"
												class="btn btn-info form-control penykuota" href="javascript:void(0)">( Tekan Menyesuaiakan Kuota Cuti )</button>
											</td>
										</tr>
										<tr>
											<td width="25%">Alasan Cuti</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<textarea name="alasan" class="form-control alasan" id="alasan" rows="1" required></textarea>
											</td>
										</tr>
										<tr>
											<td width="25%">Alamat Selama Cuti</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<textarea name="alamat_cuti" class="form-control alamat" id="alamat" rows="1" required>{!!$item->alm!!} {!! ($item->almrt!='')? 'RT. '.$item->almrt.'':'' !!} {!! ($item->almrt!='' && $item->almrw!='' )? '/':'' !!} {!! ($item->almrw!='')? 'RW. '.$item->almrw.'':'' !!}, {!! ($item->almdesa!='')? 'Desa/Kel. '.$item->almdesa.'':'' !!} {!! ($item->almkec!='')? 'Kec. '.$item->almkec.'':'' !!} {!! ($item->almkab!='')? 'Kab/Kota. '.$item->almkab.'':'' !!},  {!! ($item->almprov!='')? 'Prov. '.$item->almprov.'':'' !!}, {!! ($item->almkdpos!='')? 'Kode Pos.'.$item->almkdpos.'':'' !!}</textarea>
											</td>
										</tr>
										<tr>
											<td width="25%">No. Telepon</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<input type="text" name="telepon" class="form-control telepon" value="{!!$item->telepon!!}" required><em>*Pastikan Nomor Yang Dapat Di Hubungi</em>
											</td>
										</tr>
									</table>
								</div>
								<div class="col-md-6" style="margin-left: -10px;">
									<table class="table table-hovered table-stripped" width="100%">
										<tr>
											<td width="25%">Sisa Kuota</td>
											<td class="text-center" width="2%"> : </td>
											<td colspan="3" class="box_kuota_cuti">
												<div class="input-group">
													<input type="text" name="" class="form-control kuota_cuti" disabled>
													<span class="input-group-addon">
														Hari
													</span>
												</div>
											</td>
										</tr>
										<tr>
											<td width="25%">Tanggal Mulai</td>
											<td class="text-center" width="2%"> : </td>
											<td>
												<div class="input-group tgldinamis datepicker1">
													<input name="tgl_mulai" maxlength="10" class="date tglreset form-control tgl_mulai" placeholder="dd-mm-yyyy" type="text" required>
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
													<input name="tgl_selesai" maxlength="10" class="date tglreset form-control tgl_selesai" placeholder="dd-mm-yyyy" type="text" required>
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
															<input type="hidden" name="lama_cuti" class="form-control jml_hari_kerja"><em>*Hari Kerja</em></td>
															<td class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_sabtu" class="form-control jml_hari_sabtu" disabled><em>*Hari Sabtu</em></td>
															<td class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_minggu" class="form-control jml_hari_minggu" disabled><em>*Hari Minggu</em></td>
															<td width="33%" class="text-center" style="vertical-align: middle;"><input type="text" name="jml_hari_libur" class="form-control jml_hari_libur" disabled><em>*Hari Libur Nasional</em></td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</div>
									<div class="box-footer">
										<div class="form-group">
											<div class="col-sm-offset-9 col-sm-7">
												{!! ClaravelHelpers::btnSave() !!}
												&nbsp;
												&nbsp;
												{!! ClaravelHelpers::btnCancel() !!}
											</div>
										</div> 
									</div>
								</div>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</section>

				<script>
					var kuota_cuti = "";
					function refresh_page(){
						<?php
						$index_page = explode('/', \Request::path());
						$jum = count($index_page) -1;
						unset ($index_page[$jum]);
						$index = join('/', $index_page);
						echo 'var index_page=laravel_base + "/'.$index.'";';
						?>
						$.ajax({
							url : index_page,
							type : 'GET',
							beforeSend: function(){
								preloader.on();
							},
							success:function(html){
								preloader.off();
								$('#utama').html(html);
							}
						}); 
					}
					$(document).ready(function(){
						var xedit = "0";
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
							if ($(".tgl_mulai").val() != "") {
								$(".datepicker2").data("DateTimePicker").minDate($(".tgl_mulai").val());
							}
						});
						/*end*/
						$(".date").mask("99-99-9999");
						var checkRiwayat = "{!! CheckAdaDiRiwayatCuti($item->nip) !!}";
			// alert(checkRiwayat)
			if (checkRiwayat != 0) {
				$(".adariwayat").show();
				$(".belumriwayat").hide();
			}else{
				$(".adariwayat").hide();
				$(".belumriwayat").show();
			}
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
			/*get maksimal kuota cuti pegawai terpilih pada list nominatif */
			$(".id_jenis_cuti").on('change', function(e){
				e.preventDefault();
				var id = $(".id_jenis_cuti").val();
				if (id != '') {
					$.ajax({
						url: '{{url()}}/ecuti/nominatifcuti/cekkuotafinal',
						type: 'post',
						data: { 'id_jenis_cuti': id,'nip':"{!! $nip !!}",'tgl_mulai':0,'_token':'{!!csrf_token()!!}'},
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

							$(".tgl_mulai").val("");
							$(".tgl_selesai").val("");
							$(".kuota_cuti").val(kuota_cuti);
						}
					});
				}
			}).trigger('change');
			/*end*/
			$('.detail_cuti').on('click',function(e){
				e.preventDefault();
				$.ajax({
					url: '{{url()}}/ecuti/nominatifcuti/detailcuti',
					type: 'post',
					data: {'nip': "{!! $nip !!}",'_token':'{!!csrf_token()!!}'},
					success:function(html){
						bootbox.alert(html);
					}
				});
			});

			$('#batalkan,#back').on('click',function(e){
				e.preventDefault();
				refresh_page();
			});
			$('.form-nominatifpegawai').on('submit',function(e){
				var $this = $(this);
				e.preventDefault();
				bootbox.confirm('Simpan data?',function(a){
					if (a == true){
						if ($(".unvalid")[0]){
							bootbox.alert("<center><b>.: PERHATIAN :.</b> <br>Periksa Ulang Usulan Nominatif Cuti <i class='glyphicon glyphicon-exclamation-sign kedip' style='color:red;' title='Tidak Dapat Disimpan'></i></center>");
						}else{
							$.ajax({
								url: '{{url()}}/ecuti/nominatifcuti/simpandaripegawai',
								type : 'POST',
								data : $this.serialize(),
								beforeSend: function(){
									preloader.on();
								},
								success:function(html){
									preloader.off();
									if(html=='1'){
										notification('Berhasil Disimpan','success');
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
				if(tgl_mulai!="" && tgl_selesai!=""){
					$.ajax({
						url  : '{!!url()!!}/ecuti/nominatifcuti/hitungharikerja',
						type : 'POST',
						data: {'nip':"{!! $nip !!}", 'tgl_mulai': tgl_mulai,'tgl_selesai': tgl_selesai, '_token' : '{!!csrf_token()!!}'},
						success:function(response){
							var ret = $.parseJSON(response);
							var jml_hari_cuti = ret.jml_hari_kerja;
							sisacuti = kuota_cuti - jml_hari_cuti;
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
					url: '{{url()}}/ecuti/nominatifcuti/cekkuotafinal',
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
			/*On CLick Penyesuaian Kuota*/
			$('.penykuota').on('click', function(e){
				e.preventDefault();
				claravel_modal('Penyesuaian Kuota Cuti dan Hari Kerja','Loading...','main_modal');
				$.ajax({
					type:'post',
					url : '{!!url()!!}/ecuti/nominatifcuti/modal/penyesuaiankuota',
					data: {'nip': $(this).attr('recnip'), 'nama': $(this).attr('recnama'), 'nomor':"", '_token' : '{!!csrf_token()!!}'},
					success:function(html){
						$('#main_modal .modal-body').html(html);
						autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
					}
				});
			});
		});
	</script>
