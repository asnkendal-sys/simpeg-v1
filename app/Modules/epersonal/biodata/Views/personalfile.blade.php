<?php
	$data = \DB::connection('efile_2017')->table('kategori_jenis AS a')
        ->select(\DB::raw('SUM(CASE WHEN b.id != "" AND b.nip = ' . $nip . ' AND b.riwayat_flag = 0 THEN 1 ELSE 0 END) AS jmlfile'), \DB::raw('SUM(CASE WHEN b.id != "" AND b.nip = ' . $nip . ' AND b.riwayat_flag = 0 AND b.verified = 1 THEN 1 ELSE 0 END) as jmlverified'), 'a.parent AS jenis', 'a.id AS subjenis', 'b.subsubjenis', 'a.nama', 'a.level','c.nama AS parent')
        ->leftjoin('files AS b', 'b.subjenis', '=', 'a.id')
        ->join('kategori_jenis AS c','c.id','=','a.parent')
        ->where('a.level', '=', 2)
        ->groupby('a.id')
        ->orderBy('a.parent')
        ->get();
?>
<table class="table table-responsive table-bordered table-hover" id="tabel-personalfile">
	<tr>
		<td>
			No
		</td>
		<td>
			Jenis Dokumen
		</td>
		<td>
			Jumlah File
		</td>
<!--		<td>Verified</td>-->
		<td>
			Aksi
		</td>
	</tr>
	<?php
		$no=1;
	?>
	@foreach($data as $row)
	<tr>
		<td>{{$no}}</td>
		<td>{{$row->parent}} - {{$row->nama}}</td>
		<td>{{$row->jmlfile}}</td>
<!--		<td>{{$row->jmlverified}}</td>-->
		<td><a class="kelolafile" jenis="{{$row->jenis}}" subjenis="{{$row->subjenis}}" jns="{{$row->nama}}" role="button"><i class="fa fa-folder" aria-hidden="true"></i> Kelola File</a></td>
	</tr>
	<?php
		$no++;
	?>
	@endforeach
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabel-personalfile a.kelolafile').on('click',function(e){
            e.preventDefault();
            claravel_modal('Kelola  File Riwayat Pangkat','Loading...','kelola_file');
            var jenis = $(this).attr('jenis');
            var subjenis = $(this).attr('subjenis');
            var nama_jenis = $(this).attr('jns');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/epersonal/biodata/kelolafile',
                data: {'nip': '{{$nip}}', 'jenis': jenis, 'subjenis': subjenis, 'nama_jenis':nama_jenis, 'tb': 'r_gol', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#kelola_file .modal-body').html(html);
                }
            });
        });
	});
</script>