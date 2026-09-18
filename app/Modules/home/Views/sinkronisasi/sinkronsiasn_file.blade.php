<?php
    if($idbkn != ''){
        $diktek = accessDatapersonalsiasn($jenis.'/id',$idbkn);

        foreach($diktek->path as $files){
            $file = (object) $files;
            $pathfile = $file->dok_uri;
        }

        $mode = env('MODE');
        if ($mode == 'train') {
            $base_url = env('URSI_SIASN_TRAIN');
        } else if ($mode == 'prod') {
            $base_url = env('URSI_SIASN_PROD');
        }

        $resultApi = apiResult($base_url.'download-dok?filePath='.$pathfile);
        $nama_file_unduhan = $nip.'-'.$idbkn.'-'.$name.'.pdf';

        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=".$nama_file_unduhan);
        var_dump($resultApi);
    }
?>