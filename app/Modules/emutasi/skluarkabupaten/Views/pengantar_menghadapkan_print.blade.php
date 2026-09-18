<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pengantar Menghadapkan Mutasi Luar</title>
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
</head>
<body>
    <div class="print"></div>
    <?php
        date_default_timezone_set("Asia/Jakarta");

        $template = \TemplateluarkabupatenModel::getTemplate('all','3.5','template');
        $where = "(tr_mutasi_luar_daerah.statususul = 1 or tr_mutasi_luar_daerah.statussk = 1)";
        $where .= "and tr_mutasi_luar_daerah.nousul = \"".Request::segment(5)."\"";

        $count = \DB::table("tr_mutasi_luar_daerah")->whereRaw($where)->count();

        $item = \DB::table('tr_mutasi_luar_daerah')
            ->select('tr_mutasi_luar_daerah.*','tb_01.tmlhr','tb_01.tglhr','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
            \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
            \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
        )
            ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
            ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
            ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
            ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
            ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
            ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
            ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
            ->orderBy(\DB::raw('tr_mutasi_luar_daerah.nousul desc, tr_mutasi_luar_daerah.idgolrupkt,tr_mutasi_luar_daerah.nip'))
            ->whereRaw($where)
            ->first();

        if(count($item) < 1){
            echo "404 Not Found.<br>";
            echo "Daftar mutasi tidak tersedia.<br>";
            echo "Cek status berkas dan status SK.<br>";
            exit();
        }

        $i = 0;        

        $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em>";

        $arrsearch = array("search","[nosk]","[nourut]","[nip]","[namalengkap]","[tmlhr]","[tglhr]","[pangkat]","[gol]","[jablama]","[skpdlama]",
            "[pendidikan]","[jurusan]","[tmt]","[tglsurat]","[kepalabkd]","[pangkatbkd]","[nipbkd]","[bupati]","[copyright]","[nopengantar]","[tglpengantar]","[berkaspengantar]");
        $arrreplace = array("replace",(($item->nosk!='')?$item->nosk:'820/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/31'),$i,fnip($item->nip),$item->namalengkap,$item->tmlhr,formatTanggalPanjang($item->tglhr),$item->pangkat,$item->golru,$item->jabatan,$item->path,
            $item->tkpendid,$item->jenjurusan,formatTanggalPanjang($item->tmt),formatTanggalPanjang($item->tglsurat),$item->kepalabkd,$item->pangkatbkd,fnip($item->nipkepalabkd),$item->bupati,$key_rand,
            (($item->nosk_pengantar!='')?$item->nosk_pengantar:'822.3/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date('Y')),(($item->tglsk_pengantar!='0000-00-00')?formatTanggalPanjang($item->tglsk_pengantar):formatTanggalPanjang(date('Y-m-d'))),$count);

        echo str_replace($arrsearch,$arrreplace,$template);
    ?>
</body>
</html>

<script>
    $(document).ready(function(){
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