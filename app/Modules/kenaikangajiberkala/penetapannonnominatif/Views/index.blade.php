<section class="content-header">
    <h1>
        Penetapan Non Nominatif<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Penetapan Non Nominatif</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <p>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
                        <span class="caret"></span> Buat Baru
                    </button>
                    <ul class="dropdown-menu pull-left">
                        {!! btnCreatekgb('PNS') !!}
                        {!! btnCreatekgb('PPPK') !!}
                    </ul>
                </div>
            </p>
            <div class="col-md-12">
                {!! Form::open(array('url' => \Request::path(), 'method' => 'GET', 'class' => 'form-'.\Config::get('claravel::ajax'),'id' => 'cari' )) !!}
                {!!csrf_field()!!}
                <input type="hidden" name="page" id="pageno" value="{!!((Input::get('page') != '')?Input::get('page'):'')!!}">

                <table class="table">
                    <tr>
                        <td width="10%">Bulan</td>
                        <td width="2%">:</td>
                        <td width="38%">{!! comboBulan("bulan",Input::get('bulan'),"",".: Bulan :.") !!}</td>

                        <td>Status Pegawai</td>
                        <td>:</td>
                        <td>{!!comboStspns("idstspeg",Input::get('idstspeg'),"")!!}</td>
                    </tr>
                    <tr>
                        <td>Tahun</td>
                        <td>:</td>
                        <td>{!! comboTahun("tahun",Input::get('tahun'),"",".: Tahun :.") !!}</td>

                        <td width="10%">Unit Kerja</td>
                        <td width="2%">:</td>
                        <td width="38%">
                            {!! comboSkpd("idskpd",Input::get('idskpd'),"",session('idskpd'),'.: Unit Kerja :.')!!}
                        </td>
                    </tr>
                    <tr>
                        <td>Proses</td>
                        <td>:</td>
                        <td>{!! PenetapannominatifModel::comboJeniskgb("jnskgb",Input::get('jnskgb'),"",".: Proses :.") !!}</td>

                        <td>Status SK</td>
                        <td>:</td>
                        <td>{!! PenetapannominatifModel::comboStatussk("statussk",Input::get('statussk'),"",".: Status Proses :.")!!}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                            <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </td>

                        <td>Pencarian</td>
                        <td>:</td>
                        <td><input type="text" class="form-control" name="search" id="search" value="{!! \Input::get('search')!!}"></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                {!! Form::close() !!}
            </div>
        </div>

        {!! Form::open(array('url' => \Request::path().'/delete', 'method' => 'POST', 'class' => 'form-'.\Config::get('claravel::ajax'),'id'=>'data' )) !!}
        <div class="table-responsive">
            <div class="box-body no-padding">
                <table class="table table-striped table-hover table-condensed table-bordered" id='tabel'>
                    <thead class="bg-primary">
                    <tr>
                        <th rowspan="2"><div class="text-center">No</div></th>
                        <th rowspan="2">
                            <div class="text-center">NAMA</div>
                            <div class="text-center">TEMPAT,&nbsp;TGL&nbsp;LAHIR</div>
                        </th>
                        <th rowspan="2">
                            <div class="text-center">NIP</div>
                            <div class="text-center">KARPEG</div>
                        </th>
                        <th rowspan="2">
                            <div class="text-center">JABATAN </div>
                            <div class="text-center">UNIT KERJA</div>
                            <div class="text-center">TMT</div>
                        </th>
                        <th rowspan="2">
                            <div class="text-center">PKT&nbsp;GOL.&nbsp;CPNS</div>
                            <div class="text-center">TMT</div>
                            <div class="text-center">MASA KERJA</div>
                        </th>
                        <th rowspan="2">
                            <div class="text-center">PKT&nbsp;GOL.&nbsp;PNS</div>
                            <div class="text-center">TMT</div>
                            <div class="text-center">MASA KERJA</div>
                        </th>
                        <th rowspan="2">
                            <div class="text-center">PKT&nbsp;GOL.&nbsp;SEKARANG</div>
                            <div class="text-center">TMT</div>
                            <div class="text-center">MASA KERJA</div>
                        </th>
                        <th rowspan="2">
                            <div class="text-center">KGB&nbsp;TERKAHIR</div>
                            <div class="text-center">TMT</div>
                            <div class="text-center">MASA KERJA</div>
                            <div class="text-center">GAJI</div>
                        </th>
                        <th rowspan="2">
                            <div class="text-center">KGB&nbsp;BARU</div>
                            <div class="text-center">TMT</div>
                            <div class="text-center">MASA&nbsp;KERJA</div>
                            <div class="text-center">GAJI</div>
                        </th>
                        <th rowspan="2"><div align="center">PROSES</div></th>
                        <th colspan="2"><div align="center">STATUS</div></th>
                        <th rowspan="2" width="7%">Act.</th>
                    </tr>
                    <tr>
                        <th><div align="center">USUL</div></th>
                        <th><div align="center">SK</div> </th>
                    </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                        $arr[0]= ""; $n = 0;
                        $x = (!empty(Input::get('page')))?((Input::get('page') - 1)*25):0;
                    ?>
                    @foreach ($penetapannonnominatifs as $penetapannonnominatif)
                    <?php
                        $x++;
                        $n++;
                        $arr[$n] = substr($penetapannonnominatif->idkgb,0,9);
                            if($arr[$n]!=$arr[$n-1]){
                    ?>
                        <tr>
                            <th style="position:relative;" colspan="6" align="left">
                                TMT KGB <i class="icon-calendar"></i> <?php echo date("d-m-Y", strtotime($penetapannonnominatif->tmtkgbb))?> -
                                <?php
                                    if(Input::get('idskpd') != ''){
                                        echo getSkpd(Input::get('idskpd'));
                                    }else{
                                        if(session('role_id') == 4){
                                            if(strlen(session('idskpd')) == 2){
                                                echo getSkpd(substr($penetapannonnominatif->kdskpd,0,2));
                                            }else{
                                                echo getSkpd(substr($penetapannonnominatif->kdskpd,0,5));
                                            }
                                        }else{
                                            echo getSkpd(substr($penetapannonnominatif->kdskpd,0,2));
                                        }
                                    }
                                ?>
                            </th>
                            <th style="position:relative;" colspan="6" align="right">
                                <div class="text-right">
                                    @if(session('role_id') < 3)
<!--                                    <div class="btn btn-success">-->
<!--                                        <input type="checkbox" name="iscetaksk" class="iscetaksk" value="1" rectmtkgb="{!!$penetapannonnominatif->tmtkgbb!!}" recidskpd="{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($penetapannonnominatif->kdskpd,0,2))!!}" {!!($penetapannonnominatif->iscetaksk==1)?'checked':''!!}> Sudah Cetak SK-->
<!--                                    </div>-->
                                    @endif
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button" aria-expanded="false">
                                            <span class="fa fa-list"></span> Nominatif
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if(Input::get('jnskgb') == 2)
                                            <li><a href="javascript:void(0)" idjenis="{!!Input::get('jnskgb')!!}" idkgb="{!!substr($penetapannonnominatif->idkgb,0,6)!!}" idskpd="{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($penetapannonnominatif->kdskpd,0,2))!!}" class="attrpengantaropd btn-default" title="Input Surat Pengantar"><i class="fa fa-pencil"/></i> Surat Pengantar OPD</a></li>
                                            @endif
                                            <li><a href="{!!url()!!}/kenaikangajiberkala/penetapannonnominatif/cetaknominatif/{!!((Input::get('jnskgb')!='')?Input::get('jnskgb'):'0')!!}/{!!substr($penetapannonnominatif->idkgb,0,6)!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($penetapannonnominatif->kdskpd,0,2))!!}/{!!$penetapannonnominatif->idstspeg!!}" class="attrnominatif btn-default" act="nominatif" title="Cetak Daftar Nominatif" target="_blank"><i class="fa fa-print"/></i> Data Nominatif</a></li>
                                            <li><a href="{!!url()!!}/kenaikangajiberkala/penetapannonnominatif/cetakditerima/{!!((Input::get('jnskgb')!='')?Input::get('jnskgb'):'0')!!}/{!!substr($penetapannonnominatif->idkgb,0,6)!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($penetapannonnominatif->kdskpd,0,2))!!}/{!!$penetapannonnominatif->idstspeg!!}" class="attrnominatif btn-default" act="nominatif" title="Cetak Daftar Tanda Terima" target="_blank"><i class="fa fa-print"/></i> Tanda Terima</a></li>
                                        </ul>
                                    </div>
                                    &nbsp;<a href="{!!url()!!}/kenaikangajiberkala/penetapannonnominatif/cetakskkolektif/{!!((Input::get('jnskgb')!='')?Input::get('jnskgb'):'0')!!}/{!!substr($penetapannonnominatif->idkgb,0,6)!!}/{!!((Input::get('idskpd')!='')?Input::get('idskpd'):substr($penetapannonnominatif->kdskpd,0,2))!!}/{!!$penetapannonnominatif->idstspeg!!}" class="attrpengantar btn btn-success" act="pengantar" title="Cetak SK Kolektif" target="_blank"><i class="fa fa-file"/></i> SK Kolektif</a>
                                </div>
                            </th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>{!!$x!!}</td>
                        <td>
                            <div class="text-left">{!! $penetapannonnominatif->nama !!}</div>
                            <small><div class="text-left">{!! $penetapannonnominatif->tmplahir !!}, {!! tglina($penetapannonnominatif->tgllahir) !!}</div></small>
                            <div class="text-right" style="position:relative">
                                <?php
                                if($penetapannonnominatif->iscetaksk == 1){
                                    echo '<div style="position:absolute;right:-12px;top:-5px;color:#ffcc00;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                }else if($penetapannonnominatif->iscetaksk == 2){
                                    echo '<div style="position:absolute;right:-12px;top:-5px;color:#000000;"><i class="fa fa-star" title="Sudah Cetak SK"></i></div>';
                                }
                                ?>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">{!! $penetapannonnominatif->nip !!}</div>
                            <div class="text-center">{!! $penetapannonnominatif->karpeg !!}</div>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! ucword($penetapannonnominatif->nmajab) !!} {!! $penetapannonnominatif->tmpskpdskr !!}</div>
                                <div class="text-left">TMT : {!! tglina($penetapannonnominatif->tmtjbt) !!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! $penetapannonnominatif->golrucpn." - ".ucword($penetapannonnominatif->pangkatcpn) !!}</div>
                                <div class="text-left">{!! tglina($penetapannonnominatif->tmtcpn) !!}</div>
                                <div class="text-left">{!! $penetapannonnominatif->mkthncpn." Tahun ".$penetapannonnominatif->mkblncpn." Bulan" !!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! $penetapannonnominatif->golrupns." - ".ucword($penetapannonnominatif->pangkatpns) !!}</div>
                                <div class="text-left">{!! tglina($penetapannonnominatif->tmtpns) !!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! $penetapannonnominatif->golru." - ".ucword($penetapannonnominatif->pangkat) !!}</div>
                                <div class="text-left">{!! tglina($penetapannonnominatif->tmtgollama) !!}</div>
                                <div class="text-left">{!! $penetapannonnominatif->mkthn." Tahun ".$penetapannonnominatif->mkbln." Bulan" !!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! $penetapannonnominatif->golru !!} {!! ($penetapannonnominatif->noskkgbl=='')?'&nbsp;':$penetapannonnominatif->noskkgbl !!}</div>
                                <div class="text-left">{!! tglina($penetapannonnominatif->tmtkgbl) !!}</div>
                                <div class="text-left">{!! $penetapannonnominatif->mktkgbl." Tahun ".$penetapannonnominatif->mkbkgbl." Bulan" !!}</div>
                                <div class="text-left">Rp. {!! number_format($penetapannonnominatif->gkgbl) !!}</div>
                            </small>
                        </td>
                        <td>
                            <small>
                                <div class="text-left">{!! $penetapannonnominatif->noskkgbb !!}</div>
                                <div class="text-left">{!! tglina($penetapannonnominatif->tmtkgbb) !!}</div>
                                <div class="text-left">{!! $penetapannonnominatif->mktkgbb." Tahun ".$penetapannonnominatif->mkbkgbb." Bulan" !!}</div>
                                <div class="text-left">Rp. {!! number_format($penetapannonnominatif->gkgbb) !!}</div>
                            </small>
                        </td>
                        <td class="text-center">
                            <?php
                                switch($penetapannonnominatif->jnskgb){
                                    case 1 : echo "OPD"; break;
                                    case 2 : echo "BKPP"; break;
                                    default: echo ""; break;
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($penetapannonnominatif->statususul==1){
                                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/><span>';
                                }else if($penetapannonnominatif->statususul==2){
                                    echo '<span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>';
                                }else if($penetapannonnominatif->statususul==3){
                                    echo '<span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span>';
                                }else{
                                    echo '-';
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($penetapannonnominatif->statususul=='1' && $penetapannonnominatif->statussk=='2'){
                                    echo '<span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/><span>';
                                }else if($penetapannonnominatif->statussk=='1'){
                                    echo '<span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span>';
                                }else {
                                    echo '-';
                                }
                            ?>
                        </td>

                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">
                                    <span class="caret"></span> Aksi
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    @if($penetapannonnominatif->iscetaksk != 1)
                                    <li><a href="javascript:void(0)" class="text-info editkgb" recidkgb="{!!$penetapannonnominatif->idkgb!!}" recnip="{!!$penetapannonnominatif->nip!!}"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                    @endif
                                    <li><a href="javascript:void(0)" class="text-info verifikasikgb" recidstspeg="{!!$penetapannonnominatif->idstspeg!!}" recidkgb="{!!$penetapannonnominatif->idkgb!!}" recnip="{!!$penetapannonnominatif->nip!!}" recjnskgb="{!!$penetapannonnominatif->jnskgb!!}"><i class="{!!((session('role_id') < 3) or (($penetapannonnominatif->jnskgb == 1) and (session('role_id') == 4)))?'fa fa-check-square-o':'fa fa-search'!!}"></i> {!!((session('role_id') < 3) or (($penetapannonnominatif->jnskgb == 1) and (session('role_id') == 4)))?'Verifikasi':'Preview'!!}</a></li>
                                    @if($penetapannonnominatif->statussk == 1)
                                    <li><a id="cetaksk" href="{!!url()!!}/kenaikangajiberkala/penetapannonnominatif/cetaksk/{!!$penetapannonnominatif->jnskgb.'/'.$penetapannonnominatif->nip.'/'.$penetapannonnominatif->idkgb!!}" class="text-info" target="_blank"><i class="fa fa-print"></i> Cetak SK</a></li>
                                    @endif
                                    @if($penetapannonnominatif->statussk != 1)
                                    <li><a id="hapus" href="javascript:void(0)" recid="{!!$penetapannonnominatif->idkgb!!}" recnip="{!!$penetapannonnominatif->nip!!}" class="text-danger"><i class="fa fa-times-circle"></i> Hapus</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                <br>
                <div>
                    <table border="0" class="table">
                        <tr>
                            <td colspan="11">Keterangan :<br></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="color:green"><i class="fa fa-check-circle" title="Memenuhi Syarat"/></span> Memenuhi Syarat<br>
                            </td>
                            <td>
                                <span style="color:red"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span> Tidak Memenuhi Syarat<br>
                            </td>
                            <td>
                                <span style="color:orange"><i class="fa fa-info-circle" title="Berkas Tidak Lengkap"/></span> Berkas Tidak Lengkap<br>
                            </td>
                            <td>
                                <span style="color:orange"><i class="fa fa-clock-o" title="Sedang diproses"/></span> Sedang Diproses<br>
                            </td>
                            <td>
                                <span style="color:green"><i class="fa fa-check-circle" title="Selesai diproses"/></span> Selesai diproses<br>
                            </td>
                            <td>
                                <span style="color:#ffcc00"><i class="fa fa-star" title="Sudah Cetak SK"/></span> Sudah Cetak SK<br>
                            </td>
                            <td>
                                <span style="color:#000000"><i class="fa fa-star" title="Sudah Cetak SK"/></span> SK Dibatalkan<br>
                            </td>
                        </tr>
                    </table>
                </div><br>
            </div>
        </div>
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-sm-6">
              {!! ClaravelHelpers::btnDeleteAll() !!}
            </div>
            <div class="col-sm-6">
              <?php echo $penetapannonnominatifs->appends(array('bulan' => Input::get('bulan'), 'tahun' => Input::get('tahun'), 'jnskgb' => Input::get('jnskgb'), 'idskpd' => Input::get('idskpd'), 'statussk' => Input::get('statussk'), 'search' => Input::get('search')))->render(); ?>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>         

<script>
    function refresh_page(){
        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>
        $.ajax({
            url : index_page,
            type : 'GET',
            data : $('#cari').serialize(),
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
        $('select').select2();
        $('.pagination').addClass('pagination-sm no-margin pull-right');
        $('.checkme,.checkall').on('change',function(){
            if($(this).is(':checked'))
                $('#deleteall').fadeIn(300);
            else
                $('#deleteall').fadeOut(300);
        });

        $('#buatkgbpns').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),
                //url : laravel_base + '/' + $(this).attr('href'),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        $('#buatkgbp3k').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),
                //url : laravel_base + '/' + $(this).attr('href'),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        $('.attrpengantaropd').on('click', function(e){
            e.preventDefault();
            claravel_modal('Atribut Surat Pengantar OPD','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/suratpengantar',
                data: {'idkgb': $(this).attr('idkgb'), 'idskpd': $(this).attr('idskpd'), 'jnskgb': $(this).attr('idjenis'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        });

        $('.iscetaksk').on('change', function(e){
            e.preventDefault();
            var $this =$(this);
            if($(this).is(':checked')){
                var iscetaksk = 1;
                var alert = 'Penetapan Cetak SK Berhasil.';
                var warning = 'Tetapkan Cetak SK dan Update ke Riwayat KGB ?';
            }else{
                var iscetaksk = 0;
                var alert = 'Penetapan Cetak SK Berhasil dibatalkan.';
                var warning = 'Batalkan Penetapan Cetak SK dan Update ke Riwayat KGB ?';
            }

            bootbox.confirm(''+warning,function(a){
                if(a == true){
                    $.ajax({
                        url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/cetaksk',
                        type : 'post',
                        data: {'rectmtkgb' : $this.attr('rectmtkgb'), 'recidskpd' : $this.attr('recidskpd'), 'iscetaksk': iscetaksk, '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='4'){
                                notification(alert,'success');
                                refresh_page();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });

        });

        $('#buat').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('href'),
                //url : laravel_base + '/' + $(this).attr('href'),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });

        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>

        $('#tabel').on('click','#hapus',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Hapus?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/delete',
                        type : 'post',
                        data: {'id' : $this.attr('recid'),'nip' : $this.attr('recnip'), '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if(html=='9'){
                                notification('Berhasil Dihapus','success');
                                $this.closest('tr').fadeOut(300,function(){
                                    $(this).remove();
                                });
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
        $('#tabel').on('click','#edit',function(e){
            e.preventDefault();
            var $this =$(this);
            bootbox.confirm('Edit?',function(a){
                if(a == true){
                    $.ajax({
                        url : index_page + '/edit',
                        type : 'get',
                        data:'id=' + $this.attr('recid'),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            $('#utama').html(html);
                        }
                    });
                }
            });
        });
        $('#cari').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                data:$(this).serialize(),
                type : 'get',
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        });
        $('#data').on('submit',function(e){
            e.preventDefault();
            var iki = $(this);
            bootbox.confirm('Hapus?',function(r){
                if(r){
                    $.ajax({
                        url : iki.attr('action') + '/delete',
                        type : 'post',
                        data:iki.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            notification(html,'success');
                            iki.find('input[type=checkbox]').each(function (t){
                                if($(this).is(':checked')){
                                    $(this).closest('tr').fadeOut(100)                                        
                                }
                            });
                            $('#deleteall').fadeOut(300);
                        }
                    });
                }
            });            
        });

        $('a.editkgb').on('click', function(e){
            e.preventDefault();
            claravel_modal('Edit Kenaikan Gaji Berkala','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/editkgb',
                data: {'idkgb': $(this).attr('recidkgb'), 'nip': $(this).attr('recnip'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });

        });

        $('a.verifikasikgb').on('click', function(e){
            e.preventDefault();
            claravel_modal('Verifikasi Kenaikan Gaji Berkala','Loading...','main_modal2');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/verifikasikgb',
                data: {'idstspeg': $(this).attr('recidstspeg'),'idkgb': $(this).attr('recidkgb'), 'nip': $(this).attr('recnip'), 'jnskgb': $(this).attr('recjnskgb'), '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal2 .modal-body').html(html);
                }
            });

        });
    });
</script>
