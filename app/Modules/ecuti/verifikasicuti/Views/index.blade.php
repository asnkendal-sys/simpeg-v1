<section class="content-header">
    <h1>
        Verifikasi Cuti<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Verifikasicuti</li>
    </ol>
</section>
<section class="content">
    <!-- <div class="box box-primary"> -->
        <div class="table-responsive">
            <div class="box-body nav-tabs-custom">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="{!! (Input::get('halaman') == "1" || Input::get('halaman') == "" && Input::get('wewenangkhusus') != "2")?'active':'' !!}">
                        <a href="#atasan" data-toggle="tab" aria-expanded="false"><i class="fa fa-check"></i> Menu Verifikasi Atasan 
                            &nbsp;&nbsp;&nbsp;
                            <span class="label label-danger">
                                @if(\Session::get('role_id') == 1 || \Session::get('role_id') == 2)
                                {!! HitungNotifVerifAtasanUntukAdmin() !!}
                                @else
                                {!! HitungNotifVerifAtasan(\Session::get('user_id')) !!}
                                @endif
                            </span>
                        </a>
                    </li>
                    <li class="{!! (Input::get('halaman') == "2" || Input::get('wewenangkhusus') == "2")?'active':'' !!}">
                        <a href="#wewenang" data-toggle="tab" aria-expanded="false"><i class="fa fa-check"></i> Menu Verifikasi Wewenang 
                            &nbsp;&nbsp;&nbsp;
                            <span class="label label-danger">
                                @if(\Session::get('role_id') == 1 || \Session::get('role_id') == 2)
                                {!! HitungNotifVerifWewenangUntukAdmin() !!}
                                @else
                                {!! HitungNotifVerifWewenang(\Session::get('user_id')) !!}
                                @endif
                            </span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane {!! (Input::get('halaman') == "1" || Input::get('halaman') == "")?'active':'' !!}" id="atasan"></div>
                    <div class="tab-pane {!! (Input::get('halaman') == "2" || Input::get('wewenangkhusus') == "2")?'active':'' !!}" id="wewenang"></div>
                </div>
            </div>
        </div>
        <!-- </div> -->
    </section>  

    <script>
        function refresh_page(){
            <?php
            // echo 'var index_page=laravel_base + "/'.\Request::path().'";';
            ?>
            $.ajax({
                url:'{!!url()!!}/ecuti/verifikasicuti/awal',
                type : 'POST',
                data: {'halaman': '1','_token': '{!!csrf_token()!!}'},
                beforeSend: function(){
                    preloader.on();
                },
                success:function(html){
                    preloader.off();
                    $('#utama').html(html);
                }
            });
        }
        function viewAtasan(){
        // xhr.abort();
        $.ajax({
            type:'get',
            url:'{!!url()!!}/ecuti/verifikasicuti/atasan?atasankhusus={!!\Input::get("atasankhusus")!!}',
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#atasan').html(response);
            }
        });
    }
    function viewWewenang(){
        // xhr.abort();
        $.ajax({
            type:'get',
            url:'{!!url()!!}/ecuti/verifikasicuti/wewenang?wewenangkhusus={!!\Input::get("wewenangkhusus")!!}',
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#wewenang').html(response);
            }
        });
    }
    // var xhr = $.ajax();
    $(document).ready(function(){
        /*Dipanggil Saat Pertama DIBUKA*/
        var halaman_aktif = "{!! (Input::get('halaman') != "")?Input::get('halaman'):'1' !!}";
        var hal_notif = "{!!\Input::get('wewenangkhusus')!!}";
        if (hal_notif!="") {
            halaman_aktif = 2;
        }
        // alert(halaman_aktif);
        // viewAtasan();
        if (halaman_aktif == 2) {
            viewWewenang();
        }else{
            viewAtasan();
        }
        $('#myTab li a').each(function(index,item){
            $(item).click(function(){
                switch(index){
                    case 0 : viewAtasan(); break;
                    case 1 : viewWewenang(); break;
                }
            });
        });                

        $('.pagination').addClass('pagination-sm no-margin pull-right');
        <?php
        echo 'var index_page=laravel_base + "/'.\Request::path().'";';
        ?>
    });
</script>
