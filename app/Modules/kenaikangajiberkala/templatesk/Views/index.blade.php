<section class="content-header">
    <h1>
        Template SK<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Template SK</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="table-responsive">
            <div class="box-body nav-tabs-custom">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#pengantarskpd" data-toggle="tab" aria-expanded="true"><i class="fa fa-pencil"></i> Surat Pengantar OPD</a></li>
                    <li class=""><a href="#persetujuan" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Kenaikan Gaji Berkala</a></li>
                    <?php
                    $role_id = \session::get('role_id');
                    if($role_id<=2){
                    ?>
					<li class=""><a href="#persetujuan_tte" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> KGB Paperless</a></li>
                    <li class=""><a href="#persetujuan_tte_p3k" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> KGB Paperless PPPK</a></li>
					<?php } ?>
                </ul>

                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="persetujuan"></div>
                    <!-- /.tab-pane -->
                </div>

            </div>
        </div>
    </div>
</section>         

<script>
    var xhr = $.ajax();

    $(document).ready(function(){
        getPengantarskpd();
        $('#myTab li a').each(function(index,item){
            $(item).click(function(){
                switch(index){
                    case 0: getPengantarskpd(); break;
                    case 1: getPersetujuan(); break;
                    case 2: getPersetujuanTTE(); break;
                    case 3: getPersetujuanTTEP3k(); break;
                }
            });
        });
    });

    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }

    function getPengantarskpd(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/kenaikangajiberkala/templatesk/data/pengantarskpd',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
                $('#persetujuan').html('Memuat...');
            },
            success:function(response){
                preloader.off();
                $('#persetujuan').html(response);
            }
        });
    }

    function getPersetujuan(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/kenaikangajiberkala/templatesk/data/persetujuan',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
                $('#persetujuan').html('Memuat...');
            },
            success:function(response){
                preloader.off();
                $('#persetujuan').html(response);
            }
        });
    }

    function getPersetujuanTTE(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/kenaikangajiberkala/templatesk/data/persetujuan_tte',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
                $('#persetujuan').html('Memuat...');
            },
            success:function(response){
                preloader.off();
                $('#persetujuan').html(response);
            }
        });
    }

    function getPersetujuanTTEP3k(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/kenaikangajiberkala/templatesk/data/persetujuan_tte_p3k',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
                $('#persetujuan').html('Memuat...');
            },
            success:function(response){
                preloader.off();
                $('#persetujuan').html(response);
            }
        });
    }
</script>
