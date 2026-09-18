@if(Request::segment(3) == 'print')
<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Jabatan Fungsional Guru dan Unit Kerja</title>
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
            .page-break { display:block; page-break-before:always; }
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
@else
    <style>
        .link{
            cursor:pointer;
        }
    </style>
@endif

<script>
    $(document).ready(function(){
        $('#tb-statistik .link').click(function(){
            var vidissek = $(this).attr("data");
            var vidskpd = $(this).attr("ed2");
            var vidstspeg = $(this).attr("ed3");
            
            $('#form-print #idissek').val(vidissek);
            $('#form-print #idskpd').val(vidskpd);
            $('#form-print #idstspeg').val(vidstspeg);
            $('#form-print').submit();
            
        });
    });
</script>
<form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistik_jabfungguru_unker" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    {!!csrf_field()!!}
    <input type="hidden" id="idissek" name="idissek" value="" />
    <input type="hidden" id="idskpd" name="idskpd" value="" />
    <input type="hidden" id="idstspeg" name="idstspeg" />
</form>
<h4 align="center">STATISTIK PEGAWAI BERDASARKAN JABATAN FUNGSIONAL GURU DAN UNIT KERJA {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4><br>
<table class="table table-hovered table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
    <thead class="bg-primary">
        <tr>
            <th><div class="text-center">UNIT KERJA</div></th>
            <th><div class="text-center">TOTAL</div></th>
            <th><div class="text-center">KOSONG</div></th>
            <th><div class="text-center">TK</div></th>
            <th><div class="text-center">SD</div></th>
            <th><div class="text-center">SMP</div></th>
            <th><div class="text-center">DPK</div></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $idstspeg = implode(",",Input::get('idstspeg'));
            $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab = 2 AND LEFT(b.idjabfung,3) = '300' ";

            if(Input::get('idskpd') != ''){
                $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
            }else{
                $where .= "";
            }

            if(Input::get('idstspeg') != '') {
                $where .= " and b.idstspeg in (".$idstspeg.")";
            }

        $rs = \DB::table('a_skpd as a')
              ->select('a.idskpd','a.issek','a.skpd',
                \DB::raw("IF(a.issek=1,'TK',IF(a.issek=2,'SD',IF(a.issek=3,'SMP',IF(a.issek=4,'DPK',IF(a.issek=5,'SMA/SMK','-'))))) as jenjang"),
                // \DB::raw("SUM(IF(a.issek!='',1,0)) AS 'total'"),
                \DB::raw("COUNT(*) AS 'total'"),
                \DB::raw("SUM(IF(a.issek='',1,0)) AS 'empty'"),
                \DB::raw("SUM(IF(a.issek='1',1,0)) AS 'tk'"),
                \DB::raw("SUM(IF(a.issek='2',1,0)) AS 'sd'"),
                \DB::raw("SUM(IF(a.issek='3',1,0)) AS 'smp'"),
                \DB::raw("SUM(IF(a.issek='4',1,0)) AS 'dpk'"),
                \DB::raw("SUM(IF(a.issek='5',1,0)) AS 'sma'")
                )
              ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
              ->whereRaw($where)
              ->orderBy('a.idskpd', 'asc')
              ->groupBy('a.idskpd')
              ->get();

            $n = 0;
        ?>     
           
@if(count($rs) > 0)
    @foreach($rs as $item)
        <?php 
        $n++;
        $total[] = $item->total;
        $empty[] = $item->empty;
        $tk[] = $item->tk;
        $sd[] = $item->sd;
        $smp[] = $item->smp;
        $dpk[] = $item->dpk;
        $sma[] = $item->sma;     
        
        ?>
        <tr>
            <td><div class="text-left">{!!$item->skpd!!}</div></td>
            <td><div class="link text-center" data="notnull" ed2="{!! $item->idskpd !!}" ed3="{!!$idstspeg!!}" title="Lihat Detail"><div align='center'>{!!$item->total!!}</div></div></td>
            <td><div class="link text-center" data="null" ed2="{!! $item->idskpd !!}" ed3="{!!$idstspeg!!}" title="Lihat Detail"><div align='center'>{!!$item->empty!!}</div></div></td>
            <td><div class="link text-center" data="1" ed2="{!! $item->idskpd !!}" ed3="{!!$idstspeg!!}" title="Lihat Detail"><div align='center'>{!!$item->tk!!}</div></div></td>
            <td><div class="link text-center" data="2" ed2="{!! $item->idskpd !!}" ed3="{!!$idstspeg!!}" title="Lihat Detail"><div align='center'>{!!$item->sd!!}</div></div></td>
            <td><div class="link text-center" data="3" ed2="{!! $item->idskpd !!}" ed3="{!!$idstspeg!!}" title="Lihat Detail"><div align='center'>{!!$item->smp!!}</div></div></td>
            <td><div class="link text-center" data="4" ed2="{!! $item->idskpd !!}" ed3="{!!$idstspeg!!}" title="Lihat Detail"><div align='center'>{!!$item->dpk!!}</div></div></td>
        </tr>
            @endforeach
        @else
            <tr>
                <td colspan="23">Data tidak ditemukan.</td>
            </tr>
        @endif
    </tbody>
    @if(count($rs) > 0)
    <tfoot class="breadcrumb">
        <tr>
            <th>Total</th>
            <th><div class="text-center">{!! array_sum($total) !!}</div></th>
            <th><div class="text-center">{!! array_sum($empty) !!}</div></th>
            <th><div class="text-center">{!! array_sum($tk) !!}</div></th>
            <th><div class="text-center">{!! array_sum($sd) !!}</div></th>
            <th><div class="text-center">{!! array_sum($smp) !!}</div></th>
            <th><div class="text-center">{!! array_sum($dpk) !!}</div></th>
        </tr>
    </tfoot>    
     @endif
</table>

@if(Request::segment(3) == 'print')
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
@endif