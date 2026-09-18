<section class="content-header">
    <h1>
        Buat Riwayat PPPK Baru<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li><a href="#" id="back"> Riwayat PPPK</a></li>
        <li class="active">Buat Riwayat PPPK Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border row">
            <div class="col-md-12">
                <ul class="nav nav-tabs tab1" id="myTab">
                    <li class="{!!(Request::segment(3)=='')?'active':''!!}"><a href="{!!url()!!}/konversidata/riwayatpppk"> <i class="fa fa-fw fa-list-ul"></i> HISTORI KONVERSI</a></li>
                    <li class="{!!(Request::segment(3)=='create')?'active':''!!}"><a href="{!!url()!!}/konversidata/riwayatpppk/create"> <i class="fa fa-fw fa-list-ul"></i> FORMULIR KONVERSI</a></li>
                </ul>

                <div class="tab-pane active"><br>
                    {!! Form::open(array('url' => \Request::path(), 'method' => 'POST', 'class'=>'form-horizontal form-'.\Config::get('claravel::ajax'),'id'=>'simpan')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('konversi', 'Konversi:', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-7">
                                <input type="file" name="konversi" id="konversi" title=".xls .xlsx" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                                <em><small>* file konversi type .xls atau .xlsx</small></em>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-7">
                                {!! ClaravelHelpers::btnSave() !!}
                                &nbsp;
                                &nbsp;
                                <button type="reset" id="batalkan" class="btn btn-warning "><i class="fa fa-times-circle-o"></i> Batalkan</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
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

        $('ul#myTab').on('click','a',function(e){
            var str = $(this).attr('href');
            var n = str.search("dashboard");
            loading('utama');
            if(n > 0){
            }
            else{
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
                    type: 'get',
                    url : $(this).attr('href'),
                    beforeSend: function(){
                        preloader.on();
                    },
                    success: function(data) {
                        preloader.off();
                        $('#utama').html(data);
                    }
                });
            }
        });

        $('#simpan').on('submit',function(e){
            var $this = $(this);
            var formData = new FormData(this);
            e.preventDefault();
            bootbox.confirm('Simpan data?',function(a){
                if (a == true){
                    $.ajax({
                        type:'POST',
                        url: $this.attr('action'),
                        data:formData,
                        cache:false,
                        contentType: false,
                        processData: false,
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

        $('#konversi').fileinput({
            showUpload:false,
            previewFileType:'any',
            allowedFileExtensions: ["xls", "xlsx"],
            maxFileSize: 1024 * 50 * 1 ,
            browseLabel: "",
            browseIcon: '<i class="fa fa-folder-open"></i>',
            removeLabel: " Hapus",
            removeIcon: '<i class="fa fa-times"></i>',
            layoutTemplates: {
                main1: "{preview}\n" +
                    "<div class=\'input-group {class}\'>\n" +
                    "   <div class=\'input-group-btn\'>\n" +
                    "       {browse}\n" +
                    "       {upload}\n" +
                    "       {remove}\n" +
                    "   </div>\n" +
                    "   {caption}\n" +
                    "</div>"
            }
        });
    });
</script>
