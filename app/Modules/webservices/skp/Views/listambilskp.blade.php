<style>table.tb td{padding:5px;}.grad {-moz-box-shadow: inset 0 0 50px #888;-webkit-box-shadow: inset 0 0 50px#888;box-shadow: inner 0 0 50px #888;}.kedip {animation: blinker 1s linear infinite;}@keyframes blinker {50% {opacity: 0;}}</style>
<?php
$nip 	= Input::get('nip');
$item 	= \DB::table('tb_01 as a')
->select(
	'a.nip','a.idjenjab','a.idskpd','a.idjenjab','a.idsapk',
	'b.jab',
	'a.idgolrupkt',
	'b.skpd','a_golruang.golru','a_golruang.pangkat',
	\DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,IF(a.idjenjab=4,e.jabnonjob,"-")))) as jabatan'),
	\DB::raw('IF(a.idjenjab>4,b.idskpd,IF(a.idjenjab=2,c.idjabfung,IF(a.idjenjab=3,d.idjabfungum,IF(a.idjenjab=4,e.idjabnonjob,"-")))) as idjab'),
	\DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", "," "),a.gdb) as namalengkap')
  )
->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
->leftjoin('a_golruang', 'a.idgolrupkt', '=', 'a_golruang.idgolru')
->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
->leftjoin('a_jabnonjob as e', 'a.idjabnonjob', '=', 'e.idjabnonjob')
->where('a.nip', $nip)
->first();
?>
<div class="nomi" id="{!!Input::get('nip')!!}" >
	<table class="tb table-bordered" border="0" width="97%" style="margin-left: 15px;">
		<tbody>
			<tr>
				<th width="20%">NIP <br> Nama Lengkap</th>
				<th>Gol. Ruang</th>
				<th>Jabatan</th>
				<th>Unit Kerja</th>
				<td style="vertical-align: middle;"><span class="pull-right"><a class="remove_item" style="color: red;" href="javascript:void(0)" title="Delete Nominatif"><i class="glyphicon glyphicon-trash"></i></a></span></td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name="{!!Input::get('n')!!}[nip]" class="nipnomi{!!Input::get('n')!!}" value="{!!Input::get('nip')!!}">
					<span id="ed1" style="display:none"><?=$item->nip?></span>
					<a title="popdetil" class="detailriwayat{!!Input::get('n')!!}" recnip="{!! $item->nip !!}" recnama="{!! $item->namalengkap !!}" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a><br>
					{!!$item->namalengkap!!}
				</td>
				<td>{!!$item->golru!!}<br>{!!$item->pangkat!!}</td>
				<td>{!!$item->jabatan!!}</td>
				<!-- <td>{!!getSkpd($item->idskpd)!!}</td> -->
				<td>{!!$item->skpd!!}
				</td>
			</tr>
		</tbody>
	</table>
	<!-- START List Input type Hidden -->
	<input type="hidden" name="nip" value="{!! $item->nip !!}">
  <input type="hidden" name="idsapk" value="{!! $item->idsapk !!}">
 <input type="hidden" name="idskpd" value="{!! $item->idskpd !!}">
	<!-- END List Input type Hidden -->
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-fw fa-paper-plane"></i> ATRIBUT SKP BKN - <a title="popdetil" recnip="{!! $item->nip !!}" recnama="{!! $item->namalengkap !!}" class="detailriwayat{!!Input::get('n')!!}" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a> - {!!$item->namalengkap!!}</h3>
				<h3 class="box-title"><span class="tidak_valid{!!Input::get('n')!!}"></span></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="col-md-6" style="margin-left: -10px;">
					<table class="table table-hovered table-stripped" width="100%">


						<tr>
							<td width="25%">ID Skp</td>
							<td class="text-center" width="2%"> : </td>
							<td>
							    <input type="text" name="id_skp" class="form-control" value="{{$skp['id']}}" readonly>
							</td>
						</tr>
						<tr>
							<td width="25%">Nil Skp</td>
							<td class="text-center" width="2%"> : </td>
							<td>
                	<input type="text" name="nilaiSkp" class="form-control" value="{{$skp['nilaiSkp']}}" readonly>
							</td>
						</tr>
						<tr>
							<td width="25%">Orientasi Pelayanan</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="orientasiPelayanan" class="form-control" value="{{$skp['orientasiPelayanan']}}" readonly>
							</td>
						</tr>
            <tr>
							<td width="25%">Integritas</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="integritas" class="form-control" value="{{$skp['integritas']}}" readonly>
							</td>
						</tr>
            <tr>
							<td width="25%">Komitmen</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="komitmen" class="form-control" value="{{$skp['komitmen']}}" readonly>
							</td>
						</tr>
            <tr>
              <td width="25%">Disiplin</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="disiplin" class="form-control" value="{{$skp['disiplin']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Kerjasama</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="kerjasama" class="form-control" value="{{$skp['kerjasama']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Perilaku Kerja</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="nilaiPerilakuKerja" class="form-control" value="{{$skp['nilaiPerilakuKerja']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Prestasi Kerja</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="nilaiPrestasiKerja" class="form-control" value="{{$skp['nilaiPrestasiKerja']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Kepemimpinan</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="kepemimpinan" class="form-control" value="{{$skp['kepemimpinan']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Jumlah</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="jumlah" class="form-control" value="{{$skp['jumlah']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Rata-rata</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="nilairatarata" class="form-control" value="{{$skp['nilairatarata']}}" readonly>
              </td>
            </tr>
					</table>
				</div>
				<div class="col-md-6" style="margin-left: -10px;">
					<table class="table table-hovered table-stripped" width="100%">

            <tr>
              <td width="25%">Nip Penilai</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="penilaiNipNrp" class="form-control" value="{{$skp['penilaiNipNrp']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Nama Penilai</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="penilaiNama" class="form-control" value="{{$skp['penilaiNama']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Unit Kerja Penilai</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="penilaiUnorNama" class="form-control" value="{{$skp['penilaiUnorNama']}}" readonly>
              </td>
            </tr>


            <tr>
              <td width="25%">Jabatan Penilai</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="penilaiJabatan" class="form-control" value="{{$skp['penilaiJabatan']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Gol Penilai</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="penilaiGolongan" class="form-control" value="{{$skp['penilaiGolongan']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Tmt Gol Penilai</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="penilaiTmtGolongan" class="form-control" value="{{$skp['penilaiTmtGolongan']}}" readonly>
              </td>
            </tr>

            <tr>
              <td width="25%">Sts Penilai</td>
              <td class="text-center" width="2%"> : </td>
              <td>
                <input type="text" name="statusPenilai" class="form-control" value="{{$skp['statusPenilai']}}" readonly>
              </td>
            </tr>

						<tr>
							<td width="25%">Nip Ats Penilai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="atasanPenilaiNipNrp" class="form-control" value="{{$skp['penilaiNipNrp']}}" readonly>
							</td>
						</tr>

						<tr>
							<td width="25%">Nama  Ats Penilai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="atasanPenilaiNama" class="form-control" value="{{$skp['pejabatPenilaiNama']}}" readonly>
							</td>
						</tr>

						<tr>
							<td width="25%">Unit Kerja Ats Penilai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="atasanPenilaiUnorNama" class="form-control" value="{{$skp['penilaiUnorNama']}}" readonly>
							</td>
						</tr>


						<tr>
							<td width="25%">Jabatan Ats Penilai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="atasanPenilaiJabatan" class="form-control" value="{{$skp['penilaiJabatan']}}" readonly>
							</td>
						</tr>

						<tr>
							<td width="25%">Gol  Ats Penilai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="atasanPenilaiGolongan" class="form-control" value="{{$skp['penilaiGolongan']}}" readonly>
							</td>
						</tr>

						<tr>
							<td width="25%">Tmt Gol Ats Penilai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="atasanPenilaiTmtGolongan" class="form-control" value="{{$skp['penilaiTmtGolongan']}}" readonly>
							</td>
						</tr>

						<tr>
							<td width="25%">Sts Ats Penilai</td>
							<td class="text-center" width="2%"> : </td>
							<td>
								<input type="text" name="statusAtasanPenilai" class="form-control" value="{{$skp['statusPenilai']}}" readonly>
							</td>
						</tr>


					</div>
				</div>
				{{-- <div class="box box-warning">
					<div class="box-footer with-border">
					</div>
				</div> --}}
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){

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
			$(".datepicker1{!!Input::get('n')!!}").on("dp.change", function (e) {
				if ($(".tgl_mulai{!!Input::get('n')!!}").val() != "") {
					$(".datepicker2{!!Input::get('n')!!}").data("DateTimePicker").minDate($(".tgl_mulai{!!Input::get('n')!!}").val());
				}
			});




			/*END*/
			/*get maksimal kuota cuti pegawai terpilih pada list nominatif */

			/*end*/
			/*On CLick Penyesuaian Kuota*/
			$('.penykuota').on('click', function(e){
				e.preventDefault();
				claravel_modal('Penyesuaian Kuota Cuti dan Hari Kerja','Loading...','main_modal');
				$.ajax({
					type:'post',
					url : '{!!url()!!}/ecuti/nominatifcuti/modal/penyesuaiankuota',
					data: {'nip': $(this).attr('recnip'), 'nama': $(this).attr('recnama'), 'nomor':"{!!Input::get('n')!!}", '_token' : '{!!csrf_token()!!}'},
					success:function(html){
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
