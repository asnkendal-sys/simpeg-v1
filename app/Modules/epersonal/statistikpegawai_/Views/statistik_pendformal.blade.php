@if(Request::segment(3) == 'print')
<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Pendidikan Formal</title>
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
@else
<style>
    .link{
        cursor:pointer;
    }
</style>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        $('#tb-statistik .link').on('click', function(e){
            e.preventDefault();
            var vidgolru = $(this).attr("data");
            var vidtkpendid = $(this).attr("ed1");
            var vidskpd = $(this).attr("ed2");

            $('#form-print #idgolru').val(vidgolru);
            $('#form-print #idskpd').val(vidskpd);
            $('#form-print #idtkpendid').val(vidtkpendid);
            $('#form-print').submit();

        });
    });
</script>

    <form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistik_pendformal" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
        {!!csrf_field()!!}
        <input type="hidden" id="idgolru" name="idgolru" />
        <input type="hidden" id="idskpd" name="idskpd" />
        <input type="hidden" id="idtkpendid" name="idtkpendid" />
    </form>
    <h3 align="center">STATISTIK PEGAWAI BERDASARKAN PENDIDIKAN FORMAL {!! ((Input::get('idskpd')!='')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'') !!}</h3><br>
    <table class="table table-striped table-hover table-condensed table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
        <thead class="bg-primary">
            <tr>
                <th rowspan="3"><div class="text-center">PENDIDIKAN FORMAL</div></th>
                <th rowspan="3"><div class="text-center">JML GOL.</div></th>
                <th rowspan="3"><div class="text-center">JML GOL. KOSONG</div></th>
                <th colspan="17"><div class="text-center">JUMLAH PER-GOLONGAN</div></th>
            </tr>
            <tr>
                <th colspan="4"><div class="text-center">GOL I</div></th>
                <th colspan="4"><div class="text-center">GOL II</div></th>
                <th colspan="4"><div class="text-center">GOL III</div></th>
                <th colspan="5"><div class="text-center">GOL IV</div></th>
            </tr>
            <tr>
                <th><div class="text-center">I/a</div></th>
                <th><div class="text-center">I/b</div></th>
                <th><div class="text-center">I/c</div></th>
                <th><div class="text-center">I/d</div></th>
                <th><div class="text-center">II/a</div></th>
                <th><div class="text-center">II/b</div></th>
                <th><div class="text-center">II/c</div></th>
                <th><div class="text-center">II/d</div></th>
                <th><div class="text-center">III/a</div></th>
                <th><div class="text-center">III/b</div></th>
                <th><div class="text-center">III/c</div></th>
                <th><div class="text-center">III/d</div></th>
                <th><div class="text-center">IV/a</div></th>
                <th><div class="text-center">IV/b</div></th>
                <th><div class="text-center">IV/c</div></th>
                <th><div class="text-center">IV/d</div></th>
                <th><div class="text-center">IV/e</div></th>
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

                $rs = \DB::table('a_tkpendid as a')
                    ->select(
                        'a.idtkpendid','a.tkpendid',
                        \DB::raw("SUM(if(b.idgolrupkt!='',1,0)) as 'gol'"),
                        \DB::raw("SUM(if(b.idgolrupkt='',1,0)) as 'golempty'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='11',1,0)) AS 'ia'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='12',1,0)) AS 'ib'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='13',1,0)) AS 'ic'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='14',1,0)) AS 'id'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='21',1,0)) AS 'iia'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='22',1,0)) AS 'iib'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='23',1,0)) AS 'iic'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='24',1,0)) AS 'iid'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='31',1,0)) AS 'iiia'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='32',1,0)) AS 'iiib'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='33',1,0)) AS 'iiic'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='34',1,0)) AS 'iiid'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='41',1,0)) AS 'iva'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='42',1,0)) AS 'ivb'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='43',1,0)) AS 'ivc'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='44',1,0)) AS 'ivd'"),
                        \DB::raw("SUM(IF(b.idgolrupkt='45',1,0)) AS 'ive'")
                    )
                    ->leftjoin('tb_01 as b', 'a.idtkpendid', '=', 'b.idtkpendid')
                    ->whereRaw($where)
                    ->orderBy('a.idtkpendid', 'asc')
                    ->groupBy('a.idtkpendid')
                    ->get();

                $n = 0;
            ?>

            @if(count($rs) > 0)
                @foreach($rs as $item)
                    <?php
                        $n++;
                        $gol[] = $item->gol;
                        $golempty[] = $item->golempty;
                        $ia[] = $item->ia;
                        $ib[] = $item->ib;
                        $ic[] = $item->ic;
                        $id[] = $item->id;
                        $iia[] = $item->iia;
                        $iib[] = $item->iib;
                        $iic[] = $item->iic;
                        $iid[] = $item->iid;
                        $iiia[] = $item->iiia;
                        $iiib[] = $item->iiib;
                        $iiic[] = $item->iiic;
                        $iiid[] = $item->iiid;
                        $iva[] = $item->iva;
                        $ivb[] = $item->ivb;
                        $ivc[] = $item->ivc;
                        $ivd[] = $item->ivd;
                        $ive[] = $item->ive;
                    ?>

                    <tr>
                        <td><div class="text-left">{{$item->tkpendid}}</div></td>
                        <td><div class="link text-center" data="notnull" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->gol}}</div></div></td>
                        <td><div class="link text-center" data="null" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->golempty}}</div></div></td>
                        <td><div class="link text-center" data="11" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->ia}}</div></div></td>
                        <td><div class="link text-center" data="12" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->ib}}</div></div></td>
                        <td><div class="link text-center" data="13" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->ic}}</div></div></td>
                        <td><div class="link text-center" data="14" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->id}}</div></div></td>
                        <td><div class="link text-center" data="21" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iia}}</div></div></td>
                        <td><div class="link text-center" data="22" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iib}}</div></div></td>
                        <td><div class="link text-center" data="23" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iic}}</div></div></td>
                        <td><div class="link text-center" data="24" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iid}}</div></div></td>
                        <td><div class="link text-center" data="31" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iiia}}</div></div></td>
                        <td><div class="link text-center" data="32" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iiib}}</div></div></td>
                        <td><div class="link text-center" data="33" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iiic}}</div></div></td>
                        <td><div class="link text-center" data="34" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iiid}}</div></div></td>
                        <td><div class="link text-center" data="41" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->iva}}</div></div></td>
                        <td><div class="link text-center" data="42" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->ivb}}</div></div></td>
                        <td><div class="link text-center" data="43" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->ivc}}</div></div></td>
                        <td><div class="link text-center" data="44" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->ivd}}</div></div></td>
                        <td><div class="link text-center" data="45" ed1="{!!$item->idtkpendid!!}" ed2="{!!Input::get('idskpd')!!}" title="Lihat Detail"><div align='center'>{{$item->ive}}</div></div></td>
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
                    <th align="left">Total</th>
                    <th><div class="text-center">{{array_sum($gol)}}</div></th>
                    <th><div class="text-center">{{array_sum($golempty)}}</div></th>
                    <th><div class="text-center">{{array_sum($ia)}}</div></th>
                    <th><div class="text-center">{{array_sum($ib)}}</div></th>
                    <th><div class="text-center">{{array_sum($ic)}}</div></th>
                    <th><div class="text-center">{{array_sum($id)}}</div></th>
                    <th><div class="text-center">{{array_sum($iia)}}</div></th>
                    <th><div class="text-center">{{array_sum($iib)}}</div></th>
                    <th><div class="text-center">{{array_sum($iic)}}</div></th>
                    <th><div class="text-center">{{array_sum($iid)}}</div></th>
                    <th><div class="text-center">{{array_sum($iiia)}}</div></th>
                    <th><div class="text-center">{{array_sum($iiib)}}</div></th>
                    <th><div class="text-center">{{array_sum($iiic)}}</div></th>
                    <th><div class="text-center">{{array_sum($iiid)}}</div></th>
                    <th><div class="text-center">{{array_sum($iva)}}</div></th>
                    <th><div class="text-center">{{array_sum($ivb)}}</div></th>
                    <th><div class="text-center">{{array_sum($ivc)}}</div></th>
                    <th><div class="text-center">{{array_sum($ivd)}}</div></th>
                    <th><div class="text-center">{{array_sum($ive)}}</div></th>
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