<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Keputusan Cuti</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <link rel="author" href="dinustek">

    <style type="text/css">
    div.print {
        background: url('{!!url()!!}/packages/tugumuda/images/print_icon.png') no-repeat;
        width: 110px;
        height: 110px;
        top: 20;
        right: 50;
        position: fixed;
        opacity: 0.1;
        cursor: pointer;
        right: 5px;
    }

    div.print:hover {
        opacity: 1;
    }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
    <!-- <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script> -->
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode.js"></script>
</head>

<body>
    <div class="print"></div>
    <?php
    date_default_timezone_set("Asia/Jakarta");

    $nousul = \Request::segment(5);
    $nip    = \Request::segment(6);
    $cekTemplate =  \DB::table('tr_ijin_cuti_template_sk')->whereRaw("jnssurat = '1.1' AND idskpd = '".substr(session('idskpd'),0,2)."' ")->first();
    if(count($cekTemplate) > 0){
        $template = TemplateskcutiModel::getTemplateCuti(substr(session('idskpd'),0,2), '1.1', 'template');
    }else{
        $template = TemplateskcutiModel::getTemplateCuti('all', '1.1', 'template');
    }
    $where = "";
    // $where = "(tr_ijin_cuti.atasan_status = 1 or tr_ijin_cuti.wewenang_status = 1)";
    $where .= "tr_ijin_cuti.nip =\"".$nip."\" and tr_ijin_cuti.nousul = \"".$nousul."\" AND view_kuota_cuti.nousul = \"".$nousul."\"";
    // $count = \DB::table("tr_ijin_cuti")->whereRaw($where)->count();


    $item   = \DB::table('tr_ijin_cuti')
    ->leftjoin('view_kuota_cuti','tr_ijin_cuti.nip','=','view_kuota_cuti.nip')
    ->whereRaw($where)->first();
    // dd($item);// exit();

    /*Jika ATASAN PLT / PLH*/
    if ($item->atasan_sts_plt==2) {
        $atasanjab = "PLT. ".$item->atasan_jab_plt.", ".((strlen($item->idskpd)>2)?getSkpd(substr($item->idskpd, 0,2)):'')." Kabupaten Kendal";
    }else if($item->atasan_sts_plt==3){
        $atasanjab = "PLH. ".$item->atasan_jab_plt.", ".((strlen($item->idskpd)>2)?getSkpd(substr($item->idskpd, 0,2)):'')." Kabupaten Kendal";
    }else{
        $atasanjab = $item->atasan_jab.", ".((strlen($item->idskpd)>2)?getSkpd(substr($item->idskpd, 0,2)):'')." Kabupaten Kendal";
    }

    if ($item->wewenang_sts_plt==2) {
        $jabkepada   = "PLT. ".((substr($item->wewenang_jab_plt,0,6)!="BUPATI")?$item->wewenang_jab_plt." Kabupaten Kendal":$item->wewenang_jab_plt." KENDAL");
        $wewenangjab = "PLT. ".((substr($item->wewenang_jab_plt,0,6)=="BUPATI")?$item->wewenang_jab_plt." KENDAL":$item->wewenang_jab_plt." Kabupaten Kendal");
    }else if($item->wewenang_sts_plt==3){
        $jabkepada   = "PLH. ".((substr($item->wewenang_jab_plt,0,6)!="BUPATI")?$item->wewenang_jab_plt." Kabupaten Kendal":$item->wewenang_jab_plt." KENDAL");
        $wewenangjab = "PLH. ".((substr($item->wewenang_jab_plt,0,6)=="BUPATI")?$item->wewenang_jab_plt." KENDAL":$item->wewenang_jab_plt." Kabupaten Kendal");
    }else{
        $jabkepada   = (substr($item->wewenang_jab,0,6)!="BUPATI")?$item->wewenang_jab." Kabupaten Kendal":$item->wewenang_jab." KENDAL";
        $wewenangjab = (substr($item->wewenang_jab,0,6)=="BUPATI")?$item->wewenang_jab." KENDAL":$item->wewenang_jab." Kabupaten Kendal";
    }


    if ($item->nosk_cuti == "") {
        $nosk = "................................"; 
    }else{
        $nosk = $item->nosk_cuti; 
    }
    if(count($item) < 0){
        echo "404 Not Found.<br>";
        echo "Daftar Cuti tidak tersedia.<br>";
        echo "Cek status berkas dan status SK.<br>";
        exit();
    }

    $i = 0;    
    $key = TemplateskcutiModel::rand_char();    
    $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />
    <span class='kode bolditalic'>".$key."</span>";

    $arrsearch = array("search",
        "[nosk]",
        "[tglsk_cuti]",
        "[tgl_usul]",
        "[nip_pemohon]",
        "[nama_pemohon]",
        "[jabatan_pemohon]",
        "[opd_pemohon]",
        "[masa_kerja_pemohon]",
        "[jenis_cuti_tahunan]","[jenis_cuti_besar]","[jenis_cuti_sakit]","[jenis_cuti_melahirkan]","[jenis_cuti_alasan_penting]","[jenis_cuti_diluar]",
        "[alasan_cuti]",
        "[lama_cuti]",
        "[tanggal_mulai]",
        "[tanggal_selesai]",

        "[sisa_n2]",
        "[sisa_n1]",
        "[sisa_n]",
        "[sisa_besar]",
        "[sisa_sakit]",
        "[sisa_lahir]",
        "[sisa_penting]",
        "[sisa_diluarnegara]",

        "[alamat_selama_cuti]",
        "[no_telp]",
        "[disetujui_atasan]",
        "[dirubah_atasan]","[ket_atasan_perubahan]",
        "[ditangguhkan_atasan]","[ket_atasan_ditangguhkan]",
        "[ditolak_atasan]","[ket_atasan_ditolak]",

        "[jab_atasan]","[nama_atasan]","[nip_atasan]",

        "[disetujui_wewenang]",
        "[dirubah_wewenang]","[ket_wewenang_perubahan]",
        "[ditangguhkan_wewenang]","[ket_wewenang_ditangguhkan]",
        "[ditolak_wewenang]","[ket_wewenang_ditolak]",

        "[jab_kepada]",
        "[jab_wewenang]",
        "[nama_wewenang]","[nip_wewenang]",


        "[qrcode]"
    );
    $arrreplace = array("replace",
        $nosk,
        formattanggalpanjang(($item->tglsk_cuti)!=""?$item->tglsk_cuti:date('Y-m-d')),
        formattanggalpanjang(($item->tgl_usul)!=""?$item->tgl_usul:date('Y-m-d')),
        $item->nip,
        $item->nama,
        $item->jab,
        // $item->skpd.", ".((strlen($item->idskpd)>2)?getSkpd(substr($item->idskpd, 0,2)):''),
        getSkpdUntukCuti($item->idskpd),

        // disesuaikan dengan masa kerja cpns
        $item->mscpn_thn." Tahun  ".ltrim($item->mscpn_bln,'0')." Bulan",
        // $item->msk_thn." Tahun  ".ltrim($item->msk_bln,'0')." Bulan",
        getCentangCuti($item->id_jenis_cuti,1),getCentangCuti($item->id_jenis_cuti,2),getCentangCuti($item->id_jenis_cuti,3),
        getCentangCuti($item->id_jenis_cuti,4),getCentangCuti($item->id_jenis_cuti,5),getCentangCuti($item->id_jenis_cuti,6),
        $item->alasan,
        getTanggalKuota($item->lama_cuti),
        formattanggalpanjang($item->tgl_mulai),
        formattanggalpanjang($item->tgl_selesai),
        getTanggalKuota($item->kuota_tahunan_n2),
        getTanggalKuota($item->kuota_tahunan_n1),
        getTanggalKuota($item->kuota_tahunan_n),
        // getTanggalKuota($item->kuota_besar),
        // getTanggalKuota($item->kuota_sakit),
        // getTanggalKuota($item->kuota_melahirkan),
        // getTanggalKuota($item->kuota_penting),
        // getTanggalKuota($item->kuota_diluarnegara),
        "",
        "",
        "",
        "",
        "",
        $item->alamat_cuti,
        $item->telepon,
        getCentangCuti($item->atasan_status,1),
        getCentangCuti($item->atasan_status,2),($item->atasan_status == 2)?$item->atasan_alasan:'',
        getCentangCuti($item->atasan_status,3),($item->atasan_status == 3)?$item->atasan_alasan:'',
        getCentangCuti($item->atasan_status,4),($item->atasan_status == 4)?$item->atasan_alasan:'',
        $atasanjab,
        $item->atasan_nama,$item->atasan_nip,
        getCentangCuti($item->wewenang_status,1),
        getCentangCuti($item->wewenang_status,2),($item->wewenang_status == 2)?$item->wewenang_alasan:'',
        getCentangCuti($item->wewenang_status,3),($item->wewenang_status == 3)?$item->wewenang_alasan:'',
        getCentangCuti($item->wewenang_status,4),($item->wewenang_status == 4)?$item->wewenang_alasan:'',
        $jabkepada,
        $wewenangjab,
        $item->wewenang_nama,($item->wewenang_nip!="-")?"NIP.".$item->wewenang_nip:"",

        '<div id="qrcode"></div>'
    );

    echo str_replace($arrsearch,$arrreplace,$template);

    ?>
</body>

</html>
<script>
$(document).ready(function() {

    $("#qrcode").qrcode({
        width: 105.82677165,
        height: 105.82677165,
        render: "image",
        text: "{!!url().'/digitalsigns/ecuti/'.$nip.'/'.$nousul!!}"
    });

    $('div.print').click(function() {
        $(this).hide();
        window.print();

    });

    $('img').each(function(index, item) {
        $(item).error(function() {
            $(item).attr('src', 'no_image.jpg');
        });
    });

    $(document).on('mouseover', function() {
        $('div.print').show();
    });

});
</script>