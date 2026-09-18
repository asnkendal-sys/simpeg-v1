<p class="text-center">
    <b>
        Daftar Detail Sisa Kuota Cuti
        <br>
        {!! $data['nip'] !!} - {!! $data['nama'] !!} 
    </b>
</p>
<table class='table table-striped table-hover table-condensed table-bordered' width="100%">
    <thead class='bg-primary'>
        <tr>
            <th class='text-center' style="vertical-align: middle;" width="40%">Jenis Cuti</th>
            <th class='text-center' style="vertical-align: middle;">Tahun {!!date('Y')-2!!}  (N-2)</th>
            <th class='text-center' style="vertical-align: middle;">Tahun {!!date('Y')-1!!}  (N-1)</th>
            <th class='text-center' style="vertical-align: middle;">Tahun {!!date('Y')!!}  (N)</th>
            <th class='text-center' style="vertical-align: middle;">Total</th>
        </tr>
    </thead>
    <?php 
    $rs  = \DB::table('a_jenis_cuti')->orderBy('id','asc')->get();
    $rs2 = \DB::table('view_kuota_cuti')->where('nip',$data['nip'])->first();
    $pgw = getDetailpegawai($data['nip']);
    ?>
    @if($rs2)
    @foreach($rs as $no => $item)
    <tr>
        <td>{!! $item->jenis_cuti !!}</td>
        <td class="text-center" style="vertical-align: middle;">
            <?php
            if ($item->id == 1) {
                echo $rs2->kuota_tahunan_n2;
            }
            ?>
        </td>
        <td class="text-center" style="vertical-align: middle;">
            <?php
            if ($item->id == 1) {
                echo $rs2->kuota_tahunan_n1;
            }
            ?>
        </td>
        <td class="text-center" style="vertical-align: middle;">
            <?php 
            if ($item->id == 1) {
                echo $rs2->kuota_tahunan_n;
            }elseif ($item->id == 2) {
                echo number_format($rs2->kuota_besar,0);
            }elseif ($item->id == 3) {
                echo number_format($rs2->kuota_sakit,0);
            }elseif ($item->id == 4) {
                echo (($pgw->idjenkel=="2")?number_format($rs2->kuota_melahirkan,0):"0");
            }elseif ($item->id == 5) {
                echo number_format($rs2->kuota_penting,0);
            }elseif ($item->id == 6) {
                echo number_format($rs2->kuota_diluarnegara,0);
            }
            ?>
        </td>
        <td class="text-center" style="vertical-align: middle;">
            <?php
            if ($item->id == 1) {
                echo ($rs2->kuota_tahunan_n2+$rs2->kuota_tahunan_n1+$rs2->kuota_tahunan_n);
            }elseif ($item->id == 2) {
                echo number_format($rs2->kuota_besar,0);
            }elseif ($item->id == 3) {
                echo number_format($rs2->kuota_sakit,0);
            }elseif ($item->id == 4) {
                echo (($pgw->idjenkel=="2")?number_format($rs2->kuota_melahirkan,0):"0");
            }elseif ($item->id == 5) {
                echo number_format($rs2->kuota_penting,0);
            }elseif ($item->id == 6) {
                echo number_format($rs2->kuota_diluarnegara,0);
            }
            ?>
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <th class='text-center' style="vertical-align: middle;" colspan="4">Belum ada riwayat cuti</th>
    </tr>
    @endif
</table>
<b>Keterangan : </b> <br>
<table class="table table-striped table-hover table-condensed table-bordered">
    <tr>
        <td width="30%">N-2</td>
        <td class="text-center" widht="1%">:</td>
        <td>Sisa Cuti 2(Dua) Tahun Sebelumnya</td>
    </tr>
    <tr>
        <td width="30%">N-1</td>
        <td class="text-center" widht="1%">:</td>
        <td>Sisa Cuti 1(Satu) Tahun Sebelumnya</td>
    </tr>
    <tr>
        <td width="30%">N</td>
        <td class="text-center" widht="1%">:</td>
        <td>Sisa Cuti Tahun Berjalan</td>
    </tr>
    <tr>
        <td colspan="3">*Sisa Kuota Di Hitung Berdasarkan Hari</td>
    </tr>
</table>