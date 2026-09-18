{!!View::make('home::portal.header')!!}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrappers" id='utama' style="padding-top: 50px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Digital Signature
            <!--<small>Version 2.0</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!!url()!!}/tracking"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Digital Signature</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box box-primary">
            <div class="row">
                <div class="col-md-12">

                    <?php
                    if($module == 'mutasi'){
                        $where = "statussk = 1 and nousul = \"".$nousul."\"";
                        $where.= ($nip!='')?" and tb_01.nip = \"".$nip."\"":"";

                        switch ($jenis){
                            case 'pengantar' :
                            $nosk = 'no_sp';
                            $tglsk = 'tgl_sp';
                            $jabpenetap = 'jabpengantar';
                            $namapenetap = 'namapengantar';
                            $nippenetap = 'nippengantar';
                            $pangkatpenetap = 'pangkatpengantar';
                            break;
                            case 'permohonan' :
                            $nosk = 'no_sp';
                            $tglsk = 'tgl_sp';
                            $jabpenetap = '-';
                            $namapenetap = 'bupati';
                            $nippenetap = '-';
                            $pangkatpenetap = '-';
                            break;
                            case 'persetujuan' :
                            $nosk = 'nosk_persetujuan';
                            $tglsk = 'tglsk_persetujuan';
                            $jabpenetap = '-';
                            $namapenetap = 'bupati';
                            $nippenetap = '-';
                            $pangkatpenetap = '-';
                            break;
                            case 'menghadapkan' :
                            $nosk = 'nosk';
                            $tglsk = 'tglsurat';
                            $jabpenetap = '-';
                            $namapenetap = 'kepalabkd';
                            $nippenetap = 'nipkepalabkd';
                            $pangkatpenetap = 'pangkatbkd';
                            break;
                            case 'surattugas' :
                            $nosk = 'nosk';
                            $tglsk = 'tglsurat';
                            $jabpenetap = 'jabkepalasekda';
                            $namapenetap = 'kepalasekda';
                            $nippenetap = 'nipsekda';
                            $pangkatpenetap = 'pangkatsekda';
                            break;
                        }

                        switch ($submodule){
                            case 'dalamskpd' :
                            $nmmodule = "Mutasi Dalam OPD";
                            $item = \DB::table('tr_mutasi_dalam_skpd')
                            ->select('tr_mutasi_dalam_skpd.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','skpdlama.skpd as skpdlama','skpdbaru.skpd as skpdbaru',
                                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                                \DB::raw('IF(tr_mutasi_dalam_skpd.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_skpd.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_skpd.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
                                \DB::raw('IF(tr_mutasi_dalam_skpd.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_skpd.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_skpd.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru')
                            )
                            ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_skpd.idskpd', '=', 'skpdlama.idskpd')
                            ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_skpd.idskpdbaru', '=', 'skpdbaru.idskpd')
                            ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_skpd.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                            ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_skpd.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                            ->leftjoin('a_golruang', 'tr_mutasi_dalam_skpd.idgolrupkt', '=', 'a_golruang.idgolru')
                            ->leftjoin('tb_01', 'tr_mutasi_dalam_skpd.nip', '=', 'tb_01.nip')
                            ->leftjoin('a_jabfung', 'tr_mutasi_dalam_skpd.idjabfung', '=', 'a_jabfung.idjabfung')
                            ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_skpd.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                            ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_skpd.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
                            ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_skpd.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
                            ->whereRaw($where)
                            ->first();
                            break;
                            case 'antarskpd' :
                            $nmmodule = "Mutasi Antar OPD";
                            $item = \DB::table('tr_mutasi_dalam_daerah')
                            ->select('tr_mutasi_dalam_daerah.*','a_golruang.golru','a_golruang.pangkat','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','skpdlama.path as skpdlama','skpdbaru.path as skpdbaru',
                                \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
                                \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjab>4,skpdlama.jab,IF(tr_mutasi_dalam_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_dalam_daerah.idjenjab=3,a_jabfungum.jabfungum,"-"))) as jabatan'),
                                \DB::raw('IF(tr_mutasi_dalam_daerah.idjenjabbaru>4,skpdbaru.jab,IF(tr_mutasi_dalam_daerah.idjenjabbaru=2,a_jabfungbaru.jabfung,IF(tr_mutasi_dalam_daerah.idjenjabbaru=3,a_jabfungumbaru.jabfungum,"-"))) as jabatanbaru')
                            )
                            ->leftJoin('a_skpd as skpdlama', 'tr_mutasi_dalam_daerah.idskpd', '=', 'skpdlama.idskpd')
                            ->leftJoin('a_skpd as skpdbaru', 'tr_mutasi_dalam_daerah.idskpdbaru', '=', 'skpdbaru.idskpd')
                            ->leftjoin('a_tkpendid', 'tr_mutasi_dalam_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                            ->leftjoin('a_jenjurusan', 'tr_mutasi_dalam_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                            ->leftjoin('a_golruang', 'tr_mutasi_dalam_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
                            ->leftjoin('tb_01', 'tr_mutasi_dalam_daerah.nip', '=', 'tb_01.nip')
                            ->leftjoin('a_jabfung', 'tr_mutasi_dalam_daerah.idjabfung', '=', 'a_jabfung.idjabfung')
                            ->leftjoin('a_jabfungum', 'tr_mutasi_dalam_daerah.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                            ->leftjoin('a_jabfung as a_jabfungbaru', 'tr_mutasi_dalam_daerah.idjabfungbaru', '=', 'a_jabfungbaru.idjabfung')
                            ->leftjoin('a_jabfungum as a_jabfungumbaru', 'tr_mutasi_dalam_daerah.idjabfungumbaru', '=', 'a_jabfungumbaru.idjabfungum')
                            ->whereRaw($where)
                            ->first();
                            if ($item->idskpd == "") {
                                $nmmodule = "CPNS";
                            }
                            break;
                            case 'luarkabupaten' :
                            $nmmodule = "Mutasi Luar Kabupaten";
                            $item = \DB::table('tr_mutasi_luar_daerah')
                            ->select('tr_mutasi_luar_daerah.*','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_skpd.path_short as skpdlama','a_golruang.golru','a_golruang.pangkat',
                                \DB::raw("CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0,' ',''),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,', ',''),tb_01.gdb) AS namalengkap"),
                                \DB::raw("IF(tr_mutasi_luar_daerah.idjenjab>=20,a_skpd.jab,IF(tr_mutasi_luar_daerah.idjenjab=2,a_jabfung.jabfung,IF(tr_mutasi_luar_daerah.idjenjab=3,a_jabfungum.jabfungum,'-'))) AS jabatan")
                            )
                            ->leftJoin('tb_01','tr_mutasi_luar_daerah.nip','=','tb_01.nip')
                            ->leftJoin('a_tkpendid','tr_mutasi_luar_daerah.idtkpendid','=','a_tkpendid.idtkpendid')
                            ->leftJoin('a_jenjurusan','tr_mutasi_luar_daerah.idjenjurusan','=','a_jenjurusan.idjenjurusan')
                            ->leftJoin('a_skpd','tr_mutasi_luar_daerah.idskpd','=','a_skpd.idskpd')
                            ->leftJoin('a_jabfung','tr_mutasi_luar_daerah.idjabfung','=','a_jabfung.idjabfung')
                            ->leftJoin('a_jabfungum','tr_mutasi_luar_daerah.idjabfungum','=','a_jabfungum.idjabfungum')
                            ->leftJoin('a_golruang','tr_mutasi_luar_daerah.idgolrupkt','=','a_golruang.idgolru')
                            ->whereRaw($where)
                            ->first();
                            break;
                            case 'masukkabupaten' :
                            $nmmodule = "Mutasi Masuk Kabupaten";
                            $item = \DB::table('tr_mutasi_masuk_daerah')
                            ->select('tr_mutasi_masuk_daerah.*','a_golruang.golru','a_golruang.pangkat','a_skpd.path_short','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                                \DB::raw('CONCAT(tr_mutasi_masuk_daerah.gdp,IF(LENGTH(tr_mutasi_masuk_daerah.gdp)>0," ",""),tr_mutasi_masuk_daerah.nama,IF(LENGTH(tr_mutasi_masuk_daerah.gdb)>0,", "," "),tr_mutasi_masuk_daerah.gdb) as namalengkap'), \DB::raw('IF(tr_mutasi_masuk_daerah.idjenjabbaru>4,a_skpd.jab,IF(tr_mutasi_masuk_daerah.idjenjabbaru=2,a_jabfung.jabfung,IF(tr_mutasi_masuk_daerah.idjenjabbaru=3,a_jabfungum.jabfungum,"-"))) as jabatan'), \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_mutasi_masuk_daerah.tglhr)), '%Y%m')+0 AS usia")
                            )
                            ->leftjoin('a_skpd', 'tr_mutasi_masuk_daerah.idskpdbaru', '=', 'a_skpd.idskpd')
                            ->leftjoin('a_tkpendid', 'tr_mutasi_masuk_daerah.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                            ->leftjoin('a_jenjurusan', 'tr_mutasi_masuk_daerah.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                            ->leftjoin('a_golruang', 'tr_mutasi_masuk_daerah.idgolrupkt', '=', 'a_golruang.idgolru')
                            ->leftjoin('a_jabfung', 'tr_mutasi_masuk_daerah.idjabfungbaru', '=', 'a_jabfung.idjabfung')
                            ->leftjoin('a_jabfungum', 'tr_mutasi_masuk_daerah.idjabfungumbaru', '=', 'a_jabfungum.idjabfungum')
                            ->whereRaw("statussk = 1 and nousul = \"".$nousul."\" and nip = \"".$nip."\"")
                            ->first();
                            break;
                            default:
                            echo "Data tidak ditemukan.<br><a href='".url()."'>Kembali</a>";
                            exit();
                            break;
                        }
                    }
                    ?>

                    @if($module == 'mutasi')
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-fw fa-child"></i> BIODATA PRIBADI</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped table-hover table-condensed">
                                    <tbody>
                                        <tr>
                                            <td width="24%">NIP</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!$item->nip!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Nama</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!$item->namalengkap!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Pangkat / Golongan</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!$item->pangkat!!} / {!!ucword($item->golru)!!}</td>
                                        </tr>
                                        @if($submodule != 'masukkabupaten')
                                        <tr>
                                            <td width="24%">Jabatan</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->jabatan)!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Unit Kerja</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->skpdlama)!!}</td>
                                        </tr>
                                        @if($submodule != 'luarkabupaten')
                                        <tr>
                                            <td width="24%">Jabatan Baru</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->jabatanbaru)!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Unit Kerja Baru</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->skpdbaru)!!}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td width="24%">Jabatan Baru</td>
                                            <td width="1%">:</td>
                                            <td width="75%">-</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Unit Kerja Baru</td>
                                            <td width="1%">:</td>
                                            <td width="75%">
                                                <?=$item->instansi?>,
                                                <?=$item->kabupaten?>,
                                                <?=$item->provinsi?>.
                                            </td>
                                        </tr>
                                        @endif
                                        @else
                                        <tr>
                                            <td width="24%">Jabatan</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->jabatanlama)!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Unit Kerja</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->skpdlama)!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Jabatan Baru</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->jabatan)!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Unit Kerja Baru</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword($item->path_short)!!}</td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-fw fa-fire"></i> DIGITAL SIGNATURE</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped table-hover table-condensed">
                                    <tbody>
                                        <tr>
                                            <td width="24%">Jenis Dokumen</td>
                                            <td width="1%">:</td>
                                            <td width="75%">
                                            @if($jenis == 'surattugas')
                                            {!! "Surat Tugas ".@$nmmodule!!}</td>
                                            @else
                                            {!!ucword(@$jenis)." ".@$nmmodule!!}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td width="24%">Nomor SK</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!@$item->$nosk!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Tanggal SK</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!formatTanggalPanjang(@$item->$tglsk)!!}</td>
                                        </tr>
                                        @if($submodule == 'dalamskpd')
                                        <tr>
                                            <td width="24%">Jabatan Penetap</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!@$item->jabkepalabkd!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Nama Penetap</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!@$item->kepalabkd!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Nip Penetap</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!@$item->nipkepalabkd!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Pangkat Penetap</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword(@$item->pangkatbkd)!!}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td width="24%">Jabatan Penetap</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!@$item->$jabpenetap!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Nama Penetap</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!@$item->$namapenetap!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Nip Penetap</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!@$item->$nippenetap!!}</td>
                                        </tr>
                                        <tr>
                                            <td width="24%">Pangkat Penetap</td>
                                            <td width="1%">:</td>
                                            <td width="75%">{!!ucword(@$item->$pangkatpenetap)!!}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                    @endif

                    <!-- ./box-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

{!!View::make('home::portal.footer')!!}
