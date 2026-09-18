<?php
$v = "<span style='color:green;'><i class='fa fa-check-circle' title='Memenuhi Syarat'/></span>";
$x = "<span style='color:red;'><i class='fa fa-times-circle' title='Tidak Memenuhi Syarat'/></span>";
?>
<p class='text-center'>

    <b>.: Perhatian :.
        <!-- <br>{!! \Input::get('nip') !!} - {!! \Input::get('nama') !!} -->
    </b>
</p>Berdasarkan <a href='{!!url()!!}/packages/upload/pdf/Peraturan-BKN-Nomor-24-Tahun-2017-tentang-tata-Cara-Pemberian-Cuti-PNS.pdf' target='_blank'> Peraturan BKN Nomor 24 Tahun 2017 tentang Tata Cara Pemberian Cuti Pegawai Negeri Sipil&nbsp;<i class='glyphicon glyphicon-new-window'></i></a> . Usulan cuti <b>di Luar Tanggungan Negara</b> tidak dapat dilanjukan karena : <br> 
<table class='table table-striped table-hover table-condensed table-bordered' width='100%'>
    <thead class='bg-primary'>
        <tr>
            <th class='text-center' style='vertical-align: middle;' width='3%'>NO</th>
            <th class='text-center' style='vertical-align: middle;'>KETERANGAN</th>
            <th class='text-center' style='vertical-align: middle;'>SYARAT</th>
            <th class='text-center' style='vertical-align: middle;'>KONDISI</th>
            <th class='text-center' style='vertical-align: middle;' width='3%'>STATUS</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Masa Kerja</td>
            <td>5 Tahun</td>
            <td>4 Tahun 5 Bulan 3 Hari</td>
            <td class='text-center' style='vertical-align: middle;'>{!! $v !!}</td>
        </tr>
    </tbody>
</table>
<b>Keterangan : </b> <br>
<table class='table table-striped table-hover table-condensed table-bordered'>
    <tr>
        <td width='3%'></td>
        <td>
            <li>Untuk kelahiran anak pertama sampai dengan kelahiran anak ketiga pada saat menjadi PNS berhak atas cuti melahirkan.</li>
            <li>Untuk kelahiran anak keempat dan seterusnya kepada PNS diberikan cuti besar.</li>
            <li>*Jika terdapat kesalahan hubungi admin atau update biodata melalui <b>E-Personal</b>.</li>
        </td>
    </tr>
</table>