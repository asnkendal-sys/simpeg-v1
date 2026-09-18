<?php
    $rs = \DB::table('tb_01')
        ->select('tb_01.nip','a_skpd.skpd',
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap, b_skpd.skpd as unit'),
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan')
        )
        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->join('a_skpd as b_skpd', 'tb_01.kdunit', '=', 'b_skpd.idskpd')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        ->where('nip', Input::get('nip'))
        ->first();

    $rhukdis = \BiodataModel::getRhukdis(Input::get('nip'));
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="col-md-12">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-fw fa-child"></i> RIWAYAT HUKUMAN DISIPLIN</h3>
                    </div>
                    <table border="0">
                        <tr>
                            <td width="25%">NIP</td>
                            <td width="1%">:</td>
                            <td width="74%">{!!$rs->nip!!}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{!!$rs->namalengkap!!}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>{!!$rs->jabatan!!}</td>
                        </tr>
                        <tr>
                            <td>Unit Kerja</td>
                            <td>:</td>
                            <td>{!!$rs->unit!!}</td>
                        </tr>
                        <tr>
                            <td>Sub Unit</td>
                            <td>:</td>
                            <td>{!!$rs->skpd!!}</td>
                        </tr>
                    </table>
                    <br>
                </div>
                <div class="col-md-12">
                    <table border="0" class="table table-stripped table-hovered">
                        <thead class="bg-primary">
                        <tr>
                            <!--<th width="2%"><div class="text-center">NO</div></th>-->
                            <th><div class="text-center">JENIS&nbsp;HUKUM&nbsp;DISIPLIN</div></th>
                            <th><div class="text-center">TINGKAT</div></th>
                            <th><div class="text-center">PEJABAT</div></th>
                            <th><div class="text-center">NO.&nbsp;SK <br>TGL.&nbsp;SK</div></th>
                            <th><div class="text-center">TGL.&nbsp;MULAI<br>TGL.&nbsp;SELESAI</div></th>
                            <th><div class="text-center">KETERANGAN</div></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($rhukdis->get()) > 0)
                            <?php $n = 0; ?>
                            @foreach($rhukdis->get() as $item)
                            <?php $n++; ?>
                            <tr>
                                <!--<td align="center">{!!$n!!}.</td>-->
                                <td>{!!$item->jenhukum!!} {!!($item->kathukdis!='')?'-'.$item->kathukdis:''!!}</td>
                                <td>{!!$item->pejab!!}</td>
                                <td>{!!$item->nosk!!} <br> {!!date('d-m-Y',strtotime($item->tgsk))!!}</td>
                                <td align="center">{!!date('d-m-Y',strtotime($item->tgmul))!!} <br> {!!date('d-m-Y',strtotime($item->tgsel))!!}</td>
                                <td>{!!$item->ket!!}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9">Riwayat hukuman disiplin tidak tersedia.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>