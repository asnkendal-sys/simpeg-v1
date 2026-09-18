<section class="content-header">
    <h1>
        Template SK Cuti<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Template SK Cuti </li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">

        <div class="table-responsive">
            <div class="box-body nav-tabs-custom">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#skcuti" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> Formulir Permintaan Dan Pemberian Cuti </a></li>
                   <!--  <li><a href="#izinsementara" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> Izin Sementara </a></li> -->
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="skcuti"></div>
                    <div class="tab-pane" id="izinsementara"></div>
                </div>

            </div>
        </div>

    </div>
</section>

<script>
    // var xhr = $.ajax();        
    $(document).ready(function(){
        /*Kelupaan TRUS*/
        getSKCuti();
        /*Dipanggil Saat Pertama DIBUKA*/
        $('#myTab li a').each(function(index,item){
            $(item).click(function(){
                switch(index){
                    case 0 : getSKCuti(); break;
                    case 1 : getIzinsementara(); break;
                }
            });
        });                
    });

    function getSKCuti(){
        // xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/ecuti/templateskcuti/data/skcuti',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#skcuti').html(response);
            }
        });
    }

    function getIzinsementara(){
        // xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/ecuti/templateskcuti/data/izinsementara',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#izinsementara').html(response);
            }
        });
    }
</script>
