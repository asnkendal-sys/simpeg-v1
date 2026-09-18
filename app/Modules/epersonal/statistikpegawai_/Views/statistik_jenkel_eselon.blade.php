@if(Request::segment(3) == 'print')
<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Jenis Kelamin dan Eselon</title>
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
        $('#tb-statistik .link').on('click', function(e){
            e.preventDefault();
            var videsl = $(this).attr("data");
            var vidjenkel = $(this).attr("ed1");
            var vidskpd = $(this).attr("ed2");

            $('#form-print #idesl').val(videsl);
            $('#form-print #idskpd').val(vidskpd);
            $('#form-print #idjenkel').val(vidjenkel);
            $('#form-print').submit();
            
        });
    });
</script>

<form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistik_jenkel_eselon" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    {!!csrf_field()!!}
    <input type="hidden" id="idesl" name="idesl" value="" />
    <input type="hidden" id="idskpd" name="idskpd" value="" />
    <input type="hidden" id="idjenkel" name="idjenkel" value="" />
</form>
<h4 align="center">STATISTIK PEGAWAI BERDASARKAN JENIS KELAMIN DAN ESELON {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h4><br>
<table class="table table-hovered table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
    <thead class="bg-primary">
        <tr>
            <th rowspan="3"><div class="text-center">JENIS KELAMIN</div></th>
            <th rowspan="3"><div class="text-center">JML ESL.</div></th>
            <th rowspan="3"><div class="text-center">JML ESL. KOSONG</div></th>
            <th colspan="11"><div class="text-center">JUMLAH PER-ESELON</div></th>
        </tr>
        <tr>
            <th colspan="2"><div class="text-center">ESL I</div></th>
            <th colspan="2"><div class="text-center">ESL II</div></th>
            <th colspan="2"><div class="text-center">ESL III</div></th>
            <th colspan="2"><div class="text-center">ESL IV</div></th>
            <th colspan="2"><div class="text-center">ESL V</div></th>
            <th rowspan="2"><div class="text-center">-</div></th>
        </tr>
        <tr>
            <th><div class="text-center">I/a</div></th>
            <th><div class="text-center">I/b</div></th>
            <th><div class="text-center">II/a</div></th>
            <th><div class="text-center">II/b</div></th>
            <th><div class="text-center">III/a</div></th>
            <th><div class="text-center">III/b</div></th>
            <th><div class="text-center">IV/a</div></th>
            <th><div class="text-center">IV/b</div></th>
            <th><div class="text-center">V/a</div></th>
            <th><div class="text-center">V/b</div></th>
        </tr>
    </thead>
    <tbody>
            <?php
            $where = " b.idjenkedudupeg not in('21','99') and b.idjenjab >= 20";
            if(Input::get('idskpd') != ''){
                $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
            }else{
                $where .= "";
            }

            $rs = \DB::table('a_jenkel as a')
                ->select('a.idjenkel','a.jenkel',
                \DB::raw("COUNT(*) AS 'TOT'"),
                \DB::raw("SUM(IF(b.idesljbt!='',1,0)) AS eselon"),
                \DB::raw("SUM(IF(b.idesljbt='',1,0)) AS eselonempty"),
                \DB::raw("SUM(IF(b.idesljbt='11',1,0)) AS '_11'"),
                \DB::raw("SUM(IF(b.idesljbt='12',1,0)) AS '_12'"),
                \DB::raw("SUM(IF(b.idesljbt='21',1,0)) AS '_21'"),
                \DB::raw("SUM(IF(b.idesljbt='22',1,0)) AS '_22'"),
                \DB::raw("SUM(IF(b.idesljbt='31',1,0)) AS '_31'"),
                \DB::raw("SUM(IF(b.idesljbt='32',1,0)) AS '_32'"),
                \DB::raw("SUM(IF(b.idesljbt='41',1,0)) AS '_41'"),
                \DB::raw("SUM(IF(b.idesljbt='42',1,0)) AS '_42'"),
                \DB::raw("SUM(IF(b.idesljbt='51',1,0)) AS '_51'"),
                \DB::raw("SUM(IF(b.idesljbt='52',1,0)) AS '_52'"),
                \DB::raw("SUM(IF(b.idesljbt='99',1,0)) AS '_99'")
            )
            ->leftjoin('tb_01 as b', 'a.idjenkel', '=', 'b.idjenkel')
            ->whereRaw($where)
            ->orderBy('a.idjenkel', 'asc')
            ->groupBy('a.idjenkel')
            ->get();

            $n = 0;
        ?>
        @if(count($rs) > 0)
            @foreach($rs as $item)
            <?php
                $eselon[] = $item->eselon;
                $eselonempty[] = $item->eselonempty;
                $ia[] = $item->_11;
                $ib[] = $item->_12;
                $iia[] = $item->_21;
                $iib[] = $item->_22;
                $iiia[] = $item->_31;
                $iiib[] = $item->_32;
                $iva[] = $item->_41;
                $ivb[] = $item->_42;
                $va[] = $item->_51;
                $vb[] = $item->_52;
                $v0[] = $item->_99;
            ?>
            <tr>
                <td><div class="text-left">{!!($item->idjenkel=='1')?'Laki-laki':'Perempuan'!!}</div></td>
                <td><div class="link text-center" data="notnull" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->eselon!!}</div></div></td>
                <td><div class="link text-center" data="null" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->eselonempty!!}</div></div></td>
                <td><div class="link text-center" data="11" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_11!!}</div></div></td>
                <td><div class="link text-center" data="12" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_12!!}</div></div></td>
                <td><div class="link text-center" data="21" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_21!!}</div></div></td>
                <td><div class="link text-center" data="22" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_22!!}</div></div></td>
                <td><div class="link text-center" data="31" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_31!!}</div></div></td>
                <td><div class="link text-center" data="32" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_32!!}</div></div></td>
                <td><div class="link text-center" data="41" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_41!!}</div></div></td>
                <td><div class="link text-center" data="42" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_42!!}</div></div></td>
                <td><div class="link text-center" data="51" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_51!!}</div></div></td>
                <td><div class="link text-center" data="52" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_52!!}</div></div></td>
                <td><div class="link text-center" data="99" ed1="{!!$item->idjenkel!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{!!$item->_99!!}</div></div></td>
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan="14">Data tidak ditemukan.</td>
        </tr>
        @endif
    </tbody>
    <tfoot class="breadcrumb">
        <tr>
            <td>Total</td>
            <td><div class="text-center">{!!array_sum($eselon)!!}</div></td>
            <th><div class="text-center">{!!array_sum($eselonempty)!!}</div></th>
            <th><div class="text-center">{!!array_sum($ia)!!}</div></th>
            <th><div class="text-center">{!!array_sum($ib)!!}</div></th>
            <th><div class="text-center">{!!array_sum($iia)!!}</div></th>
            <th><div class="text-center">{!!array_sum($iib)!!}</div></th>
            <th><div class="text-center">{!!array_sum($iiia)!!}</div></th>
            <th><div class="text-center">{!!array_sum($iiib)!!}</div></th>
            <th><div class="text-center">{!!array_sum($iva)!!}</div></th>
            <th><div class="text-center">{!!array_sum($ivb)!!}</div></th>
            <th><div class="text-center">{!!array_sum($va)!!}</div></th>
            <th><div class="text-center">{!!array_sum($vb)!!}</div></th>
            <th><div class="text-center">{!!array_sum($v0)!!}</div></th>
        </tr>
    </tfoot>    
    
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