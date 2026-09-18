@if(Request::segment(3) == 'print')
<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Unit Kerja dan Pendidikan Formal</title>
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
    <script type="text/javascript" src="{!!url()!!}/packages/tugumuda/plugins/jQuery/jquery.js"></script>

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
        $('#tb-statistik .link').on('click', function(e){
            e.preventDefault();
            var vidtkpendid = $(this).attr("data");
            var vidskpd = $(this).attr("ed2");

            $('#form-print #idskpd').val(vidskpd);
            $('#form-print #idtkpendid').val(vidtkpendid);
            $('#form-print').submit();

        });
	});
</script>
    <form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistik_ukerja_pendformal" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
        {!!csrf_field()!!}
        <input type="hidden" id="idskpd" name="idskpd" value="" />
        <input type="hidden" id="idtkpendid" name="idtkpendid" value="" />
    </form>
    <h4 align="center">STATISTIK PEGAWAI BERDASARKAN UNIT KERJA DAN PENDIDIKAN FORMAL {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4><br>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
        <thead class="bg-primary">
            <tr>
                <th><div class="text-center">UNIT KERJA</div></th>
                <th><div class="text-center">TOTAL</div></th>
                <th><div class="text-center">KOSONG</div></th>
                <th><div class="text-center">SD</div></th>
                <th><div class="text-center">SMP</div></th>
                <th><div class="text-center">SMPK</div></th>
                <th><div class="text-center">SMA</div></th>
                <th><div class="text-center">SMAK</div></th>
                <th><div class="text-center">SMAKG</div></th>
                <th><div class="text-center">D1</div></th>
                <th><div class="text-center">D2</div></th>
                <th><div class="text-center">D3</div></th>
                <th><div class="text-center">D4</div></th>
                <th><div class="text-center">S1</div></th>
                <th><div class="text-center">S2</div></th>
                <th><div class="text-center">S3</div></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $where = " b.idjenkedudupeg not in('21','99')";
                if(Input::get('idskpd') != ''){
                    $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
                }else{
                    $where .= "";
                }

                $rs = \DB::table('a_skpd as a')
                    ->select(
                        'a.idskpd','a.skpd',
                        \DB::raw("COUNT(*) AS 'TOT'"),
                        \DB::raw("SUM(if(b.idtkpendid='',1,0)) AS 'empty'"),
                        \DB::raw("SUM(IF(b.idtkpendid='05',1,0)) AS 'sd'"),
                        \DB::raw("SUM(IF(b.idtkpendid='10',1,0)) AS 'sp'"),
                        \DB::raw("SUM(IF(b.idtkpendid='12',1,0)) AS 'spk'"),
                        \DB::raw("SUM(IF(b.idtkpendid='15',1,0)) AS 'sa'"),
                        \DB::raw("SUM(IF(b.idtkpendid='17',1,0)) AS 'sak'"),
                        \DB::raw("SUM(IF(b.idtkpendid='18',1,0)) AS 'sag'"),
                        \DB::raw("SUM(IF(b.idtkpendid='20',1,0)) AS 'd1'"),
                        \DB::raw("SUM(IF(b.idtkpendid='25',1,0)) AS 'd2'"),
                        \DB::raw("SUM(IF(b.idtkpendid='30',1,0)) AS 'd3'"),
                        \DB::raw("SUM(IF(b.idtkpendid='35',1,0)) AS 'd4'"),
                        \DB::raw("SUM(IF(b.idtkpendid='40',1,0)) AS 's1'"),
                        \DB::raw("SUM(IF(b.idtkpendid='45',1,0)) AS 's2'"),
                        \DB::raw("SUM(IF(b.idtkpendid='50',1,0)) AS 's3'")
                    )
                    ->leftjoin('tb_01 as b', 'a.idskpd', '=', 'b.idskpd')
                    ->leftjoin('a_tkpendid as c', 'b.idtkpendid', '=', 'c.idtkpendid')
                    ->whereRaw($where)
                    ->groupBy('a.idskpd')
                    ->get();

                    $n = 0;
            ?>

            @if(count($rs) > 0)
                @foreach($rs as $item)
                    <?php
                        $n++;
                        $TOT[] = $item->TOT;
                        $empty[] = $item->empty;
                        $sd[] = $item->sd;
                        $sp[] = $item->sp;
                        $spk[] = $item->spk;
                        $sa[] = $item->sa;
                        $sak[] = $item->sak;
                        $sag[] = $item->sag;
                        $d1[] = $item->d1;
                        $d2[] = $item->d2;
                        $d3[] = $item->d3;
                        $d4[] = $item->d4;
                        $s1[] = $item->s1;
                        $s2[] = $item->s2;
                        $s3[] = $item->s3;
                    ?>
                    <tr>
                        <td><div class="text-left">{!!$item->skpd!!}</div></td>
                        <td><div class="link text-center" data="notnull" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->TOT!!}</div></div></td>
                        <td><div class="link text-center" data="null" ed2="{!!$item->idskpd!!}" title="Lihat Detail">{!!$item->empty!!}</div></td>
                        <td><div class="link text-center" data="05" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->sd!!}</div></div></td>
                        <td><div class="link text-center" data="10" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->sp!!}</div></div></td>
                        <td><div class="link text-center" data="12" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->spk!!}</div></div></td>
                        <td><div class="link text-center" data="15" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->sa!!}</div></div></td>
                        <td><div class="link text-center" data="17" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->sak!!}</div></div></td>
                        <td><div class="link text-center" data="18" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->sag!!}</div></div></td>
                        <td><div class="link text-center" data="20" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->d1!!}</div></div></td>
                        <td><div class="link text-center" data="25" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->d2!!}</div></div></td>
                        <td><div class="link text-center" data="30" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->d3!!}</div></div></td>
                        <td><div class="link text-center" data="35" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->d4!!}</div></div></td>
                        <td><div class="link text-center" data="40" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->s1!!}</div></div></td>
                        <td><div class="link text-center" data="45" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->s2!!}</div></div></td>
                        <td><div class="link text-center" data="50" ed2="{!!$item->idskpd!!}" title="Lihat Detail"><div align='center'>{!!$item->s3!!}</div></div></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="23">Data tidak ditemukan.</td>
                </tr>
            @endif
        </tbody>
        @if(count($rs) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th><div class="text-center">{!!array_sum($TOT)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($empty)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($sd)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($sp)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($spk)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($sa)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($sak)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($sag)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($d1)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($d2)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($d3)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($d4)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($s1)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($s2)!!}</div></th>
                    <th><div class="text-center">{!!array_sum($s3)!!}</div></th>
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