<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pengantar Mutasi Antar SKPD</title>
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

    $idskpd = ((strlen(session('idskpd'))==2) or (session('idskpd') == ''))?substr(Input::get('idskpd'),0,2):session('idskpd');

    /*update ke sk*/
    $dt['nousul'] = Input::get('nousul');
    $data['no_sp'] = Input::get('no_sp');
    $data['berkas_sp'] = Input::get('berkas_sp');
    $data['tgl_sp'] = date("Y-m-d", strtotime(Input::get('tgl_sp')));
    \DB::table('tr_mutasi_dalam_skpd')->where($dt)->update($data);    

    $template = (\TemplateskmutasiModel::getTemplate($idskpd,'1.1','template') == '0')?\TemplateskmutasiModel::getTemplate('all','1.1','template'):\TemplateskmutasiModel::getTemplate($idskpd, '1.1', 'template');

    $rs = \DB::table('tr_mutasi_dalam_skpd')
    ->select('tr_mutasi_dalam_skpd.*','tb_01.tmlhr','tb_01.tglhr','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
        \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
        \DB::raw("IF(tr_mutasi_dalam_skpd.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_dalam_skpd.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_skpd.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
    )
    ->leftJoin('tb_01','tr_mutasi_dalam_skpd.nip','=','tb_01.nip')
    ->leftJoin('a_tkpendid','tr_mutasi_dalam_skpd.idtkpendid','=','a_tkpendid.idtkpendid')
    ->leftJoin('a_jenjurusan','tr_mutasi_dalam_skpd.idjenjurusan','=','a_jenjurusan.idjenjurusan')
    ->leftJoin('a_skpd','tr_mutasi_dalam_skpd.idskpd','=','a_skpd.idskpd')
    ->leftJoin('a_jabfung','tr_mutasi_dalam_skpd.idjabfung','=','a_jabfung.idjabfung')
    ->leftJoin('a_jabfungum','tr_mutasi_dalam_skpd.idjabfungum','=','a_jabfungum.idjabfungum')
    ->leftJoin('a_golruang','tr_mutasi_dalam_skpd.idgolrupkt','=','a_golruang.idgolru')
    ->orderBy(\DB::raw('tr_mutasi_dalam_skpd.nousul desc,tr_mutasi_dalam_skpd.idgolrupkt,tr_mutasi_dalam_skpd.nip'))
    ->where($dt)
    ->get();

    /*akses mod jika admin*/
    $attr = \TemplateskmutasiModel::attrPengantar($idskpd);
    if(count($rs) < 1){
        echo "404 Not Found.";
        exit();
    }

    $jml = count($rs);
    $i = 0;
    foreach($rs as $item){
        $i++;
        $key = \TemplateskmutasiModel::rand_char();            

        $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em>";

        $arrsearch = array("search","[nosk]","[dkk]","[skpd]","[namalengkap]","[nip]","[berkas_sp]","[tgl_surat]","[jab_penetap]","[nama_pejabat]","[pangkat_penetap]",
            "[nip_penetap]","[copyright]","[qrcode]");
        $arrreplace = array("replace",$item->no_sp,(($item->berkas_sp>1)?'dkk.':''),getSkpdgroup($idskpd),$item->namalengkap,$item->nip,$item->berkas_sp,formatTanggalPanjang($item->tgl_sp),
            strtoupper($item->jabkepalabkd),$item->kepalabkd,ucword($item->pangkatbkd),$item->nipkepalabkd,$key_rand,'<div id="qrcode"></div>');

        echo str_replace($arrsearch,$arrreplace,$template);
        
        if($i != $jml){
            echo "<div class='page-break'></div>";
        }
        
        
        
        
    }
    ?>
</body>
</html>

<script>
    $(document).ready(function(){
     $("#qrcode").qrcode({
        size    : 83.149606299,
        render  : "image",
        text    : "{!!url().'/digitalsign/mutasi/dalamopd/pengantar/'.$item->nip.'/'.$item->nousul!!}"
    });
        //alert(window.orientation);
        $('div.print').click(function(){
            $(this).hide();
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

