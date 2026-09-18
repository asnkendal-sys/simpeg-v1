<section class="content">
    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'nominatif-pegawai')) !!}

      <div class="row">
        <div class="col-md-12">
            <div class="box-body" align="center">
                <?php $rs = \DB::table('tr_kgb_ledger')->where(array('idskpd'=>Input::get('idskpd'), 'bulan'=>Input::get('bulan'), 'tahun'=>Input::get('tahun')))->first(); ?>
                @if(count($rs) > 0)
                    @if($rs->file != '')
                        <a href="{!!asset('packages/upload/kgb-ledger/'.$rs->file)!!}" style="float: right;" target="_blank"><span aria-hidden="true" class="glyphicon glyphicon-download-alt"></span> Download</a>
                        <object data="{!!asset('packages/upload/kgb-ledger/'.$rs->file)!!}" style="width: 100%" height="450px"></object>
                    @else
                        File belum tersedia.
                    @endif
                @else
                    File belum tersedia.
                @endif
            </div>
        </div>
      </div>

    {!! Form::close() !!}

    <div class="box-footer">
        <a href="javascript:void(0)" title="Close" id="xclose">
            <div class="mybuttonmodal pull-right">Close</div>
        </a>&nbsp;
        @if(session('role_id') <= 3)
        <div class="mybuttonmodal pull-right">
            <input type="file" class="myfilemodal" name="upload" recidskpd="{!!@$rs->idskpd!!}" recbulan="{!!@$rs->bulan!!}" rectahun="{!!@$rs->tahun!!}" title=".pdf" accept=".pdf"/>
            Ganti File
        </div>&nbsp;
        <div class="mybuttonmodal pull-right">
            <a href="javascript:void(0)" id="xhapus" title="Hapus File" recidskpd="{!!@$rs->idskpd!!}" recbulan="{!!@$rs->bulan!!}" rectahun="{!!@$rs->tahun!!}" recfile="{!!@$rs->file!!}" class="myfilemodal">Hapus File</a>
        </div>&nbsp;
        @endif
    </div>
</section>

<script>
    $(document).ready(function(){
        $('#xclose').click(function(e){
            e.preventDefault();
            claravel_modal('Upload Ledger Gaji','Loading...','main_modal');
            $.ajax({
                type:'post',
                url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/data/ledgergaji',
                data: {'bulan': '{!!Input::get("bulan")!!}', 'tahun': '{!!Input::get("tahun")!!}', '_token' : '{!!csrf_token()!!}'},
                success:function(html){
                    $('#main_modal .modal-body').html(html);
                }
            });
        })

        $('#xhapus').on('click', function(e){
            e.preventDefault();
            var idskpd = $(this).attr('recidskpd');
            var bulan = $(this).attr('recbulan');
            var tahun = $(this).attr('rectahun');
            var file = $(this).attr('recfile');
            bootbox.confirm('Hapus file ledger gaji ?',function(a){
                if(a == true){
                    $.ajax({
                        type:'post',
                        url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/hapusledgergaji',
                        data: {'bulan': bulan, 'tahun': tahun, 'idskpd': idskpd, 'file': file, '_token' : '{!!csrf_token()!!}'},
                        beforeSend: function(){
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            $('#loading-state').fadeOut("slow");
                            if(html==9){
                                notification('Berhasil Hapus','success');
                                preview(idskpd, bulan, tahun);
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        })

        $('.myfilemodal').change(function(e) {
            e.preventDefault();
            var form_data = new FormData();
            var idskpd = $(this).attr('recidskpd');
            var bulan = $(this).attr('recbulan');
            var tahun = $(this).attr('rectahun');
            var file_data = $(this).prop('files')[0];
            bootbox.confirm('Ganti ledger gaji ?',function(a){
                if(a == true){
                    form_data.append('file', file_data);
                    form_data.append('idskpd', idskpd);
                    form_data.append('bulan', bulan);
                    form_data.append('tahun', tahun);
                    form_data.append('_token', '{!!csrf_token()!!}');
                    $.ajax({
                        url : '{!!url()!!}/kenaikangajiberkala/penetapannominatif/uploadfile',
                        type : 'post',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        beforeSend: function(){
                            $('#loading-state').fadeIn("slow");
                        },
                        success:function(html){
                            $('#loading-state').fadeOut("slow");
                            if(html==4){
                                notification('Berhasil Diupload','success');
                                preview(idskpd, bulan, tahun);
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

<style type="text/css">
    .data-awal .form-control{
        height: auto;
        background-color: #ececec;
    }

    .alert-dangers{
        border: 2px solid red;
    }

    .modal {
        overflow: auto !important;
    }
</style>

<style type="text/css">
    div.mybuttonmodal {

        /* IMPORTANT STUFF */
        overflow: hidden;
        position: relative;
        cursor:   pointer;

        /* SOME CUSTOM STYLING */
        width:  120px;
        padding: 7px;
        text-align: center;
        border: 1px solid green;
        font-weight: bold
        background: red;
    }

    div.mybuttonmodal:hover {
        background: green;
    }


    input.myfilemodal {
        height: 30px;
        cursor: pointer;
        position: absolute;
        top: 0px;
        right: 0px;
        font-size: 100px;
        z-index: 2;

        opacity: 0.0; /* Standard: FF gt 1.5, Opera, Safari */
        filter: alpha(opacity=0); /* IE lt 8 */
        -ms-filter: "alpha(opacity=0)"; /* IE 8 */
        -khtml-opacity: 0.0; /* Safari 1.x */
        -moz-opacity: 0.0; /* FF lt 1.5, Netscape */
    }

    table.tb td{
        padding:5px;
    }

    .grad {
        -moz-box-shadow: inset 0 0 50px #888;
        -webkit-box-shadow: inset 0 0 50px#888;
        box-shadow: inner 0 0 50px #888;
    }
</style>