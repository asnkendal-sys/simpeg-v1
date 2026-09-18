<section class="content-header">
    <h1>
        Template SK Pengantar<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Template SK Pengantar</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="table-responsive">
            <div class="box-body nav-tabs-custom">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#pengantarskpd" data-toggle="tab" aria-expanded="true"><i class="fa fa-pencil"></i> Surat Pengantar OPD</a></li>
                    @if(session('role_id') <= 3)
                    <li class=""><a href="#pengantarbkd" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Pengantar BKPP</a></li>
                    <li class=""><a href="#skperintah" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Perintah</a></li>
                    <li class=""><a href="#skperintahrangkap" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Perintah Merangkap</a></li>
                    <li class=""><a href="#pengantarsekda" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Perintah Kolektif </a></li>
                    <li class=""><a href="#notadinas" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Nota Dinas </a></li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="pengantarskpd"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="pengantarbkd"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="skperintah"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="skperintahrangkap"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="pengantarsekda"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="notadinas"></div>
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
                    case 1: getPengantarbkd(); break;
                    case 2: getSkperintah(); break;
                    case 3: getSkperintahRangkap(); break;
                    case 4: getPengantarsekda(); break;
                    case 5: getNotadinas(); break;
                }
            });
        });
    });

    function getPengantarskpd(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateskpengantar/data/pengantarskpd',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#pengantarskpd').html(response);
            }
        });
    }

    function getPengantarsekda(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateskpengantar/data/pengantarsekda',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#pengantarsekda').html(response);
            }
        });
    }

    function getPengantarbkd(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateskpengantar/data/pengantarbkd',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#pengantarbkd').html(response);
            }
        });
    }

    function getSkperintah(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateskpengantar/data/skperintah',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#skperintah').html(response);
            }
        });
    }

    function getNotadinas(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateskpengantar/data/notadinas',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#notadinas').html(response);
            }
        });
    }

    function getSkperintahRangkap(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateskpengantar/data/skperintahrangkap',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#skperintahrangkap').html(response);
            }
        });
    }
</script>
