<?php
    if(count($pengumumans) > 0) {
        foreach($pengumumans as $item) {
            echo "
                <blockquote><i class='fa fa-fw fa-bullhorn'></i>
                    ".$item->judul."
                    <p>".$item->pengumuman."</p>
                    <small class='pull-right'><em>Admin on ".date('d-m-Y H:i', strtotime($item->created_at))." WIB</em></small>
                </blockquote>
            ";
        }
    } else {
        echo 'Selamat datang di Simpeg Onlie.';
    }

    function getKetsaksi($idjenis)
    {
        switch ($idjenis) {
            case 1: $ket = "&nbsp;Permohonan&nbsp;Baru"; break;
            case 2: $ket = "&nbsp;Permohonan&nbsp;Edit"; break;
            case 3: $ket = "&nbsp;Permohonan&nbsp;Hapus"; break;
            default: $ket = "-";
        }

        return $ket;
    }

    if(session('role_id') == 5){
        $x = 0;
        $nip = session("user_id");
        $rs = getNotifikasi($nip);
        if(count($rs) > 0){
            echo "<div class='alert alert-warning alert-biodata' role='alert' style='display: block;'><span class='glyphicon glyphicon-exclamation-sign'></span> PERMOHONAN PERUBAHAN DATA <br>";

            $arr[0]= ""; $n = 0;
            foreach ($rs as $item) {
                $x++; $n++;
                $arr[$n] = $item->perubahan;
                if($arr[$n]!=$arr[$n-1]){
                    echo "<em>".$x.". <b>".$item->perubahan."</em><br>";
                }
                echo "<em> - ".getKetsaksi($item->idjnsaksi)."</b> - ".$item->tentang." - Keterangan : '".ucfirst($item->ketditolak)."'</em><br>";
            }

            echo "</div>";
        }
    }
?>