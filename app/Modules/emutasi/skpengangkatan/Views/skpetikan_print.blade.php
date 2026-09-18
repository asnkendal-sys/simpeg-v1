<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Keputusan Petikan</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <link rel="author" href="dinustek">

    <style type="text/css">
    div.print{
        background: url('{!!url()!!}/packages/tugumuda/images/print_icon.png') no-repeat;
        width:110px;
        height:110px;
        top:20;
        right:50;
        position:fixed;
        opacity:0.1;
        cursor:pointer;
        right: 5px;
    }

    div.print:hover{
        opacity:1;
    }
</style>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/js/jquery.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/EAN_UPC.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/CODE128.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/JsBarcode.js"></script>
<script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jsbarcode/jquery.qrcode-0.11.0.js"></script>
</head>
<body>
    <div class="print"></div>
    <?php
        date_default_timezone_set("Asia/Jakarta");

        $template = TemplateskpengangkatanModel::getTemplate('all', '5.1', 'template');
        $periode_tgl1 = Input::get('periode_tgl1');
        $periode_tgl2 = Input::get('periode_tgl2');
        $where = "(tr_mutasi_pengangkatan.statususul = 1 or tr_mutasi_pengangkatan.statussk = 1)";
        if($periode_tgl1!='' && $periode_tgl2!=''){
            $periode_tgl1 = date('Y-m-d', strtotime($periode_tgl1));
            $periode_tgl2 = date('Y-m-d', strtotime($periode_tgl2));
            $where .= " and tglusul between \"".$periode_tgl1."\" and \"".$periode_tgl2."\"";
        } else{
            $where .= "and tr_mutasi_pengangkatan.nousul = \"".Input::get('nousul')."\"";
        }

        $count = \DB::table("tr_mutasi_pengangkatan")->whereRaw($where)->count();


        $rs = \DB::table('tr_mutasi_pengangkatan')
        ->select('tr_mutasi_pengangkatan.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','skpdlama.path_short as skpdlama','skpdbaru.path_short as skpdbaru','tb_01.tmlhr','tb_01.tglhr',
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
            \DB::raw('IF(tr_mutasi_pengangkatan.idjenjab>4,skpdlama.jab,IF(tr_mutasi_pengangkatan.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_pengangkatan.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
            \DB::raw('IF(tr_mutasi_pengangkatan.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_pengangkatan.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_pengangkatan.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru'))
        ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_pengangkatan.idskpd', '=', 'skpdlama.idskpd')
        ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_pengangkatan.idskpdbaru', '=', 'skpdbaru.idskpd')
        ->leftjoin('a_tkpendid', 'tr_mutasi_pengangkatan.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tr_mutasi_pengangkatan.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tr_mutasi_pengangkatan.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('tb_01', 'tr_mutasi_pengangkatan.nip', '=', 'tb_01.nip')
        ->leftjoin('a_jabfung', 'tr_mutasi_pengangkatan.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tr_mutasi_pengangkatan.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_pengangkatan.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
        ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_pengangkatan.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
        ->whereRaw($where)
        //->take(1000)
        ->orderby('tr_mutasi_pengangkatan.idskpd','asc')
        ->orderby('tr_mutasi_pengangkatan.nip','asc')
        ->orderby('tr_mutasi_pengangkatan.idusul','asc')
        ->get();

        if(count($rs) < 1){
            echo "404 Not Found.<br>";
            echo "Daftar mutasi tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.<br>";
            exit();
        }

        $key = TemplateskpengangkatanModel::rand_char();
        $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />
        <span class='kode bolditalic'>".$key."</span>";

        $jml = count($rs);
        $x = 0;
        foreach ($rs as $item) {
            $x++;

        $arrsearch = array("search","[nosk]","[no_suratrek]","[surat_dari]","[tgl_suratrek]","[perihalrek]","[urutan]","[namalengkap]","[tkpendid]","[nip]","[tmlhr]","[tglhr]","[pangkat]","[gol]","[jablama]","[skpdlama]","[jabbaru]",
                "[skpdbaru]","[tgl_sp]","[jurusan]","[tmt]","[tglsurat]","[jabatansekda]","[namasekda]","[pangkatsekda]","[nipsekda]","[kepalabkd]","[pangkatbkd]","[nipkepalabkd]","[jabkepalabkd]","[bupati]","[tembusan_skpd_baru]","[tembusan_skpd_lama]","[copyright]","[qrcode]","[dasar2]",
                "[kepala]","[pangkatkepala]","[nipkepala]","[jabkepala]","[jabkepalattd]");
            $arrreplace = array("replace",
                $item->nosk,
                $item->no_suratrek,
                $item->surat_dari,
                formatTanggalPanjang($item->tgl_suratrek),
                $item->perihalrek,
                $item->urutan,
                $item->namalengkap,
                $item->tkpendid,
                fnip($item->nip),
                ucword($item->tmlhr),
                formatTanggalPanjang($item->tgl_sp),
                ucword($item->pangkat),$item->golru,
                ucword($item->jabatan." ".NominatifpengangkatanModel::isSekdes($item->nip,$item->idjabfungum)),
                ucword(((strlen($item->idskpd)>2)?getSkpdgroup(substr($item->idskpd,0,2)):$item->skpdlama)),
                strtoupper($item->jabatanbaru." ".NominatifpengangkatanModel::isSekdes($item->nip,$item->idjabfungumbaru)),
                ucword(((strlen($item->idskpdbaru)>2)?getSkpdgroup(substr($item->idskpdbaru,0,2)):$item->skpdbaru)),'',ucword($item->jenjurusan),
                formatTanggalPanjang($item->tmt),
                formatTanggalPanjang($item->tglsurat),
                strtoupper($item->jabkepalasekda),
                $item->kepalasekda,
                $item->pangkatsekda,
                fnip($item->nipsekda),
                $item->kepalabkd,
                ucword($item->pangkatbkd),
                fnip($item->nipkepalabkd),
                strtoupper($item->jabkepalabkd),$item->bupati,"Kepala ".ucword(getSkpdgroup(substr($item->idskpdbaru,0,2))),"Kepala ".ucword(getSkpdgroup(substr($item->idskpd,0,2))),$key_rand,'<div id="qrcode'.$x.'"></div>',


                (($item->no_suratrek!='')?"<li style='text-align: justify;'>
                    <span style='font-size:14px;'>
                    Surat Kepala ".ucword($item->surat_dari)." Kabupaten Kendal Nomor : ".$item->no_suratrek." Tanggal ".formatTanggalPanjang($item->tgl_suratrek)." Perihal : ".$item->perihalrek."</span></li>":''),
                $item->kepalabkd,
                ucword($item->pangkatbkd),
                fnip($item->nipkepalabkd),
                $item->jabkepalabkd,
                strtoupper($item->jabkepalabkd));



            echo str_replace($arrsearch,$arrreplace,$template);
    ?>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#barcode{!!$x!!}").JsBarcode("{!!$item->nip!!}",{width:1,height:25});
            $("#qrcode{!!$x!!}").qrcode({
                size    : 83.149606299,
                render  : "image",
                text    : "{!!url().'/digitalsign/mutasi/pengangkatanpelaksana/petikan/'.$item->nip.'/'.$item->nousul!!}"
            });
        })
    </script>

    <?php if($x != $jml){?>
        <div class="page-break"></div>
    <?php }} ?>
</body>
</html>

<script>
    $(document).ready(function(){
        /*$("#qrcode").qrcode({
            size    : 83.149606299,
            render  : "image",
            text    : "{!!url().'/digitalsignature/mutasi/pengangkatanpelaksana/surattugas/'.$item->nousul.'/'.$item->nip!!}"
        });*/
        //alert(window.orientation);
        $('div.print').click(function(){
            $(this).hide();
            window.print();
            /*
               setTimeout(function() {
                   window.close();
               }, 1);
               */
           });

        $('img').each(function(index,item){
            $(item).error(function(){

                $(item).attr('src','no_image.jpg');
            });
        });


        $(document).on('mouseover',function(){
            $('div.print').show();
        });

    });

</script>