<h4 class="text-center">{!!$title!!}</h4>
<table class="table table-striped table-hover table-condensed table-bordered">
    <thead class="bg-primary">
        <tr>
        <th rowspan="2"><div class="text-center">NO</div></th>
        <th rowspan="2">
            <div class="text-left">NAMA</div>
            <div class="text-left">TEMPAT, TGL LAHIR</div>
        </th>
        <th rowspan="2">
            <div class="text-center">NIP</div>
            <div class="text-center">KARPEG</div>
        </th>
        <th rowspan="2">
            <div class="text-center">GOLONGAN</div>            
        </th>        
        <th rowspan="2">
            <div class="text-center">JABATAN</div>
            <div class="text-center">UNIT KERJA</div>
            <div class="text-center">TMT</div>
        </th>        
        <th colspan="2">
            <div class="text-center">MASA&nbsp;KERJA <br> SAMPAI SEKARANG</div>
        </th>        
        <th rowspan="2">
            <div class="text-center">PENDIDIKAN TERAKHIR</div>
            <div class="text-center">TAHUN</div>
        </th>
        <th rowspan="2">
            <div class="text-center">AGAMA</div>
            <div class="text-center">USIA</div>
        </th>
        <th rowspan="2">
            <div class="text-center">AWAL PPPK</div>     
        </th>
        <th rowspan="2">
            <div class="text-center">AWAL KONTRAK</div>     
        </th>
        <th rowspan="2">
            <div class="text-center">AKHIR KONTRAK</div>
        </th>
        <th rowspan="2">
            <div class="text-center">BUP</div>
        </th>
        <th rowspan="2">
            <div class="text-center">JARAK AKHIR KONTRAK</div>
            <div class="text-center">DENGAN PENSIUN</div>
        </th>
    </tr>
    <tr>
        <th>
            <div class="text-center">THN</div>
        </th>
        <th>
            <div class="text-center">BLN</div>
        </th>
    </tr>
    </thead>
    <tbody>
	<?php
    $n = 0;
	foreach($detail as $item){ $n++;
      /*masa kerja*/
      $mkbln = substr($item->mkskr,-2) + $item->mkblncpn;
      if($mkbln > 12){
      $thnmkskr = substr($item->mkskr,0,-2)+1;
      $blnmkskr = "0".($mkbln-12);
      }else{
      $thnmkskr = substr($item->mkskr,0,-2);
      $blnmkskr = (strlen($mkbln)==2)?$mkbln:"0".$mkbln;
      }

      $tmtmulaiawal_pppk = new \Datetime($item->tmtmulaiawal_pppk);
      $tmtakhirawal_pppk = new \Datetime($item->tmtakhirawal_pppk);
      $tmtmulaiakhir_pppk = new \Datetime($item->tmtmulaiakhir_pppk);
      $tmtakhirakhir_pppk = new \Datetime($item->tmtakhirakhir_pppk);
      $pensiunnext = new \Datetime($item->pensiunnext);
      $format = 'd-m-Y';

      //PERHITUNGAN JARAK AKHIR KONTRAK DENGAN PENSIUN     
      $hasil = date_diff($pensiunnext,$tmtakhirakhir_pppk);
	?>
    <tr>
        <td align="center">{!!$n!!}.</td>
        <td>
            <div class="text-left">{!!$item->namalengkap!!}</div>
            <small><div class="text-left">{!!$item->tmlhr!!}, {!!($item->tglhr!='0000-00-00')?date('d-m-Y', strtotime($item->tglhr)):''!!}</div></small>            
        </td>
        <td align="center">
            <div class="text-center">{!!$item->nip!!}</div>
            <div class="text-center">{!!$item->nokarpeg!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->golru_p3k!!}</div>
            <div class="text-center">{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</div>
        </td>        
        <td>
            <small>
                <div class="text-left">{!!ucwords($item->jabatan)!!}</div>
                <div class="text-left"><i>Pada</i></div>
                <div class="text-left">{!!ucwords($item->path)!!}</div>
                <div class="text-left">TMT : {!!($item->tmtjbt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtjbt)):''!!}</div>
            </small>
        </td>        
        <td align="center">
            <div class="text-center">{!!$thnmkskr!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$blnmkskr!!}</div>
        </td>        
        <td>
            <div class="text-left">{!!ucwords($item->jenjurusan)!!}</div>
            <div class="text-left">{!!$item->thijaz!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!$item->agama!!}</div>
            <div class="text-center">{!!substr($item->usia,0,2)!!} thn {!!substr($item->usia,2,2)!!} bln</div>
        </td>
        <td align="center">
            <div class="text-center">{!!($item->tmtmulaiawal_pppk!='0000-00-00')?$tmtmulaiawal_pppk->format($format):''!!}</div>          
        </td>
        <td align="center">
            <div class="text-center">{!!($item->tmtmulaiakhir_pppk!='0000-00-00')?$tmtmulaiakhir_pppk->format($format):''!!}</div>
        </td>
        <td align="center">            
            <div class="text-center">{!!($item->tmtakhirakhir_pppk!='0000-00-00')?$tmtakhirakhir_pppk->format($format):''!!}</div>
        </td>
        <td align="center">
            <div class="text-center">{!!($item->pensiunnext!='0000-00-00')?$pensiunnext->format($format):''!!}</div>            
        </td>
        <td align="center">
            <div class="text-center">{!!$hasil->y!!} Tahun {!!($hasil->y > 0)?$hasil->m:$item->selisih_bulankerja!!} Bulan</div>            
        </td>
    </tr>
	<?php } ?>
  </tbody>
</table>
