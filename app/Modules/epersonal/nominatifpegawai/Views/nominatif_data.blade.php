<?php
    $where = " tb_01.idjenkedudupeg not in('99','21')";

    /*Kondisi list NIP*/
    $listpegawai = Input::get('listpegawai');
    if(!empty($listpegawai)){
        $x = 0;
        $data = '';
        foreach ($listpegawai as $item) {
            $x++;
            $data .= $item.((count($listpegawai) == $x)?'':',');
        }

        $where.= " and tb_01.nip in (".$data.")";
    }

    /* Kondisi golongan */
    if(Input::get('opt') == ''){
        $where .= " and tb_01.idgolrupkt = '".Input::get('idgolru')."'";
    }else if(Input::get('opt') != ''){
        if(Input::get('opt') == '1'){
            $where .= " and tb_01.idgolrupkt > '".Input::get('idgolru')."'";
        } else if(Input::get('opt') == '2'){
            $where .= " and tb_01.idgolrupkt < '".Input::get('idgolru')."'";
        } else if(Input::get('opt') == '3'){
            $where .= " and tb_01.idgolrupkt between '".Input::get('idgolru')."' and '".Input::get('idgolru2')."'";
        }
    }

    /* Kondisi eselon */
    if(Input::get('idesl') != ''){
        $where .= " and tb_01.idesljbt = '".Input::get('idesl')."'";
    }
/* Kondisi struktural */
if (Input::get('idisesl') != '') {
    if (Input::get('idisesl') == 'esl') {
        $where .= " and tb_01.idesljbt in('21','22','31','32','41','42')";
    } else if (Input::get('idisesl') == 'koord') {
        $where .= " and tb_01.idkoord!=''";
    } else {
        $where .= " and tb_01.iskepsek='1'";
    }
}
    /* Kondisi jenjang kedudukan pegawai */
    if(Input::get('idjenkedudupeg') != ''){
        $where .= " and tb_01.idjenkedudupeg = '".Input::get('idjenkedudupeg')."'";
    }

    /* Kondisi diklat */
    if(Input::get('iddikstru') != ''){
        $where .= " and tb_01.iddikstru = '".Input::get('iddikstru')."'";
    }

    /* Kondisi jenis kelamin */
    if(Input::get('idjenkel') != ''){
        $where .= " and tb_01.idjenkel = '".Input::get('idjenkel')."'";
    }

    /* Kondisi agama */
    if(Input::get('idagama') != ''){
        $where .= " and tb_01.idagama = '".Input::get('idagama')."'";
    }

    /* Kondisi pendidikan */
    if(Input::get('idtkpendid') != ''){
        $where .= " and tb_01.idtkpendid = '".Input::get('idtkpendid')."'";
    }

    //kondisi subkoordinator
    if(Input::get('idkoord') != ''){
        $where .= " and tb_01.idkoord != ''";
    }

    /* Kondisi jenis jabatan */
    if(Input::get('idjenjab') != ''){
        $where .= " and tb_01.idjenjab = '".Input::get('idjenjab')."'";

        if(Input::get('idjenjab') == 2){
            /*Kondisi jika jabatan fungsional umum*/
            if((Input::get('idtkjabfung') != '') and (Input::get('idjabfung') != '')){
                $where .= " and tb_01.idjabfung = '".Input::get('idjabfung')."'";
            }else if((Input::get('idtkjabfung') != '') and (Input::get('idjabfung') == '')){
                $where .= " and tb_01.idjabfung like '".Input::get('idtkjabfung')."%'";
            }else if((Input::get('idtkjabfung') == '') and (Input::get('idjabfung') != '')){
                $where .= " and tb_01.idjabfung = '".Input::get('idjabfung')."'";
            }
        }else if(Input::get('idjenjab') == 3){
            /*Kondisi jika jabatan fungsional tertentu*/
            if(Input::get('idjabfungum') != ''){
                $where .= " and tb_01.idjabfungum = '".Input::get('idjabfungum')."'";
            }
        }
    }

    /* Kondisi status pegawai */
    $idstspeg = Input::get('idstspeg');
    if($idstspeg != ''){
        $x = 0;
        $data = '';
        foreach ($idstspeg as $item) {
            $x++;
            $data .= $item.((count($idstspeg) == $x)?'':',');
        }
        $where.= " and tb_01.idstspeg in (".$data.")";
    }

    /* Kondisi skpd atau unit kerja */
    switch(Input::get('idskpd')){
        case "":
            $where .= " ";
            break;
        default:
            $where .= " and tb_01.idskpd like '".Input::get('idskpd')."%'";
            break;
    }

    /* Kondisi urut data */
    $order = (Input::get('order')=='')?'':Input::get('order');
    switch(Input::get('urutan')){
        case "1":
            $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.idgolrupkt $order, tmtpkt, tb_01.iddikstru, tb_01.nama";
            break;
        case "2":
            $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.nip $order, tb_01.idgolrupkt, tmtpkt, tb_01.nama";
            break;
        case "3":
            $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.nama $order, tb_01.idgolrupkt, tmtpkt, tb_01.nip";
            break;
        case "4":
            $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.tglhr $order, tb_01.idgolrupkt, tmtpkt, tb_01.nama";
            break;
        default:
            $urutan = "tb_01.idskpd, a_jenjab.order, tb_01.idesljbt desc, tb_01.idgolrupkt $order, tmtpkt, tb_01.nama, tb_01.tglhr";
            break;
    }

    $rs = \DB::table('tb_01')
        ->select('tb_01.*','z.skpd','a_golruang.golru','a_golruang.pangkat','a_golruang.golru_p3k','a_skpd.path_short','a_skpd.skpd as sub_unit','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab',
            'a_tugasgurudosen.tugasgurudosen','a_matkulpel.matkulpel','a_sekolahswasta.nmasekolah','a_tugasdokter.tugasdokter','a_jabfung.jenjang',
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
        )
        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->leftjoin('a_skpd as z', 'tb_01.idkoord', '=', 'z.idskpd')
        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
        ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        ->leftjoin('a_tugasgurudosen', 'tb_01.idtugasgurudosen', '=', 'a_tugasgurudosen.idtugasgurudosen')
        ->leftjoin('a_matkulpel', 'tb_01.idmatkulpel', '=', 'a_matkulpel.idmatkulpel')
        ->leftjoin('a_sekolahswasta', 'tb_01.iddiperbantukan', '=', 'a_sekolahswasta.id')
        ->leftjoin('a_tugasdokter', 'tb_01.idtugasdokter', '=', 'a_tugasdokter.idtugasdokter')
        ->whereRaw($where)
        ->orderBy(\DB::raw($urutan))
        ->get();
?>

<div align="center">
<h4>DAFTAR NOMINATIF PEGAWAI NEGERI SIPIL</h4>
<h4>{!!(Input::get('idskpd')!='')?'PADA '.getSkpd(Input::get('idskpd')):''!!}</h4>
</div>
<table border="0" width="100%" class="table table-striped table-hover table-condensed table-bordered">
  <thead class="bg-primary">
    <tr>
        <th><div class="text-center">NO</div></th>
        <th><div class="text-left">NAMA</div></th>
        <th><div class="text-center">NIP</div></th>
 @if(Input::get('tmtakhirpppk'))
            <th>
                <div class="text-left">TMT AKHIR PPPK</div>
            </th>
            @endif
        @if(Input::get('tmlhr2'))
        <th><div class="text-left">TEMPAT LAHIR</div></th>
        @endif
        @if(Input::get('tglhr2'))
        <th><div class="text-center">TANGGAL LAHIR</div></th>
        @endif
        @if(Input::get('idagama2'))
        <th><div class="text-left">AGAMA</div></th>
        @endif
        @if(Input::get('idjenkel2'))
        <th><div class="text-left">JENIS KELAMIN</div></th>
        @endif
        @if(Input::get('alm2'))
        <th><div class="text-left">ALAMAT</div></th>
        @endif
        @if(Input::get('telp2'))
        <th><div class="text-left">NO TELEPON</div></th>
        @endif
        @if(Input::get('email'))
        <th><div class="text-left">EMAIL PRIBADI</div></th>
        @endif
        @if(Input::get('nonpwp2'))
        <th><div class="text-left">NO NPWP</div></th>
        @endif
        @if(Input::get('noktp2'))
        <th><div class="text-left">NO KTP</div></th>
        @endif
        @if(Input::get('sipd2'))
        <th><div class="text-left">SIPD</div></th>
        @endif
        @if(Input::get('idstspeg2'))
        <th><div class="text-left">STATUS PEGAWAI</div></th>
        @endif
        @if(Input::get('tmtcpn2'))
        <th><div class="text-left">TMT CPNS</div></th>
        @endif
        @if(Input::get('tmtpns2'))
        <th><div class="text-left">TMT PNS</div></th>
        @endif
        @if(Input::get('golru2'))
        <th><div class="text-center">GOL.</div></th>
        @endif
        @if(Input::get('pangkat2'))
        <th><div class="text-center">PANGKAT</div></th>
        @endif
        @if(Input::get('tmtpkt2'))
        <th><div class="text-center">TMT GOL</div></th>
        @endif
        @if(Input::get('idtkpendid2'))
        <th><div class="text-left">JENJANG PENDIDIKAN</div></th>
        @endif
        @if(Input::get('idjenjurusan2'))
        <th><div class="text-left">JURUSAN PENDIDIKAN</div></th>
        @endif
        @if(Input::get('sekolah2'))
        <th><div class="text-left">NAMA SEKOLAH</div></th>
        @endif
        @if(Input::get('thijaz2'))
        <th><div class="text-left">TAHUN LULUS</div></th>
        @endif
        @if(Input::get('kdunit2'))
        <th><div class="text-left">INSTANSI INDUK</div></th>
        @endif
        @if(Input::get('path2'))
        <th><div class="text-left">INSTANSI SUB UNIT </div></th>
        @endif
        @if(Input::get('idjenjab2'))
        <th><div class="text-left">JENIS JABATAN</div></th>
        @endif
        @if(Input::get('jabatan2'))
        <th><div class="text-left">JABATAN</div></th>
        @endif
        @if(Input::get('tmtjbt2'))
        <th><div class="text-left">TMT JABATAN</div></th>
        @endif
        @if(Input::get('idesljbt2'))
        <th><div class="text-center">ESELON</div></th>
        @endif
        @if(Input::get('tugasgurudosen2'))
        <th><div class="text-left">TUGAS GURU</div></th>
        @endif
        @if(Input::get('matkulpel2'))
        <th><div class="text-left">MATA PELAJARAN</div></th>
        @endif
        @if(Input::get('iskepsek2'))
        <th><div class="text-left">KEPALA SEKOLAH</div></th>
        @endif
        @if(Input::get('nmasekolah2'))
        <th><div class="text-left">SEKOLAH DIPERBANTUKAN </div></th>
        @endif
        @if(Input::get('tugasdokter2'))
        <th><div class="text-left">TUGAS DOKTER</div></th>
        @endif
        @if(Input::get('jenjang2'))
        <th><div class="text-left">JENJANG JABATAN FUNGSIONAL </div></th>
        @endif
        @if(Input::get('idkoord'))
        <th><div class="text-left">KOORDINATOR </div></th>
        @endif
    </tr>
  </thead>
  <tbody>
	<?php $n = 0; ?>
    @foreach ($rs as $item)
    <?php $n++; ?>
    <tr>
        <td align="center">{!!$n!!}.</td>
        <td><div class="text-left">{!!$item->namalengkap!!}</div></td>
        <td><div class="text-left">{!!$item->nip!!}</div></td>
        @if(Input::get('tmlhr2'))
        <td><div class="text-left">{!!$item->tmlhr!!}</div></td>
        @endif
     @if(Input::get('tmtakhirpppk'))
            <td>
                <div class="text-left">{!!date('d-m-Y', strtotime($item->tmtakhirawal_pppk))!!}</div>
            </td>
            @endif
        @if(Input::get('tglhr2'))
        <td><div class="text-left">{!!date('d-m-Y', strtotime($item->tglhr))!!}</div></td>
        @endif
        @if(Input::get('idagama2'))
        <td><div class="text-left">{!!$item->agama!!}</div></td>
        @endif
        @if(Input::get('idjenkel2'))
        <td><div class="text-left">{!!$item->jenkel!!}</div></td>
        @endif
        @if(Input::get('alm2'))
        <td><div class="text-left">{!!$item->alm!!} {!! ($item->almrt!='')? 'RT. '.$item->almrt.'':'' !!} {!! ($item->almrt!='' && $item->almrw!='' )? '/':'' !!} {!! ($item->almrw!='')? 'RW. '.$item->almrw.'':'' !!} <br/> {!! ($item->almdesa!='')? 'Desa/Kel. '.$item->almdesa.'':'' !!} {!! ($item->almkec!='')? 'Kec. '.$item->almkec.'':'' !!} {!! ($item->almkab!='')? 'Kab/Kota. '.$item->almkab.'':'' !!} <br/> {!! ($item->almprov!='')? 'Prov. '.$item->almprov.'':'' !!} {!! ($item->almkdpos!='')? 'Kode Pos.'.$item->almkdpos.'':'' !!}</div></td>
        @endif
        @if(Input::get('telp2'))
        <td><div class="text-left">{!!$item->hp!!}</div></td>
        @endif
        @if(Input::get('email'))
        <td><div class="text-left">{!!$item->email!!}</div></td>
        @endif
        @if(Input::get('nonpwp2'))
        <td><div class="text-left">{!!$item->nonpwp!!}</div></td>
        @endif
        @if(Input::get('noktp2'))
        <td><div class="text-left">{!!$item->noktp!!}</div></td>
        @endif
        @if(Input::get('sipd2'))
        <td><div class="text-left">-</div></td>
        @endif
        @if(Input::get('idstspeg2'))
        <td><div class="text-left">{!!(($item->idstspeg=='1')?'CPNS':(($item->idstspeg=='2')?'PNS':'PPPK'))!!}</div></td>
        @endif
        @if(Input::get('tmtcpn2'))
        <td><div class="text-left">{!!date('d-m-Y', strtotime($item->tmtcpn))!!}</div></td>
        @endif
        @if(Input::get('tmtpns2'))
        <td><div class="text-left">{!!date('d-m-Y', strtotime($item->tmtpns))!!}</div></td>
        @endif
        @if(Input::get('golru2'))
        <td><div class="text-center">{!!($item->idstspeg=='3')?$item->golru_p3k:$item->golru!!}</div></td>
        @endif
        @if(Input::get('pangkat2'))
        <td><div class="text-left">{!!$item->pangkat!!}</div></td>
        @endif
        @if(Input::get('tmtpkt2'))
        <td><div class="text-center">{!!date('d-m-Y', strtotime($item->tmtpkt))!!}</div></td>
        @endif
        @if(Input::get('idtkpendid2'))
        <td><div class="text-left">{!!$item->tkpendid!!}</div></td>
        @endif
        @if(Input::get('idjenjurusan2'))
        <td><div class="text-left">{!!$item->jenjurusan!!}</div></td>
        @endif
        @if(Input::get('sekolah2'))
        <td><div class="text-left">{!!$item->namasekolah!!}</div></td>
        @endif
        @if(Input::get('thijaz2'))
        <td><div class="text-left">{!!$item->thijaz!!}</div></td>
        @endif
        @if(Input::get('kdunit2'))
        <td><div class="text-left">{!!ucwords(($item->kdunit!=$item->idskpd)?getSkpd($item->kdunit):getSkpd($item->idskpd))!!}</div></td>
        @endif
        @if(Input::get('path2'))
        <!-- <td><div class="text-left">{!!ucwords($item->path_short)!!}</div></td> -->
        <td><div class="text-left">{!!ucwords($item->sub_unit)!!}</div></td>
        @endif
        @if(Input::get('idjenjab2'))
        <td><div class="text-left">{!!$item->jenjab!!}</div></td>
        @endif
        @if(Input::get('jabatan2'))
        <td><div class="text-left">{!!ucwords($item->jabatan)!!}</div></td>
        @endif
        @if(Input::get('tmtjbt2'))
        <td><div class="text-center">{!!date('d-m-Y', strtotime($item->tmtjbt))!!}</div></td>
        @endif
        @if(Input::get('idesljbt2'))
        <td><div class="text-center">{!!($item->esl!='')?$item->esl:'-'!!}</div></td>
        @endif
        @if(Input::get('tugasgurudosen2'))
        <td><div class="text-left">{!!$item->tugasgurudosen!!}</div></td>
        @endif
        @if(Input::get('matkulpel2'))
        <td><div class="text-left">{!!$item->matkulpel!!}</div></td>
        @endif
        @if(Input::get('iskepsek2'))
        <td><div class="text-center">{!!($item->iskepsek==1)?'Ya':'-'!!}</div></td>
        @endif
        @if(Input::get('nmasekolah2'))
        <td><div class="text-left">{!!$item->nmasekolah!!}</div></td>
        @endif
        @if(Input::get('tugasdokter2'))
        <td><div class="text-left">{!!$item->tugasdokter!!}</div></td>
        @endif
        @if(Input::get('jenjang2'))
        <td><div class="text-left">{!!$item->jenjang!!}</div></td>
        @endif
        @if(Input::get('idkoord'))
        <td><div class="text-left">{!!$item->skpd!!}</div></td>
        @endif
    </tr>
    @endforeach
  </tbody>
</table>
