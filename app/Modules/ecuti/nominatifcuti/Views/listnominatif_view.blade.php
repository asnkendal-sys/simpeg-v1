<style>
	table.tb td {
		padding: 5px;
	}

	.grad {
		-moz-box-shadow: inset 0 0 50px #888;
		-webkit-box-shadow: inset 0 0 50px#888;
		box-shadow: inner 0 0 50px #888;
	}

	.kedip {
		animation: blinker 1s linear infinite;
	}

	@keyframes blinker {
		50% {
			opacity: 0;
		}
	}
</style>
<?php
$nip 	= Input::get('nip');
$item 	= \DB::table('tb_01 as a')
	->select(
		'a.nip',
		'a.idjenjab',
		'a.idskpd',
		'a.idjenjab',
		'a.idstspeg',
		\DB::raw('a.hp as telepon'),
		'a.alm',
		'a.almrt',
		'a.almrw',
		'a.almdesa',
		'a.almkec',
		'a.almkab',
		'a.almprov',
		'a.almkdpos',
		'a.photo',
		'b.jab',
		'a.idgolrupkt',
		'b.skpd',
		'a_golruang.golru',
		'a_golruang.pangkat',
		'c.idjabfung',
		\DB::raw('IF(LENGTH(a.alm)>0,CONCAT(a.alm,", ",a.almdesa,", ",a.almkec,", ",a.almprov,", ",a.almkdpos),"") AS alamat'),
		\DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
		\DB::raw('IF(a.idjenjab>4,b.idskpd,IF(a.idjenjab=2,c.idjabfung,IF(a.idjenjab=3,d.idjabfungum,IF(a.idjenjab=4,e.idjabnonjob,"-")))) as idjab'),
		\DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap'),

		\DB::raw("CONCAT(IF((LEFT(a.idgolrupkt,1) != LEFT(idgolrucpn,1)),(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0,1,(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0)-2))-(IF((LEFT(a.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - a.mkthncpn,IF((LEFT(a.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - a.mkthncpn,IF((LEFT(a.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - a.mkthncpn, 0 ))))),(SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0,1,(LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0)-2))+ a.mkthncpn)),RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(a.tmtcpn='0000-00-00',a.tmtpns,a.tmtcpn))), '%Y%m')+0, 2)) AS mkskr"),
		\DB::raw("
		FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(if(a.idstspeg=3,if(a.tgskcalonawal_pppk='0000-00-00',NOW(),a.tgskcalonawal_pppk),a.tmtcpn), '%Y%m')) / 12) AS thn_cpns, 
		PERIOD_DIFF(DATE_FORMAT(DATE_ADD((CASE WHEN DAY(NOW()) >= DAY(if(a.idstspeg=3,if(a.tgskcalonawal_pppk='0000-00-00',NOW(),a.tgskcalonawal_pppk),a.tmtcpn)) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), INTERVAL -(FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(if(a.idstspeg=3,if(a.tgskcalonawal_pppk='0000-00-00',NOW(),a.tgskcalonawal_pppk),a.tmtcpn), '%Y%m')) / 12)) YEAR), '%Y%m'), DATE_FORMAT(if(a.idstspeg=3,if(a.tgskcalonawal_pppk='0000-00-00',NOW(),a.tgskcalonawal_pppk),a.tmtcpn), '%Y%m')) AS bln_cpns,
		DATEDIFF(NOW(), if(a.idstspeg=3,if(a.tgskcalonawal_pppk='0000-00-00',NOW(),a.tgskcalonawal_pppk),a.tmtcpn)) - DATEDIFF(DATE_ADD(CONVERT(CONCAT(DATE_FORMAT((CASE WHEN DAY(NOW()) >= DAY(if(a.idstspeg=3,if(a.tgskcalonawal_pppk='0000-00-00',NOW(),a.tgskcalonawal_pppk),a.tmtcpn)) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), '%Y-%m-'), RIGHT('0' + DAY(if(a.idstspeg=3,if(a.tgskcalonawal_pppk='0000-00-00',NOW(),a.tgskcalonawal_pppk),a.tmtcpn)), 2)), DATE), INTERVAL -1 DAY), if(a.idstspeg=3,if(a.tgskcalonawal_pppk='0000-00-00',NOW(),a.tgskcalonawal_pppk),a.tmtcpn)) AS hari_cpns")
	)
	->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
	->leftjoin('a_golruang', 'a.idgolrupkt', '=', 'a_golruang.idgolru')
	->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
	->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
	->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
	->where('a.nip', $nip)
	->first();
?>
@if(count($item) > 0)
<div class="nomi" id="{!!Input::get('nip')!!}" urutan="{!!Input::get('n')!!}">
	<table class="tb table-bordered" border="0" width="97%" style="margin-left: 15px;">
		<tbody>
			<tr>
				<td rowspan="2" align="center" width="5%">
					<?php
					if (file_exists("./packages/upload/photo/pegawai/" . $item->photo)) {
						$pict = $item->photo;
					} else {
						$pict = "default.jpg";
					}
					?>
					<div align="center"><img src="{!!url()!!}/packages/upload/photo/pegawai/{!!$pict!!}" width="100"></div>
				</td>
				<th width="20%">NIP <br> Nama Lengkap</th>
				<th>Gol. Ruang</th>
				<th>Jabatan</th>
				<th>Unit Kerja</th>
				<td style="vertical-align: middle;"><span class="pull-right"><a class="remove_item" style="color: red;" href="javascript:void(0)" title="Delete Nominatif"><i class="glyphicon glyphicon-trash"></i></a></span></td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name="{!!Input::get('n')!!}[nip]" class="nipnomi{!!Input::get('n')!!}" value="{!!Input::get('nip')!!}">
					<span id="ed1" style="display:none"><?= $item->nip ?></span>
					<a title="popdetil" class="detailriwayat{!!Input::get('n')!!}" recnip="{!! $item->nip !!}" recnama="{!! $item->namalengkap !!}" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a><br>
					{!!$item->namalengkap!!}
				</td>
				<td>{!!$item->golru!!}<br>{!!$item->pangkat!!}</td>
				<td>{!!$item->jabatan!!}</td>
				<!-- <td>{!!getSkpd($item->idskpd)!!}</td> -->
				<td>{!!$item->skpd!!}<br>
					<p style="border-style: dotted;"><b>&nbsp;Masa Kerja</b> :
						<!-- {!!$item->idstspeg!!}==3{mkthnakhir_pppk, mkblnakhir_pppk}  -->
						{!!$item->thn_cpns!!} Tahun -
						{!!$item->bln_cpns!!} Bulan -
						{!!$item->hari_cpns!!} Hari
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- START List Input type Hidden -->
	<input type="hidden" name="{!!Input::get('n')!!}[nama]" value="{!! $item->namalengkap !!}">
	<input type="hidden" name="{!!Input::get('n')!!}[idjenjab]" value="{!! $item->idjenjab !!}">
	<input type="hidden" name="{!!Input::get('n')!!}[idjab]" value="{!! $item->idjab !!}">
	<input type="hidden" name="{!!Input::get('n')!!}[jab]" value="{!! $item->jabatan !!}">
	<input type="hidden" name="{!!Input::get('n')!!}[idskpd]" value="{!! $item->idskpd !!}">
	<input type="hidden" name="{!!Input::get('n')!!}[skpd]" value="{!! $item->skpd !!}">
	<input type="hidden" name="{!!Input::get('n')!!}[msk_thn]" value="{!!substr($item->mkskr,0,-2)!!}">
	<input type="hidden" name="{!!Input::get('n')!!}[msk_bln]" value="{!!substr($item->mkskr,-2)!!}">

	<input type="hidden" name="{!!Input::get('n')!!}[mscpn_thn]" value="{!!$item->thn_cpns!!}">
	<input type="hidden" name="{!!Input::get('n')!!}[mscpn_bln]" value="{!!$item->bln_cpns!!}">
	<input type="hidden" name="{!!Input::get('n')!!}[mscpn_hari]" value="{!!$item->hari_cpns!!}">


	<!-- END List Input type Hidden -->
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT USULAN CUTI - <a title="popdetil" recnip="{!! $item->nip !!}" recnama="{!! $item->namalengkap !!}" class="detailriwayat{!!Input::get('n')!!}" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a> - {!!$item->namalengkap!!}</h3>
				<h3 class="box-title"><span class="tidak_valid{!!Input::get('n')!!}"></span></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="col-md-6" style="margin-left: -10px;">
					<table class="table table-hovered table-stripped" width="100%">
						<tr class="adariwayat{!!Input::get('n')!!}">
							<td width="25%">Jenis Cuti</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								{!!NominatifcutiModel::comboJenisCutiNominatif('[id_jenis_cuti]','','','id_jenis_cuti',Input::get('n'),$item->idstspeg,'','',$item->nip)!!}
							</td>
						</tr>
						<tr class="belumriwayat{!!Input::get('n')!!}">
							<td width="25%">Jenis Cuti</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<button title="Tekan Untuk isi Kuota xxxx" recnip="{!! $item->nip !!}" recnama="{!! $item->namalengkap !!}" class="btn btn-info form-control penykuota" href="javascript:void(0)">( Tekan Menyesuaiakan Kuota Cuti )</button>
							</td>
						</tr>
						<tr>
							<td width="25%">Alasan Cuti</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<textarea name="{!!Input::get('n')!!}[alasan]" class="form-control alasan{!!Input::get('n')!!}" rows="1" required></textarea>
							</td>
						</tr>
						<tr>
							<td width="25%">Alamat Selama Cuti</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<textarea name="{!!Input::get('n')!!}[alamat_cuti]" class="form-control alamat{!!Input::get('n')!!}" rows="1" required>{!!$item->alm!!} {!! ($item->almrt!='')? 'RT. '.$item->almrt.'':'' !!} {!! ($item->almrt!='' && $item->almrw!='' )? '/':'' !!} {!! ($item->almrw!='')? 'RW. '.$item->almrw.'':'' !!}, {!! ($item->almdesa!='')? 'Desa/Kel. '.$item->almdesa.'':'' !!} {!! ($item->almkec!='')? 'Kec. '.$item->almkec.'':'' !!} {!! ($item->almkab!='')? 'Kab/Kota. '.$item->almkab.'':'' !!},  {!! ($item->almprov!='')? 'Prov. '.$item->almprov.'':'' !!}, {!! ($item->almkdpos!='')? 'Kode Pos.'.$item->almkdpos.'':'' !!}</textarea>
							</td>
						</tr>
						<tr>
							<td width="25%">No. Telepon</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="{!!Input::get('n')!!}[telepon]" class="form-control telepon{!!Input::get('n')!!}" value="{!!$item->telepon!!}" required><em>*Pastikan Nomor Yang Dapat Di Hubungi</em>
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
									<input type="text" name="" class="form-control kuota_cuti{!!Input::get('n')!!}" disabled>
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
								<div class="input-group tgldinamis datepicker1{!!Input::get('n')!!}">
									<input name="{!!Input::get('n')!!}[tgl_mulai]" maxlength="10" class="date tglreset form-control tgl_mulai{!!Input::get('n')!!}" placeholder="dd-mm-yyyy" type="text" required>
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
								<div class="input-group datepicker2{!!Input::get('n')!!}">
									<input name="{!!Input::get('n')!!}[tgl_selesai]" maxlength="10" class="date tglreset form-control tgl_selesai{!!Input::get('n')!!}" placeholder="dd-mm-yyyy" type="text" required>
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
										<td class="text-center" style="vertical-align: middle;">
											<input type="text" class="form-control jml_hari_kerja{!!Input::get('n')!!}" disabled>
											<input type="hidden" name="{!!Input::get('n')!!}[lama_cuti]" class="form-control jml_hari_kerja{!!Input::get('n')!!}"><em>*Hari Kerja</em>
										</td>
										<td class="text-center" style="vertical-align: middle;"><input type="text" class="form-control jml_hari_sabtu{!!Input::get('n')!!}" disabled><em>*Hari Sabtu</em></td>
										<td class="text-center" style="vertical-align: middle;"><input type="text" class="form-control jml_hari_minggu{!!Input::get('n')!!}" disabled><em>*Hari Minggu</em></td>
										<td width="33%" class="text-center" style="vertical-align: middle;"><input type="text" class="form-control jml_hari_libur{!!Input::get('n')!!}" disabled><em>*Hari Libur Nasional</em></td>
										<input type="hidden" class="form-control sisacuti{!!Input::get('n')!!}" disabled>
									</tr>
								</table>
							</td>
						</tr>

					</table>
				</div>
			</div>
			<div class="box box-warning">
				<div class="box-footer with-border">
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$('.menuselect').select2();

		$(".datepicker{!!Input::get('n')!!}").datetimepicker({
			format: 'DD-MM-YYYY',
			locale: 'id',
			useCurrent: false
		});
		$(".datepicker1{!!Input::get('n')!!}").datetimepicker({
			format: 'DD-MM-YYYY',
			locale: 'id',
			useCurrent: false
		});

		$(".datepicker2{!!Input::get('n')!!}").datetimepicker({
			format: 'DD-MM-YYYY',
			locale: 'id',
			useCurrent: false
		});
		$(".datepicker1{!!Input::get('n')!!}").on("dp.change", function(e) {
			if ($(".tgl_mulai{!!Input::get('n')!!}").val() != "") {
				$(".datepicker2{!!Input::get('n')!!}").data("DateTimePicker").minDate($(".tgl_mulai{!!Input::get('n')!!}").val());
			}
		});

		var checkRiwayat = "{!! CheckAdaDiRiwayatCuti($item->nip) !!}";
		// alert(checkRiwayat)
		if (checkRiwayat != 0) {
			$(".adariwayat{!!Input::get('n')!!}").show();
			$(".belumriwayat{!!Input::get('n')!!}").hide();
		} else {
			$(".adariwayat{!!Input::get('n')!!}").hide();
			$(".belumriwayat{!!Input::get('n')!!}").show();
		}
		$(".detailriwayat{!!Input::get('n')!!}").on('click', function(e) {
			e.preventDefault();
			$.ajax({
				url: '{{url()}}/ecuti/nominatifcuti/detailcuti',
				type: 'post',
				data: {
					'nip': $(this).attr('recnip'),
					'nama': $(this).attr('recnama'),
					'_token': '{!!csrf_token()!!}'
				},
				success: function(html) {
					bootbox.alert(html);
				}
			});
		});

		/*get maksimal kuota cuti pegawai terpilih pada list nominatif */
		$(".id_jenis_cuti{!!Input::get('n')!!}").on('change', function(e) {
			e.preventDefault();
			var id = $(".id_jenis_cuti{!!Input::get('n')!!}").val();
			if (id != '') {
				$.ajax({
					url: '{{url()}}/ecuti/nominatifcuti/cekkuotafinal',
					type: 'post',
					data: {
						'id_jenis_cuti': id,
						'nip': $(".nipnomi{!!Input::get('n')!!}").val(),
						'tgl_mulai': 0,
						'_token': '{!!csrf_token()!!}'
					},
					beforeSend: function() {
						preloader.on();
						$(".kuota_cuti{!!Input::get('n')!!}").val("Loading....");
						$(".tgl_mulai{!!Input::get('n')!!}").val("Loading....");
						$(".tgl_selesai{!!Input::get('n')!!}").val("Loading....");
						// loadingnyareza('box_kuota_cuti');
					},
					success: function(response) {
						preloader.off();
						var ret = $.parseJSON(response);
						kuota_cuti = ret.kuota_cuti;
						if (ret.notif == 1) {
							bootbox.alert(ret.feedback);

							$(".tidak_valid{!!Input::get('n')!!}").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i>");
						
							// $(".tidak_valid{!!Input::get('n')!!}").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i><audio controls autoplay style='display:none;'><source src='{!!url()!!}/packages/tugumuda/mp3/danger.mp3' type='audio/ogg'><source src='{!!url()!!}/packages/tugumuda/mp3/danger.mp3' type='audio/mpeg'>Your browser does not support the audio element.</audio>");
						} else {
							$(".tidak_valid{!!Input::get('n')!!}").html("");
						}
						if (ret.dis_mulai == 1) {
							$(".id_jenis_cuti{!!Input::get('n')!!}").val('').trigger('change');
							$(".tgl_mulai{!!Input::get('n')!!}").attr('disabled', 'disabled');
						} else {
							$(".tgl_mulai{!!Input::get('n')!!}").removeAttr("disabled", "disabled");
						}
						if (ret.dis_selesai == 1) {
							$(".tidak_valid{!!Input::get('n')!!}").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i>");
							$(".tgl_selesai{!!Input::get('n')!!}").attr('disabled', 'disabled');
						} else {
							$(".tgl_selesai{!!Input::get('n')!!}").removeAttr("disabled", "disabled");
						}
						if (ret.dis_mulai == 1 || ret.dis_selesai == 1) {
							$(".tidak_valid{!!Input::get('n')!!}").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i>");
						} else {
							$(".tidak_valid{!!Input::get('n')!!}").html("");
						}

						$(".tgl_mulai{!!Input::get('n')!!}").val("");
						$(".tgl_selesai{!!Input::get('n')!!}").val("");
						$(".kuota_cuti{!!Input::get('n')!!}").val(kuota_cuti);
					}
				});
			}
		}).trigger('change');
		/*end*/


		/*Function untuk mengambil tanggal mulai dan selesai lalu ditung detailnya*/
		$(".datepicker1{!!Input::get('n')!!}, .datepicker2{!!Input::get('n')!!}").on('dp.change', function(e) {
			e.preventDefault();
			var tgl_mulai = $(".tgl_mulai{!!Input::get('n')!!}").val();
			var tgl_selesai = $(".tgl_selesai{!!Input::get('n')!!}").val();
			if (tgl_mulai != "" && tgl_selesai != "") {
				$.ajax({
					url: '{!!url()!!}/ecuti/nominatifcuti/hitungharikerja',
					type: 'POST',
					data: {
						'nip': "{!! $nip !!}",
						'tgl_mulai': tgl_mulai,
						'tgl_selesai': tgl_selesai,
						'_token': '{!!csrf_token()!!}'
					},
					success: function(response) {
						var ret = $.parseJSON(response);
						var jml_hari_cuti = ret.jml_hari_kerja;
						sisacuti = kuota_cuti - jml_hari_cuti;
						if (sisacuti < 0 && sisacuti != "") {
							bootbox.alert("Mohon Maaf Kuota Tidak Mencukupi, Periksa Ulang Sisa Kuota Anda");
							$(".tgl_selesai{!!Input::get('n')!!}").val('');
							$(".sisacuti{!!Input::get('n')!!}").val('');
							$(".jml_hari_kerja{!!Input::get('n')!!}").val('');
							$(".jml_hari_sabtu{!!Input::get('n')!!}").val('');
							$(".jml_hari_minggu{!!Input::get('n')!!}").val('');
							$(".jml_hari_libur{!!Input::get('n')!!}").val('');
						} else {
							$(".jml_hari_kerja{!!Input::get('n')!!}").val(jml_hari_cuti);
							$(".jml_hari_sabtu{!!Input::get('n')!!}").val(ret.jml_hari_sabtu);
							$(".jml_hari_minggu{!!Input::get('n')!!}").val(ret.jml_hari_minggu);
							$(".jml_hari_libur{!!Input::get('n')!!}").val(ret.jml_hari_libur);
							$(".sisacuti{!!Input::get('n')!!}").val(sisacuti);
						}

					}
				});
			}
		}).trigger('dp.change');
		/*END*/
		/*get maksimal kuota cuti pegawai terpilih pada list nominatif*/
		$(".datepicker1{!!Input::get('n')!!}").on('dp.change', function(e) {
			e.preventDefault();
			var tgl_mulai = $(".tgl_mulai{!!Input::get('n')!!}").val();
			var jencuti = $(".id_jenis_cuti{!!Input::get('n')!!}").val();
			$.ajax({
				url: '{{url()}}/ecuti/nominatifcuti/cekkuotafinal',
				type: 'post',
				data: {
					'nip': $(".nipnomi{!!Input::get('n')!!}").val(),
					'tgl_mulai': tgl_mulai,
					'id_jenis_cuti': $(".id_jenis_cuti{!!Input::get('n')!!}").val(),
					'_token': '{!!csrf_token()!!}'
				},
				success: function(response) {
					var ret = $.parseJSON(response);
					kuota_cuti = ret.kuota_cuti;
					$(".kuota_cuti{!!Input::get('n')!!}").val(kuota_cuti);
					if (ret.notif == 1) {
						bootbox.alert(ret.feedback);
						// candra tambahan
						$(".tgl_mulai{!!Input::get('n')!!}").val('');
						$(".tgl_selesai{!!Input::get('n')!!}").val('');
						// candra 
					}
					if (ret.dis_mulai == 1) {
						$(".tgl_mulai{!!Input::get('n')!!}").attr('disabled', 'disabled');
					} else {
						$(".tgl_mulai{!!Input::get('n')!!}").removeAttr("disabled", "disabled");
					}
					if (ret.dis_selesai == 1) {
						$(".tidak_valid{!!Input::get('n')!!}").html("<i class='glyphicon glyphicon-exclamation-sign kedip unvalid' style='color:red;' title='Tidak Dapat Disimpan'></i>");
						$(".tgl_selesai{!!Input::get('n')!!}").attr('disabled', 'disabled');
					} else {
						$(".tgl_selesai{!!Input::get('n')!!}").removeAttr("disabled", "disabled");
					}
				}
			});
		}).trigger('dp.change');
		/*end*/
		/*On CLick Penyesuaian Kuota*/
		$('.penykuota').on('click', function(e) {
			e.preventDefault();
			claravel_modal('Penyesuaian Kuota Cuti dan Hari Kerja', 'Loading...', 'main_modal');
			$.ajax({
				type: 'post',
				url: '{!!url()!!}/ecuti/nominatifcuti/modal/penyesuaiankuota',
				data: {
					'nip': $(this).attr('recnip'),
					'nama': $(this).attr('recnama'),
					'nomor': "{!!Input::get('n')!!}",
					'_token': '{!!csrf_token()!!}'
				},
				success: function(html) {
					$('#main_modal .modal-body').html(html);
					autoCompleteimg('#simpan .nip', '{{url()}}/epersonal/biodata/caripegawai', 'Ketikkan NIP atau Nama', null, '', '', '');
				}
			});
		});
	});
</script>

<!-- Dev Noted :
		PENTING !!!!
	Gunakan PETIK DOUBLE biar selaras
-->
@endif