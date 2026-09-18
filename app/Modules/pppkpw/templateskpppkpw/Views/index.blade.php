<section class="content-header" style="margin-bottom: 0 !important;">
    <h1>
        Template SK PPPK PW<small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!!url()!!}"> Dashboard</a></li>
        <li class="active">Template SK PPPK PW</li>
    </ol>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="table-responsive">
            <div class="box-body nav-tabs-custom">

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#templatepengantar" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Template Pengantar OPD</a></li>
                    @if(session('idskpd') <= 2)
                    <li class=""><a href="#templatecpppk" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i> Template CPPPK</a></li>
                    <li class=""><a href="#templatesp" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Template SP</a></li>
                    <li class=""><a href="#templatespk" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Template SPK</a></li>
                    <li class=""><a href="#templatepetikan" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Petikan Pengangkatan</a></li>
                    <li class=""><a href="#templatepetikanperpanjangan" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Petikan Perpanjangan</a></li>
                    <!-- <li class=""><a href="#templatepemberhentianbup" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Pemberhentian BUP</a></li>
                    <li class=""><a href="#templatepemberhentiannonbup" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Pemberhentian Meninggal</a></li>
                    <li class=""><a href="#templateberhenti" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Pemberhentian APS</a></li>
                    <li class=""><a href="#templatepemberhentiankeuzuran" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Pemberhentian Keuzuran</a></li>
                    <li class=""><a href="#templatepemberhentianhukdis" data-toggle="tab" aria-expanded="false"><i class="fa fa-list"></i> Pemberhentian Hukdis</a></li> -->
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="templatepengantar"></div>
                    @if(session('idskpd') <= 2)
                    <div class="tab-pane" id="templatecpppk"></div>
                    <div class="tab-pane" id="templatesp"></div>
                    <div class="tab-pane" id="templatespk"></div>
                    <div class="tab-pane" id="templatepetikan"></div>
                    <div class="tab-pane" id="templatepetikanperpanjangan"></div>
                    <!-- <div class="tab-pane" id="templatepemberhentianbup"></div>
                    <div class="tab-pane" id="templatepemberhentiannonbup"></div>
                    <div class="tab-pane" id="templateberhenti"></div>
                    <div class="tab-pane" id="templatepemberhentiankeuzuran"></div>
                    <div class="tab-pane" id="templatepemberhentianhukdis"></div> -->
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        getTemplatepengantar();
        $('#myTab li a').each(function(index,item){
            $(item).click(function(){
                switch(index){
                    case 0: getTemplatepengantar(); break;
                    case 1: getTemplatecpppk(); break;
                    case 2: getTemplatesp(); break;
                    case 3: getTemplatespk(); break;
                    case 4: getTemplatepetikan(); break;
                    case 5: getTemplatepetikanperpanjangan(); break;
                    case 6: getTemplatepemberhentianbup(); break;
                    case 7: getTemplatepemberhentiannonbup(); break;
                    case 8: getTemplateberhenti(); break;
                    case 9: getTemplatepemberhentiankeuzuran(); break;
                    case 10: getTemplatepemberhentianhukdis(); break; 
                }
            });
        });
    });

    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }

    function getTemplatecpppk(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatecpppkpw',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatecpppk').html(response);
            }
        });
    }

    function getTemplatesp(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatesp',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatesp').html(response);
            }
        });
    }

    function getTemplateberhenti(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templateberhenti',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templateberhenti').html(response);
            }
        });
    }

    function getTemplatespk(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatespk',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatespk').html(response);
            }
        });
    }

    function getTemplatepetikan(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatepetikan',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatepetikan').html(response);
            }
        });
    }

    function getTemplatepengantar(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatepengantar',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatepengantar').html(response);
            }
        });
    }

    function getTemplatepetikanperpanjangan(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatepetikanperpanjangan',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatepetikanperpanjangan').html(response);
            }
        });
    }

    function getTemplatepemberhentianbup(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatepemberhentianbup',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatepemberhentianbup').html(response);
            }
        });
    }

    function getTemplatepemberhentiannonbup(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatepemberhentiannonbup',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatepemberhentiannonbup').html(response);
            }
        });
    }

    function getTemplatepemberhentiankeuzuran(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatepemberhentiankeuzuran',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatepemberhentiankeuzuran').html(response);
            }
        });
    }

    function getTemplatepemberhentianhukdis(){
        xhr.abort();
        $.ajax({
            type:'post',
            url:'{!!url()!!}/pppkpw/templateskpppkpw/data/templatepemberhentianhukdis',
            data: {'_token': '{!!csrf_token()!!}'},
            beforeSend:function(){
                preloader.on();
            },
            success:function(response){
                preloader.off();
                $('#templatepemberhentianhukdis').html(response);
            }
        });
    }
</script>
