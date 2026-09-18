
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>DPCP Pensiun Kolektif</title>
    <link rel="shortcut icon" href="{!!url()!!}/packages/tugumuda/img/favicon.png">
    <link rel="stylesheet" href="{!!url()!!}/packages/tugumuda/css/text-stylesheet.css" media="all">
    <style type="text/css">
        @media print {
            @page {
                size: F4 potrait;
                margin-left: 0in;
                margin-right: 0in;
                margin-top: 0in;
                margin-bottom: 0.15in;
            }
            .page-break	{ display:block; page-break-before:always; }
        }

        *{
            -webkit-box-sizing: border-box;
               -moz-box-sizing: border-box;
                    box-sizing: border-box;
        }
        html {
            font-family: 'Arial';
            font-size: 11pt;
            background: white;
            line-height:1.5;
            padding: 0;
            margin: 0;
        }

        body{
            position: relative;
        }

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

        table{
            border-collapse: collapse;
        }
        table tbody > tr > td{
            vertical-align: top;
            padding: 0;
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

        if(\Request::segment(5) != ''){
            $idskpd = \Request::segment(5);
        }else{
            $idskpd = session('idskpd');
        }
        $tmtpens = \Request::segment(4);        

        $rs = \NominatifpensiunModel::getDatanominatiftmtver($tmtpens);
        if(!count($rs)){
            echo "Data Pensiun tidak ditemukan.";
            exit();
        }

        $jml = count($rs);
        $i = 0;
        foreach($rs as $item){
            $ranak = \NominatifpensiunModel::getRanak($item->nip,1);            

            $i++;
            $rstemplate = (\NominatifpensiunModel::getTemplatesk($idskpd,2) == '0')?'<div align="center"><b>Perhatian!</b> Template SK Pensiun Belum tersedia.<br><em>"Silahkan buat template pada menu Template SK."</em></div>':\NominatifpensiunModel::getTemplatesk($idskpd,2);

            $arrsearch = array("search","[unit_kerja]","[tmt_pensiun]","[tanggal_dpcp]","[nip]","[nama_pegawai]","[tempat_lahir]","[tanggal_lahir]","[jabatan]",
            "[pangkat]","[golongan]","[mkthn_gol]","[mkbln_gol]","[mkthn_pens]","[mkbln_pens]","[mkthn_awal]","[mkbln_awal]","[gaji_pokok]",
            "[tk_pendid]","[tahun_lulus]","[tmt_masukpns]","[riwayat_issu]","[riwayat_anak]","[jalan_sekarang]","[rt_sekarang]","[rw_sekarang]",
            "[desa_sekarang]","[kecamatan_sekarang]","[kabupaten_sekarang]","[provinsi_sekarang]","[jalan_pens]","[rt_pens]","[rw_pens]","[desa_pens]",
            "[kecamatan_pens]","[kabupaten_pens]","[provinsi_pens]","[jabatan_penetap]","[pejabat_penetap]","[golongan_penetap]","[nip_penetap]");

            $rs = \DB::table('a_skpd')->where('idskpd', substr($item->idskpd,0,2))->first();
            $tembusan = ucword($rs->jab_utuh);
            //$attr = \NominatifpensiunModel::attrPengantar($item->kdunit);

            $arrreplace = array("replace",strtoupper($item->path_short),formatTanggalPanjang($item->tmtpens),formatTanggalPanjang($item->tgskpens),$item->nip,$item->nama,$item->tmlhr,formatTanggalPanjang($item->tglhr),$item->jabatan,
                $item->golpnsskr_txt,$item->golpns_txt,((strlen($item->mkthnpkt)==1)?"0".$item->mkthnpkt:$item->mkthnpkt),((strlen($item->mkblnpkt)==1)?"0".$item->mkblnpkt:$item->mkblnpkt),((strlen($item->mkthnpens)==1)?"0".$item->mkthnpens:$item->mkthnpens),((strlen($item->mkblnpens)==1)?"0".$item->mkblnpens:$item->mkblnpens),((strlen($item->mkthnpns)==1)?"0".$item->mkthnpns:$item->mkthnpns),((strlen($item->mkblnpns)==1)?"0".$item->mkblnpns:$item->mkblnpns),'Rp. '.number_format($item->gaji),
                $item->tkpendid,$item->thijaz,formatTanggalPanjang($item->tmtcpn),\NominatifpensiunModel::getRissu($item->nip),$ranak,$item->almskrpens,$item->almrtskrpens,$item->almrwskrpens,
                $item->almdesaskrpens,$item->almkecskrpens,$item->almkabskrpens,$item->almprovskrpens,$item->almpens,$item->almrtpens,$item->almrwpens,$item->almdesapens,
                $item->almkecpens,$item->almkabpens,$item->almprovpens,$item->jabpenpens,$item->pejpenpens,$item->golrupenpens,$item->nippenpens);

            echo str_replace($arrsearch,$arrreplace,$rstemplate);

            /*echo "<pre>";
                print_r($item);
            echo "</pre>";*/
        ?>

        <script type="text/javascript">
            $(document).ready(function(){
                $("#barcode{!!$i!!}").JsBarcode("{!!$item->nip!!}",{width:1,height:25});
                $("#qrcode{!!$i!!}").qrcode({
                    size    : 90,
                    render  : "image",
                    text	: "{!!url().'/digitalsign/'.$item->nip.'/'.$item->tmtpens!!}"
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