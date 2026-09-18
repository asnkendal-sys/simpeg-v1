<html>
<head>
<title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik PPPK</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<link href="{!!url()!!}/packages/tugumuda/css/print.css" rel="stylesheet">
    <style type="text/css">
        @media print {
            @page {
                size: A4 potrait;
                margin-left: 0.4in;
                margin-right: 0.4in;
                margin-top: 0.4in;
                margin-bottom: 0.4in;
            }
            /*p.breakhere { page-break-after: always; }*/
            .page-break	{ display:block; page-break-before:always; }
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
        }

        div.print:hover{
            opacity:1;
        }

        hr {
            border: 1px dotted #000000;
            border-bottom: none;
            border-right: none;
            border-left: none;
        }
    </style>
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jQuery/jquery-1.11.0.min.js"></script>

</head>
<body>
<div class="print"></div>
<div class="page">

<?php
      $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' and tb_01.idstspeg = 3 ";
      $having = '';      

    /* Kondisi Tahun */
    if((Input::get('tahun1') != '') and (Input::get('tahun2') != '')){
        $where .= "and YEAR(tmtakhirakhir_pppk) between ".Input::get('tahun1')." and ".Input::get('tahun2')."";
        $titletahun = ' TAHUN '.((Input::get('tahun1') != Input::get('tahun2'))?Input::get('tahun1').' S/D '.Input::get('tahun2'):Input::get('tahun1'));
    }else if((Input::get('tahun1') != '') and (Input::get('tahun2') == '')){
        $where .= "and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun1')."";
        $titletahun = ' TAHUN '.Input::get('tahun1');
    }else if((Input::get('tahun1') == '') and (Input::get('tahun2') != '')){
        $where .= "and YEAR(tmtakhirakhir_pppk)= ".Input::get('tahun2')."";
        $titletahun = ' TAHUN '.Input::get('tahun2');
    }

    /* Kondisi Bulan */
    if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
        $where .= " AND MONTH(tmtakhirakhir_pppk) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
        $titlebulan = ' BULAN '.((Input::get('bulan1') != Input::get('bulan2'))?strtoupper(formatBulan(Input::get('bulan1'))).' S/D '.strtoupper(formatBulan(Input::get('bulan2'))):strtoupper(formatBulan(Input::get('bulan1'))));
    }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
        $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan1')."";
        $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan1')));
    }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
        $where .= " AND MONTH(tmtakhirakhir_pppk)= ".Input::get('bulan2')."";
        $titlebulan = ' BULAN '.strtoupper(formatBulan(Input::get('bulan2')));
    }

    /* Kondisi skpd atau unit kerja */
    if(Input::get('idskpd') != ''){
        $where.= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
    }

    $rs = \DB::table('tb_01')
            ->select(\DB::raw('
                tb_01.kdunit, a_skpd.skpd, COUNT(*) AS jml, SUM(IF(tr_pppk.sts_kontrak=2,1,0)) AS perpanjang, SUM(IF(tr_pppk.sts_kontrak=3,1,0)) AS berhenti,SUM(IF(tr_pppk.status=2,1,0)) AS tidakdiusulkan,
                SUM(IF(tr_pppk.statussk=0,1,0)) AS belum, SUM(IF(tr_pppk.statususul>1,1,0)) AS tms, SUM(IF(tr_pppk.statussk=2,1,0)) AS proses, 
                SUM(IF(tr_pppk.statussk=1,1,0)) AS selesai
            '))
            ->join('a_skpd', 'tb_01.kdunit', '=', 'a_skpd.idskpd')
            ->leftJoin('tr_pppk', function($join){
                $join->on('tb_01.nip', '=', 'tr_pppk.nip')
                ->on('tb_01.tmtakhirakhir_pppk', '=', 'tr_pppk.tmtakhirl');
            }) 
            ->whereRaw($where)      
            ->groupBy('tb_01.kdunit')
            ->orderBy('tb_01.kdunit')
            ->get();
?>
<div align="center">
<h3>DAFTAR NOMINATIF PEGAWAI PPPK HABIS KONTRAK</h3>
<h3>
    {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    {!!(((Input::get('bulan1') != '') or (Input::get('bulan2') != ''))?$titlebulan:'')!!}
    {!!(((Input::get('tahun1') != '') or (Input::get('tahun2') != ''))?$titletahun:'')!!}
</h3>
</div><br>
<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
    <thead class="bg-primary">
        <tr>
            <th rowspan="2" align="center">NO</th>        
            <th rowspan="2" align="center">UNIT KERJA</th>        
            <th rowspan="2" align="center">JUMLAH KONTRAK</th>        
            <th colspan="3" align="center">USULAN</th>        
            <th colspan="2" align="center">STATUS VERIFIKASI</th>        
            <th colspan="2" align="center">STATUS PROSES</th>        
        </tr>
        <tr>
            <th>PERPANJANGN</th>
            <th>PEMBERHENTIAN</th>
            <th>TIDAK DIUSULKAN</th>
            <th>BELUM</th>
            <th>TMS</th>
            <th>ON PROSES</th>
            <th>SELESAI</th>
        </tr>
    </thead>  
    <tbody>
	<?php
        $x = 0;
        foreach($rs as $item){ 
            $x++;
            $tot_jml[$x] = $item->jml;
            $tot_perpanjang[$x] = $item->perpanjang;
            $tot_berhenti[$x] = $item->berhenti;
            $tot_tidakdiusulkan[$x] = $item->tidakdiusulkan;
            $tot_belum[$x] = $item->belum;
            $tot_tms[$x] = $item->tms;
            $tot_proses[$x] = $item->proses;
            $tot_selesai[$x] = $item->selesai;
	?>
    <tr>
        <td align="center">{!!$x!!}.</td>        
        <td align="left">{!!$item->skpd!!}</td>
        <td align="center">{!!$item->jml!!}</td>
        <td align="center">{!!$item->perpanjang!!}</td>
        <td align="center">{!!$item->berhenti!!}</td>
        <td align="center">{!!$item->tidakdiusulkan!!}</td>
        <td align="center">{!!$item->belum!!}</td>
        <td align="center">{!!$item->tms!!}</td>
        <td align="center">{!!$item->proses!!}</td>
        <td align="center">{!!$item->selesai!!}</td>
    </tr>
	<?php } ?>
    <tr>
        <td>&nbsp;</td>
        <td>TOTAL</td>
        <td align="center">{!!array_sum($tot_jml)!!}</td>
        <td align="center">{!!array_sum($tot_perpanjang)!!}</td>
        <td align="center">{!!array_sum($tot_berhenti)!!}</td>
        <td align="center">{!!array_sum($tot_tidakdiusulkan)!!}</td>
        <td align="center">{!!array_sum($tot_belum)!!}</td>
        <td align="center">{!!array_sum($tot_tms)!!}</td>
        <td align="center">{!!array_sum($tot_proses)!!}</td>
        <td align="center">{!!array_sum($tot_selesai)!!}</td>
    </tr>
    </tbody>
</table>
</div>
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
