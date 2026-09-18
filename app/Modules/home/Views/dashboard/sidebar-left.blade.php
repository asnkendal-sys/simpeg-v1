<?php
$claravel = new \MenuLibrary;
$menu =  $claravel->createMenu();
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <div class="user-panel">
        <?php
        $pict = "default.jpg";
        if (session('role_id') == 5) {
            if (file_exists("./packages/upload/photo/pegawai/" . session('foto'))) {
                $pict = 'pegawai/' . session('foto');
            } else {
                $pict = "default.jpg";
            }
        } else {
            if (file_exists("./packages/upload/photo/" . session('user_id') . "/" . session('foto'))) {
                $pict = session('user_id') . '/' . session('foto');
            } else {
                $pict = "default.jpg";
            }
        }
        ?>
        <div class="pull-left image">
            <img alt="User Image" class="img-circle" src="{!!asset('packages/upload/photo/'.$pict)!!}">
        </div>
        <div class="pull-left info">
            <p>{{session('name')}}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> {{session('role')}}</a>
        </div>
    </div>
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU UTAMA</li>
            {!!$menu!!}
            <?php if (session('role_id') <= 4) { ?>
                <li>
                    <a id="menu-akhir" class="small-box-footer links linkhref" hal="Si Macan De'bezz" scret="loginfsimpeg_adm" link="https://simpeg.kendalkab.go.id/bezetting" href="javascript:void(0)"><i class="fa fa-paper-plane-o"></i> SI MACAN DE BEZZ</a>
                    <input type="hidden" name="use" id="use" value="{!!Session('user_name')!!}">
                    <input type="hidden" name="key" id="key" value="{!!Session('_key')!!}">
                    <input type="hidden" name="rol" id="rol" value="{!!Session('role_id')!!}">

                </li>
            <?php } ?>

            <li><a href="http://simpeg.kendalkab.go.id/bangkop"><i class="fa fa-graduation-cap"></i><span>IBEL / TUBEL</span> </a></li>
            <li><a href="http://simpeg.kendalkab.go.id/suket"><i class="fa fa-files-o"></i><span>SUKET ONLINE</span> </a></li>
            <li><a href="http://simpeg.kendalkab.go.id/diklatpim"><i class="fa fa-briefcase"></i><span>DIKLAT PIM</span> </a></li>
            <li><a href="http://simpeg.kendalkab.go.id/jabfung"><i class="fa fa-pagelines"></i><span>DALANE JABFUNG</span> </a></li>
            <li><a href="http://simpeg.kendalkab.go.id/tkp"><i class="fa fa-check"></i><span>TES KOMPETENSI PNS</span> </a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<script>
    $(document).ready(function() {
        $('a.linkhref').on('click', function(e) {
            var $this = $(this);
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
            bootbox.confirm('Lanjutkan ke Halaman ' + $this.attr('hal') + '..?', function(a) {
                if (a == true) {
                    $.ajax({
                        type: 'GET',
                        url: $this.attr('link') + '/' + $this.attr('scret'),
                        data: {
                            'username': $('#use').val(),
                            'password': $('#key').val(),
                            'role_id': $('#rol').val(),
                            '_token': '{!!csrf_token()!!}'
                        },
                        /*cache:false,
                        contentType: false,
                        processData: false,*/
                        beforeSend: function() {
                            preloader.on();
                            loading('utama');
                        },
                        success: function(html) {
                            preloader.off();
                            //window.location.replace($this.attr('link'));
                            //window.location.replace($this.attr('link'));
                            //window.location = $this.attr('link');
                            window.location.href = $this.attr('link');

                            //window.history.pushState("", "", $this.attr('link'));
                            //window.location.reload();

                            //location.assign($this.attr('link'));
                        },
                        error: function(html) {}
                    });
                }
            });
        });
    });
</script>
