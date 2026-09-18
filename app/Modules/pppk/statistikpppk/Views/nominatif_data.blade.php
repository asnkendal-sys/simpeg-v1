
<?php
	$where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.idstspeg = 3 ";
    $having = '';

    /* Kondisi jabatan jabatan*/      

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
                tb_01.kdunit, a_skpd.skpd, COUNT(*) AS jml, SUM(IF(tr_pppk.sts_kontrak=2 and tr_pppk.status=1,1,0)) AS perpanjang, SUM(IF(tr_pppk.sts_kontrak=3,1,0)) AS berhenti,SUM(IF(tr_pppk.status=2,1,0)) AS tidakdiusulkan, 
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
<br><div align="center">
<h4>DAFTAR NOMINATIF PEGAWAI PPPK HABIS KONTRAK</h4>
<h4>
    {!!((Input::get('idskpd') != '')?'PADA '.strtoupper(getSkpd(Input::get('idskpd'))):'')!!}
    {!!(((Input::get('bulan1') != '') or (Input::get('bulan2') != ''))?$titlebulan:'')!!}
    {!!(((Input::get('tahun1') != '') or (Input::get('tahun2') != ''))?$titletahun:'')!!}
</h4>
</div><br>
<table border="1" width="100%" id="table table-striped table-hover table-condensed table-bordered">
    <thead class="bg-primary">
    <tr>
        <th rowspan="2" class="text-center">NO</th>        
        <th rowspan="2" class="text-center">UNIT KERJA</th>        
        <th rowspan="2" class="text-center">JUMLAH KONTRAK</th>        
        <th colspan="3" class="text-center">USULAN</th>        
        <th colspan="2" class="text-center">STATUS VERIFIKASI</th>        
        <th colspan="2" class="text-center">STATUS PROSES</th>        
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
        <td class="text-center">{!!$x!!}.</td>        
        <td class="text-left">{!!$item->skpd!!}</td>
        <td class="text-center"><a href="javascript:void(0)" title="Lihat Detail" class="prev-detail" recidskpd="{!!$item->kdunit!!}" recstatus="1">{!!$item->jml!!}</a></td>
        <td class="text-center"><a href="javascript:void(0)" title="Lihat Detail" class="prev-detail" recidskpd="{!!$item->kdunit!!}" recstatus="2">{!!$item->perpanjang!!}</a></td>
        <td class="text-center"><a href="javascript:void(0)" title="Lihat Detail" class="prev-detail" recidskpd="{!!$item->kdunit!!}" recstatus="3">{!!$item->berhenti!!}</a></td>
        <td class="text-center"><a href="javascript:void(0)" title="Lihat Detail" class="prev-detail" recidskpd="{!!$item->kdunit!!}" recstatus="8">{!!$item->tidakdiusulkan!!}</a></td>
        <td class="text-center"><a href="javascript:void(0)" title="Lihat Detail" class="prev-detail" recidskpd="{!!$item->kdunit!!}" recstatus="4">{!!$item->belum!!}</a></td>
        <td class="text-center"><a href="javascript:void(0)" title="Lihat Detail" class="prev-detail" recidskpd="{!!$item->kdunit!!}" recstatus="5">{!!$item->tms!!}</a></td>
        <td class="text-center"><a href="javascript:void(0)" title="Lihat Detail" class="prev-detail" recidskpd="{!!$item->kdunit!!}" recstatus="6">{!!$item->proses!!}</a></td>
        <td class="text-center"><a href="javascript:void(0)" title="Lihat Detail" class="prev-detail" recidskpd="{!!$item->kdunit!!}" recstatus="7">{!!$item->selesai!!}</a></td>
    </tr>
	<?php } ?>
    <tr>
        <td>&nbsp;</td>
        <td>TOTAL</td>
        <td class="text-center">{!!array_sum($tot_jml)!!}</td>
        <td class="text-center">{!!array_sum($tot_perpanjang)!!}</td>
        <td class="text-center">{!!array_sum($tot_berhenti)!!}</td>
        <td class="text-center">{!!array_sum($tot_tidakdiusulkan)!!}</td>
        <td class="text-center">{!!array_sum($tot_belum)!!}</td>
        <td class="text-center">{!!array_sum($tot_tms)!!}</td>
        <td class="text-center">{!!array_sum($tot_proses)!!}</td>
        <td class="text-center">{!!array_sum($tot_selesai)!!}</td>
    </tr>
  </tbody>
</table>


<script>
    $(document).ready(function(){
        $('.prev-detail').on('click', function(e){
            e.preventDefault();
            var idskpd = $(this).attr('recidskpd');
            var idstatus = $(this).attr('recstatus');

            claravel_modal('Detail Kontrak PPPK','Loading...','main_modal2');
            $.ajax({
                url : '{{url('')}}/pppk/statistikpppk/detail',
                type : 'post',
                data : {
                    'idskpd': idskpd, 
                    'idstatus': idstatus, 
                    'bulan1': "{!!Input::get('bulan1')!!}", 
                    'bulan2': "{!!Input::get('bulan2')!!}", 
                    'tahun1': "{!!Input::get('tahun1')!!}", 
                    'tahun2': "{!!Input::get('tahun2')!!}", 
                    '_token': '{!!csrf_token()!!}'
                },
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });
        })        
    })
</script>