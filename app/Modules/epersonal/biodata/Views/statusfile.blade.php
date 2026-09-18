<?php
	$data = \DB::connection('efile_2017')->table('kategori_jenis AS a')
        ->select(\DB::raw('SUM(CASE WHEN b.id != "" AND b.nip = ' . $nip . ' AND b.riwayat_flag = 0 THEN 1 ELSE 0 END) AS jmlfile'), \DB::raw('SUM(CASE WHEN b.id != "" AND b.nip = ' . $nip . ' AND b.riwayat_flag = 0 AND b.verified = 1 THEN 1 ELSE 0 END) as jmlverified'), 'a.parent AS jenis', 'a.id AS subjenis', 'b.subsubjenis', 'a.nama', 'a.level','c.nama AS parent')
        ->leftjoin('files AS b', 'b.subjenis', '=', 'a.id')
        ->join('kategori_jenis AS c','c.id','=','a.parent')
        ->where('a.level', '=', 2)
        ->groupby('a.id')
        ->get();
?>
<table class="table table-responsive table-hover table-bordered">
	<tr>
		<td>No</td>
		<td>Jenis Dokumen</td>
		<td>Status</td>
	</tr>
	<?php
		$no=1;
	?>
	@foreach($data as $row)
	<tr>
		<td>{{$no}}</td>
		<td>{{$row->parent}} - {{$row->nama}}</td>
		<td>{{$row->jmlfile == 0 ? 'Tidak Ada' : 'Ada'}}</td>
	</tr>
	<?php
		$no++;
	?>
	@endforeach
</table>