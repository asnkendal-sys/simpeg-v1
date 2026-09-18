<section class="content-header">
    <h1>
        Template Kenaikan Pangkat<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Template Kenaikan Pangkat</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="table-responsive">
            <div class="box-body nav-tabs-custom">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#pengantarskpd" data-toggle="tab" aria-expanded="true"><i class="fa fa-pencil"></i> Surat Pengantar OPD</a></li>
                    @if(Session::get('role_id') <= 3)
                    <li class=""><a href="#persetujuan" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Surat Kenaikan Pangkat</a></li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="pengantarskpd"></div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="persetujuan"></div>
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
            url:'{!!url()!!}/kenaikanpangkat/templatekenaikanpangkat/data/pengantarskpd',
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
            url:'{!!url()!!}/kenaikanpangkat/templatekenaikanpangkat/data/persetujuan',
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
</script>
