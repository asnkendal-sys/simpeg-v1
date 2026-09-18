<html>
<head>
    <title>Struktur Organisasi</title>
    <style type="text/css" media="all">
            /*Now the CSS*/
        * {margin: 0; padding: 0;background-color:#fff}
        .treeDiv
        {
            margin:0 auto;
            text-align:center;
            width:10500px;
        }
        .tree ul {
            padding-top: 20px; position: relative;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

            /*We will use ::before and ::after to draw the connectors*/

        .tree li::before, .tree li::after{
            content: '';
            position: absolute; top: 0; right: 50%;
            border-top: 1px solid #ccc;
            width: 50%; height: 20px;
        }
        .tree li::after{
            right: auto; left: 50%;
            border-left: 1px solid #ccc;
        }

            /*We need to remove left-right connectors from elements without
           any siblings*/
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

            /*Remove space from the top of single children*/
        .tree li:only-child{ padding-top: 0;}

            /*Remove left connector from first child and
        right connector from last child*/
        .tree li:first-child::before, .tree li:last-child::after{
            border: 0 none;
        }
            /*Adding back the vertical connector to the last nodes*/
        .tree li:last-child::before{
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }
        .tree li:first-child::after{
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

            /*Time to add downward connectors from parents*/
        .tree ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 20px;
        }

        a span.sotk-title{
            display:block;
            background-color:#F4F4F4;
            min-height:50px;
            max-height:55px;
            overflow:hidden;
        }

        .tree li a,.tree a.top-tree{
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display:inline-block;
            width:80px;
            height:200px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li a.vert-line{
            border:none;
            position:relative;
            height:450px;
        }

        .tree li a.vert-line:before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 460px;
        }

        .sotk-nama{
            display:block;
            background-color:#F4f4f4;
            font-size:9px;
            overflow:hidden;
        }

        .sotk-nip{
            margin-top:20px;
            display:block;
            background-color:#F4f4f4;
            text-decoration:underline;
            font-size:9px;
            overflow:hidden;
        }
    </style>

    <script type="text/javascript" src="{!!asset('packages/tugumuda/plugins/jQuery/jquery-1.11.0.min.js')!!}"></script>
    <script>
        $(document).ready(function(){
            $('ul li a').find('.sotk-nip').each(function(index,item){
                if($(item).html()=='Jabatan Kosong') $(item).parent().css('background-color','orange');
            });
        });
    </script>
</head>
<body>
<div align="center">
    <div class="treeDiv">
        <div class="tree">
            <?php
                if ($idskpd != ''){
                $rs = \DB::table('a_skpd as a')
                    ->select(
                        'a.idskpd','a.skpd','a.jab','a.path','b.nip','b.niplama','b.photo',
                        \DB::raw("concat(if(length(b.gdp)>0,concat(b.gdp,' '),''),b.nama,if(length(b.gdb)>0,concat(',',b.gdb),'')) as namalengkap")
                    )
                    ->leftjoin('tb_01 as b', function($join){
                    $join->on('a.idskpd','=','b.idjabjbt')
                        ->where('b.idjenkedudupeg','!=',99)
                        ->where('b.idjenkedudupeg','!=',21);
                })
                ->where('a.flag', 1)
                ->where('a.idskpd', $idskpd);

                $item = $rs->first();
            ?>

            @if(count($item) > 0)
            <?php
                $div1 = "<div class=\"sotk-nama\">".$item->namalengkap."</div>";
                $div2 = "<div class=\"sotk-nip\">".(($item->nip!='')?$item->nip:'Jabatan Kosong')."</div>";

                if(File::exists("packages/upload/photo/pegawai/".$item->photo)){
                    $urlphoto = url()."/packages/upload/photo/pegawai/".$item->photo;
                }else{
                    $urlphoto = url()."/packages/upload/photo/pegawai/default.jpg";
                }
            ?>
            <ul>
                <li><a><span class="sotk-title">{!!$item->skpd!!}</span>
                    <i style="margin:0 auto;margin-top:5px;border:1px solid #CCCCCC;background:url({!!$urlphoto!!})
                        no-repeat center center;background-size:100% 100%;width:70px;height:80px;display:block;border-radius:5px;"></i>
                    {!!$div2!!}
                    {!!$div1!!}
                </a>
                    <ul>
                        {!! familytree($idskpd) !!}
                    </ul>
                </li>
            </ul>
            @else
            <ul>
                <li>
                    <div><i>Mohon Maaf.. Unit Kerja tidak ditemukan.</i></div>
                </li>
            </ul>
            @endif
            <?php }else{  
                $urlphoto = url()."/packages/upload/photo/pegawai/default.jpg";
            ?>
            <ul>
                <li>
                    <div><i>Mohon Maaf.. Unit Kerja tidak ditemukan.</i></div>
                </li>
            </ul>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>