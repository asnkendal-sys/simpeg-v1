<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Permohonan Pindah Tugas</title>
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

    $idskpd = ((strlen(session('idskpd'))==2) or (session('role_id') <= 3))?substr(Input::get('idskpd'),0,2):session('idskpd');
    /*update ke sk*/
    $dt['nousul'] = Input::get('nousul');
    $data['no_sp'] = Input::get('no_sp');
    $data['berkas_sp'] = Input::get('berkas_sp');
    $data['tgl_sp'] = date("Y-m-d", strtotime(Input::get('tgl_sp')));
    $data['jabpengantar'] = Input::get('jabpengantar');
    $data['namapengantar'] = Input::get('namapengantar');
    $data['nippengantar'] = Input::get('nippengantar');
    $data['pangkatpengantar'] = Input::get('pangkatpengantar');

    \DB::table('tr_mutasi_luar_daerah')->where($dt)->update($data);    

    $template = (\TemplateluarkabupatenModel::getTemplate($idskpd,'3.1','template') == '0')?\TemplateluarkabupatenModel::getTemplate('all','3.1','template'):\TemplateluarkabupatenModel::getTemplate($idskpd, '3.1', 'template');

    $rs = \DB::table('tr_mutasi_luar_daerah')
    ->select('tr_mutasi_luar_daerah.*','tr_mutasi_jenis_pemerintah.pemerintah','tr_mutasi_jenis_pemerintah.pejabat','tb_01.tmlhr','tb_01.tglhr','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path','a_golruang.golru','a_golruang.pangkat',
        \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
        \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
    )
    ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
    ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
    ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
    ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
    ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
    ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
    ->leftJoin('tr_mutasi_jenis_pemerintah','tr_mutasi_luar_daerah.idpemerintah','=','tr_mutasi_jenis_pemerintah.id')
    ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
    ->orderBy(\DB::raw('tr_mutasi_luar_daerah.nousul desc,tr_mutasi_luar_daerah.idgolrupkt,tr_mutasi_luar_daerah.nip'))
    ->where($dt)
    ->get();

    /*akses mod jika admin*/
    $attr = \TemplateluarkabupatenModel::attrPengantar($idskpd);
    if(count($rs) < 1){
        echo "404 Not Found.";
        exit();
    }


    $jml = count($rs);
    $i = 0;
    foreach($rs as $item){
        $i++;
        $key = \TemplateluarkabupatenModel::rand_char();            
        $key_rand = "<em>e-Simpeg Kab. Kendal ".gmdate("d-m-Y H:i", time()+60*60*7)."</em><br />";
        
        $instansi_tujuan = (($item->pejabat!='')?$item->pejabat.' ':'').$item->kabupaten;
        if($item->idpemerintah <= 3)
        {
            $instansi_tujuan = $item->pejabat." ".$item->kabupaten;
            if($item->idpemerintah == 1)
            {
                $tujuan_pem = "Pemerintah Kota ".$item->kabupaten;
            }else if($item->idpemerintah == 2)
            {
                $tujuan_pem = "Pemerintah Kabupaten ".$item->kabupaten;
            }else if($item->idpemerintah == 3)
            {
                $tujuan_pem = "Pemerintah Provinsi ".$item->kabupaten;
            }
        }
        else if($item->idpemerintah > 3)
        {
            $instansi_tujuan = $item->pejabat." ".$item->instansi;
            $tujuan_pem = $item->instansi; 
        }

        $arrsearch = array("search","[nosp]","[skpd]","[instansibaru]",
            "[kabkota]","[tglpermintaan]","[namalengkap]","[nip]","[berkas_sp]","[tglsp]","[jab_penetap]","[nama_pejabat]","[pangkat_penetap]",
            "[nip_penetap]","[copyright]","[qrcode]");
        $arrreplace = array("replace",$item->no_sp,ucword(getSkpd($idskpd)),ucword($tujuan_pem),ucword($item->kabupaten),formatTanggalPanjang($item->tglskpermintaan),$item->namalengkap,fnip($item->nip),$item->berkas_sp,($item->tgl_sp!='0000-00-00')?formatTanggalPanjang($item->tgl_sp):'',
            strtoupper($item->jabpengantar),$item->namapengantar,$item->pangkatpengantar,$item->nippengantar,$key_rand,'<div id="qrcode'.$i.'"></div>');
        
        echo str_replace($arrsearch,$arrreplace,$template);
        ?>

        <script type="text/javascript">
            $(document).ready(function(){
                $("#barcode{!!$i!!}").JsBarcode("{!!$item->nip!!}",{width:1,height:25});
                $("#qrcode{!!$i!!}").qrcode({
                    size    : 90,
                    render  : "image",
                    text	: "{!!url().'/digitalsignature/mutasi/luarkabupaten/pengantar/'.$item->nousul.'/'.$item->nip!!}"
                });
            })
        </script>

        <?php if($i != $jml){?>
            <div class="page-break"></div>
        <?php }} ?>

    </body>
    </html>

    <script>
        $(document).ready(function(){
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

