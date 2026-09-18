<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pengantar Kenaikan Pangkat</title>
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
    if ($idskpd == "") {
        $idskpd = "25";
    }

    /*update ke sk*/
    $dt['nousul'] = Input::get('nousul');
    $dt['idskpd'] = Input::get('idskpd');
    $data['no_sp'] = Input::get('no_sp');
    $data['berkas_sp'] = Input::get('berkas_sp');
    $data['tgl_sp'] = date("Y-m-d", strtotime(Input::get('tgl_sp')));
    \DB::table('tr_kenaikan_pangkat')->where($dt)->update($data);    

    $template = (\TemplatekenaikanpangkatModel::getTemplate($idskpd,'3') == '0')?\TemplatekenaikanpangkatModel::getTemplate('all','3'):\TemplatekenaikanpangkatModel::getTemplate($idskpd,'3');

    $rs = \DB::table('tr_kenaikan_pangkat')
    ->select('tr_kenaikan_pangkat.*','tb_01.tmlhr','tb_01.tglhr','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
        \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
        \DB::raw("IF(tr_kenaikan_pangkat.idjenjab>=20,a_skpd.jab,IF(tr_kenaikan_pangkat.idjenjab=2,a_jabfung.jabfung,IF(tr_kenaikan_pangkat.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
    )
    ->join('tb_01','tr_kenaikan_pangkat.nip','=','tb_01.nip')
    ->join('a_skpd','tr_kenaikan_pangkat.idskpd','=','a_skpd.idskpd')
    ->leftjoin('a_jenjab', 'tr_kenaikan_pangkat.idjenjab', '=', 'a_jenjab.idjenjab')
    ->leftjoin('a_golruang', 'tr_kenaikan_pangkat.idgolrupkt', '=', 'a_golruang.idgolru')
    ->leftjoin('a_golruang as a_golruangbaru', 'tr_kenaikan_pangkat.idgolrupktb', '=', 'a_golruangbaru.idgolru')
    ->leftjoin('a_jabfung', 'tr_kenaikan_pangkat.idjabfung', '=', 'a_jabfung.idjabfung')
    ->leftjoin('a_jabfungum', 'tr_kenaikan_pangkat.idjabfungum', '=', 'a_jabfungum.idjabfungum')
    ->orderBy(\DB::raw('tr_kenaikan_pangkat.idusul'))
    // ->where($dt)
    ->where('nousul', $dt['nousul'])->where('tr_kenaikan_pangkat.idskpd', 'like', $dt['idskpd']. '%')
    ->take(1)
    ->get();

    /*akses mod jika admin*/
    $attr = RekapusulankenaikanpangkatModel::attrPengantar($idskpd);
    if(count($rs) < 1){
        echo "404 Not Found.";
        exit();
    }

    $jml = count($rs);
    $i = 0;
    foreach($rs as $item){
        $i++;          
        $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em>";

        $arrsearch = array("search","[no_sp]","[dkk]","[nama_opd]","[nama_opd]","[nama_pns]","[nip]","[berkas_sp]","[tgl_surat]","[jab_penetap]","[nama_pejabat]","[pangkat_penetap]",
            "[nip_penetap]","[copyright]");
        $arrreplace = array("replace",$data['no_sp'],(($data['berkas_sp']>1)?'dkk.':''),
            getSkpdgroup($idskpd),
            getSkpdgroup($idskpd),
            $item->namalengkap,$item->nip,$data['berkas_sp'],formatTanggalPanjang($data['tgl_sp']),

            strtoupper($attr->jab),
            @$attr->namalengkap,
            @ucword($attr->pangkat),
            @$attr->nip,
            $key_rand);

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
        size    : 90,
        render  : "image",
        text    : "{!!url().'/digitalsign/kenaikanpangkat/pengantar/'.$item->nip.'/'.$item->nousul!!}"
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

