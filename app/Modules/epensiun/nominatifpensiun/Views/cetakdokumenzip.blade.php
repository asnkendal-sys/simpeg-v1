<?php
require_once app_path() . "/expdf.php";
$nip = \Input::get('nip');
$jenis = \Input::get('jenis');
$iterasi = \Input::get('iterasi');

$subjenis = \Input::get('subjenis');
\Input::get('subsubjenis') == '' ? $subsubjenis = 0 : $subsubjenis = \Input::get('subsubjenis');

$files = \DB::table('files')
->where('nip', '=', $nip)
->where('jenis', '=', $jenis)
->where('subjenis', '=', $subjenis)
->where('subsubjenis', '=', $subsubjenis)
// ->where('status', '=', '1')
->orderby('order', 'asc')
->get();

$pdf = new exFPDF('P', 'mm', 'A4');

$pdf->SetAutoPageBreak(true, 5);
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont('Arial', '', '9');

foreach($files as $row){
    $pdf->AddPage();

    $imagePath = './packages/upload/files/'.substr($row->nip,0,4).'/' . $row->nip . '/' . $row->filename;

    list($width, $height) = getimagesize($imagePath);

    if($width > $height){ // landscape
        $pdf->RotatedImage($imagePath,10,277,267,190,90);
    }else{ // portraid
        $pdf->Image($imagePath, 10, 10, 190, 267);
    }

    $qrcode = new QRcode(substr($row->filename, 0, -4), 'H'); // error level : L, M, Q, H
    $qrcode->displayFPDF($pdf, 180, 10, 20);
}

$filename = explode('.', \Input::get("filename"));

if($jenis == 9){
    $cek_dikstru = \DB::connection('simpeg_2015')->table('r_dikstru')
    ->where('id','=',$subjenis)
    ->first();

    if($cek_dikstru->iddikstru == 22){
        $nama_cetak = 'SK_PIM_'.\Input::get('nip');
    }else{
        $nama_cetak = sanitizeFilename(\Input::get('jenisdokumen')).'_'.\Input::get('nip');
    }
}else{

    if($jenis == 6){
        $cekformat = \DB::table('kategori_jenis')
        ->where('id','=',$subsubjenis)
        ->first();
    }else{
        $cekformat = \DB::table('kategori_jenis')
        ->where('id','=',$jenis)
        ->first();
        
     
        if($cekformat->format_file == ''){

            if($cekformat->riwayat_flag != 1){
                $cekformat = \DB::table('kategori_jenis')
                ->where('id','=',$subjenis)
                ->first();
            }
        }
    }

    if($cekformat->format_file != ''){
        if($cekformat->riwayat_flag == 1){
            $nama_cetak = str_replace('IDENT', \Input::get('ident'), str_replace('NIP',\Input::get('nip'), $cekformat->format_file));
        }else{
            $nama_cetak = str_replace('NIP', \Input::get('nip'), $cekformat->format_file);
        }
    }else{
        $nama_cetak = sanitizeFilename(\Input::get('jenisdokumen')).'_'.\Input::get('nip');
    }
}
$filePath = 'packages/upload/files/'.substr($row->nip,0,4).'/' . $row->nip ;
\Session::put('filePathZip',$filePath);


$filePath .=  '/zip'."/";
$filePath = base_path($filePath);


if(!file_exists($filePath)){
    mkdir($filePath,0777,true);
}


$pdf->Output($filePath.$nama_cetak.'.pdf', 'F');
