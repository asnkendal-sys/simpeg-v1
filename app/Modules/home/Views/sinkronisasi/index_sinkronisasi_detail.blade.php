<?php
    use App\Models\SinkronisasiModel;
    $siasn = new SinkronisasiModel();

    $view = Request::segment(2);
    $nip = ((Request::segment(3)!='kendal')?Request::segment(3):'198305152011011014');
?>
<html>
    <head>
        <title>Service - {{$view}}</title>
    </head>
    <body>
    <?php
    switch($view){
        case 'data-anak':
            $bkn = accessDatariwayatsiasn('pns/data-anak',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'data-ortu':
            $bkn = accessDatariwayatsiasn('pns/data-ortu',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'data-pasangan':
            $bkn = accessDatariwayatsiasn('pns/data-pasangan',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'data-utama':
            $bkn = accessDatapersonalsiasn('pns/data-utama',$nip);
//            $bkn = accessDatariwayatsiasn('pns/data-utama',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-angkakredit':
            $bkn = accessDatariwayatsiasn('pns/rw-angkakredit',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-cltn':
            $bkn = accessDatariwayatsiasn('pns/rw-cltn',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-diklat':
            $bkn = accessDatariwayatsiasn('pns/rw-diklat',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-dp3':
            $bkn = accessDatariwayatsiasn('pns/rw-dp3',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-golongan':
            $bkn = accessDatariwayatsiasn('pns/rw-golongan',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-hukdis':
            $bkn = accessDatariwayatsiasn('pns/rw-hukdis',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-jabatan':
            $bkn = accessDatariwayatsiasn('pns/rw-jabatan',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-kursus':
            $bkn = accessDatariwayatsiasn('pns/rw-kursus',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-pemberhentian':
            $bkn = accessDatariwayatsiasn('pns/rw-pemberhentian',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-pendidikan':
            $bkn = accessDatariwayatsiasn('pns/rw-pendidikan',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-penghargaan':
            $bkn = accessDatariwayatsiasn('pns/rw-penghargaan',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-pindahinstansi':
            $bkn = accessDatariwayatsiasn('pns/rw-pindahinstansi',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-masakerja':
            $bkn = accessDatariwayatsiasn('pns/rw-masakerja',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-pnsunor':
            $bkn = accessDatariwayatsiasn('pns/rw-pnsunor',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-pwk':
            $bkn = accessDatariwayatsiasn('pns/rw-pwk',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-skp':
            $bkn = accessDatariwayatsiasn('pns/rw-skp',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'rw-skp22':
            $bkn = accessDatariwayatsiasn('pns/rw-skp22',$nip);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        /*Data berkala PPO*/
        case 'kpo-sk':
            $bkn = accessDatariwayatsiasn('kpo/sk');
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'kpo-sk-hist':
            list($tgl1,$tgl2)=explode("&",$nip);
            $tgl = $tgl1.'/'.$tgl2;
            $bkn = accessDatariwayatsiasn('kpo/sk/hist',$tgl);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'peremajaan-data':
            $bkn = accessDatariwayatsiasn('updated/pns');
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'peremajaan-data-hist':
            list($tgl1,$tgl2)=explode("&",$nip);
            $tgl = $tgl1.'/'.$tgl2;
            $bkn = accessDatariwayatsiasn('updated/hist',$tgl);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        /*Data berkala PPO*/
        case 'ppo-sk':
            $bkn = accessDatariwayatsiasn('ppo/sk');
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'ppo-sk-hist':
            list($tgl1,$tgl2)=explode("&",$nip);
            $tgl = $tgl1.'/'.$tgl2;
            $bkn = accessDatariwayatsiasn('ppo/sk/hist',$tgl);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'wafat':
            $bkn = accessDatariwayatsiasn('ppo/usul/wafat');
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
        case 'wafat-hist':
            list($tgl1,$tgl2)=explode("&",$nip);
            $tgl = $tgl1.'/'.$tgl2;
            $bkn = accessDatariwayatsiasn('ppo/usul/wafat/hist',$tgl);
            echo "<pre>";
            print_r($bkn);
            echo "</pre>";
            break;
    }
    ?>
    </body>
</html>