<?php
//    use App\Repositories\JabatanRepository;
//    use App\Services\JabatanService;

$nip = Input::get('nip');
$idjab = Input::get('id');
$idjabbkn = Input::get('idjabbkn');

if ($idjabbkn != '') {
    //        $jabBkn =(new JabatanService(new JabatanRepository))->fetchById($idjabbkn)->get();
    $jabBkn = accessDatapersonalsiasn('jabatan/id', $idjabbkn);
    $fieldid = getIdjabatanbkn($jabBkn->jenisJabatan);
    $fieldnm = getNamajabatanbkn($jabBkn->jenisJabatan);
    $idjabatan = $jabBkn->$fieldid;
    $namajabatan = $jabBkn->$fieldnm;

    /*echo "<pre>";
            print_r($jabBkn);
        echo "</pre>";
        exit();*/
}

/*catatan sinkronisasi*/
/*
     *
     Jika $idjabbkn kosong maka data sinkronisasi upload kebkn dengan hanya menampilan 1 form r_jabatan yang akan dikirim sinkronisasinya
     Jika $idjabbkn tidka kosong maka data sinkronisasi menampilkan 2 form yaitu data dari SIASN dan data dari r_jabatan simpeg kemudian ada pilihan tombol :
     1. TARIK DATA KE SIMPEG : Untuk form preview data dari r_jabatan SIASN
     2. TARIK DATA KE SIASN    : Untuk form preview data dari r_jabatan simpeg
     *
     * */

?>


<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        @if($idjab != '')
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>SINKRONISAI SIASN</b></a></li>
        @endif
        <li class="<?php echo (($idjab != '') ? '' : 'active') ?>"><a data-toggle="tab" id="xdatabkn" href="#tab_2"><i class="fa fa-list"></i> <b>DATA JABATAN SIASN</b></a></li>
    </ul>
    <div class="tab-content">
        @if($idjab != '')
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                @if($idjabbkn != '')
                <!--preview data r_jabatan SIASN-->
                <div class="col-md-6">
                    <div class="callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan data Riwayat Jabatan dari BKD</li>
                            <li>Untuk melakukan sinkronisasi data Jabatan dari SIASN ke simpeg tekan tombol <b>TARIK DATA</b></li>
                            <li>Ketika proses <b>TARIK DATA</b> selesai riwayat Jabatan dari BKD sudah terkoneksi dengan SIMPEG</li>
                        </ul>
                    </div>

                    {!! Form::open(array('url' => url()."/epersonal/biodata/syncrjabbkn", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rjab1')) !!}
                    {!! Form::hidden('id', $idjab, array('id'=> 'id')) !!}
                    {!! Form::hidden('idjabbkn', $idjabbkn, array('id'=> 'idjabbkn')) !!}
                    <div class="box-body">

                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idskpd','Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('unorNama', $jabBkn->unorNama, array('class'=> 'form-control', 'placeholder'=>'Nomor SK', 'readonly' => true)) !!}
                                {!! Form::hidden('unorId', $jabBkn->unorId, array('class'=> '')) !!}
                                {!! Form::hidden('eselonId', $jabBkn->eselonId, array('class'=> '')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idjenjab','Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('jenjab', getJenisjabatanbkn($jabBkn->jenisJabatan), array('class'=> 'form-control', 'placeholder'=>'Jenis Jabatan', 'readonly' => true)) !!}
                                {!! Form::hidden('idjenjab', $jabBkn->jenisJabatan, array('class'=> '')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('namajab', $jabBkn->namaJabatan, array('class'=> 'form-control', 'placeholder'=>'Nama Jabatan', 'readonly' => true)) !!}
                                {!! Form::hidden('idjab', $idjabatan, array('class'=> '')) !!}
                            </div>
                        </div>
                        {{-- <div class="form-group">
                                {!! Form::label('pejmen', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7">
                                    {!! comboPenetapsk("pejmen","","") !!}
                                </div>
                            </div> --}}
                        <div class="form-group">
                            {!! Form::label('nosk', 'Nomor SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nosk', $jabBkn->nomorSk, array('class'=> 'form-control', 'placeholder'=>'Nomor SK', 'readonly' => true)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tgsk', $jabBkn->tanggalSk, array('class'=> 'form-control', 'placeholder'=>'Tanggal SK', 'readonly' => true)) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tmtjab', 'TMT Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tmtjab', $jabBkn->tmtJabatan, array('class'=> 'form-control', 'placeholder'=>'Tmt Jabatan', 'readonly' => true)) !!}

                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> TARIK DATA KE SIMPEG</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
                @endif

                @if($idjab != 'x')
                <!--preview data r_jabatan simpeg-->
                <div class="col-md-<?php echo (($idjabbkn != '') ? 6 : 12) ?>">
                    <div class="callout callout-success">
                        <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                        <ul style="padding-left: 15px">
                            <li>Preview data yang ditampilkan merupakan data Riwayat Jabatan dari SIMPEG</li>
                            <li>Untuk melakukan sinkronisasi data dari SIMPEG ke SIASN tekan tombol <b>SINKRONISASI DATA</b></li>
                            <li>Ketika proses <b>SINKRONISASI</b> selesai data pada riwayat Jabatan SIMPEG sudah terkoneksi dengan SIASN</li>
                        </ul>
                    </div>
                    {!! Form::open(array('url' => url()."/epersonal/biodata/syncrjabsimpegsiasn", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rjab2')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    {!! Form::hidden('idjabbkn', null, array('id'=> 'idjabbkn')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idskpd','Unit Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="idskpd" class="form-control" id="idskpd" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                {!! Form::hidden('skpd', '', array('class'=> 'form-control', 'id'=>'skpd')) !!}
                                <em><small>(* Isian Unit Kerja isi dengan sub unit kerja terkecil.)</small></em>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('idjenjab','Jenis Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboJenjab("idjenjab","","") !!}
                            </div>
                        </div>
                        <div id="xjenisjabatan">
                            <div class="form-group">
                                {!! Form::label('jab', 'Nama Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                                <div class="col-sm-7" id="jenisjabatan">
                                    <select name="jab" class="form-control" id="jab" data-placeholder=".: Pilihan :." style="width: 100%"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pejmen', 'Pejabat Menetapkan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! comboPenetapsk("pejmen","","") !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('nosk', 'Nomor SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nosk', null, array('class'=> 'form-control', 'placeholder'=>'Nomor SK')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgsk', 'Tanggal SK:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tgsk', null, array('class'=> 'form-control date', 'placeholder'=>'Tanggal SK')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tmtjab', 'TMT Jabatan:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class='input-group datepicker'>
                                    {!! Form::text('tmtjab', null, array('class'=> 'form-control date', 'placeholder'=>'TMT SK')) !!}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> SINKRON DATA KE SIASN</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o"></i> BATALKAN</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
                @endif
            </div>
        </div>
        @endif

        <div id="tab_2" class="tab-pane <?php echo (($idjab != '') ? '' : 'active') ?>">
            <div class="row">
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> PETUNJUK</h4>
                    <ul style="padding-left: 15px">
                        <li>Menu ini menampilkan data riwayat Jabatan dari SIASN</li>
                        <li>Terdapat status sinkronisasi pada masing-masing list data riwayat</li>
                        <li>Tekan Tombol <b>SINKRONISASI</b> untuk tarik data Jabatan dari SIASN ke SIMPEG</li>
                    </ul>
                </div>

                <table class="table table-striped table-hover table-condensed table-bordered" role="grid" id="tb-rpangkat">
                    <thead class="bg-primary">
                        <tr>
                            <th width="2%">
                                <div class="text-center">NO</div>
                            </th>
                            <th>
                                <div class="text-center">JENIS JABATAN</div>
                            </th>
                            <th>
                                <div class="text-center">NAMA JABATAN</div>
                            </th>
                            <th>
                                <div class="text-center">NOMOR SK</div>
                            </th>
                            <th>
                                <div class="text-center">TANGGAL SK</div>
                            </th>
                            <th>
                                <div class="text-center">TMT SK</div>
                            </th>
                            <th>
                                <div class="text-center">UNIT KERJA</div>
                            </th>
                            <th width="8%">
                                <div class="text-center">AKSI</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="xresult">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.tab-content -->
</div>

<style type="text/css">
    .modal-dialog {
        overflow-y: initial !important
    }
</style>

<script type="text/javascript">
    var xhr = $.ajax();
    $(document).ready(function() {
        <?php if ($idjab == '') { ?>
            loadRjabbkn();
        <?php } ?>

        $('#xdatabkn').on('click', function() {
            loadRjabbkn();
        })

        $('#form-rjab2 select').select2();

        <?php if (Input::get("flag") == 1) { ?>
            $('#form-rjab2 #skpd').val($('#simpan #idskpd').find(":selected").text());
            autoComplete('#form-rjab2 #idskpd', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, $('#simpan #idskpd').val(), $('#simpan #idskpd').find(":selected").text(), '');
        <?php } ?>
        $('#form-rjab2 #idskpd').on('change', function(e) {
            e.preventDefault();
            $('#form-rjab2 #skpd').val($(this).find(":selected").text());
            /*$("#form-rjab2 #idjab, #form-rjab2 #idesljbt").data('select2').trigger('select', {
                data: {"id":'',"text":''}
            });*/
        });

        $('#form-rjab2 .num').keyup(function() {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rjab2 .date").mask("99-99-9999");
        $("#form-rjab2 .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#form-rjab1').on('submit', function(e) {
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Sinkroniasi Data SIASN ke Simpeg ?', function(a) {
                if (a == true) {
                    $.ajax({
                        url: $this.attr('action'),
                        type: 'POST',
                        data: $this.serialize(),
                        beforeSend: function() {
                            preloader.on();
                        },
                        success: function(html) {
                            preloader.off();
                            if ((html == 1) || (html == 4)) {
                                notification('Data Berhasil Tersinkronisasi.', 'success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal2');
                                loadRjab();
                            } else {
                                notification(html, 'danger');
                            }
                        }
                    });
                }
            });
        });

        $('#form-rjab2').on('submit', function(e) {
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Sinkroniasi Data Simpeg ke SIASN ?', function(a) {
                if (a == true) {
                    $.ajax({
                        url: $this.attr('action'),
                        type: 'POST',
                        data: $this.serialize(),
                        beforeSend: function() {
                            preloader.on();
                        },
                        success: function(html) {
                            preloader.off();
                            if ((html == 1) || (html == 4)) {
                                notification('Data Berhasil Tersinkronisasi.', 'success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal2');
                                loadRjab();
                            } else {
                                notification(html, 'danger');
                            }
                        }
                    });
                }
            });
        });

        <?php if (Input::get("flag") > 1) { ?>
            $.ajax({
                url: '{!!url()!!}/epersonal/biodata/editriwayat',
                type: 'post',
                data: {
                    'id': '{!!Input::get("id")!!}',
                    'tb': 'r_jab',
                    '_token': '{!!csrf_token()!!}'
                },
                beforeSend: function() {
                    preloader.on();
                },
                success: function(response) {
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrdate = new Array("tgsk", "tmtjab");
                    var arrselect2 = new Array("idjenjab", "jab", "pejmen", "idskpd");
                    if (ret) {
                        for (attrname in ret) {
                            $('#form-rjab2 #' + attrname).val(ret[attrname]);
                            if ($.inArray(attrname, arrselect2) != -1) {
                                $('#form-rjab2 #' + attrname).select2('val', ret[attrname]);
                            }
                            if ($.inArray(attrname, arrdate) != -1) {
                                var str = ret[attrname];
                                var res = str.split("-");
                                $('#form-rjab2 #' + attrname).val(res[2] + '-' + res[1] + '-' + res[0]);
                            }
                        }

                        /*$("#form-rjab2 #idskpd").data('select2').trigger('select', {
                            data: {"id":ret.idskpd,"text":ret.skpd}
                        });*/

                        autoComplete('#form-rjab2 #idskpd', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, ret.idskpd, ret.skpd, '');
                    }
                }
            });
        <?php } ?>

        $('#form-rjab2 #idjenjab').on('change', function(e) {
            e.preventDefault();
            var idjenjab = $(this).val();
            /*alert($('#form-rjab2 #idjnsaksi').val()+' - '+$('#form-rjab2  #id').val()+' vs '+$('#idjnsaksi').val()+' - '+$('#id').val());*/
            $.ajax({
                url: '{{url()}}/epersonal/biodata/jenisjabatan2',
                type: 'post',
                data: {
                    'idjenjab': $(this).val(),
                    'idskpd': $('#form-rjab2  #idskpd').val(),
                    'nip': $('#form-rjab2  #nip').val(),
                    'id': $('#form-rjab2  #id').val(),
                    'tb': "r_jab",
                    '_token': '{!!csrf_token()!!}',
                    'act': 'sinkron2'
                },
                beforeSend: function() {
                    $('#form-rjab2 #jenisjabatan').html('Looading...');
                },
                success: function(respose) {
                    $('#form-rjab2 #xjenisjabatan').html(respose);
                }
            })
        });
    });

    function loadRjabbkn() {
        xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: '{!!url()!!}/epersonal/biodata/data/rjab_sinkronsiasn_data',
            data: {
                'nip': '<?php echo $nip ?>',
                '_token': '{!!csrf_token()!!}'
            },
            beforeSend: function() {
                $('#xresult').html('Looading..');
            },
            success: function(response) {
                $('#xresult').html(response);
            }
        });
    }
</script>