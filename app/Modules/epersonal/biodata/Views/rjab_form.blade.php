<?php
    if(session('role_id') <= 3){
        $alert = "Simpan data ?";
    }else{
        $alert = "<strong>Perhatian!</strong><ul><li>Penambahan, Update atau Delete akan diverifikasi oleh Admin BKD terlebih dahulu.</li><li>Riwayat jabatan yang memiliki tmt jabatan terbaru akan langsung terupdate ke biodata.</li></ul>";
    }
?>

<div class="nav-tabs-custom" style="box-shadow:none;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_1"><i class="fa fa-pencil"></i> <b>INPUTs</b></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => url()."/epersonal/biodata/".((session('role_id') <= 3)?'saverjab':'saverjabtemp'), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'form-rjab')) !!}
                    @if(session('role_id') <= 3)
                        {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                        {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                    @else
                        {!! Form::hidden('tb', Input::get('tb'), array('id'=> 'tb')) !!}
                        @if((Input::get('tb') == 'r_jab') or (Input::get('tb') == ''))
                            {!! Form::hidden('id_rjab', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('idjnsaksi', Input::get('flag'), array('id'=> 'idjnsaksi')) !!}
                        @else
                            {!! Form::hidden('id', null, array('id'=> 'id')) !!}
                            {!! Form::hidden('id_rjab', null, array('id'=> 'id_rjab')) !!}
                            {!! Form::hidden('idjnsaksi', null, array('id'=> 'idjnsaksi')) !!}
                        @endif
                    @endif
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

                        <!-- <div id="xisttb"></div> -->

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
                                    @if(Input::get('flag') == 1)
                                        <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    @elseif(Input::get('flag') == 2)
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> Update</button>
                                    @elseif(Input::get('flag') == 3)
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> Hapus</button>
                                    @endif
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
        $('#form-rjab select').select2();

        <?php if(Input::get("flag") == 1){ ?>
            $('#form-rjab #skpd').val($('#simpan #idskpd').find(":selected").text());
            autoComplete('#form-rjab #idskpd', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, $('#simpan #idskpd').val(), $('#simpan #idskpd').find(":selected").text(), '');
        <?php } ?>
        $('#form-rjab #idskpd').on('change', function(e){
            e.preventDefault();
            $('#form-rjab #skpd').val($(this).find(":selected").text());
            /*$("#form-rjab #idjab, #form-rjab #idesljbt").data('select2').trigger('select', {
                data: {"id":'',"text":''}
            });*/
        });

        $('#form-rjab .num').keyup(function () {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });
        $("#form-rjab .date").mask("99-99-9999");
        $("#form-rjab .datepicker").datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#form-rjab').on('submit',function(e){
            var $this = $(this);
            e.preventDefault();
            bootbox.confirm('{!!$alert!!}',function(a){
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
                                loadBiodata();
                                loadRjab();
                            }else{
                                notification(html,'danger');
                            }
                        }
                    });
                }
            });
        });
		
		$('#form-rjab #idjenjab').on('change', function(e){
            e.preventDefault();
            var idjenjab = $(this).val();
            /*alert($('#form-rjab #idjnsaksi').val()+' - '+$('#form-rjab  #id').val()+' vs '+$('#idjnsaksi').val()+' - '+$('#id').val());*/
            $.ajax({
                url:'{{url()}}/epersonal/biodata/jenisjabatan2',
                type:'post',
                data:{'idjenjab': $(this).val(), 'idskpd': $('#form-rjab  #idskpd').val(), 'nip': $('#form-rjab  #nip').val(), 'id': $('#form-rjab  #id').val(), 'tb':  "{!!Input::get('tb')!!}",'_token' : '{!!csrf_token()!!}', 'act': 'biodata'},
                beforeSend:function(){
                    $('#form-rjab #jenisjabatan').html('Looading...');
                },
                success:function(respose){
                    $('#form-rjab #xjenisjabatan').html(respose);
                }
            })
        })

        <?php if(Input::get("flag") > 1){ ?>
        $.ajax({
            url:'{!!url()!!}/epersonal/biodata/editriwayat',
            type:'post',
            data:{'id':'{!!Input::get("id")!!}','tb':'{!!Input::get("tb")!!}','_token' : '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                var ret = $.parseJSON(response);
                var arrdate = new Array("tgsk","tmtjab");
                var arrselect2 = new Array("idjenjab","jab","pejmen","idskpd");
                if(ret){
                    for(attrname in ret){
                        $('#form-rjab #'+attrname).val(ret[attrname]);
                        if($.inArray(attrname,arrselect2)!=-1){
                            $('#form-rjab #'+attrname).select2('val',ret[attrname]);
                        }
                        if($.inArray(attrname,arrdate)!=-1){
                            var str = ret[attrname];
                            var res = str.split("-");
                            $('#form-rjab #'+attrname).val(res[2]+'-'+res[1]+'-'+res[0]);
                        }
                    }

                    /*$("#form-rjab #idskpd").data('select2').trigger('select', {
                        data: {"id":ret.idskpd,"text":ret.skpd}
                    });*/
					getistt(ret.idjenjab, ret.idskpd);
                    autoComplete('#form-rjab #idskpd', '{{url()}}/epersonal/biodata/skpd', '.: Pilihan :.', null, ret.idskpd, ret.skpd, '');					
                }				
            }
        });
        <?php } ?>

        // $('#form-rjab #idskpd').on('change', function(e){
        //     e.preventDefault();
        //     var idskpd = $('#form-rjab #idskpd').val();
        //     $.ajax({
        //         url:'{{url()}}/epersonal/biodata/isttb',
        //         type:'post',
        //         data:{'idskpd': idskpd, 'nip': $('#form-rjab  #nip').val(), 'id': $('#form-rjab  #id').val(),'tb':  "{!!Input::get('tb')!!}",'_token' : '{!!csrf_token()!!}'},
        //         success:function(respose){
        //             $('#form-rjab #xisttb').html(respose);
        //         }
        //     })
        // }).trigger('change');
    });
	
	function getistt(idjenjab, idskpd){	           
		$.ajax({
			url:'{{url()}}/epersonal/biodata/jenisjabatan2',
			type:'post',
			data:{'idjenjab': idjenjab, 'idskpd': idskpd, 'nip': $('#form-rjab  #nip').val(), 'id': $('#form-rjab  #id').val(), 'tb':  "{!!Input::get('tb')!!}",'_token' : '{!!csrf_token()!!}', 'act': 'biodata'},
			beforeSend:function(){
				$('#form-rjab #jenisjabatan').html('Looading...');
			},
			success:function(respose){
				$('#form-rjab #xjenisjabatan').html(respose);
			}
		})
	}

</script>