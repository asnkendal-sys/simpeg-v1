@if(Request::segment(3) == 'print')
<html>
<head>
    <title>{!!ucfirsts(getUtility('alias_aplikasi'))!!} Statistik Rekap Jabatan Dan Golongan</title>
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

<script>
	$(document).ready(function(){
		$('#tb-statistik .link').click(function(){
            var vidjenpens = $(this).attr("ed1");

            $('#form-print #idjenpens').val(vidjenpens);
            $('#form-print').submit();
		});
	});
</script>

<form id="form-print" name="form-print" action="{!!url()!!}/epersonal/statistikpegawai/print/statistikrekappensiun_statistik" class="form-horizontal" method="post" enctype="multipart/form-data" target="_blank">
    {!!csrf_field()!!}
    <input type="hidden" id="idjenpens" name="idjenpens" value="" />
    <input type="hidden" id="idskpd" name="idskpd" value="{!! Input::get('idskpd')!!}" />
    <input type="hidden" id="bulan1" name="bulan1" value="{!! Input::get('bulan1')!!}" />
    <input type="hidden" id="bulan2" name="bulan2" value="{!! Input::get('bulan2')!!}" />
    <input type="hidden" id="tahun" name="tahun" value="{!! Input::get('tahun')!!}" />
</form> <br/><br/>
<h3 align="center">REKAPITULASI PNS PENSIUN {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'KABUPATEN KENDAL')!!}</h3>
<h3 align="center">     
    @if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')) 
        BULAN {!!strtoupper(formatBulan(Input::get('bulan1')))!!} - {!!strtoupper(formatBulan(Input::get('bulan2')))!!}
    @elseif ((Input::get('bulan1') == '') and (Input::get('bulan2') != '')) 
        BULAN {!!strtoupper(formatBulan(Input::get('bulan2')))!!}
    @elseif ((Input::get('bulan1') != '') and (Input::get('bulan2') == '')) 
        BULAN {!!strtoupper(formatBulan(Input::get('bulan1')))!!}
    @endif {!!((Input::get('tahun') != '')?'TAHUN '.Input::get('tahun'):'')!!}
</h3>
<table class="table table-hovered table-bordered" id="tb-statistik" border="{!!(Request::segment(3) == 'print')?'1':'0'!!}">
	<thead class="bg-primary">
		<tr>
            <th rowspan="2"><div class="text-center">NO.</div></th>
			<th rowspan="2"><div class="text-center">JENIS PENSIUN</div></th>
            <th rowspan="2"><div class="text-center">JUMLAH</div></th>
		</tr>
	</thead>
	<tbody>
        <?php
        $where = " b.idjenkedudupeg not in ('21') and b.idjenkedudupeg='99' and b.nip !=''";
        
        if(Input::get('idskpd') != ''){
            $where .= " and b.idskpd like '".Input::get('idskpd')."%' ";
        }else{
            $where .= "";
        }
        
        /* Kondisi Tahun */
        if(Input::get('tahun') != ''){
            $where .= " and YEAR(b.tmtpens)= ".Input::get('tahun')."";
        }

        /* Kondisi Bulan */
        if((Input::get('bulan1') != '') and (Input::get('bulan2') != '')){
            $where .= " and MONTH(b.tmtpens) between ".Input::get('bulan1')." and ".Input::get('bulan2')."";
        }else if((Input::get('bulan1') != '') and (Input::get('bulan2') == '')){
            $where .= " and MONTH(b.tmtpens)= ".Input::get('bulan1')."";
        }else if((Input::get('bulan1') == '') and (Input::get('bulan2') != '')){
            $where .= " and MONTH(b.tmtpens)= ".Input::get('bulan2')."";
        }
        

            $rs = \DB::table('a_jenpens as a')
                    ->select('a.idjenpens as idjenispensiun', 'a.jenpens',\DB::raw('count(b.idjenpens) as jumlah'))
                    ->leftjoin('tb_01 as b','a.idjenpens','=','b.idjenpens')
                    ->whereRaw($where)
                    ->groupBy('b.idjenpens')
                    ->get();
        
        $n = 0;
        $total = 0;
    ?>

    @if(count($rs) > 0)
        @foreach($rs as $item)
            <?php
                $n++;
            ?>
            <tr>
                <td><center>{!!$n!!}</center></td>
                <td><div class="text-left">{!!$item->jenpens!!}</div></td>
                <td><center><div class="link" ed1="{!!$item->idjenispensiun!!}">{!! $item->jumlah !!}</div></center></td>    
            </tr>
            <?
                $total += $item->jumlah;
            ?>
        @endforeach
    @else
        <tr>
            <td colspan="2">Data tidak ditemukan.</td>
        </tr>
    @endif
    </tbody>
    @if(count($rs) > 0)
    <tfoot class="breadcrumb">
        <tr>
            <th rowspan="2" colspan="2">
                <div class="text-center">TOTAL</div>
            </th>
            <th>
                <div class="text-center">{!! $total !!}</div>
            </th>
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
