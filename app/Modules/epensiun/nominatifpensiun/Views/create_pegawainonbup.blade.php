<?php $_GET['n'] = 1?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".tmt, .date").mask("99-99-9999");
        $('.num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
    });
</script>

<section class="content-header">
    <h1>
        Buat Nominatif Pensiun Non BUP<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Nominatif Pensiun Non BUP</a></li>
        <li class="active">Buat Nominatif Pensiun Non BUP</li>
    </ol>
</section>

<section class="content">
{!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
    <div class="box box-primary">
        <div class="row">
            <div class="col-md-12">
            <div class="form-button-custom">
                <ul class="breadcrumb pull-right">
                    <li><a href="{!!url()!!}"> Dashboard</a></li>
                    <li><a href="#" id="back">Nominatif Pensiun</a></li>
                    <li>
                        {!! ClaravelHelpers::btnSave() !!}
                        {!! ClaravelHelpers::btnCancel() !!}
                    </li>
                </ul>
            </div>

            <table class="tb table-bordered" border="0" width="98%">
                <tbody>
                    <tr>
                        <td rowspan="3" align="center" width="5%">
                            <?php
                            if(file_exists("./packages/upload/photo/pegawai/".$item->photo)){
                                $pict = $item->photo;
                            }else {
                                $pict = "default.jpg";
                            }
                            ?>
                            <div align="center"><img src="{!!url()!!}/packages/upload/photo/pegawai/{!!$pict!!}"  width="100"></div>
                        </td>
                        <th rowspan="2" width="17%">NIP <br> NAMA LENGKAP</th>
                        <th rowspan="2" width="5%">GOL. RUANG</th>
                        <th rowspan="2" width="20%">JABATAN <br> UNIT KERJA</th>
                        <th colspan="4" width="20%">MASA KERJA S/D SEKARANG</th>
                        <th colspan="2" width="15%">PENDIDIKAN TERAKHIR</th>
                        <th rowspan="2" width="10%">TMT <br> USIA PENSIUN</th>
                    </tr>
                    <tr>
                        <th >THN</th>
                        <th >BLN</th>
                        <th >THN</th>
                        <th >BLN</th>
                        <th width="5%">TINGKAT</th>
                        <th width="10%">JURUSAN</th>
                    </tr>
                    <?php
                    $where = " tb_01.idjenkedudupeg not in('99','21') and tb_01.nip != '' and tb_01.nip = '".Session::get('user_id')."'";

                    $item = \DB::table('tb_01')
                    ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','a_jenjab.jenjab','a_dikstru.dikstru',
                    \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(tb_01.tglhr, INTERVAL IF(tb_01.idjenjab>=20,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,58)))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),
                    \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
                    \DB::raw('IF(tb_01.idjenjab>4,a_skpd.bup,IF(tb_01.idjenjab=2,a_jabfung.pens,IF(tb_01.idjenjab=3,a_jabfungum.pens,IF(tb_01.idjenjab=4,a_jabnonjob.pens,"-")))) as usiapens'),
                    \DB::raw("
                            CONCAT(
                                IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                        -
                                        (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                                        IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                            IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                                    ),
                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                                        + tb_01.mkthncpn
                                    )
                                ),
                                RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
                            "),
                        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
                    )
                    ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
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
                    ->leftjoin('a_dikstru', 'tb_01.iddikstru', '=', 'a_dikstru.iddikstru')
                    ->whereRaw($where)
                    ->first();
                    // dd($item);
                    ?>
                    <tr>
                <td>
                    <input type="hidden" name="{!!Input::get('n')!!}[nip]" value="{!!Input::get('nip')!!}">
                    <span id="ed1" style="display:none"><?=$item->nip?></span>
                    <a title="popdetil" href="javascript:void(0)"><b>{!!fnip($item->nip)!!}</b></a><br>
                    {!!$item->namalengkap!!}
                </td>
                <td>{!!$item->golru!!}<br>{!!($item->tmtpkt!='0000-00-00')?date('d-m-Y', strtotime($item->tmtpkt)):''!!}</td>
                <td>{!!$item->jabatan!!}<br>{!!$item->path_short!!}</td>
                <td align="center">
                    <div class="text-center">{!!$item->mkthnpkt!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!$item->mkblnpkt!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!substr($item->mkskr,0,-2)!!}</div>
                </td>
                <td align="center">
                    <div class="text-center">{!!substr($item->mkskr,-2)!!}</div>
                </td>
                <td>{!!$item->tkpendid!!}</td>
                <td>{!!$item->jenjurusan!!}</td>
                <td>
                    <div class="text-center">{!!(($item->pensiunnext!='0000-00-00')?"TMT : ".date('d-m-Y', strtotime($item->pensiunnext)):'')!!}</div>
                    <div class="text-center">{!!$item->usiapens!!} thn</div>
                </td>
            </tr>
            <tr>
                <td colspan="11">
                    <table width="100%" border="0">
                        <tr style="background-color: #ececec">
                            <td width="10%" rowspan="2" style="vertical-align:middle">
                                <div align="center">Atribut Pensiun</div>
                            </td>
                            <td width="15%">Jenis Pensiun</td>
                            <td width="15%">TMT Pensiun</td>
                            <td width="20%">Keterangan Pensiun <span class="pull-right"><a class="remove_item" href="javascript:void(0)" title="Delete Nominatif"><i class="glyphicon glyphicon-trash"></i></a></span></td>
                        </tr>
                        <tr>
                            <td>
                                {!!NominatifpensiunModel::comboJenpens('[idjenpens]',$item->idjenpens,'','idjenpens',Input::get('n'))!!}
                            </td>

                            <td>
                                <div class='input-group datepicker'>
                                    <input type="text" name="{!!Input::get('n')!!}[tmtpens]" required class=" form-control date" placeholder="dd-mm-yyyy">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>

                                <input type="hidden" name="{!!Input::get('n')!!}[idjenkedudupeg]" value="99">
                                <input type="hidden" name="{!!Input::get('n')!!}[almpens]" value="{!!$item->alm!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almrtpens]" value="{!!$item->almrt!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almrwpens]" value="{!!$item->almrw!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almdesapens]" value="{!!$item->almdesa!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almkecpens]" value="{!!$item->almkec!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almkabpens]" value="{!!$item->almkab!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almprovpens]" value="{!!$item->almprov!!}">

                                <input type="hidden" name="{!!Input::get('n')!!}[idskpdpens]" value="{!!$item->idskpd!!}">

                                <input type="hidden" name="{!!Input::get('n')!!}[almskrpens]" value="{!!$item->alm!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almrtskrpens]" value="{!!$item->almrt!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almrwskrpens]" value="{!!$item->almrw!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almdesaskrpens]" value="{!!$item->almdesa!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almkecskrpens]" value="{!!$item->almkec!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almkabskrpens]" value="{!!$item->almkab!!}">
                                <input type="hidden" name="{!!Input::get('n')!!}[almprovskrpens]" value="{!!$item->almprov!!}">

                                <!-- BUPATI -->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[bupati]" value="{!! getPenetapsk('005','namalengkap') !!}">
                                <!-- KEPALA BKPP -->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[idpejabpens]" value="033">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pejpenpens]" value="{!! getKepskpd('25','nama') !!}"> <!--$item->kdunit-->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabpenpens]" value="{!! getKepskpd('25','jab') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[nippenpens]" value="{!! getKepskpd('25','nip') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pangkatpenpens]" value="{!! getKepskpd('25','pangkat') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[golrupenpens]" value="{!! getKepskpd('25','golru') !!}">

                                <!-- OPD -->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pejpen_sp]" value="{!! getKepskpd($item->kdunit,'nama') !!}"> <!--$item->kdunit-->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabpen_sp]" value="{!! getKepskpd($item->kdunit,'jab') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[nippen_sp]" value="{!! getKepskpd($item->kdunit,'nip') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[golpen_sp]" value="{!! getKepskpd($item->kdunit,'pangkat') !!}">

                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pejpen_hukpid]" value="{!! getKepskpd($item->kdunit,'nama') !!}"> <!--$item->kdunit-->
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[jabpen_hukpid]" value="{!! getKepskpd($item->kdunit,'jab') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[nippen_hukpid]" value="{!! getKepskpd($item->kdunit,'nip') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[golpen_hukpid]" value="{!! getKepskpd($item->kdunit,'pangkat') !!}">
                                <input type="hidden" class="form-control" name="{!!Input::get('n')!!}[pangpen_hukpid]" value="{!! getKepskpd($item->kdunit,'golongan') !!}">
                            </td>
                            <td>
                                <input type="text" name="{!!Input::get('n')!!}[keterangan]" required class=" form-control" placeholder="Keterangan Pensiun">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <em>* Harap periksa kembali biodata PNS apabila jenis jabatan dan nama jabatan belum sesuai dengan data sebenarnya.</em>
                            </td>
                        </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
{!! Form::close() !!}
</section>

<script>
    function refresh_page(){
        <?php
        $index_page = explode('/', \Request::path());
        $jum = count($index_page) -1;
        unset ($index_page[$jum]);
        $index = join('/', $index_page);
        echo 'var index_page=laravel_base + "/'.$index.'";';
        ?>
        $.ajax({
            url : index_page,
            type : 'GET',
            beforeSend: function(){
                preloader.on();
            },
            success:function(html){
                preloader.off();
                $('#utama').html(html);
            }
        }); 
    }

    $(document).ready(function(){
        $('#batalkan,#back').on('click',function(e){
            e.preventDefault();
            refresh_page();
        });

        $('#simpan select').select2();
        $("#simpan .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $("#simpan .date").mask("99-99-9999");

        $('#simpan').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : '{!!url()!!}/epensiun/nominatifpensiun/createpegawainonbup',
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='1'){
                                notification('Berhasil Disimpan','success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
    });
</script>