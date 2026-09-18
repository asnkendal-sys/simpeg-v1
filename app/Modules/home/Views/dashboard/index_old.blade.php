{!!View::make('home::dashboard.header')!!}
{!!View::make('home::dashboard.sidebar-left')!!}


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id='utama'>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard 
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
    @if(session('role_id')==5 && substr(session('user_id'), 12, 2)!=21)
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Indeks Profesionalitas
                            <b>{!!session('name')!!} </b>

                        </h3>

                        <div class="box-tools pull-right">
    <button type="button" id="tarikdatapersonal" recid="{!!session('user_id')!!}" class="btn btn-success btn-sm" title="Update Nilai IPASN">Update Nilai IP ASN
                                <i class="fa fa-download"></i></button>
  <a href="{{ route('file.download', ['filename' => 'tutorialupdateIPASN.pdf']) }}" class="btn btn-info btn-sm">
    Tutorial
</a>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <?php
                            // $nilaiasn = accessDatariwayatsiasn('pns/nilaiipasn', $nip);


                            $nilaiasn = \DB::table('tr_ipasn')->where('nip', '=', session("user_id"))->first();
                            $kinerja = $nilaiasn->kinerja;
                            $disiplin = $nilaiasn->hukdis;
                            $kompetensi = $nilaiasn->kompetensi;
                            $kualifikasi = $nilaiasn->kualifikasi;
                            ?>
                            <div class="col-lg-6 col-xs-6">
                             <div id="progressnilaiipasn">
                                <div class="progress-group">

                                    <span class="progress-text">Hasil Penilaian Kinerja</span>
                                    <span class="progress-number"><b>{{$nilaiasn->kinerja}}</b>/30</span>

                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-aqua" style="width:<?= ($kinerja / 30) * 100; ?>%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">Riwayat Hukum Disiplin</span>
                                    <span class="progress-number"><b>{{$nilaiasn->hukdis}}</b>/5</span>

                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-aqua" style="width: <?= ($disiplin / 5) * 100; ?>%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">Kompetensi - Riwayat Pengembangan Kompetensi</span>
                                    <span class="progress-number"><b>{{$nilaiasn->kompetensi}}</b>/40</span>

                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-aqua" style="width: <?= ($kompetensi / 40) * 100; ?>%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">Kualifikasi - Riwayat Pendidikan Terakhir</span>
                                    <span class="progress-number"><b>{{$nilaiasn->kualifikasi}}</b>/25</span>

                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-aqua" style="width: <?= ($kualifikasi / 25) * 100; ?>%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
 </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3 class="box-title">Indikator Pengukuran IP ASN Pada Dimensi Kompetensi</h3>
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body table-responsive no-padding">
                                                <table class="table table-hover">
                                                    <tr>
                                                        <th>Indikator</th>
                                                        <th>Struktural/Fungsional</th>
                                                        <th>Pelaksana</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Diklatpim/ Struktural</td>
                                                        <td><span class="label label-success text-center">15 %</span></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Diklat Fungsional</td>
                                                        <td><span class="label label-success text-center">15 %</span></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Diklat Teknis</td>
                                                        <td><span class="label label-success text-center">15 %</span> </td>
                                                        <td><span class="label label-info text-center">22.5 % </span> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Seminar</td>
                                                        <td><span class="label label-success text-center">10 %</span> </td>
                                                        <td><span class="label label-info text-center">17.5 %</span> </td>
                                                    </tr>

                                                </table>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                             <div id="nilaiipasn">
                                @if ($nilaiasn->subtotal > 90)
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="info-box bg-green">
                                        <span class="info-box-icon">
                                            <!-- <i class="fa fa-thumbs-o-up"></i> -->
                                            {{$nilaiasn->subtotal}}
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Nilai IP ASN Anda Kategori Sangat Tinggi</span>
                                            <!-- <span class="info-box-number">{{$bkn->subtotal}}</span> -->

                                            <div class="progress">
                                                <div class="progress-bar" style="width: 70%"></div>
                                            </div>
                                            <span class="progress-description">
                                                update data kompetensi Anda.
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <!-- /.info-box -->
                                @elseif ($nilaiasn->subtotal >80)
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="info-box bg-green">
                                        <span class="info-box-icon">
                                            <!--    <i class="fa fa-thumbs-o-up"></i> -->
                                            {{$nilaiasn->subtotal}}
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Nilai IP ASN Anda Kategori Tinggi</span>
                                            <!-- <span class="info-box-number">{{$bkn->subtotal}}</span> -->

                                            <div class="progress">
                                                <div class="progress-bar" style="width: 70%"></div>
                                            </div>
                                            <span class="progress-description">
                                                update data kompetensi Anda.
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <!-- /.info-box -->
                                @elseif ($nilaiasn->subtotal >70)
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="info-box bg-yellow">
                                        <span class="info-box-icon">
                                            <!-- <i class="fa fa-meh-o"></i> -->
                                            {{$nilaiasn->subtotal}}
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Nilai IP ASN Anda Kategori Sedang</span>
                                            <!-- <span class="info-box-number">{{$bkn->subtotal}}</span> -->

                                            <div class="progress">
                                                <div class="progress-bar" style="width: 70%"></div>
                                            </div>
                                            <span class="progress-description">
                                                <h4>update data kompetensi Anda.</h4>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <!-- /.info-box -->
                                @else
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="info-box bg-red">
                                        <span class="info-box-icon">
                                            <!-- <i class="fa fa-thumbs-o-down"></i> -->
                                            {{$nilaiasn->subtotal}}
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text"> Nilai IP ASN Anda Kategori Rendah</span>
                                            <!-- <span class="info-box-number">{{$bkn->subtotal}}</span> -->

                                            <div class="progress">
                                                <div class="progress-bar" style="width: 70%"></div>
                                            </div>
                                            <span class="progress-description">
                                                update data kompetensi Anda.
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <!-- /.info-box -->
                                @endif
</div>
                                <div class="col-md-12">
                                    <div class="box box-warning">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Untuk Diperhatikan </h3>

                                            <div class="box-tools pull-right">
                                                <div class="pull-right box-tools">
                                                    <a type="button" href="{{url()}}/epersonal/biodata" class="btn btn-info btn-sm links"
                                                        title="Update"> Update Data
                                                        <i class="fa fa-refresh"></i></a>
                                                </div>
                                            </div>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <h3>
                                                <p class="text-red">MOHON UNTUK DAPAT MENGUPDATE KOMPETENSI / MENGIKUTI PENGEMBANGAN KOMPETENSI</p>
                                            </h3>
                                            <br />Melalui Menu E-Personal
                                            <br />Pilih Biodata Pegawai
                                            <br />Data Pegawai
                                            <br />Pilih pada Tab Riwayat
                                            <br />Pilih Kompetensi Anda

                                        </div>
                                        <!-- /.box-body -->

                                    </div>
                                    <!-- /.box -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">
                  @if(session('role_id') <=3)
                    {!!getUtility('alias_aplikasi')!!} {!!getUtility('kab_instansi')!!}
                  @else
                    {{session('skpd')}}
                  @endif
              </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <?php
                $nip = Input::get('nip');

                if(session('role_id') <= 3){
                    $rs1 = \DB::table('tb_01')->where('idjenkedudupeg', '!=', 99)->where('tmtpens','<',date('Y-m-d'))->where('idjenkedudupeg', '!=', 21)->count();
                    $rs2 = \DB::table('tb_01')->where('idstspeg', 1)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();
                    $rs3 = \DB::table('tb_01')->where('idstspeg', 2)->where('idjenkedudupeg', '!=', 99)->where('tmtpens','<',date('Y-m-d'))->where('idjenkedudupeg', '!=', 21)->count();
                    $rs6 = \DB::table('tb_01')->where('idstspeg', 3)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();
                $rspppkpw = \DB::table('tb_01')->where('idstspeg', 4)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->count();
                $having = " YEAR(pensiunnext)= " .  date("Y") . "";
                        $having .= " AND MONTH(pensiunnext)= " . date("m") . "";
                        $rs7 = \DB::table('tb_01')
                            ->select(
                                \DB::raw('count(*) as jumlah'),
                                \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext")
                            )
                            ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                            ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                            ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                            ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                            ->whereRaw("tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != ''")
                            ->groupBy('pensiunnext')
                            ->havingRaw($having)
                            ->orderBy(\DB::raw('tb_01.tglhr, tb_01.idgolrupkt, tb_01.tmtpkt, tb_01.nama'))
                            ->get();
                }else{
                    $rs1 = \DB::table('tb_01')->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();
                    $rs2 = \DB::table('tb_01')->where('idstspeg', 1)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();
                    $rs3 = \DB::table('tb_01')->where('idstspeg', 2)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();
                    $rs6 = \DB::table('tb_01')->where('idstspeg', 3)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd','like',''.session("idskpd"). '%')->count();
                $rspppkpw = \DB::table('tb_01')->where('idstspeg', 4)->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd', 'like', '' . session("idskpd") . '%')->count();
                    $nip = session("user_id");
                    //$rs4 = cekperubahanbiodata($nip);
                    $rs4 = \DB::table('tb_01_temp')->where('nip', '=', $nip)->where('status', '!=', '1')->count();
                    $rpang =\DB::table('r_gol_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rgol', '!=', '0')->count();
                    $rjab =\DB::table('r_jab_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rjab', '!=', '0')->count();
                    $dikstru =\DB::table('r_dikstru_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rdikstru', '!=', '0')->count();
                    $dikfung =\DB::table('r_dikfung_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rdikfung', '!=', '0')->count();
                    $diktek =\DB::table('r_diktek_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rdiktek', '!=', '0')->count();
                    $kgb =\DB::table('r_kgb_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rkgb', '!=', '0')->count();
                    $pend =\DB::table('r_pend_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rpend', '!=', '0')->count();
                    $hukdis =\DB::table('r_hukdis_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rhukdis', '!=', '0')->count();
                    $pppk =\DB::table('r_pppk_temp')->where('nip', '=', $nip)->where('status', '=', '0')->where('id_rpppk', '!=', '0')->count();
                    $rs5 = 0;
                    if($rpang > 0){
                        $rs5 = $rs5 + 1;
                    }
                    if($rjab > 0){
                        $rs5 = $rs5 + 1;
                    }
                    if($dikstru > 0){
                        $rs5 = $rs5 + 1;
                    }
                    if($dikfung > 0){
                        $rs5 = $rs5 + 1;
                    }
                    if($diktek > 0){
                        $rs5 = $rs5 + 1;
                    }
                     if($kgb > 0){
                        $rs5 = $rs5 + 1;
                    }
                     if($pend > 0){
                        $rs5 = $rs5 + 1;
                    }
                     if($hukdis > 0){
                        $rs5 = $rs5 + 1;
                    }
                    if($pppk > 0){
                        $rs5 = $rs5 + 1;
                    }




                }
            ?>
            <div class="box-body">
                @if(session('role_id') == 5)
                    <div class="alert alert-warning alert-biodata" role="alert" style="display: block;">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Perhatian :</span>
                        <em>
                            Hello, Selamat Datang <b>{!!session('name')!!} !</b>
                        </em>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <!-- <h3 class="jumlahbiodata">0</h3> -->
                                    <h3>{{$rs4}}</h3>

                                    <p><small>Perubahan</small> BIODATA</p>
                                </div>
                                <div class="icon">
                                    <!--<i class="ion ion-stats-bars"></i>-->
                                    <i class="fa fa-list" aria-hidden="true"></i>
                                </div>
                                <a class="small-box-footer links" href="{{url()}}/epersonal/perubahanbiodata">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <!-- <h3 class="jumlahriwayat">0</h3> -->
                                    <h3>{{$rs5}}</h3>
                                    <p><small>Perubahan</small> RIWAYAT</p>
                                </div>
                                <div class="icon">
                                    <!--<i class="ion ion-person-add"></i>-->
                                    <i class="fa fa-list" aria-hidden="true"></i>
                                </div>
                                <a class="small-box-footer links" href="{{url()}}/epersonal/perubahanriwayat">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                     
                    </div>

                    <div style="height: 200px"></div>
                @else
                <div class="nav-tabs-custom">
                    @if(session('role_id')!= 3)
                    <div class="row">
                                <div class="col-lg-2 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <h3>{{$rs1}}</h3>

                                            <p>Pegawai</p>
                                        </div>
                                        <div class="icon">
                                            <!--<i class="ion ion-bag"></i>-->
                                            <i class="fa fa-signal" aria-hidden="true"></i>
                                        </div>
                                        <a class="small-box-footer links" href="{{url()}}/epersonal/biodata">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-2 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3>{{$rs3}}</h3>

                                            <p>PNS</p>
                                        </div>
                                        <div class="icon">
                                            <!--<i class="ion ion-stats-bars"></i>-->
                                            <i class="fa fa-list" aria-hidden="true"></i>
                                        </div>
                                        <a class="small-box-footer links" href="{{url()}}/epersonal/biodata?idstspeg=2">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-2 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h3>{{$rs2}}</h3>

                                            <p>CPNS</p>
                                        </div>
                                        <div class="icon">
                                            <!--<i class="ion ion-person-add"></i>-->
                                            <i class="fa fa-list" aria-hidden="true"></i>
                                        </div>
                                        <a class="small-box-footer links" href="{{url()}}/epersonal/biodata?idstspeg=1">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-2 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-blue">
                                        <div class="inner">
                                            <h3>{{$rs6}}</h3>

                                            <p>PPPK</p>
                                        </div>
                                        <div class="icon">
                                            <!--<i class="ion ion-person-add"></i>-->
                                            <i class="fa fa-list" aria-hidden="true"></i>
                                        </div>
                                        <a class="small-box-footer links" href="{{url()}}/epersonal/biodata?idstspeg=3">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->

                                <div class="col-lg-2 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-blue">
                                        <div class="inner">
                                            <h3>{{$rspppkpw}}</h3>

                                            <p>PPPK PARUH WAKTU</p>
                                        </div>
                                        <div class="icon">
                                            <!--<i class="ion ion-person-add"></i>-->
                                            <i class="fa fa-list" aria-hidden="true"></i>
                                        </div>
                                        <a class="small-box-footer links" href="{{url()}}/epersonal/biodata?idstspeg=3">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- ./col -->
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h3 class="jumlahbiodata">0</h3>

                                            <p>Perubahan Data</p>
                                        </div>
                                        <div class="icon">
                                            <!--<i class="ion ion-pie-graph"></i>-->
                                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                        </div>
                                        <a class="small-box-footer links" href="{{url()}}/epersonal/perubahanriwayat">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-2 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h3 class="jumlahbup"> {{empty($rs7[0]->jumlah)?'0':$rs7[0]->jumlah}}</h3>

                                            <p>PENSIUN BUP</p>
                                        </div>
                                        <div class="icon">
                                            <!--<i class="ion ion-pie-graph"></i>-->
                                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                        </div>
                                        <btn class="small-box-footer links" id="pensiunkan" href="#">Selengkapnya <i class="fa fa-arrow-circle-right"></i></btn>
                                    </div>
                                </div>
                            </div>
                    @endif


                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab_1" aria-expanded="true">Grafik PNS</a></li>
                        <li class=""><a data-toggle="tab" href="#tab_2" aria-expanded="false">Grafik CPNS</a></li>
                        <li class=""><a data-toggle="tab" href="#tab_3" aria-expanded="false">Grafik PPPK</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab_1" class="tab-pane active">
                            <div id="graph-pns" style="width:100%;"></div>
                        </div>
                        <!-- /.tab-pane -->
                        <div id="tab_2" class="tab-pane">
                            <div id="graph-cpns" style="width:100%;"></div>
                        </div>
                        <!-- /.tab-pane -->
                        <div id="tab_3" class="tab-pane">
                            <div id="graph-pppk" style="width:100%;"></div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                @endif
              <!-- /.row -->
            </div>
            <!-- ./box-body -->

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 @if(session('role_id') == 100)
                         //if(session('role_id') == 4)
        <div class="row">

            <!-- Left col -->
            <div class="col-md-8">
                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Indeks Profesionalitas Pada Perangkat Daerah</h3>
                        <div class="pull-right box-tools">
                 {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'nominatif-pegawai','target'=>'_blank')) !!}
                            <button class="btn btn-success" type="button" id="excel-nominatif"><i class="fa fa-file-excel-o"></i> Download Excel</button>
                            {!! Form::close() !!}
                               <!--<button type="button" id="tarikdata"  recid="{!!$urutanpegawai->idskpd!!}" class="btn btn-info btn-sm" data-toggle="tarik data"
                                title="Tarik Data"> Sinkron SIASN
                                <i class="fa fa-refresh"></i></button>-->
                            <!-- <button class="btn btn-success" type="button" id="excel-nominatif"><i class="fa fa-file-excel-o"></i> Download Excel</button> -->
                        </div>

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="ipasn" class="table table-bordered table-striped">
                                <thead class="bg-aqua">
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Tanggal SIASN</th>
                                        <th>Kinerja</th>
                                        <th>Hukdis</th>
                                        <th>Kompetensi</th>
                                        <th>Kualifikasi</th>
                                        <th>Total</th>
<th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (session('role_id') <= 3) {
                                        $idskpd = '25';
                                    } else {
                                        $idskpd = session('idskpd');
                                    }
                                    $pegawais = \DB::table('tb_01')->select(
                                        'tb_01.nip',
                                        'nama',
                                        'tr_ipasn.kinerja',
                                        'tr_ipasn.hukdis',
                                        'tr_ipasn.kompetensi',
                                        'tr_ipasn.kualifikasi',
                                        'tr_ipasn.subtotal',
                                        'tr_ipasn.tgipasn',
                                        'idgolrupkt',
                                        'idesljbt',
                                        'idskpd',
                                        'tmtpkt',
                                        'tmtesljbt',
                                        'tmtcpn',
                                        'a_jenjab.order as order',
                                        'a_golruang.golru',
                                        'a_esl.esl',
                                        'a_tkpendid.tkpendid',
                                        'a_jenjurusan.jenjurusan'
                                    )

                                        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                                        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                                        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                                        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                                        // ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                                        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                                        // ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                                        // ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                                        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
                                        ->leftjoin('tr_ipasn', 'tb_01.nip', '=', 'tr_ipasn.nip')
                                        ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd', 'like', '' . session("idskpd") . '%')->where('idstspeg', '=', 2)
                                        ->orderBy(\DB::raw('a_jenjab.order,tb_01.idesljbt asc,tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
                                        ->get();

                                    $totalkinerja = 0;
                                    $totaldisiplin = 0;
                                    $totalkompetensi = 0;
                                    $totalkualifikasi = 0;
                                    $jumlah = 0;
                                    ?>

                                    @foreach($pegawais as $urutanpegawai)

                                    <tr>
                                        <td>{{$urutanpegawai->nip}}</td>
                                        <td>{{$urutanpegawai->nama}}</td>
                                        <td class="text-center">{{$urutanpegawai->tgipasn}}</td>
                                        <td class="text-center">{{$urutanpegawai->kinerja}}</td>
                                        <td class="text-center">{{$urutanpegawai->hukdis}}</td>
                                        <td class="text-center">{{$urutanpegawai->kompetensi}}</td>
                                        <td class="text-center">{{$urutanpegawai->kualifikasi}}</td>
                                        <td class="text-center"><span class="label label-success">{{$urutanpegawai->subtotal}}</span>
<td>
                                    <a class="text-info tarikperubahanasn" recid="{!!$urutanpegawai->nip!!}" href="javascript:void(0)"><i class="fa fa-check-circle"></i> Sinkron</a> 
                                    </td>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <?php
            $totals = \DB::table('tb_01')->select(
                DB::raw('ROUND(AVG(tr_ipasn.kinerja),0) AS sumkinerja'),
                DB::raw('ROUND(AVG(tr_ipasn.hukdis),0) AS sumhukdis'),
                DB::raw('ROUND(AVG(tr_ipasn.kompetensi),0) AS sumkompetensi'),
                DB::raw('ROUND(AVG(tr_ipasn.kualifikasi),0) AS sumkualifikasi'),
                DB::raw('ROUND(AVG(tr_ipasn.subtotal),2) AS sumtotal')
            )
                ->leftjoin('tr_ipasn', 'tb_01.nip', '=', 'tr_ipasn.nip')
                ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd', 'like', '' . session("idskpd") . '%')->where('idstspeg', '=', 2)
                ->get();

            ?>

            <div class="col-md-4">
                <!-- Info Boxes Style 2 -->
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Kinerja</span>
                        <span class="info-box-number">{{$totals[0]->sumkinerja}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description">
                            Hasil Rata Rata Penilaian Kinerja
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-frown-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Hukuman Disiplin</span>
                        <span class="info-box-number">{{$totals[0]->sumhukdis}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 20%"></div>
                        </div>
                        <span class="progress-description">
                            Nilai Rata-rata Riwayat Hukum Disiplin
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Kompetensi</span>
                        <span class="info-box-number">{{$totals[0]->sumkompetensi}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                            Nilai Rata-rata Kompetensi - Riwayat Pengembangan Kompetensi
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-mortar-board"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Kualifikasi</span>
                        <span class="info-box-number">{{$totals[0]->sumkualifikasi}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 40%"></div>
                        </div>
                        <span class="progress-description">
                            Nilai Rata-rata Kualifikasi - Riwayat Pendidikan Terakhir
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <!-- /.info-box -->
                <div class="info-box bg-navy">
                    <span class="info-box-icon"><i class="fa fa-child"></i></span>

                    <div class="info-box-content">


                        @if($totals[0]->sumtotal>91)
                        <span class="info-box-text">Total NILAI IP ASN OPD Kategori Sangat Tinggi</span>
                        @elseif($totals[0]->sumtotal<91)
                            <span class="info-box-text">Total NILAI IP ASN OPD Kategori Tinggi</span>
                            @elseif($totals[0]->sumtotal<81)
                                <span class="info-box-text">Total NILAI IP ASN OPD Kategori Sedang</span>
                                @elseif($totals[0]->sumtotal<71)
                                    <span class="info-box-text">Total NILAI IP ASN OPD Kategori Rendah</span>
                                    @else
                                    <span class="info-box-text">Total NILAI IP ASN OPD Kategori Sangat Rendah</span>
                                    @endif

                                    <span class="info-box-number">{{$totals[0]->sumtotal}}</span>

                                    <div class="progress">
                                        <div class="progress-bar" style="width: 70%"></div>
                                    </div>
                                    <span class="progress-description">
                                        Nilai Rata-rata OPD
                                    </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>


            </div>
            <!-- /.col -->
        </div>
        @endif

        @if(session('role_id') < 1)
           // if(session('role_id') < 3)
            <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Indeks Profesionalitas Pada Perangkat Daerah</h3>
                        <div class="pull-right box-tools">
                             <!-- <button type="button" id="tarikdataopd" class="btn btn-info btn-sm" data-toggle="tarik data"
                                  title="Remove"> Sinkron SIASN
                                  <i class="fa fa-refresh"></i></button> -->
                        </div>

                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="ipasn" class="table table-bordered table-striped">
                                <thead class="bg-aqua">
                                    <tr>
                                        <!-- <th>NIP</th> -->
                                        <th>Nama</th>
                                        <!-- <th>Tanggal SIASN</th> -->
                                        <th>Kinerja</th>
                                        <th>Hukdis</th>
                                        <th>Kompetensi</th>
                                        <th>Kualifikasi</th>
                                        <th>Total</th>
                                        <th>ASN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pegawais = \DB::table('tb_01')->select(
                                     // DB::raw('count(tr_ipasn.kinerja) AS totalasn'),
                                        'a_skpd.idskpd',
                                        'path_short',
                                        DB::raw('ROUND(AVG(tr_ipasn.kinerja),0) AS sumkinerja'),
                                        DB::raw('ROUND(AVG(tr_ipasn.hukdis),0) AS sumhukdis'),
                                        DB::raw('ROUND(AVG(tr_ipasn.kompetensi),0) AS sumkompetensi'),
                                        DB::raw('ROUND(AVG(tr_ipasn.kualifikasi),0) AS sumkualifikasi'),
                                        DB::raw('ROUND(AVG(tr_ipasn.subtotal),2) AS sumtotal')
                                    )
                                        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                                        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                                        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                                        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                                        // ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                                        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                                        // ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                                        // ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                                        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
                                        ->leftjoin('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                                        ->leftjoin('tr_ipasn', 'tb_01.nip', '=', 'tr_ipasn.nip')
                                        ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idstspeg', '=', 2)
                                        ->where('idparent', '=', '')
                                        ->groupBy('a_skpd.idskpd')
                                        ->get();
                                    $totalkinerja = 0;
                                    $totaldisiplin = 0;
                                    $totalkompetensi = 0;
                                    $totalkualifikasi = 0;
                                    $jumlah = 0;
                                    ?>
                                    <!-- data-id="{{$urutanpegawai->path_short}}" -->
                                    @foreach($pegawais as $urutanpegawai)

                                    <tr>
                                        <!-- <td><a href="pages/examples/invoice.html">{{$urutanpegawai->path_short}}</h4></td> -->
                                        <td>{{$urutanpegawai->path_short}}</td>
                                        <!-- <td class="text-center">{{$urutanpegawai->path_short}}</td> -->
                                        <td class="text-center"><h4>{{$urutanpegawai->sumkinerja}}</h4></td>
                                        <td class="text-center"><h4>{{$urutanpegawai->sumhukdis}}</h4></td>
                                        <td class="text-center"><h4>{{$urutanpegawai->sumkompetensi}}</h4></td>
                                        <td class="text-center"><h4>{{$urutanpegawai->sumkualifikasi}}</h4></td>
                                        <td class="text-center"><h4><span class="label label-success">{{$urutanpegawai->sumtotal}}</span></h4>
                                        <td>
                                    <!--<span class="label label-info">{{$urutanpegawai->totalasn}}</span>-->
                                             <!--<a class="text-info tarikperubahan" recid="{!!$urutanpegawai->idskpd!!}" href="javascript:void(0)"><i class="fa fa-check-circle"></i> Sinkron</a> -->
                                            <!-- <button type="button" id="tarikdataopd" class="btn btn-info btn-sm" data-toggle="tarik data"
                                                title="Sinkron"> Sinkron
                                                <i class="fa fa-refresh"></i></button> -->
                                        </td>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-4">
                <?php
                $totals = \DB::table('tb_01')->select(
                    DB::raw('ROUND(AVG(tr_ipasn.kinerja),0) AS sumkinerja'),
                    DB::raw('ROUND(AVG(tr_ipasn.hukdis),0) AS sumhukdis'),
                    DB::raw('ROUND(AVG(tr_ipasn.kompetensi),0) AS sumkompetensi'),
                    DB::raw('ROUND(AVG(tr_ipasn.kualifikasi),0) AS sumkualifikasi'),
                    DB::raw('ROUND(AVG(tr_ipasn.subtotal),2) AS sumtotal')
                )
                    ->leftjoin('tr_ipasn', 'tb_01.nip', '=', 'tr_ipasn.nip')
                    ->where('idjenkedudupeg', '!=', 99)->where('idjenkedudupeg', '!=', 21)->where('idskpd', 'like', '' . session("idskpd") . '%')->where('idstspeg', '=', 2)
                    ->get();

                ?>
                <!-- Info Boxes Style 2 -->
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Kinerja</span>
                        <span class="info-box-number">{{$totals[0]->sumkinerja}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description">
                            Hasil Rata Rata Penilaian Kinerja
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-frown-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Hukuman Disiplin</span>
                        <span class="info-box-number">{{$totals[0]->sumhukdis}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 20%"></div>
                        </div>
                        <span class="progress-description">
                            Nilai Rata-rata Riwayat Hukum Disiplin
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Kompetensi</span>
                        <span class="info-box-number">{{$totals[0]->sumkompetensi}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                            Nilai Rata-rata Kompetensi - Riwayat Pengembangan Kompetensi
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-mortar-board"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Kualifikasi</span>
                        <span class="info-box-number">{{$totals[0]->sumkualifikasi}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 40%"></div>
                        </div>
                        <span class="progress-description">
                            Nilai Rata-rata Kualifikasi - Riwayat Pendidikan Terakhir
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <!-- /.info-box -->
                <div class="info-box bg-navy">
                    <span class="info-box-icon"><i class="fa fa-child"></i></span>

                    <div class="info-box-content">


                        @if($totals[0]->sumtotal>91)
                        <span class="info-box-text">Total IP ASN PEMKAB KENDAL Sangat Tinggi</span>
                        @elseif($totals[0]->sumtotal<91)
                            <span class="info-box-text">Total IP ASN PEMKAB KENDAL Tinggi</span>
                            @elseif($totals[0]->sumtotal<81)
                                <span class="info-box-text">Total IP ASN PEMKAB KENDAL Sedang</span>
                                @elseif($totals[0]->sumtotal<71)
                                    <span class="info-box-text">Total IP ASN PEMKAB KENDAL Rendah</span>
                                    @else
                                    <span class="info-box-text">Total IP ASN PEMKAB KENDAL Sangat Rendah</span>
                                    @endif

                                    <span class="info-box-number">{{$totals[0]->sumtotal}}</span>

                                    <div class="progress">
                                        <div class="progress-bar" style="width: 70%"></div>
                                    </div>
                                    <span class="progress-description">
                                        Nilai Rata-rata OPD
                                    </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>


            </div>
</div>
@endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
    var xhr = $.ajax();

    $(document).ready(function(){
    
    //candra sinkron ip asn
      $('#excel-nominatif').on('click', function(e) {
            e.preventDefault();
            $('#nominatif-pegawai').attr("action", "{!!url()!!}/cetakexcel");
            $('#nominatif-pegawai').submit();

        });
    $('#pensiunkan').on('click', function(e) {
            console.log("test");
            e.preventDefault(e);

            $.ajax({
                type: 'post',
                url: '{!!url()!!}/epersonal/entripensiun/pensiunkan',
                data: {
                    'id': $(this).attr('recid'),
                    '_token': '{!!csrf_token()!!}'
                },
                // beforeSend: function() {
                //     $('#ipasn').html('Looading..');
                // },
                success: function(html) {
                    //console.log(html);
                    notification(html, 'danger');
                    window.location.reload();
                },
                error: function(e) {
                    //console.log(e);
                    //window.location.reload();
                }
            });
        });
 $('#tarikdatapersonal').on('click', function(e) {
 // console.log("test");
            e.preventDefault(e);
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/ipasnpersonal',
                data: {
                    'id': $(this).attr('recid'),
                    '_token': '{!!csrf_token()!!}'
                },
                beforeSend: function() {
                    $('#nilaiipasn').html('Looading..');
                    $('#progressnilaiipasn').html('Looading..');

                },
                success: function(html) {
                    console.log(html);
                    // notification(html, 'danger');
                    window.location.reload();
                },
                error: function(e) {
                    console.log(e);
                    window.location.reload();
                }
            });
        });
    $('.tarikperubahanasn').on('click', function(e) {
 // console.log("test");
            e.preventDefault(e);
            $.ajax({
                type: 'post',
                url: '{!!url()!!}/ipasnpersonal',
                data: {
                    'id': $(this).attr('recid'),
                    '_token': '{!!csrf_token()!!}'
                },
                beforeSend: function() {
                    $('#ipasn').html('Looading..');
                },
                success: function(html) {
                    console.log(html);
                    // notification(html, 'danger');
                    window.location.reload();
                },
                error: function(e) {
                    console.log(e);
                    window.location.reload();
                }
            });
        });
        $('#tarikdata').on('click', function(e) {
            console.log("test");
            e.preventDefault(e);

            $.ajax({
                type: 'post',
                url: '{!!url()!!}/ipasn',
                data: {
                    '_token': '{!!csrf_token()!!}'
                },
                beforeSend: function() {
                    $('#ipasn').html('Looading..');
                },
                success: function(html) {
                    console.log(html);
                    notification(html, 'danger');
                    window.location.reload();
                },
                error: function(e) {
                    console.log(e);
                    window.location.reload();
                }
            });
        });

        $('.tarikperubahan').on('click', function(e) {
            console.log("test");
            e.preventDefault(e);

            $.ajax({
                type: 'post',
            url: '{!!url()!!}/ipasnopd',
                data: {
                    'id': $(this).attr('recid'),
                    '_token': '{!!csrf_token()!!}'
                },
                beforeSend: function() {
                    $('#ipasn').html('Looading..');
                },
                success: function(html) {
                    console.log(html);
                    notification(html, 'danger');
                    window.location.reload();
                },
                error: function(e) {
                    console.log(e);
                    window.location.reload();
                }
            });
        });

        //end candra
    
        $('.links').on('click',function(e){
            e.preventDefault();
            e.preventDefault();
            e.stopImmediatePropagation();
            preloader = new $.materialPreloader({
                position: 'top',
                height: '5px',
                col_1: '#159756',
                col_2: '#da4733',
                col_3: '#3b78e7',
                col_4: '#fdba2c',
                fadeIn: 200,
                fadeOut: 200
            });

            $.ajax({
                url : $(this).attr('href'),
                type : 'get',
                success:function(html){
                    $('#utama').html(html);
                }
            });
        });

        @if(session('role_id') != 5)
        var graphWidth = $('.tab-content').width();
        var options = {
            chart: {
                renderTo: 'graph-cpns',
                defaultSeriesType: 'column',
                spacingLeft: 0,
                spacingRight: 0,
                width: graphWidth
            },
            title: {
                text: 'Grafik CPNS di {!!getUtility('kab_instansi')!!} <?php echo date('Y')?>'
            },
            subtitle: {
                text: 'Source: {!!getUtility('link_instansi')!!}'
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                min:0,
                title: {
                    text: 'Jumlah'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },
            series: []
        };

        $.get('{{url()}}/graphcpns', function(data) {
            var lines = data.split('\n');
            $.each(lines, function(lineNo, line) {
                var items = line.split(',');
                if(line!=''){
                    if (lineNo == 0) {
                        $.each(items, function(itemNo, item) {
                            if (itemNo > 0) options.xAxis.categories.push(item);
                        });
                    }else {
                        var series = {
                            data: []
                        };
                        $.each(items, function(itemNo, item) {
                            if (itemNo == 0) {
                                series.name = item;
                            } else {
                                series.data.push(parseFloat(item));
                            }
                        });
                        options.series.push(series);
                    }
                }
            });

            var chart = new Highcharts.Chart(options);
        });


        var options2 = {
            chart: {
                renderTo: 'graph-pns',
                defaultSeriesType: 'column',
                spacingLeft: 0,
                spacingRight: 0,
                width: graphWidth
            },
            title: {
                text: 'Grafik PNS di {!!getUtility('kab_instansi')!!} <?php echo date('Y')?>'
            },
            subtitle: {
                text: 'Source: {!!getUtility('link_instansi')!!}'
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },
            series: []
        };

        $.get('{{url()}}/graphpns', function(data) {
            var lines = data.split('\n');
            $.each(lines, function(lineNo, line) {
                var items = line.split(',');
                if(line!=''){
                    if (lineNo == 0) {
                        $.each(items, function(itemNo, item) {
                            if (itemNo > 0) options2.xAxis.categories.push(item);
                        });
                    }else {
                        var series = {
                            data: []
                        };
                        $.each(items, function(itemNo, item) {
                            if (itemNo == 0) {
                                series.name = item;
                            } else {
                                series.data.push(parseFloat(item));
                            }
                        });
                        options2.series.push(series);
                    }
                }
            });

            var chart2 = new Highcharts.Chart(options2);
        });

        var options3 = {
            chart: {
                renderTo: 'graph-pppk',
                defaultSeriesType: 'column',
                spacingLeft: 0,
                spacingRight: 0,
                width: graphWidth
            },
            title: {
                text: 'Grafik PPPK di {!!getUtility('kab_instansi')!!} <?php echo date('Y')?>'
            },
            subtitle: {
                text: 'Source: {!!getUtility('link_instansi')!!}'
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },
            series: []
        };

        $.get('{{url()}}/graphpppk', function(data) {
            var lines = data.split('\n');
            $.each(lines, function(lineNo, line) {
                var items = line.split(',');
                if(line!=''){
                    if (lineNo == 0) {
                        $.each(items, function(itemNo, item) {
                            if (itemNo > 0) options3.xAxis.categories.push(item);
                        });
                    }else {
                        var series = {
                            data: []
                        };
                        $.each(items, function(itemNo, item) {
                            if (itemNo == 0) {
                                series.name = item;
                            } else {
                                series.data.push(parseFloat(item));
                            }
                        });
                        options3.series.push(series);
                    }
                }
            });

            var chart3 = new Highcharts.Chart(options3);
        });
        @endif
    });
</script>

{!!View::make('home::dashboard.footer')!!}


