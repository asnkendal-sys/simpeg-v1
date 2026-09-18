<section class="content-header">
    <h1>
        Template SK Luar Kabupaten<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Template SK Luar Kabupaten {!!\TemplateluarkabupatenModel::getPenetap('069', 'namalengkap')!!}</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="table-responsive">
            <div class="box-body nav-tabs-custom">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#pengantarskpd" data-toggle="tab" aria-expanded="true"><i class="fa fa-pencil"></i> Surat Pengantar OPD</a></li>
                    @if(session('role_id') <= 3)
                    <li class=""><a href="#persetujuan" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Persetujuan Pindah</a></li>
                    <li class=""><a href="#pengantarpersetujuan" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Pengantar Persetujuan</a></li>
                    <li class=""><a href="#menghadapkan" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Menghadapkan Pegawai</a></li>
                    <li class=""><a href="#pengantarmenghadapkan" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Pengantar Menghadapkan</a></li>
                    <li class=""><a href="#nodinpermohonan" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Nota Dinas Permohonan</a></li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="pengantarskpd"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="persetujuan"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="pengantarpersetujuan"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="menghadapkan"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="pengantarmenghadapkan"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="nodinpermohonan"></div>
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
                    case 2: getPengantarpersetujuan(); break;
                    case 3: getMenghadapkan(); break;
                    case 4: getPengantarmenghadapkan(); break;
                    case 5: getNodinpermohonan(); break;
                }
            });
        });                
    });

    function getPengantarskpd(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateluarkabupaten/data/pengantarskpd',
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

    function getPersetujuan(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateluarkabupaten/data/persetujuan',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#persetujuan').html(response);
            }
        });
    }

    function getPengantarpersetujuan(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateluarkabupaten/data/pengantarpersetujuan',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#pengantarpersetujuan').html(response);
            }
        });
    }

    function getMenghadapkan(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateluarkabupaten/data/menghadapkan',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#menghadapkan').html(response);
            }
        });
    }

    function getPengantarmenghadapkan(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateluarkabupaten/data/pengantarmenghadapkan',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#pengantarmenghadapkan').html(response);
            }
        });
    }
    function getNodinpermohonan(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/emutasi/templateluarkabupaten/data/nodinpermohonan',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#nodinpermohonan').html(response);
            }
        });
    }
</script>
