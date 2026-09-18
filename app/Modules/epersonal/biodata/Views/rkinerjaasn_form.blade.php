<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab"><i class="fa fa-pencil"></i> <b>INPUT</b></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/saverkinerjaasn", 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rkinerjaasn')) !!}
                    {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('nip', 'NIP:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('nip', $nip, array('class'=> 'form-control', 'maxlength'=>18, 'placeholder'=>'Nomor Induk Pegawai', 'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tahun', 'Tahun:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tahun', null, array('class'=> 'form-control', 'placeholder'=>'Tahun', 'maxlength'=> 4)) !!}
                                
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('nippenilai', 'NIP Pejabat Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <select name="nippenilai" class="form-control nippenilai" id="nippenilai" style="width: 100%"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pejpenilai', 'Nama Pejabat Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('pejpenilai', null, array('class'=> 'form-control', 'placeholder'=>'Nama Pejabat Penilai')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('jabpenilai', 'Jab Pejabat Penilai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                {!! Form::text('jabpenilai', null, array('class'=> 'form-control', 'placeholder'=>'Jab Pejabat Penilai')) !!}
                                <!-- LIST INPUT TYPE HIDDEN -->
                                <!-- <input class="idjenjabpenilai" name="idjenjabpenilai" type="text">
                                <input class="idjabpenilai" name="idjabpenilai" type="text"> -->
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('skpd', 'OPD:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <input id="idskpdpenilai" name="idskpdpenilai" type="hidden">
                                {!! Form::text('skpd', null, array('class'=> 'form-control', 'placeholder'=>'OPD')) !!}
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            {!! Form::label('capaiankinerja', 'Capaian Kinerja Organisasi:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                            {!!combo_capaianKinerja("capaiankinerja","","")!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('ratinghasil', 'Rating Hasil Kerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                            {!!combo_ratingHasil("ratinghasil","","")!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('ratingperilaku', 'Rating Perilaku Kinerja:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                            {!!combo_ratingPerilaku("ratingperilaku","","")!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('predikatkinerja', 'Predikat Kinerja Pegawai:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                            {!!combo_predikatKinerja("predikatkinerja","","")!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    <button aria-hidden="true" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times-circle-o"></i> Batalkan</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /.tab-content -->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        autoComplete2('.nippenilai', '{{url('')}}/ecuti/nominatifcuti/caripegawai', 'Ketikkan NIP atau Nama', null, '{!!Input::get("id")!!}', '{!!Input::get("id")!!}', '');
        $(".nippenilai").on('change', function(e){
            e.preventDefault();
            var nippenilai = $(".nippenilai").val();
            if (nippenilai != null) {
                $.ajax({
                    url: '{{url('')}}/ecuti/nominatifcuti/detailpegawai',
                    type: 'post',
                    data: { 'nip':nippenilai,'_token':'{!!csrf_token()!!}'},
                    success:function(response){
                        var ret = $.parseJSON(response);
                        $("#pejpenilai").val(ret.nama);
                        $("#jabpenilai").val(ret.jab);
                        $("#skpd").val(ret.skpd);

                        $("#idjenjabpenilai").val(ret.idjenjab);
                        $("#idjabpenilai").val(ret.idjab);
                        $("#idskpdpenilai").val(ret.idskpd);
                    }
                });
            }
        }).trigger('change');

        $('#form-rkinerjaasn').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        beforeSend: function(){
                            preloader.on();
                        },
                        success:function(html){
                            preloader.off();
                            if((html==1) || (html==4)){
                                notification('Data Berhasil Disimpan.','success');
                                $('.modal-close').trigger('click');
                                claravel_modal_close('main_modal');
                                loadRkinerjaasn();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });


        <?php if(Input::get("flag") == 2){ ?>
            $.ajax({
                url:'{!!url()!!}/epersonal/biodata/editriwayat',
                type:'post',
                data:{'id':'{!!Input::get("id")!!}','tb':'r_kinerjaasn','_token' : '{!!csrf_token()!!}'},
                beforeSend:function(){
                    preloader.on();
                },
                success:function(response){
                    preloader.off();
                    var ret = $.parseJSON(response);
                    var arrselect2 = new Array("capaiankinerja","ratinghasil","ratingperilaku","predikatkinerja");
                    if(ret){
                        for(attrname in ret){
                            $('#form-rkinerjaasn #'+attrname).val(ret[attrname]);
                            if($.inArray(attrname,arrselect2)!=-1){
                                $('#form-rkinerjaasn #'+attrname).val(ret[attrname]).trigger('change.select2');
                            }
                        }

                        $("#form-rkinerjaasn #nippenilai").data('select2').trigger('select', {
                            data: {"id":ret.nippenilai,"text":ret.nippenilai}
                        });
                    }
                }
            });
        <?php } ?>
    });
</script>