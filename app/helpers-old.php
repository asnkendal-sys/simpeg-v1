<?php
function getTextAgama($id)
{
    return \DB::table('a_agama')->where('idagama', $id)->first(['agama'])->agama;
}
function getTextToIdAgama($text)
{
    return \DB::table('a_agama')->where('agama', $text)->first();
}

function getIdEselon($eselon, $jenis = 0)
{
    if ($jenis == 1) {
        $rs = \DB::table('a_esl')->where('idesl', $eselon)->first();
        return @$rs->esl;
    } else {
        $rs = \DB::table('a_esl')->where('esl', $eselon)->first();
        return @$rs->idesl;
    }
}

function getJabatanIdSapk($idjenjab, $id, $jenis = 0)
{
    if ($jenis == 1) {
        if ($idjenjab == 1) {
            $rs = \DB::table('a_skpd')->where('idsapk', $id)->first();
            $unorid = @$rs->idskpd;
        } elseif ($idjenjab == 2) {
            $rs = \DB::table('a_jabfung')->where('idsapk', $id)->first();
            $unorid = @$rs->idjabfung;
        } else {
            $rs = \DB::table('a_jabfungum')->where('idsapk', $id)->first();
            $unorid = @$rs->idjabfungum;
        }
    } else {
        if ($idjenjab == 1) {
            $rs = \DB::table('a_skpd')->where('idskpd', $id)->first();
            $unorid = @$rs->idsapk;
        } elseif ($idjenjab == 2) {
            $rs = \DB::table('a_jabfung')->where('idjabfung', $id)->first();
            $unorid = @$rs->idsapk;
        } else {
            $rs = \DB::table('a_jabfungum')->where('idjabfungum', $id)->first();
            $unorid = @$rs->idsapk;
        }
    }
    return $unorid;
}

function getGolru($id)
{
    return \DB::table('a_golruang')->where('idgolru', $id)->first()->golru;
}

function getUnOrId($id, $jenis = 0)
{
    if ($jenis == 1) {
        $rs = \DB::table("a_skpd")->where("idsapk", "$id")->first();
        return @$rs->idskpd;
    } else {
        $rs = \DB::table("a_skpd")->where("idskpd", "$id")->first();
        return @$rs->idsapk;
    }
}

function getPnsIdSapk($nip)
{
    return  \DB::table('tb_01')->where('nip', $nip)->first()->idsapk;
}
function getTextJenkel($key)
{
    $kelamin = [1 => 'Laki-laki', 2 => 'Perempuan'];
    return $kelamin[$key];
}

function getTextJenkelBkn($key)
{
    $kelamin = ['Pria' => '1', 'Wanita' => '2', 'M' => '1', 'F' => '2'];
    return $kelamin[$key];
}

function getTextStatusKawinBkn($key)
{
    $kawin = ['Menikah' => 1, 'Janda/Duda' => 2, 'Belum Kawin' => 3];
    return $kawin[$key];
}

function getTextStatusKawin($key)
{
    $kawin = [1 => 'Menikah', 2 => 'Janda/Duda', 3 => 'Belum Menikah'];
    return $kawin[$key];
}


function sanitizeFilename($filename)
{
    $invalid_char = array('/', '\\', '?', '*', '%', ':', '|', '"', '>', '<', '.', ' ');

    for ($n = 0; $n < sizeof($invalid_char); $n++) {
        str_replace($invalid_char[$n], '_', $filename);
    }

    $filename = preg_replace('/\s+/', '_', $filename);

    return $filename;
}

function uang($nominal = '')
{
    if ($nominal == '') {
        return '';
    } else {
        return '&nbsp;' . number_format($nominal, 0, ',', '.');
    }
}

// function uang($nominal = ''){
//     if ($nominal == ''  || !isset($nominal)){
//         return 0;
//     }elseif($nominal==0){
//         return 0;
//     }
//     else{
//         return ' '.@number_format($nominal,0,',','.');
//     }
// }


function debug($s = '', $die = true)
{
    echo '<pre>';
    print_r($s);
    echo '</pre>';
    if ($die == true) {
        die();
    }
}

function jam_tabrakan($s1 = '', $e1 = '', $s2 = '', $e2 = '')
{
    if (
        ($s1 == $s2 || $e1 == $e2) ||
        ($s1 <= $s2 && $e1 <= $e2 && $e1 >= $s2) ||
        //            ($s1 >= $s2 && $e1 >= $e2 && $s1 <= $e2) ||
        ($s1 >= $s2 && $e1 >= $e2 && $s1 < $e2) ||
        ($s1 >= $s2 && $e1 <= $e2) ||
        ($s1 <= $s2 && $e1 >= $e2)
    ) {
        //        if(($s1 == $s2 || $e1 == $e2)){
        //            echo 'Kondisi 1<br>';
        //        }
        //        if($s1 <= $s2 && $e1 <= $e2 && $e1 >= $s2){
        //            echo 'Kondisi 2<br>';
        //        }
        //        if($s1 >= $s2 && $e1 >= $e2 && $s1 < $e2){
        //            echo 'Mulai 1 = '.$s1.'<br>';
        //            echo 'Selesai 1 = '.$e1.'<br>';
        //            echo 'Mulai 2 = '.$s2.'<br>';
        //            echo 'Selesai 2 = '.$e2.'<br>';
        //            echo 'Kondisi 3<br>';
        //        }
        //        if($s1>=$s2 && $e1<=$e2){
        //            echo 'Kondisi 4<br>';
        //        }
        //        if($s1<=$s2 && $e1>=$e2){
        //            echo 'Kondisi 5<br>';
        //        }
        return true;
    } else {
        return false;
    }
    //    if(
    //            ($s1 == $s2 || $e1 == $e2) ||
    //            ($s1 <= $s2 && $e1 <= $e2 && $e1 >= $s2) ||
    //            ($s1 >= $s2 && $e1 >= $e2 && $s1 <= $e2) ||
    //            ($s1>=$s2 && $e1<=$e2) ||
    //            ($s1<=$s2 && $e1>=$e2)
    //            ){
    //        return true;
    //            }else{
    //        return false;
    //            }
}

function rangesNotOverlapClosed($start_time1, $end_time1, $start_time2, $end_time2)
{
    $utc = new DateTimeZone('UTC');

    $start1 = new DateTime($start_time1, $utc);
    $end1 = new DateTime($end_time1, $utc);
    if ($end1 < $start1) {
        throw new Exception('Range is negative.');
    }

    $start2 = new DateTime($start_time2, $utc);
    $end2 = new DateTime($end_time2, $utc);
    if ($end2 < $start2) {
        throw new Exception('Range is negative.');
    }
    return ($end1 < $start2) || ($end2 < $start1);
}

function rangesNotOverlapOpen($start_time1, $end_time1, $start_time2, $end_time2)
{
    $utc = new DateTimeZone('UTC');

    $start1 = new DateTime($start_time1, $utc);
    $end1 = new DateTime($end_time1, $utc);
    if ($end1 < $start1) {
        throw new Exception('Range is negative.');
    }

    $start2 = new DateTime($start_time2, $utc);
    $end2 = new DateTime($end_time2, $utc);
    if ($end2 < $start2) {
        throw new Exception('Range is negative.');
    }

    return ($end1 <= $start2) || ($end2 <= $start1);
}



function rentang($h = '')
{
    $huruf = array('A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0);
    return @$huruf[$h];
}

function konversi_nilai($angkatan = '2015', $nilai = 100)
{
    $data = \Session::get('range_nilai');
    $huruf = 'E';
    foreach ($data as $d) {
        if ($d->angkatan_awal <= $angkatan && $d->angkatan_akhir >= $angkatan) {
            if ($nilai >= $d->angka_awal && $nilai <= $d->angka_akhir) {
                $huruf = $d->huruf;
            }
        }
    }
    return $huruf;
}

function konversi_ta($ta = '')
{
    return substr($ta, 0, 4) . ((substr($ta, 4, 1) == '1') ? ' Ganjil' : ' Genap');
}

function jatah_sks($h = '')
{
    if ($h >= 3) {
        return 24;
    } elseif ($h >= 2.5 && $h < 2.99) {
        return 22;
    } elseif ($h >= 2 && $h < 2.49) {
        return 20;
    } else {
        return 18;
    }
}

function searchMataKuliah($id = "", $text = "", $name = 'id_mk', $url = '/masterdata/dataskpd/jsonskpd')
{
    $str = "";
    //if (\PermissionsLibrary::hasPermission('mod-skpd-choose')){
    $str .= Form::hidden($name, null);
    $str .= "<script>
    autoComplete($('input[name=$name]'), '$url', 'Pilih Data', null);

    ";
    if ($id != "") {
        $str .= " $(\"input[name=$name]\").select2('data',{id:'" . $id . "', text:'" . $text . "'});";
    }
    $str .= "</script>";
    return $str;
}

function spasi($rekursive = 1)
{
    for ($a = 1; $a <= $rekursive; $a++) {
        echo '&nbsp;';
    }
}

function get_client_ip()
{
    $ipaddress = '';
    if ($_SERVER['REMOTE_ADDR']) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

function formatTanggalPanjang($tanggal)
{
    if (($tanggal != '') and ($tanggal != '0000-00-00') and ($tanggal != '1970-01-01')) {
        $aBulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        list($thn, $bln, $tgl) = explode("-", $tanggal);
        $bln = (($bln > 0) && ($bln < 10)) ? substr($bln, 1, 1) : $bln;

        return $tgl . " " . $aBulan[$bln] . " " . $thn;
    }
}

function formatBulanTahun($tanggal)
{
    $aBulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    list($thn, $bln, $tgl) = explode("-", $tanggal);
    $bln = (($bln > 0) && ($bln < 10)) ? substr($bln, 1, 1) : $bln;
    return $aBulan[$bln] . " " . $thn;
}



function tanggal($date = 1)
{
    date_default_timezone_set('Asia/Jakarta'); // your reference timezone here
    $date = date('Y-m-d', strtotime($date)); // ubah sesuai format penanggalan standart
    $bulan = array(
        '01' => 'Januari', // array bulan konversi
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    );
    $date = explode('-', $date); // ubah string menjadi array dengan paramere '-'

    return @$date[2] . ' ' . @$bulan[$date[1]] . ' ' . @$date[0]; // hasil yang di kembalikan}
}




function romawi($n = '1')
{
    $hasil = '';
    $iromawi = array(
        '', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X',
        20 => 'XX', 30 => 'XXX', 40 => 'XL', 50 => 'L', 60 => 'LX', 70 => 'LXX', 80 => 'LXXX',
        90 => 'XC', 100 => 'C', 200 => 'CC', 300 => 'CCC', 400 => 'CD', 500 => 'D',
        600 => 'DC', 700 => 'DCC', 800 => 'DCCC', 900 => 'CM', 1000 => 'M',
        2000 => 'MM', 3000 => 'MMM'
    );

    if (array_key_exists($n, $iromawi)) {
        $hasil = $iromawi[$n];
    } elseif ($n >= 11 && $n <= 99) {
        $i = $n % 10;
        $hasil = $iromawi[$n - $i] . Romawi($n % 10);
    } elseif ($n >= 101 && $n <= 999) {
        $i = $n % 100;
        $hasil = $iromawi[$n - $i] . Romawi($n % 100);
    } else {
        $i = $n % 1000;
        $hasil = $iromawi[$n - $i] . Romawi($n % 1000);
    }
    return $hasil;
}

function combo_jenjang($id = 'asa', $selected = "")
{
    $h = "<select id='$id' name='$id' style='width:100%'>";
    $h .= '<option value="">Pilih Jenjang Pendidikan</option>';
    $h .= '<option ' . (($selected == 'A') ? 'selected' : '') . ' value="A">S3</option>';
    $h .= '<option ' . (($selected == 'B') ? 'selected' : '') . ' value="B">S2</option>';
    $h .= '<option ' . (($selected == 'C') ? 'selected' : '') . ' value="C">S1</option>';
    $h .= '<option ' . (($selected == 'D') ? 'selected' : '') . ' value="D">D4</option>';
    $h .= '<option ' . (($selected == 'E') ? 'selected' : '') . ' value="E">D3</option>';
    $h .= '<option ' . (($selected == 'F') ? 'selected' : '') . ' value="F">D2</option>';
    $h .= '<option ' . (($selected == 'G') ? 'selected' : '') . ' value="G">D1</option>';
    $h .= '</select>';
    return $h;
}

function combo_kurikulum($id = 'asa', $selected = "")
{
    $h = "<select id='$id' name='$id' style='width:100%'>";
    $h .= '<option value="">Pilih Frekwensi Pembaruan Kurikulum</option>';
    $h .= '<option ' . (($selected == 'A') ? 'selected' : '') . ' value="A">Setiap 1 Tahun</option>';
    $h .= '<option ' . (($selected == 'B') ? 'selected' : '') . ' value="B">Setiap 2 Tahun</option>';
    $h .= '<option ' . (($selected == 'C') ? 'selected' : '') . ' value="C">Setiap 3 Tahun</option>';
    $h .= '<option ' . (($selected == 'D') ? 'selected' : '') . ' value="D">Setiap 4 Tahun</option>';
    $h .= '<option ' . (($selected == 'E') ? 'selected' : '') . ' value="E">Sesuai aturan pemerintah</option>';
    $h .= '<option ' . (($selected == 'F') ? 'selected' : '') . ' value="F">Sesuai kebutuhan</option>';
    $h .= '</select>';
    return $h;
}

function combo_pelaksanaan_kurikulum($id = 'asa', $selected = "")
{
    $h = "<select id='$id' name='$id' style='width:100%'>";
    $h .= '<option value="">Pilih Metode Pelaksanaan Kurikulum</option>';
    $h .= '<option ' . (($selected == 'A') ? 'selected' : '') . ' value="A">Oleh Program Studi Sendiri</option>';
    $h .= '<option ' . (($selected == 'B') ? 'selected' : '') . ' value="B">Bersama Tim Dalam Perguruan Tinggi</option>';
    $h .= '<option ' . (($selected == 'C') ? 'selected' : '') . ' value="C">Orientasi Perguruan Tinggi Lain</option>';
    $h .= '<option ' . (($selected == 'D') ? 'selected' : '') . ' value="D">Orientasi Kebutuhan Pasar</option>';
    $h .= '<option ' . (($selected == 'E') ? 'selected' : '') . ' value="E">Bersama Stakeholder</option>';
    $h .= '</select>';
    return $h;
}

function combo_kota($id = 'asa', $selected = "")
{
    $h = "<select id='$id' name='$id' style='width:100%'>";
    $prov = \DB::table('ms_provinsi')
        ->orderBy('nama', 'asc')->get();
    foreach ($prov as $p) {
        $h .= ' <optgroup label="' . $p->nama . '">';
        $kota = \DB::table('ms_kota_kabupaten')->where('provinsi_id', '=', $p->id)->orderBy('nama', 'asc')->get();
        foreach ($kota as $k) {
            $h .= '<option ' . (($selected == $k->id) ? ' selected ' : '') . ' value="' . $k->id . '">' . $k->nama . '</option>';
        }
        $h .= '</optgroup>';
    }
    $h .= '</select>';
    return $h;
}

function combo_kelurahan($id = 'asa', $selected = "")
{
    $h = "<select id='$id' name='$id' style='width:100%'>";
    $kota = \DB::table('ms_kota_kabupaten')->orderBy('nama', 'asc')->get();
    foreach ($kota as $k) {
        $h .= ' <optgroup label="' . $k->nama . '">';
        $kec = \DB::table('ms_kecamatan')->where('kota_kabupaten_id', '=', $k->id)->orderBy('name', 'asc')->get();
        foreach ($kec as $kc) {
            $h .= ' <optgroup label="' . $kc->name . '">';
            $kel = \DB::table('ms_desa_kelurahan')->where('kecamatan_id', '=', $kc->id)->orderBy('name', 'asc')->get();
            foreach ($kel as $kl) {
                $h .= '<option ' . (($selected == $kl->id) ? ' selected ' : '') . ' value="' . $kl->id . '">' . $kl->name . '</option>';
            }
            $h .= '</optgroup>';
        }
        $h .= '</optgroup>';
    }
    $h .= '</select>';
    return $h;
}

function combo_kecamatan($id = 'asa', $selected = "")
{
    $h = "<select id='$id' name='$id' style='width:100%'>";
    $prov = \DB::table('ms_provinsi')
        ->orderBy('nama', 'asc')->get();
    foreach ($prov as $p) {
        $h .= ' <optgroup label="' . $p->nama . '">';
        $kota = \DB::table('ms_kota_kabupaten')->where('provinsi_id', '=', $p->id)->orderBy('nama', 'asc')->get();
        foreach ($kota as $k) {
            $h .= ' <optgroup label="' . $k->nama . '">';
            $kota = \DB::table('ms_kecamatan')->where('kota_kabupaten_id', '=', $k->id)->orderBy('nama', 'asc')->get();
            foreach ($kec as $kc) {
                $h .= '<option ' . (($selected == $kc->id) ? ' selected ' : '') . ' value="' . $kc->id . '">' . $kc->name . '</option>';
            }
            $h .= '</optgroup>';
        }
        $h .= '</optgroup>';
    }
    $h .= '</select>';
    return $h;
}


function combo_jnskelamin($id = '', $selected = "")
{
    $h = "<select id='$id' name='$id' style='width:100%'>";
    $h .= '<option value="">Pilih Jenis Kelamin</option>';
    $h .= '<option ' . (($selected == '1') ? 'selected' : '') . ' value="1">Laki-laki</option>';
    $h .= '<option ' . (($selected == '2') ? 'selected' : '') . ' value="2">Perempuan</option>';
    $h .= '</select>';
    return $h;
}

function combo_status($id = '', $selected = "")
{
    $h = "<select id='$id' name='$id' style='width:100%'>";
    $h .= '<option value="">.: Pilihan :.</option>';
    $h .= '<option ' . (($selected == '0') ? 'selected' : '') . ' value="0">Belum Verifikasi</option>';
    $h .= '<option ' . (($selected == '2') ? 'selected' : '') . ' value="2">Ditolak</option>';
    $h .= '</select>';
    return $h;
}

//combo kinerja asn
function combo_capaianKinerja($id = '', $selected = "", $required = "")
{
    $h = "<select id='$id' name='$id' $required class='form-control' style='width:100%'>";
    $h .= '<option value="">.:Pilihan:.</option>';
    $h .= '<option ' . (($selected == 'Istimewa') ? 'selected' : '') . ' value="Istimewa">Istimewa</option>';
    $h .= '<option ' . (($selected == 'Baik') ? 'selected' : '') . ' value="Baik">Baik</option>';
    $h .= '<option ' . (($selected == 'Butuh Perbaikan') ? 'selected' : '') . ' value="Butuh Perbaikan">Butuh Perbaikan</option>';
    $h .= '<option ' . (($selected == 'Kurang/Missconduct') ? 'selected' : '') . ' value="Kurang/Missconduct">Kurang/Missconduct</option>';
    $h .= '<option ' . (($selected == 'Sangat Kurang') ? 'selected' : '') . ' value="Sangat Kurang">Sangat Kurang</option>';
    $h .= '</select>';
    return $h;
}

function combo_ratingHasil($id = '', $selected = "", $required = "")
{
    $h = "<select id='$id' name='$id' $required class='form-control' style='width:100%'>";
    $h .= '<option value="">.:Pilihan:.</option>';
    $h .= '<option ' . (($selected == 'Diatas Ekspektasi') ? 'selected' : '') . ' value="Diatas Ekspektasi">Diatas Ekspektasi</option>';
    $h .= '<option ' . (($selected == 'Sesuai Ekspektasi') ? 'selected' : '') . ' value="Sesuai Ekspektasi">Sesuai Ekspektasi</option>';
    $h .= '<option ' . (($selected == 'Di bawah Ekspektasi') ? 'selected' : '') . ' value="Di bawah Ekspektasi">Di bawah Ekspektasi</option>';
    $h .= '</select>';
    return $h;
}

function combo_ratingPerilaku($id = '', $selected = "", $required = "")
{
    $h = "<select id='$id' name='$id' $required class='form-control' style='width:100%'>";
    $h .= '<option value="">.:Pilihan:.</option>';
    $h .= '<option ' . (($selected == 'Diatas Ekspektasi') ? 'selected' : '') . ' value="Diatas Ekspektasi">Diatas Ekspektasi</option>';
    $h .= '<option ' . (($selected == 'Sesuai Ekspektasi') ? 'selected' : '') . ' value="Sesuai Ekspektasi">Sesuai Ekspektasi</option>';
    $h .= '<option ' . (($selected == 'Di bawah Ekspektasi') ? 'selected' : '') . ' value="Di bawah Ekspektasi">Di bawah Ekspektasi</option>';
    $h .= '</select>';
    return $h;
}

function combo_predikatKinerja($id = '', $selected = "", $required = "")
{
    $h = "<select id='$id' name='$id' $required class='form-control' style='width:100%'>";
    $h .= '<option value="">.:Pilihan:.</option>';
    $h .= '<option ' . (($selected == 'Sangat Baik') ? 'selected' : '') . ' value="Sangat Baik">Sangat Baik</option>';
    $h .= '<option ' . (($selected == 'Baik') ? 'selected' : '') . ' value="Baik">Baik</option>';
    $h .= '<option ' . (($selected == 'Butuh Perbaikan') ? 'selected' : '') . ' value="Butuh Perbaikan">Butuh Perbaikan</option>';
    $h .= '<option ' . (($selected == 'Kurang/Missconduct') ? 'selected' : '') . ' value="Kurang/Missconduct">Kurang/Missconduct</option>';
    $h .= '<option ' . (($selected == 'Sangat Kurang') ? 'selected' : '') . ' value="Sangat Kurang">Sangat Kurang</option>';
    $h .= '</select>';
    return $h;
}
//end combo kinerja asn


function select_hari($id = 0, $selected = '')
{
    $hari = array("-", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu", "All Day");
    return Form::select($id, $hari, $selected, array('style' => 'width:100%'));
}

function array_hari($id = 0, $selected = '')
{
    $hari = array("-", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu", "All Day");
    return $hari;
}

function date_picker($id = 'asa', $value = "")
{
    echo '<script>'
        . '$(document).ready(function(){'
        . '$(".tgl").datetimepicker({format: "YYYY-MM-DD"});'
        . '})</script>'
        . '<input type="text" class="form-control tgl" value="' . $value . '" id="' . $id . '" name="' . $id . '"  placeholder="Masukkan Tanggal">';
}

function tanggal_indonesia()
{
    $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    //    $cetak_date = $hari[(int)date("w")] .', '. date("j ") . $bulan[(int)date('m')] . date(" Y");
    $cetak_date = date("j ") . $bulan[(int)date('m')] . date(" Y");
    return $cetak_date;
}

function sekarang()
{
    return date("Y-m-d H:i:s");
}

function tglina($date, $stat = '')
{
    if (($date != '0000-00-00') or ($date != '1970-01-01') or ($date != '')) {
        if ($stat == 'en') {
            return date("Y-m-d", strtotime($date));
        } else {
            return date("d-m-Y", strtotime($date));
        }
    } else {
        return "-";
    }
}


function combo_agama($id = '', $selected = false)
{
    $a = '<select id="' . $id . '" name="' . $id . '" style="width:100%;">';
    $a .= '<option value="">Pilih Agama</option>';

    //    $s1 = ($selected == 'Islam')?' selected ':'';
    //    $a .= '<option '.$s1.'value="Islam">Islam</option>';
    //
    //    $s1 = ($selected == 'Kristen')?' selected ':'';
    //    $a .= '<option '.$s1.'value="Kristen">Kristen</option>';
    //
    //    $s1 = ($selected == 'Katolik')?' selected ':'';
    //    $a .= '<option '.$s1.'value="Katolik">Katolik</option>';
    //
    //    $s1 = ($selected == 'Hindu')?' selected ':'';
    //    $a .= '<option '.$s1.'value="Hindu">Hindu</option>';
    //
    //    $s1 = ($selected == 'Budha')?' selected ':'';
    //    $a .= '<option '.$s1.'value="Budha">Budha</option>';
    //
    //    $s1 = ($selected == 'Konghucu')?' selected ':'';
    //    $a .= '<option '.$s1.'value="Konghucu">Konghucu</option>';
    //
    //    $s1 = ($selected == 'Lainnya')?' selected ':'';
    //    $a .= '<option '.$s1.'value="Lainnya">Lainnya</option>';

    $agama = \DB::table('ref_agama')->orderBy('kode', 'asc')->get();
    foreach ($agama as $row) {
        $s = ($selected == $row->id) ? 'selected="selected"' : '';
        $a .= '<option ' . $s . 'value="' . $row->id . '">' . $row->uraian . '</option>';
    }
    $a .= '</select>';
    return $a;
}

function modal($sempit = false, $name = 'modal2', $body = 'Modal2', $minus = false)
{
    $class = ($sempit == false) ? 'modal-dialog-wide' : 'modal-dialog';
    $js = '<script>var duplicateChk = {};'
        . '$("div#modal2[class]").each (function (a) {'
        . 'if (duplicateChk.hasOwnProperty(this.class)) {'
        . 'alert("kembar");$(this).remove();'
        . '} else { duplicateChk[this.class] = "true";}});</script>';

    $min = ($minus == true) ? '' : '';
    $html =  '<div class="modal fade" id="' . $name . '" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="' . $class . '">
    <div class="modal-content" id="wadah_modal">
    <div class="modal-header bg-primary">
    <button onclick="claravel_modal_close(' . "'$name'" . ')" type="button" aria-hidden="true" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-remove" ></i></button>
    ' . $min . '
    <h4 class="modal-title"><b id="judulmodal"></b></h4>
    </div>
    <div class="modal-body">
    <div id="konten' . $body . '"></div>
    </div>
    <div class="modal-footer">
    <div id="footermodal">
    &nbsp;
    </div>
    </div>
    </div>
    </div>
    </div>';
    return $html;
}

function catat_log($aksi = '', $modul = '')
{
    $simpan = array(
        'aksi' => $aksi,
        'module' => $modul,
        'user' => \Session::get('user_id'),
        'url' => \Request::url(),
        'waktu' => date("Y-m-d H:i:s")
    );
    $save = \DB::table('application_log')->insert($simpan);
}
function header_dokumen()
{
    return '<link rel="stylesheet" href="' . getBaseURL(true) . '/packages/tugumuda/claravel/assets/css/bootstrap.css" />' .
        '<link rel="stylesheet" href="' . getBaseURL(true) . '/packages/tugumuda/claravel/assets/css/bootstrap-theme.css" />' .
        '<link rel="stylesheet" href="' . getBaseURL(true) . '/packages/tugumuda/claravel/assets/css/bootstrap-icons.css" />';
}
function hari($hari)
{
    switch ($hari) {
        case '0':
            return '';
            break;
        case '1':
            return 'Senin';
            break;
        case '2':
            return 'Selasa';
            break;
        case '3':
            return 'Rabu';
            break;
        case '4':
            return 'Kamis';
            break;
        case '5':
            return "Jum'at";
            break;
        case '6':
            return 'Sabtu';
            break;
        case '7':
            return 'Minggu';
            break;
    }
}
function konversi_hari($hari)
{
    $hari = date("l", strtotime($hari));
    switch ($hari) {
        case 'Monday':
            return 'Senin';
            break;
        case 'Thuesday':
            return 'Selasa';
            break;
        case 'Wednesday':
            return 'Rabu';
            break;
        case 'Thursday':
            return 'Kamis';
            break;
        case 'Friday':
            return "Jum'at";
            break;
        case 'Saturday':
            return 'Sabtu';
            break;
        case 'Sunday':
            return 'Minggu';
            break;
    }
};

function getUtility($field)
{
    $rs = \DB::table('utility')->where('id', 1)->first();
    return $rs->$field;
}

function ucfirsts($string)
{
    $text = strtolower($string);
    return ucfirst($text);
}

function cekLogin()
{
    $user = \Session::get('user_id');
    $role = \Session::get('role_id');
    return (!$user || !$role) ? false : true;
    //if (!$user || !$role){die('Invalid Access :: You must sign in first !!<br><br><i>With Love :: Developer</i>');}
}

function cekAjax()
{
    /*if (!\Request::ajax()){die('Invalid URL Request<br><br><i>With Love :: Developer</i>');}*/
    if (!\Request::ajax()) {
        header("Location: " . url() . "/dashboard");
        exit();
    }
}

function get_role()
{
    return \Session::get('role_id');
}

function get_username()
{
    $role = \Session::get('role_id');
    if ($role == '2' || $role == '3' || $role == '4' || $role == '6') {
        $user = explode('-', \Session::get('user_name'));
        $user = $user[1];
        return $user;
    }
}

function inputPeriodeRpjmd($nama = "tahun_anggaran", $id = "", $text = "", $value = false, $selected = false)
{
    $periode = \PeriodetahunModel::where('kategori', 'RPJMD/RENSTRA')->first();
    $str = "<select id='" . $id . "' style='width:100%;' class='form-control' name='" . $nama . "' placeholder=\"Pilih Tahun Anggaran\">";
    for ($i = $periode->tahun_awal; $i <= $periode->tahun_akhir; $i++) {
        $the_value = ($value == true) ? 'value="' . $i . '"' : '';
        $the_selected = ($selected == $i) ? ' selected ' : ' ';
        $str .= "<option " . $the_selected . ' ' . $the_value . ">" . $i . "</option>";
    }
    $str .= "</select>";
    echo $str;
}
//START CREATED BY WIGUNA ON 16 MARET

function inputWarna($id = '', $nama = "", $selected = "")
{
    $a1 = ($selected == 'bg-color-blue') ? ' selected ' : ' ';
    $a2 = ($selected == 'bg-color-blueDark') ? ' selected ' : ' ';
    $a3 = ($selected == 'bg-color-darken') ? ' selected ' : ' ';
    $a4 = ($selected == 'bg-color-green') ? ' selected ' : ' ';
    $a5 = ($selected == 'bg-color-greenDark') ? ' selected ' : ' ';
    $a6 = ($selected == 'bg-color-orange') ? ' selected ' : ' ';
    $a7 = ($selected == 'bg-color-pink') ? ' selected ' : ' ';
    $a8 = ($selected == 'bg-color-purple') ? ' selected ' : ' ';
    $a9 = ($selected == 'bg-color-yellow') ? ' selected ' : ' ';
    $a10 = ($selected == 'bg-color-red') ? ' selected ' : ' ';
    $html = '<select id="' . $id . '" name="' . $nama . '">
    <option ' . $a1 . 'value="bg-color-blue">Biru</option>
    <option ' . $a2 . 'value="bg-color-blueDark">Biru Gelap</option>
    <option ' . $a3 . 'value="bg-color-darken">Gelap</option>
    <option ' . $a4 . 'value="bg-color-green">Hijau</option>
    <option ' . $a5 . 'value="bg-color-greenDark">Hijau Gelap</option>
    <option ' . $a6 . 'value="bg-color-orange">Jingga</option>
    <option ' . $a7 . 'value="bg-color-pink">Merah Muda</option>
    <option ' . $a8 . 'value="bg-color-purple">Ungu</option>
    <option ' . $a9 . 'value="bg-color-red">Merah</option>
    <option ' . $a10 . 'value="bg-color-yellow">Kuning</option>
    </select>';
    return $html;
}


function isSecure()
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443;
}

function getBaseURL($with_http = false)
{
    /*
    $url = \Request::url();
    //    $url = str_replace('http://')
    $arrurl = explode('/',$url);
    if ($with_http == false){
        return $arrurl[2];
    }
    else{
        return (isSecure())?'https://'.$arrurl[2].'/':'http://'.$arrurl[2].'/';
        //return 'https://'.$arrurl[2].'/';
    }
    */
    return url();
}

function detail_tahun()
{
    $periode = \PeriodetahunModel::where('kategori', 'RPJMD/RENSTRA')->first();
    $arrtahun =
        array(
            'awal' => $periode->tahun_awal,
            'akhir' => $periode->tahun_akhir
        );
    return $arrtahun;
}

function arrayTahun()
{
    $periode = \PeriodetahunModel::where('kategori', 'RPJMD/RENSTRA')->first();
    $str = array();
    for ($i = $periode->tahun_awal; $i <= $periode->tahun_akhir; $i++) {
        array_push($str, $i);
    }
    return $str;
}


function maxDuitKelurahan($id_kel = 0, $tahun = false)
{
    $data = DB::table('s_setting_kelurahan')
        ->select('max_anggaran')->where('id_kel', '=', $id_kel)->where('tahun', '=', $tahun)
        ->get();
    foreach ($data as &$row) {
        return $row->max_anggaran;
    }
    //    $data = DB::table('s_setting_batas_max_anggaran')
    //        ->select('max_kelurahan')
    //        ->get();
    //    foreach($data as $row){
    //        return $row->max_kelurahan;
    //    }
}
/*END CEK KELURAHAN*/



function inputPeriodeRpjmd2($nama = "tahun_anggaran", $id = "", $text = "", $value = false, $selected = false)
{
    $periode = \Modules\Utility\Periodetahun\Models\PeriodetahunModel::where('kategori', 'RPJMD/RENSTRA')->first();
    $str = "<select id='" . $id . "' name='" . $nama . "' placeholder=\"Pilih Tahun Anggaran\">";
    for ($i = $periode->tahun_awal; $i <= $periode->tahun_akhir; $i++) {
        $the_value = ($value == true) ? 'value="' . $i . '"' : '';
        $a = ($i == $selected) ? ' selected ' : '';
        $str .= "<option " . $a . $the_value . ">" . $i . "</option>";
    }
    $str .= "</select>";
    echo $str;
}
//END CREATED BY WIGUNA ON 16 MARET

function combo_idj($id = '', $selected = false)
{
    $a = '<select id="' . $id . '" name="' . $id . '" style="width:100%;" class="form-control">';
    $a .= '<option value="">Pilih ID Jadwal</option>';

    $idj = \DB::table('tr_jadwal_aktif')->orderBy('id', 'asc')->get();
    foreach ($idj as $row) {
        $s = ($selected == $row->id) ? 'selected="selected"' : '';
        $a .= '<option ' . $s . 'value="' . $row->id . '">' . $row->id . '</option>';
    }
    $a .= '</select>';
    return $a;
}

/*function simpeg online
By @RendyAmdani*/

/*cobo list role*/
function comboRole($id = "role_id", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('roles')->whereNotIn('id', ['1', '5'])->orderBy('id', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->id == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->id . "\" $isSel >" . $item->name . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list golongan ruang*/
// tampilan 1 = golru saja, 2 = p3k saja, 3 = semua
function comboGolru($id = "idgolru", $sel = "", $required = "", $tampilan = 1)
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control hitunggaji\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_golruang')->orderBy('idgolru', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idgolru == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idgolru . "\" $isSel >" . ($tampilan == 1 || $tampilan == 3 ? $item->golru . " - " : "") . $item->pangkat .
            ($tampilan == 2 || $tampilan == 3 ? " | " . $item->golru_p3k : "")
            . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list tingkat pendidikan*/
function comboTkpendidikan($id = "idtkpendid", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_tkpendid')->orderBy('idtkpendid', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idtkpendid == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idtkpendid . "\" $isSel >" . $item->tkpendid . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list jenis jurusan*/
function comboJenjurusan($id = "idjenjurusan", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jenjurusan')->orderBy('jenjurusan', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjenjurusan == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjenjurusan . "\" $isSel >" . $item->jenjurusan . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list tugas guru dosen*/
function comboTgsgurudosen($id = "idtugasgurudosen", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_tugasgurudosen')->orderBy('idtugasgurudosen', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idtugasgurudosen == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idtugasgurudosen . "\" $isSel >" . $item->tugasgurudosen . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list tugas dokter*/
function comboTgsdokter($id = "idtugasdokter", $sel = "", $required = "", $jnsdokter = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    if ($jnsdokter == 'gigi') {
        $rs = \DB::table('a_tugasdokter')->whereRaw("left(idtugasdokter,2) = 'DG'")->orderBy('idtugasdokter', 'asc')->get();
    } else {
        $rs = \DB::table('a_tugasdokter')->whereRaw("left(idtugasdokter,2) != 'DG'")->orderBy('idtugasdokter', 'asc')->get();
    }

    foreach ($rs as $item) {
        $isSel = (($item->idtugasdokter == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idtugasdokter . "\" $isSel >" . $item->tugasdokter . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list skpd*/
function comboSkpd($id = "idskpd", $sel = "", $required = "", $where = "", $holder = ".: Pilihan :.")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    if (session('role_id') < 4) {
        $ret .= "<option value=\"\">" . $holder . "</option>";
    } else {
        $ret .= "<option value=" . session('idskpd') . ">" . $holder . "</option>";
    }

    if ($where != '') {
        $rs = \DB::table('a_skpd')->where('flag', 1)->where('idskpd', 'like', '' . $where . '%')->orderBy('idskpd', 'asc')->get();
    } else {
        $rs = \DB::table('a_skpd')->where('flag', 1)->orderBy('idskpd', 'asc')->get();
    }

    foreach ($rs as $item) {
        $nbsp = '';
        $char = strlen($item->idskpd);
        $index = substr($item->idskpd, 0, 2);
        for ($x = 0; $x <= $char; $x++) {
            if ($char > 2) {
                $nbsp .= '&nbsp;&nbsp;';
            }
        }

        $isSel = (($item->idskpd == $sel) ? "selected" : "");
        $ret .= ($char == 2) ? "<optgroup label='" . $item->skpd . "'>" : "";
        $ret .= "<option value=\"" . $item->idskpd . "\" $isSel >" . $nbsp . "" . $item->skpd . "</option>";
        $ret .= ($index != substr($item->idskpd, 0, 2)) ? "</optgroup>" : "";
    }
    $ret .= "</select>";
    return $ret;
}

//fungsi subkoor berdasarkan skpd yg dipilih
function comboSubkoord($id = "idkoord", $sel = "", $where = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_skpd')->where('flag', 0)->where('isttb', 1)->where('idskpd', 'like', '' . $where . '%')->orderBy('idskpd', 'asc')->get();

    foreach ($rs as $item) {
        $isSel = (($item->idskpd == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idskpd . "\" $isSel >" . $item->skpd . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list skpd*/
function comboAsalMutasi($id = "", $sel = "", $required = "", $where = "", $holder = ".: Pilihan :.")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_skpd')->where('idparent', '=', '')->orderBy('idskpd', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->jab == $sel) ? "selected" : "");
        if (substr($item->idskpd, 0, 2) == 01) {
            $rsekda = \DB::table('a_skpd')
                ->where('id_unorindukflag', '=', '01')
                ->whereRaw('LENGTH(idparent) <= 5')->orderBy('idskpd', 'asc')->get();
            $ret .= "<optgroup label='" . $item->jab . "'>";
            foreach ($rsekda as $jos) {
                $nbsp = '';
                $char = strlen($jos->idskpd);
                $index = substr($jos->idskpd, 0, 2);
                for ($x = 0; $x <= $char; $x++) {
                    if ($char > 2) {
                        $nbsp .= '';
                    }
                }
                $ret .= "<option value=\"" . $jos->jab . "\" $isSel >" . $nbsp . "" . $jos->jab . "</option>";
                $ret .= "</optgroup>";
            }
        } else {
            $ret .= "<option value=\"" . $item->jab . "\" $isSel >" . $item->jab . "</option>";
        }
    }
    $ret .= "</select>";
    return $ret;
}

function comboSkpd2($id = "idskpd", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"1\">Semua SKPD</option>";

    $rs = \DB::table('a_skpd')->where('flag', 1)->orderBy('idskpd', 'asc')->get();
    foreach ($rs as $item) {
        $nbsp = '';
        $char = strlen($item->idskpd);
        $index = substr($item->idskpd, 0, 2);
        for ($x = 0; $x <= $char; $x++) {
            if ($char > 2) {
                $nbsp .= '&nbsp;&nbsp;';
            }
        }

        $isSel = (($item->idskpd == $sel) ? "selected" : "");
        $ret .= ($char == 2) ? "<optgroup label='" . $item->skpd . "'>" : "";
        $ret .= "<option value=\"" . $item->idskpd . "\" $isSel >" . $nbsp . "" . $item->skpd . "</option>";
        $ret .= ($index != substr($item->idskpd, 0, 2)) ? "</optgroup>" : "";
    }
    $ret .= "</select>";
    return $ret;
}
/*cobo list eselon*/
function comboEselon($id = "idesl", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_esl')->orderBy('idesl', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idesl == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idesl . "\" $isSel >" . $item->esl . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list eselon*/
function comboIseselon($id = "idisesl", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";
    $ret .= "<option value=\"esl\"" . (("esl" == $sel) ? "selected" : "") . ">Eselon</option>";
    $ret .= "<option value=\"koord\"" . (("koord" == $sel) ? "selected" : "") . ">Koordinator</option>";
    $ret .= "<option value=\"kepsek\"" . (("kepsek" == $sel) ? "selected" : "") . ">Kepala Sekolah</option>";
    $ret .= "</select>";
    return $ret;
}

/*cobo list skpd unit*/
function comboSkpdunit($id = "idskpd", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_skpd')->where('flag', 1)->where('idparent', '=', '')->orderBy('idskpd', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idskpd == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idskpd . "\" $isSel >" . $item->skpd . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list sub skpd unit*/
function comboSubskpd($id = "idskpd", $sel = "", $required = "", $parent = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_skpd')->where('idparent', 'like', '' . $parent . '%')->orderBy('idskpd', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idskpd == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idskpd . "\" $isSel >" . $item->skpd . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*combo list kategori statistik*/
// function comboKategori($id="idkategori",$sel="",$required=""){
//     $html ="<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
//     $html.="<option value=\"\">.: Pilihan :.</option>";
//     $html.="<option value=\"1\" ".(($sel==1)?"selected":"").">Pendidikan Formal</option>";
//     $html.="<option value=\"2\" ".(($sel==2)?"selected":"").">Unit Kerja dan Pendidikan Formal</option>";
//     $html.="<option value=\"3\" ".(($sel==3)?"selected":"").">Unit Kerja dan Golongan</option>";
//     $html.="<option value=\"4\" ".(($sel==4)?"selected":"").">Jenis Kelamin dan Golongan</option>";
//     $html.="<option value=\"5\" ".(($sel==5)?"selected":"").">Status Kedudukan Pegawai</option>";
//     $html.="<option value=\"6\" ".(($sel==6)?"selected":"").">Diklat Struktural</option>";
//     $html.="<option value=\"7\" ".(($sel==7)?"selected":"").">Eselon dan Golongan</option>";
//     $html.="<option value=\"8\" ".(($sel==8)?"selected":"").">Jenis Kelamin dan Eselon</option>";
//     $html.="<option value=\"9\" ".(($sel==9)?"selected":"").">Agama dan Golongan</option>";
//     $html.="<option value=\"10\" ".(($sel==10)?"selected":"").">Usia dan Golongan</option>";
//     $html.="<option value=\"11\" ".(($sel==11)?"selected":"").">Status Perkawinan</option>";
//     $html.="</select>";
//     return $html;
// }

/*combo list kategori statistik*/
function comboKategori($id = "idkategori", $sel = "", $required = "")
{
    $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $html .= "<option value=\"\">.: Pilihan :.</option>";
    $html .= "<option value=\"1\" " . (($sel == 1) ? "selected" : "") . ">Pendidikan Formal</option>";
    $html .= "<option value=\"2\" " . (($sel == 2) ? "selected" : "") . ">Unit Kerja dan Pendidikan Formal</option>";
    $html .= "<option value=\"3\" " . (($sel == 3) ? "selected" : "") . ">Unit Kerja dan Golongan</option>";
    $html .= "<option value=\"4\" " . (($sel == 4) ? "selected" : "") . ">Jenis Kelamin dan Golongan</option>";
    $html .= "<option value=\"5\" " . (($sel == 5) ? "selected" : "") . ">Status Kedudukan Pegawai</option>";
    $html .= "<option value=\"6\" " . (($sel == 6) ? "selected" : "") . ">Diklat Struktural</option>";
    $html .= "<option value=\"7\" " . (($sel == 7) ? "selected" : "") . ">Eselon dan Golongan</option>";
    $html .= "<option value=\"8\" " . (($sel == 8) ? "selected" : "") . ">Jenis Kelamin dan Eselon</option>";
    $html .= "<option value=\"9\" " . (($sel == 9) ? "selected" : "") . ">Agama dan Golongan</option>";
    $html .= "<option value=\"10\" " . (($sel == 10) ? "selected" : "") . ">Usia dan Golongan</option>";
    $html .= "<option value=\"11\" " . (($sel == 11) ? "selected" : "") . ">Status Perkawinan</option>";
    $html .= "<option value=\"12\" " . (($sel == 11) ? "selected" : "") . ">Jabfung Guru dan Golongan</option>";
    $html .= "<option value=\"13\" " . (($sel == 11) ? "selected" : "") . ">Jabfung Guru dan Unit Kerja</option>";
    $html .= "<option value=\"14\" " . (($sel == 11) ? "selected" : "") . ">Jabatan Pelaksana dan Golongan</option>";
    $html .= "<option value=\"15\" " . (($sel == 11) ? "selected" : "") . ">Jabfung Kesehatan dan Golongan</option>";
    $html .= "<option value=\"16\" " . (($sel == 11) ? "selected" : "") . ">Jabfung Teknis dan Golongan</option>";
    $html .= "</select>";
    return $html;
}

/*combo list kategori rekap*/
function comboKategorirekap($id = "idkategori", $sel = "", $required = "")
{
    $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $html .= "<option value=\"\">.: Pilihan :.</option>";
    $html .= "<option value=\"1\" " . (($sel == 1) ? "selected" : "") . ">Rekap Semua Jabatan dan Golongan</option>";
    $html .= "<option value=\"2\" " . (($sel == 2) ? "selected" : "") . ">Rekap Jabatan Struktural dan Golongan</option>";
    $html .= "<option value=\"3\" " . (($sel == 3) ? "selected" : "") . ">Rekap Jabatan Fungsional dan Golongan</option>";
    $html .= "<option value=\"4\" " . (($sel == 4) ? "selected" : "") . ">Rekap Jabatan fungsional Umum dan Golongan</option>";
    $html .= "<option value=\"5\" " . (($sel == 4) ? "selected" : "") . ">Rekap Profil Pegawai Negeri Sipil</option>";
    $html .= "</select>";
    return $html;
}

/*combo list waktu */
function comboKategoriwaktu($id = "idwaktu", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"-5\" " . (($sel == -5) ? "selected" : "") . ">5 Hari Lalu</option>";
    $ret .= "<option value=\"-4\" " . (($sel == -4) ? "selected" : "") . ">4 Hari Lalu</option>";
    $ret .= "<option value=\"-3\" " . (($sel == -3) ? "selected" : "") . ">3 Hari Lalu</option>";
    $ret .= "<option value=\"-2\" " . (($sel == -2) ? "selected" : "") . ">2 Hari Lalu</option>";
    $ret .= "<option value=\"-1\" " . (($sel == -1) ? "selected" : "") . ">1 Hari Lalu</option>";
    $ret .= "<option value=\"0\" " . (($sel == 0) ? "selected" : "") . ">Hari Ini</option>";
    $ret .= "<option value=\"1\" " . (($sel == 1) ? "selected" : "") . ">1 Hari Lagi</option>";
    $ret .= "<option value=\"2\" " . (($sel == 2) ? "selected" : "") . ">2 Hari Lagi</option>";
    $ret .= "<option value=\"3\" " . (($sel == 3) ? "selected" : "") . ">3 Hari Lagi</option>";
    $ret .= "<option value=\"4\" " . (($sel == 4) ? "selected" : "") . ">4 Hari Lagi</option>";
    $ret .= "<option value=\"5\" " . (($sel == 5) ? "selected" : "") . ">5 Hari Lagi</option>";
    $ret .= "<option value=\"10\" " . (($sel == 10) ? "selected" : "") . ">Bulan Ini</option>";
    $ret .= "<option value=\"11\" " . (($sel == 11) ? "selected" : "") . ">Bulan Depan</option>";
    $ret .= "</select>";
    return $ret;
}

/*cobo list jenis jabatan*/
function comboJenjab($id = "idjenjab", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jenjab')->orderBy('order', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjenjab == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjenjab . "\" $isSel >" . $item->jenjab . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*combo list bulan*/
function comboBulan($id = "bulan", $sel = "", $required = "", $holder = ".: Pilihan :.")
{
    $month2[1] = "Januari";
    $month2[2] = "Februari";
    $month2[3] = "Maret";
    $month2[4] = "April";
    $month2[5] = "Mei";
    $month2[6] = "Juni";
    $month2[7] = "Juli";
    $month2[8] = "Agustus";
    $month2[9] = "September";
    $month2[10] = "Oktober";
    $month2[11] = "November";
    $month2[12] = "Desember";
    $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $now = '';
    $html .= "<option value=''>" . $holder . "</option>";
    for ($i = 1; $i <= 12; $i++) {
        $bulan = $month2[$i];
        if (strlen($i) == 1) {
            $i = "0" . $i;
        }
        if ($i == $sel) {
            $html .= "<option value='$i' selected>$i | $bulan</option>";
        } else {
            $html .= "<option value='$i'>$i | $bulan</option>";
        }
        $now = 1;
        $now = $now + $i;
    }
    $html .= "</select>";
    return $html;
}

/*combo list tahun*/
function comboTahun($id = "tahun", $sel = "", $required = "", $holder = '.: Pilihan :.')
{
    $html = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $html .= "<option value=''>" . $holder . "</option>";
    for ($i = date('Y') - 5; $i <= date('Y') + 30; $i++) {
        $html .= "<option value='$i' " . (($i == $sel) ? "selected" : "") . ">$i</option>";
    }
    $html .= "</select>";
    return $html;
}

/*cobo list jenis kelamin*/
function comboJenkel($id = "idjenkel", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jenkel')->orderBy('idjenkel', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjenkel == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjenkel . "\" $isSel >" . $item->jenkel . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list Agama*/
function comboAgama($id = "idagama", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_agama')->orderBy('idagama', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idagama == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idagama . "\" $isSel >" . $item->agama . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}


function comboAgama2($id = "idagama", $name = "idagama", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$name\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_agama')->orderBy('idagama', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idagama == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idagama . "\" $isSel >" . $item->agama . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list jenis kedudukan pegawai*/
function comboJenkedudupeg($id = "idjenkedudupeg", $sel = "", $required = "", $where = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    if ($where != '') {
        $where = ' idjenkedudupeg in (1,21,99)';
        $rs = \DB::table('a_jenkedudupeg')->orderBy('idjenkedudupeg', 'asc')->whereRaw($where)->get();
    } else {
        $rs = \DB::table('a_jenkedudupeg')->orderBy('idjenkedudupeg', 'asc')->get();
    }

    foreach ($rs as $item) {
        $isSel = (($item->idjenkedudupeg == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjenkedudupeg . "\" $isSel >" . $item->jenkedudupeg . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list status marital*/

function comboStsmarital($id = "idstskawin", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_stskawin')->orderBy('idstskawin', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idstskawin == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idstskawin . "\" $isSel >" . $item->stskawin . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}
function comboStsmarital2($id = "idstskawin", $name = "idstskawin", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$name\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_stskawin')->orderBy('idstskawin', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idstskawin == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idstskawin . "\" $isSel >" . $item->stskawin . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}
function comboStsDujan($project_id = "idstsdujan", $sel = "", $required = "")
{
    $dujan = array(
        '1' => 'Cerai',
        '2' => 'Meninggal',
    );
    $html = '<select id="' . $project_id . '" name="' . $project_id . '" class="form-control">';
    $html .= '<option value="">.: Pilihan :.</option>';
    $no = 1;
    foreach ($dujan as $dj) {
        // $html .= '<option value='.$no.' '.(($sel==$no)?'selected':'').'>'.$dj.'</option>';
        $isSel = (($no == $sel) ? "selected" : "");
        $html .= "<option value=\"" . $no . "\" $isSel >" . $dj . "</option>";
        $no++;
    }
    $html .= '</select>';
    return $html;
}/*cobo list status marital Duda Janda*/
function comboStsDujan2($project_id = "idstsdujan", $name = "idstsdujan", $sel = "", $required = "")
{
    $dujan = array(
        '1' => 'Cerai',
        '2' => 'Meninggal',
    );
    $html = '<select id="' . $project_id . '" name="' . $name . '" class="form-control">';
    $html .= '<option value="">.: Pilihan :.</option>';
    $no = 1;
    foreach ($dujan as $dj) {
        // $html .= '<option value='.$no.' '.(($sel==$no)?'selected':'').'>'.$dj.'</option>';
        $isSel = (($no == $sel) ? "selected" : "");
        $html .= "<option value=\"" . $no . "\" $isSel >" . $dj . "</option>";
        $no++;
    }
    $html .= '</select>';
    return $html;
}

/*cobo list status issu*/
function comboStsIssu($project_id = "idstsissu", $sel = "", $required = "")
{
    $issu = array(
        '1' => 'Hidup',
        '2' => 'Cerai',
        '3' => 'Meninggal',
    );
    $html = '<select id="' . $project_id . '" name="' . $project_id . '" class="form-control">';
    $html .= '<option value="">.: Pilihan :.</option>';
    $no = 1;
    foreach ($issu as $is) {
        // $html .= '<option value='.$no.' '.(($sel==$no)?'selected':'').'>'.$dj.'</option>';
        $isSel = (($no == $sel) ? "selected" : "");
        $html .= "<option value=\"" . $no . "\" $isSel >" . $is . "</option>";
        $no++;
    }
    $html .= '</select>';
    return $html;
}

/*cobo list golongan darah*/
function comboGoldarah($id = "idgoldarah", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_goldarah')->orderBy('idgoldarah', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idgoldarah == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idgoldarah . "\" $isSel >" . $item->goldarah . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

function comboGoldarah2($id = "idgoldarah", $name = "idgoldarah", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$name\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_goldarah')->orderBy('idgoldarah', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idgoldarah == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idgoldarah . "\" $isSel >" . $item->goldarah . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list kabupaten kota*/
function comboKabkota($id = "kdkabkota", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_kabkota')->orderBy('kdkabkota', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->kdkabkota == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->kdkabkota . "\" $isSel >" . $item->kabkota . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list penetap sk*/
function comboPenetapsk($id = "idpenetap", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_penetapsk')->orderBy('jabatan', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->id == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->id . "\" $isSel >" . $item->jabatan . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

// combo untuk opd disable
function comboPenetapskDis($id = "idpenetap", $sel = "", $required = "")
{
    $ret = "<select disabled='true' id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_penetapsk')->orderBy('jabatan', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->id == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->id . "\" $isSel >" . $item->jabatan . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list jenis pensiun*/
function comboJenpens($id = "idjenpens", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jenpens')->orderBy('jenpens', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjenpens == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjenpens . "\" $isSel >" . $item->jenpens . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list jenis kepegawaian*/
function comboJenkepeg($id = "idjenkepeg", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jenkepeg')->orderBy('jenkepeg', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjenkepeg == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjenkepeg . "\" $isSel >" . $item->jenkepeg . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list jabatan fungsional*/
function comboJabfung($id = "idjabfung", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jabfung')->orderBy('jabfung', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjabfung == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjabfung . "\" $isSel >" . $item->jabfung . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*function untuk mendapatkan list group  jabfung*/
function comboJabfung2($id = "idtkjabfung", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";
    $rs = \DB::table('a_jabfung')->orderBy('jabfung2', 'asc')->groupBy('jabfung2')->get();
    foreach ($rs as $item) {
        $isSel = (($item->tingkat == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->tingkat . "\" $isSel >" . $item->jabfung2 . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*function untuk mendapatkan list jabfung berdasarkan group*/
function comboTkjabfung($id = "idjabfung", $where = "", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";
    $rs = \DB::table('a_jabfung')->where('tingkat', 'like', '' . $where . '%')->orderBy('jabfung', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjabfung == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjabfung . "\" $isSel >" . $item->jabfung . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list jabatan fungsional umum*/
function comboJabfungum($id = "idjabfungum", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jabfungum')->orderBy('jabfungum', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjabfungum == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjabfungum . "\" $isSel >" . $item->jabfungum . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*cobo list diklat struktural*/
function comboDikstru($id = "iddikstru", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_dikstru')->orderBy('dikstru', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->iddikstru == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->iddikstru . "\" $isSel >" . $item->dikstru . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*combo list ya atau tidak */
function comboYesno($id = "idstatus", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"0\" " . (($sel == 0) ? "selected" : "") . ">.: Pilihan :.</option>";
    $ret .= "<option value=\"1\" " . (($sel == 1) ? "selected" : "") . ">Ya</option>";
    $ret .= "<option value=\"2\" " . (($sel == 2) ? "selected" : "") . ">Tidak</option>";
    $ret .= "</select>";
    return $ret;
}

/*fungtion untuk mendapatkan sttribut*/
function getAttr($table, $where, $value, $call)
{
    $rs = \DB::table($table)->select($call)->where($where, $value)->first();
    if (count($rs) > 0) {
        return $rs->$call;
    } else {
        return '';
    }
}

/*fungtion untuk mendapatkan jabatan*/
function getJabatan($idjenjab, $idjab)
{
    if (($idjenjab == 20) or ($idjenjab == 30) or ($idjenjab == 40)) {
        $rs = \DB::table('a_skpd')->select(\DB::raw('jab as jabatan'))->where('idskpd', $idjab)->first();
    } elseif ($idjenjab == 2) {
        $rs = \DB::table('a_jabfung')->select(\DB::raw('jabfung as jabatan'))->where('idjabfung', $idjab)->first();
    } elseif ($idjenjab == 3) {
        $rs = \DB::table('a_jabfungum')->select(\DB::raw('jabfungum as jabatan'))->where('idjabfungum', $idjab)->first();
    } elseif ($idjenjab == 4) {
        $rs = \DB::table('a_jabnonjob')->select(\DB::raw('jabnonjob as jabatan'))->where('idjabnonjob', $idjab)->first();
    }

    if (count($rs) > 0) {
        return $rs->jabatan;
    } else {
        return '';
    }
}

/*fungtion untuk mendapatkan gaji*/
function getGaji($golongan, $thmasker)
{
    if (strlen($thmasker) < 2) {
        $thmasker = '0' . $thmasker;
    } elseif (strlen($thmasker) == 0) {
        $thmasker = '00';
    }

    $cek = \DB::table('a_gaji')->select(\DB::raw('max(MSK) as mskmax'))->where('pkt', $golongan)->where('status', 1)->first();
    if (count($cek) > 0) {
        if ($thmasker > $cek->mskmax) {
            $masaker = $cek->mskmax;
        } else {
            $masaker = $thmasker;
        }

        $rsgaji = \DB::table('a_gaji')->select('gaji')->where('pkt', $golongan)->where('status', 1)->where('msk', $masaker)->first();
        if (count($rsgaji) > 0) {
            $gaji = $rsgaji->gaji;
        } else {
            $gaji = '';
        }
    }

    return $gaji;
}

/*function jenis bahasa*/
function comboJnsbahasa($id = "jenis_bahasa", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style='width:100%'>";
    $ret .= "<option value=\"\" " . (($sel == '') ? 'selected' : '') . ">.: Pilihan :.</option>";
    $ret .= "<option value=\"ASING\" " . (($sel == 'ASING') ? 'selected' : '') . " >Bahasa Asing</option>";
    $ret .= "<option value=\"DAERAH\" " . (($sel == 'DAERAH') ? 'selected' : '') . " >Bahasa Daerah</option>";
    $ret .= "</select>";
    return $ret;
}

/*function tingkat kemampuan bahasa*/
function comboTingkat($id = "kemampuan", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style='width:100%'>";
    $ret .= "<option value=\"\" " . (($sel == '') ? 'selected' : '') . ">.: Pilihan :.</option>";
    $ret .= "<option value=\"AKTIF\" " . (($sel == 'AKTIF') ? 'selected' : '') . ">AKTIF</option>";
    $ret .= "<option value=\"PASIF\" " . (($sel == 'PASIF') ? 'selected' : '') . ">PASIF</option>";
    $ret .= "</select>";
    return $ret;
}

/*function combo tanda jasa*/
function comboTandajasa($id = "jenis", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jnstandajasa')->orderBy('tandajasa', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idtandajasa == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idtandajasa . "\" $isSel >" . $item->tandajasa . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*function combo tanda jasa*/
function comboJenhukum($id = "idjenhukum", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jenhukum')->orderBy('jenhukum', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjenhukum == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjenhukum . "\" $isSel >" . $item->jenhukum . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*function combo tanda jasa*/
function comboTkhukum($id = "idtkhukum", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_kathukdis')->orderBy('kathukdis', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idkathukdis == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idkathukdis . "\" $isSel >" . $item->kathukdis . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*function combo status sortua*/
function comboOrtu($id = "status_ortu", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";
    $ret .= "<option value=\"1\">Ayah</option>";
    $ret .= "<option value=\"2\">Ibu</option>";
    $ret .= "<option value=\"3\">Ayah Mertua</option>";
    $ret .= "<option value=\"4\">Ibu Mertua</option>";
    $ret .= "</select>";
    return $ret;
}

/*function combo jenis pekerjaan*/
function comboStspekerjaan($id = "peker", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"0\">.: Pilihan :.</option>";
    $ret .= "<option value=\"1\">PNS Kab.Kendal</option>";
    $ret .= "<option value=\"2\">PNS Luar Kab.Kendal</option>";
    $ret .= "<option value=\"3\">Non PNS</option>";
    $ret .= "</select>";
    return $ret;
}

/*function combo status keluarga*/
function comboStskeluarga($id = "stskeluarga", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";
    $ret .= "<option value=\"Anak Kandung\">Anak Kandung</option>";
    $ret .= "<option value=\"Anak Tiri\">Anak Tiri</option>";
    $ret .= "<option value=\"Anak Angkat\">Anak Angkat</option>";
    $ret .= "</select>";
    return $ret;
}

/*function combo tunjangan*/
function comboTunjangan($id = "tunjangan", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";
    $ret .= "<option value=\"1\">Dapat</option>";
    $ret .= "<option value=\"2\">Tidak</option>";
    $ret .= "</select>";
    return $ret;
}

/*function combo saudara kandung*/
function comboJnssaudara($id = "stssaudara", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";
    $ret .= "<option value=\"1\">Saudara Kandung</option>";
    $ret .= "<option value=\"2\">Saudara Kandung Isteri/Suami</option>";
    $ret .= "</select>";
    return $ret;
}

/*function familithree sotk*/
function familytree($id = 0, $x = 0)
{
    $data['idparent'] = $id;
    $x++;
    if (strlen($id) == 2) {
        $rs = \DB::table('a_skpd as a')->select(
            'a.idskpd',
            'a.skpd',
            'a.jab',
            'a.path',
            'a.idesl',
            'b.nip',
            'b.niplama',
            'b.photo',
            \DB::raw("concat(if(length(b.gdp)>0,concat(b.gdp,' '),''),b.nama,if(length(b.gdb)>0,concat(',',b.gdb),'')) as namalengkap")
        )
            ->leftjoin('tb_01 as b', function ($join) {
                $join->on('a.idskpd', '=', 'b.idjabjbt')
                    ->where('b.idjenkedudupeg', '!=', 99)
                    ->where('b.idjenkedudupeg', '!=', 21);
            })
            ->where('a.flag', 1)
            ->where('a.idparent', $id)
            ->whereBetween('a.idesl', array(21, 52))
            ->orderBy('a.idskpd');
    } else {
        $rs = \DB::table('a_skpd as a')->select(
            'a.idskpd',
            'a.skpd',
            'a.jab',
            'a.path',
            'a.idesl',
            'b.nip',
            'b.niplama',
            'b.photo',
            \DB::raw("concat(if(length(b.gdp)>0,concat(b.gdp,' '),''),b.nama,if(length(b.gdb)>0,concat(',',b.gdb),'')) as namalengkap")
        )
            ->leftjoin('tb_01 as b', function ($join) {
                $join->on('a.idskpd', '=', 'b.idjabjbt')
                    ->where('b.idjenkedudupeg', '!=', 99)
                    ->where('b.idjenkedudupeg', '!=', 21);
            })
            ->where('a.flag', 1)
            ->where('a.idparent', $id)
            ->whereBetween('a.idesl', array(21, 52))
            ->orderBy('a.idskpd');
    }

    foreach ($rs->get() as $item) {
        $rs2 = \DB::table('a_skpd')->where('idparent', $item->idskpd);

        if (File::exists("packages/upload/photo/pegawai/" . $item->photo)) {
            $urlphoto = url() . "/packages/upload/photo/pegawai/" . $item->photo;
        } else {
            $urlphoto = url() . "/packages/upload/photo/pegawai/default.jpg";
        }

        $photo = "<i style=\"margin:0 auto;margin-top:5px;border:1px solid #CCCCCC;background:url(" . str_replace(' ', '%20', $urlphoto) . ")
        no-repeat center center;background-size:100% 100%;width:70px;height:80px;display:block;border-radius:5px;\"></i>";
        $photo_ = "";
        $div1 = "<div class=\"sotk-nama\">" . $item->namalengkap . "</div>";
        $div2 = "<div class=\"sotk-nip\">" . (($item->nip != '') ? $item->nip : 'Jabatan Kosong') . "</div>";
        if (count($rs2->get()) > 0) {
            echo "<li class=\"up-" . $item->idesl . "\"><a><span class=\"sotk-title\">" . $item->skpd . "</span>" . $photo . $div2 . $div1 . "</a>";
            echo "\n<ul>";
            familytree($item->idskpd, $x);
            echo "</ul>\n";
        } else {
            echo "<li><a><span class=\"sotk-title\">" . $item->skpd . "</span>" . $photo . $div2 . $div1 . "</a>";
        }
        echo "</li>\n";
    }
}

/*function untuk mendapatkan data pegawai*/
/*function untuk mendapatkan data pegawai*/
function getDetailpegawai($nip)
{
    $rs = \DB::table('tb_01')
        ->select(
            'tb_01.*',
            'a_goldarah.goldarah',
            'a_golrupkt.golru',
            'a_skpd.skpd',
            'a_esl.esl',
            'a_tkpendid.tkpendid',
            'a_jenjurusan.jenjurusan',
            'a_stspeg.stspeg',
            'a_jenkepeg.jenkepeg',
            'a_stskawin.stskawin',
            'a_jenkedudupeg.jenkedudupeg',
            'tb_01.idstspeg',
            'a_jabfungum.jabfung_id',
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap, b_skpd.skpd as unit'),
            'a_jenkel.jenkel',
            'a_agama.agama',
            \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
            \DB::raw("
            FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(if(tb_01.idstspeg=3,if(tb_01.tgskcalonawal_pppk='0000-00-00',NOW(),tb_01.tgskcalonawal_pppk),if(tb_01.tmtcpn='0000-00-00',NOW(),tb_01.tmtcpn)), '%Y%m')) / 12) AS thn_cpns,
            PERIOD_DIFF(DATE_FORMAT(DATE_ADD((CASE WHEN DAY(NOW()) >= DAY(if(tb_01.idstspeg=3,if(tb_01.tgskcalonawal_pppk='0000-00-00',NOW(),tb_01.tgskcalonawal_pppk),if(tb_01.tmtcpn='0000-00-00',NOW(),tb_01.tmtcpn))) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), INTERVAL -(FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(if(tb_01.idstspeg=3,if(tb_01.tgskcalonawal_pppk='0000-00-00',NOW(),tb_01.tgskcalonawal_pppk),if(tb_01.tmtcpn='0000-00-00',NOW(),tb_01.tmtcpn)), '%Y%m')) / 12)) YEAR), '%Y%m'), DATE_FORMAT(if(tb_01.idstspeg=3,if(tb_01.tgskcalonawal_pppk='0000-00-00',NOW(),tb_01.tgskcalonawal_pppk),if(tb_01.tmtcpn='0000-00-00',NOW(),tb_01.tmtcpn)), '%Y%m')) AS bln_cpns,
            DATEDIFF(NOW(), if(tb_01.idstspeg=3,if(tb_01.tgskcalonawal_pppk='0000-00-00',NOW(),tb_01.tgskcalonawal_pppk),if(tb_01.tmtcpn='0000-00-00',NOW(),tb_01.tmtcpn))) - DATEDIFF(DATE_ADD(CONVERT(CONCAT(DATE_FORMAT((CASE WHEN DAY(NOW()) >= DAY(if(tb_01.idstspeg=3,if(tb_01.tgskcalonawal_pppk='0000-00-00',NOW(),tb_01.tgskcalonawal_pppk),if(tb_01.tmtcpn='0000-00-00',NOW(),tb_01.tmtcpn))) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), '%Y-%m-'), RIGHT('0' + DAY(if(tb_01.idstspeg=3,if(tb_01.tgskcalonawal_pppk='0000-00-00',NOW(),tb_01.tgskcalonawal_pppk),if(tb_01.tmtcpn='0000-00-00',NOW(),tb_01.tmtcpn))), 2)), DATE), INTERVAL -1 DAY), if(tb_01.idstspeg=3,if(tb_01.tgskcalonawal_pppk='0000-00-00',NOW(),tb_01.tgskcalonawal_pppk),if(tb_01.tmtcpn='0000-00-00',NOW(),tb_01.tmtcpn))) AS hari_cpns"),
            \DB::raw("
            CONCAT(
            IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
            (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
            -
            (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
            IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
            IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
            ),
            (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
            + tb_01.mkthncpn
            )
            ),
            RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
            "),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia, a_golrucpn.golru as golrucpn, a_golrucpn.pangkat as pangkatcpn, a_golrupns.golru as golrupns, a_golrupns.pangkat as pangkatpns, a_golrupkt.golru as golrupkt, a_golrupkt.pangkat as pangkatpkt")
        )
        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->join('a_skpd as b_skpd', 'tb_01.kdunit', '=', 'b_skpd.idskpd')
        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang as a_golrucpn', 'tb_01.idgolrucpn', '=', 'a_golrucpn.idgolru')
        ->leftjoin('a_golruang as a_golrupns', 'tb_01.idgolrupns', '=', 'a_golrupns.idgolru')
        ->leftjoin('a_golruang as a_golrupkt', 'tb_01.idgolrupkt', '=', 'a_golrupkt.idgolru')
        ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
        ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
        ->leftjoin('a_stspeg', 'tb_01.idstspeg', '=', 'a_stspeg.idstspeg')
        ->leftjoin('a_jenkepeg', 'tb_01.idjenkepeg', '=', 'a_jenkepeg.idjenkepeg')
        ->leftjoin('a_stskawin', 'tb_01.idstskawin', '=', 'a_stskawin.idstskawin')
        ->leftjoin('a_jenkedudupeg', 'tb_01.idjenkedudupeg', '=', 'a_jenkedudupeg.idjenkedudupeg')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        ->leftjoin('a_goldarah', 'tb_01.idgoldarah', '=', 'a_goldarah.idgoldarah')
        ->where('nip', $nip)
        ->orderBy('tb_01.idjenjab', 'asc')
        ->orderBy('tb_01.idgolrupkt', 'desc')
        ->orderBy('tb_01.tmtpkt', 'asc')
        ->first();

    return $rs;
}


/*function untuk mendapatkan data pegawai by id*/
function getPegawai($idskpd = "", $idjenjab = "")
{
    $where = ' tb_01.idjenkedudupeg not in (99,21)';
    $where .= " and tb_01.idskpd = \"" . $idskpd . "\" ";

    if ($idjenjab >= 20) {
        $where .= " and tb_01.idjenjab = \"" . $idjenjab . "\" ";
    }

    $rs = \DB::table('a_skpd')
        ->select('tb_01.nip', 'tb_01.nama', 'a_skpd.path', 'a_skpd.jab_asn')
        ->join('tb_01', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
        ->whereRaw($where)
        ->first();

    return $rs;
}

/*function untuk mendapatkan data pegawai by id*/
//function geturutanpegawai($idskpd="", $idparent="", $idjenjab=""){
//    $where = ' tb_01.idjenkedudupeg not in (99,21)';
//    $where.= " and tb_01.idskpd like \"".$idskpd."%\" ";
//    $where.= " and a_skpd.idparent = \"".$idparent."\" ";
//    //if($idjenjab == 1){
//    if($idjenjab >= 20){
//        $where.= " and tb_01.idjenjab = \"".$idjenjab."\" ";
//    }
//
//    $rs = \DB::table('tb_01')
//        ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan','tb_01.idskpd',
//            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),'a_agama.agama',
//            \DB::raw('IF(tb_01.idjenjab>=20,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
//            \DB::raw("
//                            CONCAT(
//                                IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
//                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
//                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
//                                        -
//                                        (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
//                                        IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
//                                            IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
//                                    ),
//                                    (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
//                                        (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
//                                        + tb_01.mkthncpn
//                                    )
//                                ),
//                                RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
//                        "),
//            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
//        )
//        ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
//        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
//        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
//        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
//        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
//        ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
//        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
//        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
//        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
//        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
//        ->whereRaw($where)
//        ->orderBy(\DB::raw('tb_01.idskpd,a_jenjab.order,tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
//        ->get();
//
//    return $rs;
//}

/*function untuk mendapatkan data pegawai by id*/
function geturutanpegawai($idskpd = "", $idparent = "", $idjenjab = "")
{
    //$where = ' tb_01.idjenkedudupeg not in (99,21)';
    $where = " a_skpd.idskpd like \"" . $idskpd . "%\" ";
    $where .= " and a_skpd.idparent = \"" . $idparent . "\" ";

    if ($idjenjab >= 20) {
        $where .= " and tb_01.idjenjab = \"" . $idjenjab . "\" ";
    }

    $rs = \DB::table('a_skpd')
        ->select(
            'tb_01.*',
            'a_golruang.golru',
            'a_skpd.path',
            'a_skpd.jab_utuh',
            'a_skpd.jab_asn',
            'a_esl.esl',
            'a_tkpendid.tkpendid',
            'a_jenjurusan.jenjurusan',
            'tb_01.idskpd',
            \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", ",""),tb_01.gdb) as namalengkap'),
            'a_agama.agama',
            \DB::raw('IF(tb_01.idjenjab>=20,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
            \DB::raw("
            CONCAT(
            IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
            (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
            -
            (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
            IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
            IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
            ),
            (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
            (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
            + tb_01.mkthncpn
            )
            ),
            RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
            "),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia"),
            \DB::raw("a_skpd.idskpd as idskpdsub")
        )
        ->leftJoin('tb_01', function ($join) {
            $join->on('tb_01.idskpd', '=', 'a_skpd.idskpd')
                ->where('a_skpd.flag', '=', 1)
                ->whereNotIn('tb_01.idjenkedudupeg', ['99', '21']);
        })
        ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
        ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
        ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
        ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
        ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
        ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
        ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
        ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
        ->leftjoin('a_jenjab', 'tb_01.idjenjab', '=', 'a_jenjab.idjenjab')
        ->whereRaw($where)
        ->orderBy(\DB::raw('a_skpd.idskpd,a_jenjab.order,tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
        ->get();

    return $rs;
}

/*function detail pegawai untuk perubahan data*/
function getDetailpegawaiupdate($nip)
{
    $rs = \DB::table('tb_01 as a')
        ->select(
            'a.*',
            'b.skpd',
            'c.isguru',
            'h.agama',
            'i.stskawin',
            'j.jenkel',
            'k.stspeg',
            'l.jenkepeg',
            'm.jenkedudupeg',
            'n.jenjab',
            'z3.esl',
            'z4.goldarah',
            \DB::raw('g.skpd as unitskpd'),
            'o.tugasgurudosen',
            'p.matkulpel',
            \DB::raw('q.jabatan as penetapcpn, r.jabatan as penetappns, s.jabatan as penetappkt, z2.jabatan as penetapkgb'),
            \DB::raw('t.golru as golrucpn, u.golru as golrupns, v.golru as golrupkt, w.golru as golrukgb'),
            \DB::raw('x.tkpendid as tkpendidawal, y.tkpendid as tkpendidakhir, z.jenjurusan as jenjurusanawal, z1.jenjurusan as jenjurusanakhir'),
            \DB::raw('IF(LENGTH(a.idskpd) > 3, CONCAT(b.skpd," ",g.skpd), g.skpd) as skpdunit'),
            \DB::raw('IF(a.idjenjab>4,b.jab,IF(a.idjenjab=2,c.jabfung,IF(a.idjenjab=3,d.jabfungum,"-"))) as jabatan'),
            \DB::raw('CONCAT(a.gdp,IF(LENGTH(a.gdp)>0," ",""),a.nama,IF(LENGTH(a.gdb)>0,", ",""),a.gdb) as namalengkap'),
            'e.jenjurusan',
            'f.jenjurusan as jenjurusanawal'
        )
        ->leftjoin('a_skpd as b', 'a.idskpd', '=', 'b.idskpd')
        ->leftjoin('a_skpd as g', 'a.kdunit', '=', 'g.idskpd')
        ->leftjoin('a_jabfung as c', 'a.idjabfung', '=', 'c.idjabfung')
        ->leftjoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
        ->leftjoin('a_jenjurusan as e', 'a.idjenjurusan', '=', 'e.idjenjurusan')
        ->leftjoin('a_jenjurusan as f', 'a.idjenjurusanawal', '=', 'f.idjenjurusan')
        ->leftjoin('a_esl as z3', 'a.idesljbt', '=', 'z3.idesl')
        ->leftjoin('a_agama as h', 'a.idagama', '=', 'h.idagama')
        ->leftjoin('a_stskawin as i', 'a.idstskawin', '=', 'i.idstskawin')
        ->leftjoin('a_jenkel as j', 'a.idjenkel', '=', 'j.idjenkel')
        ->leftjoin('a_stspeg as k', 'a.idstspeg', '=', 'k.idstspeg')
        ->leftjoin('a_jenkepeg as l', 'a.idjenkepeg', '=', 'l.idjenkepeg')
        ->leftjoin('a_jenkedudupeg as m', 'a.idjenkedudupeg', '=', 'm.idjenkedudupeg')
        ->leftjoin('a_jenjab as n', 'a.idjenjab', '=', 'n.idjenjab')
        ->leftjoin('a_tugasgurudosen as o', 'a.idtugasgurudosen', '=', 'o.idtugasgurudosen')
        ->leftjoin('a_matkulpel as p', 'a.idmatkulpel', '=', 'p.idmatkulpel')
        ->leftjoin('a_penetapsk as q', 'a.pejmencpn', '=', 'q.id')
        ->leftjoin('a_penetapsk as r', 'a.pejmenpns', '=', 'r.id')
        ->leftjoin('a_penetapsk as s', 'a.pejmenpkt', '=', 's.id')
        ->leftjoin('a_penetapsk as z2', 'a.pejmenkgb', '=', 'z2.id')
        ->leftjoin('a_golruang as t', 'a.idgolrucpn', '=', 't.idgolru')
        ->leftjoin('a_golruang as u', 'a.idgolrupns', '=', 'u.idgolru')
        ->leftjoin('a_golruang as v', 'a.idgolrupkt', '=', 'v.idgolru')
        ->leftjoin('a_golruang as w', 'a.idgolrupkt', '=', 'w.idgolru')
        ->leftjoin('a_tkpendid as x', 'a.idtkpendidawal', '=', 'x.idtkpendid')
        ->leftjoin('a_tkpendid as y', 'a.idtkpendid', '=', 'y.idtkpendid')
        ->leftjoin('a_jenjurusan as z', 'a.idjenjurusanawal', '=', 'z.idjenjurusan')
        ->leftjoin('a_jenjurusan as z1', 'a.idjenjurusan', '=', 'z1.idjenjurusan')
        ->leftjoin('a_goldarah as z4', 'a.idgoldarah', '=', 'z4.idgoldarah')
        ->where('a.nip', '=', $nip)
        ->first();

    return $rs;
}

/*function untuk mendapatkan nama skpd*/
function getSkpd($idskpd)
{
    $rs = \DB::table('a_skpd')->where('idskpd', $idskpd)->first();
    if (count($rs) > 0) {
        if (strlen($idskpd) == 2) {
            return $rs->skpd;
        } else {
            return $rs->path;
        }
    } else {
        return 'Semua Unit Kerja';
    }
}

/*function untuk mendapatkan tingkat pendidikan*/
function getTkpendid($idtkpendid)
{
    $rs = \DB::table('a_tkpendid')->where('idtkpendid', $idtkpendid)->first();
    if (count($rs) > 0) {
        return $rs->tkpendid;
    } else {
        return '-';
    }
}

/*function format nip*/
function fnip($nip, $batas = " ")
{
    $nip = trim($nip, " ");
    $panjang = strlen($nip);

    if ($panjang == 18) {
        $sub[] = substr($nip, 0, 8); // tanggal lahir
        $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
        $sub[] = substr($nip, 14, 1); // jenis kelamin
        $sub[] = substr($nip, 15, 3); // nomor urut

        return $sub[0] . $batas . $sub[1] . $batas . $sub[2] . $batas . $sub[3];
    } elseif ($panjang == 15) {
        $sub[] = substr($nip, 0, 8); // tanggal lahir
        $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
        $sub[] = substr($nip, 14, 1); // jenis kelamin

        return $sub[0] . $batas . $sub[1] . $batas . $sub[2];
    } elseif ($panjang == 9) {
        $sub = str_split($nip, 3);

        return $sub[0] . $batas . $sub[1] . $batas . $sub[2];
    } else {
        return $nip;
    }
}

/*function combo list bulan kpr*/
function comboKpr($id = "blnkpr", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"\">.:Pilihan:.</option>";
    $ret .= "<option value=\"04\">April</option>"; //tambah 0,biar tmt kp pas create nominatif bisa auto keisi
    $ret .= "<option value=\"10\">Oktober</option>";
    $ret .= "</select>";
    return $ret;
}

/*function untuk mendapatkan nama bulan*/
function formatBulan($bln)
{
    $bln = (($bln > 0) && ($bln < 10)) ? substr($bln, 1, 1) : $bln;
    $aBulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $date = $aBulan[$bln];
    return $date;
}

/*function untuk mendapatkan keterangan permohonan*/
function getKetaksi($idjenis)
{
    switch ($idjenis) {
        case 1:
            $ket = "<i class='glyphicon glyphicon-plus-sign' title='Permohonan Baru'></i>&nbsp;Permohonan&nbsp;Baru";
            break;
        case 2:
            $ket = "<i class='glyphicon glyphicon-info-sign' title='Permohonan Update'></i>&nbsp;Permohonan&nbsp;Edit";
            break;
        case 3:
            $ket = "<i class='glyphicon glyphicon-remove-sign' title='Permohonan Delete'></i>&nbsp;Permohonan&nbsp;Hapus";
            break;
        default:
            $ket = "-";
    }

    return $ket;
}

function cekperubahanbiodata($nip)
{
    $item1 = \DB::table('tb_01')->where('nip', $nip)->first();
    $item2 = \DB::table('tb_01_temp')->where('nip', $nip)->first();

    $x = 0;
    if (count($item2) > 0) {
        if ($item1->photo != $item2->photo) {
            $x = $x + 1;
        }
        if ($item1->nip != $item2->nip) {
            $x = $x + 1;
        }
        if ($item1->niplama != $item2->niplama) {
            $x = $x + 1;
        }
        if ($item1->nip != $item2->nip) {
            $x = $x + 1;
        }
        if ($item1->gdp != $item2->gdp) {
            $x = $x + 1;
        }
        if ($item1->nama != $item2->nama) {
            $x = $x + 1;
        }
        if ($item1->gdb != $item2->gdb) {
            $x = $x + 1;
        }
        if ($item1->tmlhr != $item2->tmlhr) {
            $x = $x + 1;
        }
        if ($item1->tglhr != $item2->tglhr) {
            $x = $x + 1;
        }
        if ($item1->idagama != $item2->idagama) {
            $x = $x + 1;
        }
        if ($item1->idjenkel != $item2->idjenkel) {
            $x = $x + 1;
        }
        if ($item1->idstskawin != $item2->idstskawin) {
            $x = $x + 1;
        }
        if ($item1->idgoldarah != $item2->idgoldarah) {
            $x = $x + 1;
        }
        if ($item1->alm != $item2->alm) {
            $x = $x + 1;
        }
        if ($item1->almrt != $item2->almrt) {
            $x = $x + 1;
        }
        if ($item1->almrw != $item2->almrw) {
            $x = $x + 1;
        }
        if ($item1->almdesa != $item2->almdesa) {
            $x = $x + 1;
        }
        if ($item1->almkec != $item2->almkec) {
            $x = $x + 1;
        }
        if ($item1->almkab != $item2->almkab) {
            $x = $x + 1;
        }
        if ($item1->almprov != $item2->almprov) {
            $x = $x + 1;
        }
        if ($item1->almkdpos != $item2->almkdpos) {
            $x = $x + 1;
        }
        if ($item1->telp != $item2->telp) {
            $x = $x + 1;
        }
        if ($item1->hp != $item2->hp) {
            $x = $x + 1;
        }
        if ($item1->nokarpeg != $item2->nokarpeg) {
            $x = $x + 1;
        }
        if ($item1->noaskes != $item2->noaskes) {
            $x = $x + 1;
        }
        if ($item1->notaspen != $item2->notaspen) {
            $x = $x + 1;
        }
        if ($item1->nokaris != $item2->nokaris) {
            $x = $x + 1;
        }
        if ($item1->nonpwp != $item2->nonpwp) {
            $x = $x + 1;
        }
        if ($item1->noktp != $item2->noktp) {
            $x = $x + 1;
        }
        if ($item1->nobapertarum != $item2->nobapertarum) {
            $x = $x + 1;
        }
        if ($item1->kdunit != $item2->kdunit) {
            $x = $x + 1;
        }
        if ($item1->idskpd != $item2->idskpd) {
            $x = $x + 1;
        }
        if ($item1->idstspeg != $item2->idstspeg) {
            $x = $x + 1;
        }
        if ($item1->idjenkepeg != $item2->idjenkepeg) {
            $x = $x + 1;
        }
        if ($item1->idjenkedudupeg != $item2->idjenkedudupeg) {
            $x = $x + 1;
        }
        if ($item1->pejmencpn != $item2->pejmencpn) {
            $x = $x + 1;
        }
        if ($item1->idgolrucpn != $item2->idgolrucpn) {
            $x = $x + 1;
        }
        if ($item1->noskcpn != $item2->noskcpn) {
            $x = $x + 1;
        }
        if ($item1->tgskcpn != $item2->tgskcpn) {
            $x = $x + 1;
        }
        if ($item1->tmtcpn != $item2->tmtcpn) {
            $x = $x + 1;
        }
        if ($item1->mkthncpn != $item2->mkthncpn) {
            $x = $x + 1;
        }
        if ($item1->mkblncpn != $item2->mkblncpn) {
            $x = $x + 1;
        }
        if ($item1->nospmtcpn != $item2->nospmtcpn) {
            $x = $x + 1;
        }
        if ($item1->tgspmtcpn != $item2->tgspmtcpn) {
            $x = $x + 1;
        }
        if ($item1->tmtspmtcpn != $item2->tmtspmtcpn) {
            $x = $x + 1;
        }
        if ($item1->pejmenpns != $item2->pejmenpns) {
            $x = $x + 1;
        }
        if ($item1->idgolrupns != $item2->idgolrupns) {
            $x = $x + 1;
        }
        if ($item1->tgskpns != $item2->tgskpns) {
            $x = $x + 1;
        }
        if ($item1->noskpns != $item2->noskpns) {
            $x = $x + 1;
        }
        if ($item1->tmtpns != $item2->tmtpns) {
            $x = $x + 1;
        }
        if ($item1->mkthnpns != $item2->mkthnpns) {
            $x = $x + 1;
        }
        if ($item1->mkblnpns != $item2->mkblnpns) {
            $x = $x + 1;
        }
        if ($item1->nospmtpns != $item2->nospmtpns) {
            $x = $x + 1;
        }
        if ($item1->tgspmtpns != $item2->tgspmtpns) {
            $x = $x + 1;
        }
        if ($item1->tmtspmtpns != $item2->tmtspmtpns) {
            $x = $x + 1;
        }
        if ($item1->tinggi != $item2->tinggi) {
            $x = $x + 1;
        }
        if ($item1->berat != $item2->berat) {
            $x = $x + 1;
        }
        if ($item1->rambut != $item2->rambut) {
            $x = $x + 1;
        }
        if ($item1->muka != $item2->muka) {
            $x = $x + 1;
        }
        if ($item1->kulit != $item2->kulit) {
            $x = $x + 1;
        }
        if ($item1->ciri != $item2->ciri) {
            $x = $x + 1;
        }
        if ($item1->cacat != $item2->cacat) {
            $x = $x + 1;
        }
        if ($item1->hobby1 != $item2->hobby1) {
            $x = $x + 1;
        }
        if ($item1->hobby2 != $item2->hobby2) {
            $x = $x + 1;
        }
        if ($item1->hobby3 != $item2->hobby3) {
            $x = $x + 1;
        }
    }

    return $x;
}

/*function status publish*/
function listPublish($id = "status", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it form-control\" $required style='width: 100%;'>";
    $ret .= "<option value=\"1\" " . (($sel == '1') ? "selected" : "") . ">Publish</option>";
    $ret .= "<option value=\"0\" " . (($sel == '0') ? "selected" : "") . ">Tidak Publish</option>";
    $ret .= "</select>";
    return $ret;
}

/*helper sownload*/
function force_download($filename = '', $data = '')
{
    if ($filename == '' or $data == '') {
        return false;
    }

    // Try to determine if the filename includes a file extension.
    // We need it in order to set the MIME type
    if (false === strpos($filename, '.')) {
        return false;
    }

    // Grab the file extension
    $x = explode('.', $filename);
    $extension = end($x);

    // Load the mime types
    if (defined('ENVIRONMENT') and is_file('app/' . ENVIRONMENT . '/mimes.php')) {
        include('app/' . ENVIRONMENT . '/mimes.php');
    } elseif (is_file('app/mimes.php')) {
        include('app/mimes.php');
    }

    // Set a default mime if we can't find it
    if (!isset($mimes[$extension])) {
        $mime = 'application/octet-stream';
    } else {
        $mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
    }

    // Generate the server headers
    if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== false) {
        header('Content-Type: "' . $mime . '"');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Transfer-Encoding: binary");
        header('Pragma: public');
        header("Content-Length: " . strlen($data));
    } else {
        header('Content-Type: "' . $mime . '"');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: no-cache');
        header("Content-Length: " . strlen($data));
    }

    exit($data);
}

/*function ucword berdasarkan database*/
function ucword($string)
{
    $rsword = '';
    $x = 0;
    $rs = \DB::table('a_ucword')->get();
    foreach ($rs as $item) {
        $x++;
        $rsword .= $item->ucword . (($x != count($rs)) ? "|" : "");
    }

    return preg_replace_callback(
        "/\b($rsword)\b/i", //add words here to avoid capitalization
        function ($matches) {
            return strtoupper($matches[1]);
        },
        ucwords(strtolower($string))
    );
}

/* function untuk mendapatkan selisih tanggal kenaikan gaji berkala*/
function getMonth($tmtpens, $tmtkgb)
{
    $rs = \DB::select("SELECT DATEDIFF(\"" . $tmtpens . "\",\"" . $tmtkgb . "\")/30 AS month");
    return $rs[0]->month;
}

/*function terbilang angkat to text*/
function terbilang($x)
{
    $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($x < 12) {
        return " " . $abil[$x];
    } elseif ($x < 20) {
        return terbilang($x - 10) . "  belas";
    } elseif ($x < 100) {
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    } elseif ($x < 200) {
        return " seratus" . terbilang($x - 100);
    } elseif ($x < 1000) {
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    } elseif ($x < 2000) {
        return " seribu" . terbilang($x - 1000);
    } elseif ($x < 1000000) {
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    } elseif ($x < 1000000000) {
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
    }
}

/*function combo list status pns*/
function comboStspns($id = "idstspeg", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" class=\"it\" $required style=\"width:100%\">";
    $ret .= "<option value=\"\" " . (($sel == '') ? 'selected' : '') . ">.: Pilihan :.</option>";
    $ret .= "<option value=\"1\" " . (($sel == '1') ? 'selected' : '') . ">CPNS</option>";
    $ret .= "<option value=\"2\" " . (($sel == '2') ? 'selected' : '') . ">PNS</option>";
    $ret .= "<option value=\"3\" " . (($sel == '3') ? 'selected' : '') . ">PPPK</option>";
    $ret .= "</select>";
    return $ret;
}

function tglFormat($date = '', $flag = 1)
{
    if ($flag == 1) {
        $dateformat = date('Y-m-d', strtotime($date));
    } else {
        $dateformat = date('d-m-Y', strtotime($date));
    }

    return $dateformat;
}

/*function jadwal skpd*/
function getJadwal($role_id = '', $idskpd = '', $role_as = '')
{
    if ($role_as == 5) {
        if (strlen($idskpd) > 2) {
            $cek = \DB::table('users')->where('idskpd', '=', substr($idskpd, 0, 5))->count();
            if ($cek > 0) {
                $rs = \DB::table('users')->whereRaw("role_id = \"" . $role_id . "\" and idskpd = \"" . substr($idskpd, 0, 5) . "\" and NOW() BETWEEN aktif_mulai AND aktif_selesai")->first();
            } else {
                $rs = \DB::table('users')->whereRaw("role_id = \"" . $role_id . "\" and idskpd = \"" . substr($idskpd, 0, 2) . "\" and NOW() BETWEEN aktif_mulai AND aktif_selesai")->first();
            }
        } else {
            $rs = \DB::table('users')->whereRaw("role_id = \"" . $role_id . "\" and idskpd = \"" . $idskpd . "\" and NOW() BETWEEN aktif_mulai AND aktif_selesai")->first();
        }
    } else {
        $rs = \DB::table('users')->whereRaw("role_id = \"" . $role_id . "\" and idskpd = \"" . $idskpd . "\" and NOW() BETWEEN aktif_mulai AND aktif_selesai")->first();
    }

    if (count($rs) > 0) {
        return 1;
    } else {
        return 0;
    }
}

/*function jadwal skpd*/
function getKeterangan($role_id = '', $idskpd = '', $role_as = '')
{
    if ($role_as == 5) {
        if (strlen($idskpd) > 2) {
            $cek = \DB::table('users')->where('idskpd', '=', substr($idskpd, 0, 5))->count();
            if ($cek > 0) {
                $rs = \DB::table('users')->where("role_id", "=", "$role_id")->where("idskpd", "=", substr($idskpd, 0, 5))->first();
            } else {
                $rs = \DB::table('users')->where("role_id", "=", "$role_id")->where("idskpd", "=", substr($idskpd, 0, 2))->first();
            }
        } else {
            $rs = \DB::table('users')->where("role_id", "=", "$role_id")->where("idskpd", "=", $idskpd)->first();
        }
    } else {
        $rs = \DB::table('users')->where("role_id", "=", "$role_id")->where("idskpd", "=", $idskpd)->first();
    }

    if (count($rs) > 0) {
        return $rs->keterangan;
    }
}

/*get kepala skpd/ penandatangan sk kgb*/
function getKepskpd($idskpd = '', $field = '')
{
    $where = "a.idjenkedudupeg not in (99,21)";
    if ($idskpd != '') {
        if (strlen($idskpd) == "2") {
            $skpd = substr($idskpd, 0, 2);
            // $where .=" and a.idjenjab = 20 and a.idskpd = \"".$idskpd."\" ";
            $where .= " and a.idjabjbt = \"" . $idskpd . "\" ";
        } else {
            $skpd = substr($idskpd, 0, 2);
            $where .= " and a.idjabjbt = \"" . $idskpd . "\" ";
        }
    }

    $rs = \DB::table('tb_01 as a')
        ->select(
            'a.nip',
            \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
            'a.idskpd',
            'a.idjenjab',
            'a.idjabjbt',
            'b.skpd',
            'b.jab',
            'b.jab_utuh',
            'c.golru',
            'c.pangkat'
        )
        ->join('a_skpd as b', 'a.idjabjbt', '=', 'b.idskpd')
        ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
        ->whereRaw($where)
        ->first();

    if (count($rs) == 0) {
        $rs = \DB::table('a_skpd as b')
            ->select(
                'a.nip',
                \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
                'a.idskpd',
                'a.idjenjab',
                'a.idjabjbt',
                'b.skpd',
                'c.golru',
                'c.pangkat',
                \DB::raw('concat("Plt. ", b.jab) as jab'),
                \DB::raw('concat("Plt. ", b.jab_utuh) as jab_utuh')
            )
            ->join('tb_01 as a', 'b.plt_nip', '=', 'a.nip')
            ->leftJoin('a_golruang as c', 'a.idgolrupkt', '=', 'c.idgolru')
            ->whereRaw("b.idskpd = \"" . $skpd . "\"")
            ->first();
    }

    if (count($rs) > 0) {
        if ($field != '') {
            return $rs->$field;
        } else {
            return '-';
        }
    } else {
        return '-';
    }
}

/* Alip Prasetyo*/
/*combo list jenis jabatan mutasi*/
function comboJenjabmutasi($id = "idjenjab", $sel = "", $class = "", $required = "")
{
    $ret = '<select id="' . $class . '" name="' . $id . '" class="form-control ' . $class . '" style="width:100%" $required >';
    $ret .= '<option value="">.: Pilihan :.</option>';

    $rs = \DB::table('a_jenjab')->where('idjenjab', '<', '20')->orderBy('order', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjenjab == $sel) ? "selected" : "");
        $ret .= '<option value="' . $item->idjenjab . '"' . $isSel . ' >' . $item->jenjab . '</option>';
    }
    $ret .= '</select>';
    return $ret;
}

/*combo list tingkat pendidikan mutasi*/
function comboTkpendidikanmutasi($id = "idtkpendid", $sel = "", $class = "", $required = "")
{
    $ret = '<select id="' . $class . '" name="' . $id . '" class="form-control ' . $class . '" style="width:100%" $required >';
    $ret .= '<option value="">.: Pilihan :.</option>';

    $rs = \DB::table('a_tkpendid')->orderBy('idtkpendid', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idtkpendid == $sel) ? "selected" : "");
        $ret .= '<option value="' . $item->idtkpendid . '"' . $isSel . ' >' . $item->tkpendid . '</option>';
    }
    $ret .= '</select>';
    return $ret;
}

/*combo list status marital mutasi*/
function comboStsmaritalmutasi($id = "idstskawin", $sel = "", $class = "", $idx = "", $required = "")
{
    $ret = '<select id="' . $class . '" name="' . $id . '" idx="' . $idx . '" class="form-control ' . $class . '" style="width:100%" $required >';
    $ret .= '<option value="">.: Pilihan :.</option>';

    $rs = \DB::table('a_stskawin')->orderBy('idstskawin', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idstskawin == $sel) ? "selected" : "");
        $ret .= '<option value="' . $item->idstskawin . '"' . $isSel . ' >' . $item->stskawin . '</option>';
    }
    $ret .= '</select>';
    return $ret;
}

function getPenetapsk($id = "", $field = "")
{
    $data = \DB::table('a_penetapsk')->select('a_penetapsk.*')->where('id', '=', $id)->first();

    if ($field != "") {
        $dt = $data->$field;
    } else {
        $dt = "";
    }

    return $dt;
}
/* Alip Prasetyo*/

/*START OF REZA 2-Maret-2018*/
function getSkpdgroup($idskpd, $idpath = '')
{
    $path = '';

    if ($idpath != '') {
        $cek = \DB::table('a_skpd')->where('idskpd', substr($idpath, 0, 5))->first();
        if (substr($cek->skpd, 0, 9) == 'KELURAHAN') {
            $path .= $cek->skpd . " ";
        } elseif (substr($cek->skpd, 0, 15) == 'UPT RUMAH SAKIT') {
            $path .= $cek->skpd . " ";
        }
    }
    $rs = \DB::table('a_skpd')->where('idskpd', $idskpd)->first();
    return @$path . "" . @$rs->skpd;
}
function getSkpdgroupMutDalam($idskpd, $idpath = '')
{
    $path = '';

    if ($idpath != '') {
        $cek = \DB::table('a_skpd')->where('idskpd', substr($idpath, 0, 5))->first();
        if (substr($cek->skpd, 0, 9) == 'KELURAHAN') {
            $path .= $cek->skpd . " ";
        } elseif (substr($cek->skpd, 0, 15) == 'UPT RUMAH SAKIT') {
            $path .= $cek->skpd . " ";
        }
    }
    $rs = \DB::table('a_skpd')->where('idskpd', $idskpd)->first();
    if (substr($idskpd, 0, 2) == 03) {
        return $rs->jab . " Kabupaten Kendal";
    }
    return $rs->jab;
}
/*START OF REZA 2-Maret-2018*/
function getSkpdgroupjab($idskpd, $idpath = '')
{
    $path = '';

    if ($idpath != '') {
        $cek = \DB::table('a_skpd')->where('idskpd', substr($idpath, 0, 5))->first();
        if (substr($cek->skpd, 0, 9) == 'KELURAHAN') {
            $path .= $cek->jab . " ";
        } elseif (substr($cek->jab, 0, 15) == 'UPT RUMAH SAKIT') {
            $path .= $cek->jab . " ";
        }
    }
    $rs = \DB::table('a_skpd')->where('idskpd', $idskpd)->first();
    return $path . "" . $rs->jab;
}

function comboPenMutLuar($id = "penetapsk_kanreg", $sel = "", $required = "")
{
    $ret = '<select id="' . $id . '" name="' . $id . '" class="form-control " style="width:100%" $required >';
    $ret .= '<option value="">.: Pilihan :.</option>';

    $rs = \DB::table('a_penetapsk')->where('mutluarkab', '=', '1')->orderBy('id', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->jabatan == $sel) ? "selected" : "");
        $ret .= '<option value="' . $item->jabatan . '"' . $isSel . ' >' . $item->jabatan . '</option>';
    }
    $ret .= '</select>';
    return $ret;
}

function getTembusanDalamOPD($idskpd, $idskpdbaru)
{
    $path = '';
    $jos  = '';
    // echo strlen($idskpd)."  ".strlen($idskpdbaru);
    // echo substr($idskpdbaru,0,5);
    // exit();

    if (substr($idskpd, 0, 2) == 04 || substr($idskpdbaru, 0, 2) == 04 && $idskpdbaru != 04 && $idskpd != 04) {
        $rs = \DB::table('a_skpd')->where('idskpd', '=', '04')->first();
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs->jab . ' Kabupaten Kendal;
        </span></li>';
        if (strlen($idskpd) >= 5) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpd, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
        if (strlen($idskpdbaru) >= 5 && substr($idskpd, 0, 5) != substr($idskpdbaru, 0, 5)) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpdbaru, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
    }

    if (substr($idskpd, 0, 2) == 05 || substr($idskpdbaru, 0, 2) == 05 && $idskpdbaru != 05 && $idskpd != 05) {
        $rs = \DB::table('a_skpd')->where('idskpd', '=', '05')->first();
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs->jab . ' Kabupaten Kendal;
        </span></li>';
        if (strlen($idskpd) >= 5) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpd, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
        if (strlen($idskpdbaru) >= 5 && substr($idskpd, 0, 5) != substr($idskpdbaru, 0, 5)) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpdbaru, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
    }

    $rs = \DB::table('a_skpd')->where('idskpd', substr($idskpd, 0, 2))->first();
    // $jos1= $path."".$rs->skpd;

    if (substr($idskpd, 0, 2) == 04 || substr($idskpdbaru, 0, 2) == 05 || substr($idskpd, 0, 2) == 05 || substr($idskpdbaru, 0, 2) == 05) {
        return $jos;
    } else {
        //komen candra 17012024
        // $jos .= '<li>
        // <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        // '.$rs->jab.' Kabupaten Kendal;
        // </span></li>'; 
        //end komen candra 17012024
        //tambahan candra 17012024
        if (strlen($idskpd) >= 5) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpd, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
        if (strlen($idskpdbaru) >= 5 && substr($idskpd, 0, 5) != substr($idskpdbaru, 0, 5)) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpdbaru, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
        //end tambahan candra 1701204
    }
    return $jos;
}

function getTembusanAntarOPD($idskpd, $idskpdbaru)
{
    $path = '';
    $jos  = '';
    // echo $idskpd."  ".$idskpdbaru;
    // echo strlen($idskpd)."  ".strlen($idskpdbaru);
    // echo substr($idskpdbaru,0,5);
    // exit();

    $jos .= '<li>
    <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
    Bupati Kendal;
    </span></li>';

    if (substr($idskpd, 0, 2) == 04 || substr($idskpdbaru, 0, 2) == 04 && $idskpdbaru != 04 && $idskpd != 04) {
        $rs = \DB::table('a_skpd')->where('idskpd', '=', '04')->first();
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs->jab . ' Kabupaten Kendal;
        </span></li>';
        if (strlen($idskpd) >= 5) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpd, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
        if (strlen($idskpdbaru) >= 5 && substr($idskpd, 0, 5) != substr($idskpdbaru, 0, 5)) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpdbaru, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
    }

    if (substr($idskpd, 0, 2) == 05 || substr($idskpdbaru, 0, 2) == 05 && $idskpdbaru != 05 && $idskpd != 05) {
        $rs = \DB::table('a_skpd')->where('idskpd', '=', '05')->first();
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs->jab . ' Kabupaten Kendal;
        </span></li>';
        if (strlen($idskpd) >= 5) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpd, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
        if (strlen($idskpdbaru) >= 5 && substr($idskpd, 0, 5) != substr($idskpdbaru, 0, 5)) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpdbaru, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
    }

    $rs = \DB::table('a_skpd')->where('idskpd', substr($idskpd, 0, 2))->first();
    $rs1 = \DB::table('a_skpd')->where('idskpd', substr($idskpdbaru, 0, 2))->first();
    /*Khusus Sekda*/
    if (substr($idskpd, 0, 2) == 01 && strlen($idskpd) <= 8) {
        $rs = \DB::table('a_skpd')->where('idskpd', substr($idskpd, 0, 8))->first();
    }
    if (substr($idskpdbaru, 0, 2) == 01 && strlen($idskpdbaru) <= 8) {
        $rs1 = \DB::table('a_skpd')->select(
            \DB::raw('CONCAT("Kepala ",path_short) as jab')
        )
            ->where('idskpd', substr($idskpdbaru, 0, 8))->first();
    }

    // $jos1= $path."".$rs->skpd;
    // if(substr($idskpd, 0,2) == 04 || substr($idskpd, 0,2) == 05 || substr($idskpdbaru, 0,2) == 04 || substr($idskpdbaru, 0,2) == 05)
    // {
    // 	return $jos;
    // }else
    // $jos .= '<li>
    //     <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
    //     '.$idskpd.' - '.$idskpdbaru.' - '.substr($idskpdbaru, 0,8).' - JML1:'.strlen($idskpd).'- JML:'.strlen($idskpdbaru).';
    //     </span></li>';
    // dd(DB::getQueryLog());->View Last Query
    if (substr($idskpd, 0, 2) == 04 || substr($idskpd, 0, 2) == 05) {
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs1->jab . ' Kabupaten Kendal;
        </span></li>';
        return $jos;
    } elseif (substr($idskpdbaru, 0, 2) == 04 || substr($idskpdbaru, 0, 2) == 05) {
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs->jab . ' Kabupaten Kendal;
        </span></li>';
        return $jos;
    } else {
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs->jab . ' Kabupaten Kendal;
        </span></li>';
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs1->jab . ' Kabupaten Kendal;
        </span></li>';
    }
    return $jos;
}

function getTujuanMutLuar($idpemerintah)
{
    $rs = \DB::table('tr_mutasi_jenis_pemerintah')->where('id', $idpemerintah)->first();
}
/*End Of REZA*/

/*cobo list jab asn*/
function comboJabasn($id = "idjabasn", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jabasn')->orderBy('idjabasn', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idjabasn == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idjabasn . "\" $isSel >" . $item->jabasn . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}
/*End Of Simpegonline*/
/*REZA REVISI MAS BUDIUNTUK ANTAR OPD KHUSUS KEJADIAN CPNS*/
function getTembusanAntarOPDJikaCPNS($idskpdbaru)
{
    $path = '';
    $jos  = '';

    $jos .= '<li>
    <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
    Kepala Badan Keuangan Daerah Kabupaten Kendal.
    </span></li>';

    $rsskpdnyaawaluntukmenandaisaja = \DB::table('a_skpd')->where('idskpd', $idskpdbaru)->first();;

    if (substr($idskpdbaru, 0, 2) == 04 && $idskpdbaru != 04 && substr($idskpdbaru, 0, 2) != 27) {
        $rs = \DB::table('a_skpd')->where('idskpd', '=', '04')->first();
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs->jab . ' Kabupaten Kendal;
        </span></li>';

        if (strlen($idskpdbaru) >= 5 && $rsskpdnyaawaluntukmenandaisaja->issek != 2) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpdbaru, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
    }

    // if(substr($idskpdbaru,0,2) == 05 && $idskpdbaru != 05){
    if (substr($idskpdbaru, 0, 2) == 05 && substr($idskpdbaru, 0, 2) != 27) {
        $rs = \DB::table('a_skpd')->where('idskpd', '=', '05')->first();
        $jos .= '<li>
        <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
        ' . $rs->jab . ' Kabupaten Kendal;
        </span></li>';
        if (strlen($idskpdbaru) >= 5) {
            $rs = \DB::table('a_skpd')->where('idskpd', '=', substr($idskpdbaru, 0, 5))->first();
            $jos .= '<li>
            <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
            ' . $rs->jab . ' Kabupaten Kendal;
            </span></li>';
        }
    }

    $rs1 = \DB::table('a_skpd')->where('idskpd', substr($idskpdbaru, 0, 2))->first();

    if (substr($idskpdbaru, 0, 2) == 01 && strlen($idskpdbaru) <= 8 && substr($idskpdbaru, 0, 2) != 27) {
        $rs1 = \DB::table('a_skpd')->select(
            \DB::raw('CONCAT("Kepala ",path_short) as jab')
        )
            ->where('idskpd', substr($idskpdbaru, 0, 8))->first();
    }

    $rskepalasek = \DB::table('a_skpd')->where('idskpd', $idskpdbaru)->first();
    if ($rskepalasek->issek == '1' || $rskepalasek->issek == '2' && substr($idskpdbaru, 0, 2) != 27) {
        $jos .= '<li>
       <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
       ' . $rskepalasek->jab . ' Kabupaten Kendal;
       </span></li>';
    }

    if (substr($idskpdbaru, 0, 2) != 04 && substr($idskpdbaru, 0, 2) != 05 && substr($idskpdbaru, 0, 2) != 27) {
        $jos .= '<li>
    <span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
    ' . $rskepalasek->jab . ' Kabupaten Kendal;
    </span></li>';
    }

    $jos .= '<li>
<span style="font-size:16px; font-family:arial,helvetica,sans-serif; line-height: 14.76px; margin-left: 0px;">
Pertinggal.
</span></li>';

    return $jos;
}

/*ledger gaji rendyamdani*/
/*combo list bulan*/
function comboBulangaji($id = "bulan", $sel = "", $required = "", $holder = ".: Pilihan :.")
{
    $month2[1] = "Januari";
    $month2[2] = "Februari";
    $month2[3] = "Maret";
    $month2[4] = "April";
    $month2[5] = "Mei";
    $month2[6] = "Juni";
    $month2[7] = "Juli";
    $month2[8] = "Agustus";
    $month2[9] = "September";
    $month2[10] = "Oktober";
    $month2[11] = "November";
    $month2[12] = "Desember";
    $month2[13] = "Gaji 13";
    $month2[14] = "Gaji 14";
    $month2[15] = "Rapel Gaji";
    $html = "<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $now = '';
    $html .= "<option value=''>" . $holder . "</option>";
    for ($i = 1; $i <= 15; $i++) {
        $bulan = $month2[$i];
        if (strlen($i) == 1) {
            $i = "0" . $i;
        }
        if ($i == $sel) {
            $html .= "<option value='$i' selected>$i | $bulan</option>";
        } else {
            $html .= "<option value='$i'>$i | $bulan</option>";
        }
        $now = 1;
        $now = $now + $i;
    }
    $html .= "</select>";
    return $html;
}
/*end of ledger gaji rendyamdani*/
/*Start Of Reza 18 April 2019 E-Cuti*/
/*Combo Jenis Cuti*/
function comboJenisCuti($id = "", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control $id\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_jenis_cuti')->orderBy('id', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->id == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->id . "\" $isSel >" . $item->jenis_cuti . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}


/*function untuk mendapatkan Jenis Cuti*/
function getJenisCuti($id_jenis_cuti)
{
    $rs = \DB::table('a_jenis_cuti')->where('id', $id_jenis_cuti)->first();
    if (count($rs) > 0) {
        return $rs->jenis_cuti;
    } else {
        return '';
    }
}
function getStatusCuti($status)
{
    if ($status == 0) {
        $feed = '<span style="color:orange;"><i class="fa fa-clock-o" title="Sedang diproses"/></span>';
    } elseif ($status == 1) {
        $feed = '<span style="color:green;"><i class="fa fa-check-circle" title="Selesai diproses"/></span>';
    } elseif ($status == 2) {
        $feed = '<span style="color:orange;"><i class="fa fa-pencil-square-o" title="Perubahan"/></span>';
    } elseif ($status == 3) {
        $feed = '<span style="color:red;"><i class="fa fa-clock-o" title="Ditangguhkan"/></span>';
    } elseif ($status == 4) {
        $feed = '<span style="color:red;"><i class="fa fa-times-circle" title="Tidak Memenuhi Syarat"/></span>';
    } else {
        $feed = '-';
    }

    return $feed;
}


/*Function Untuk Cek usulan sudah ada yang di setujui */
function CekNominatifSudahAdaYangDisetujui($nousul)
{
    $rs = \DB::table('tr_ijin_cuti')->select(\DB::raw('COUNT(*) AS sudahadabelum'))->where('nousul', $nousul)->where('opd_status', 1)->first();
    return $rs->sudahadabelum;
}

/*Function Untuk Cek usulan sudah ada yang di setujui */
function CekPegawaiPadaNoUsulCuti($nousul, $nip)
{
    $rs = \DB::table('tr_ijin_cuti')->select(\DB::raw('COUNT(*) AS ceknip'))->where('nousul', $nousul)->where('nip', $nip)->first();
    return $rs->ceknip;
}

/*Combo status usulan OPD*/
function comboStatususulan($id = '', $selected = "")
{
    $h = "<select id='$id' name='$id' class='menuselect' style='width:100%'>";
    $h .= '<option value="">.: Status Usulan :.</option>';
    $h .= '<option ' . (($selected == '1') ? 'selected' : '') . ' value="1">Disetujui</option>';
    $h .= '<option ' . (($selected == '2') ? 'selected' : '') . ' value="2">Perubahan</option>';
    $h .= '<option ' . (($selected == '3') ? 'selected' : '') . ' value="3">Ditangguhkan</option>';
    $h .= '<option ' . (($selected == '4') ? 'selected' : '') . ' value="4">Tidak Disetujui</option>';
    $h .= '</select>';
    return $h;
}

/*Function untuk menampilkan status usulan*/
function getStatusUsulan($status)
{
    if ($status == 1) {
        $ket_status = "Disetujui";
    } elseif ($status == 2) {
        $ket_status = "Perubahan";
    } elseif ($status == 3) {
        $ket_status = "Ditangguhkan";
    } elseif ($status == 4) {
        $ket_status = "Tidak Disetujui";
    } elseif ($status == 0) {
        $ket_status = "Sedang Diproses";
    }

    return $ket_status;
}

function getWarnaBgStatusCuti($status)
{
    if ($status == 2) {
        $warna_bg = "#fff568";
    } elseif ($status == 3) {
        $warna_bg = "#f8c333";
    } elseif ($status == 4) {
        $warna_bg = "#e14031";
    } else {
        $warna_bg = '-';
    }

    return $warna_bg;
}

function getCentangCuti($status, $template)
{
    if ($status == $template) {
        $centang = "&radic;";
    } else {
        $centang = "";
    }
    return $centang;
}

/*Function Untuk Hitung Jumlah Yang Perlu DIverifikasi CUTI*/
function HitungNotifVerifAtasan($atasan_nip)
{
    $rs = \DB::table('tr_ijin_cuti')
        ->select(\DB::raw('COUNT(*) AS butuh_verif'))
        ->where('atasan_nip', $atasan_nip)
        ->where('opd_status', '1')
        ->where('atasan_status', '0')
        ->first();

    return $rs->butuh_verif;
}
function HitungNotifVerifWewenang($wewenang_nip)
{
    $rs = \DB::table('tr_ijin_cuti')
        ->select(\DB::raw('COUNT(*) AS butuh_verif'))
        // ->where('atasan_status', '1')
        ->where('wewenang_nip', $wewenang_nip)
        ->where('wewenang_status', '0')
        ->first();

    return $rs->butuh_verif;
}
/*UNTUK ADMIN*/
function HitungNotifVerifAtasanUntukAdmin()
{
    $where = " atasan_nip = '-' OR atasan_idskpd = '01' AND atasan_status != 1";
    $rs = \DB::table('tr_ijin_cuti')
        ->select(\DB::raw('COUNT(*) AS butuh_verif'))
        ->where('opd_status', '1')
        ->where('atasan_status', '0')
        ->whereRaw($where)
        ->first();

    return $rs->butuh_verif;
}
function HitungNotifVerifWewenangUntukAdmin()
{
    $where = " wewenang_status != 1 AND (wewenang_nip = '-' OR wewenang_idskpd = '01') ";
    $rs = \DB::table('tr_ijin_cuti')
        ->select(\DB::raw('COUNT(*) AS butuh_verif'))
        // ->where('atasan_status', '1')
        // ->where('wewenang_status', '0')
        ->whereRaw($where)
        ->first();

    return $rs->butuh_verif;
}

/*Function Untuk Ngecek Hari Libur*/
function CheckHariLibur($tgl_mulai, $tgl_selesai)
{
    $rs = \DB::table('a_libur_nasional')
        ->select(\DB::raw('COUNT(*) AS jumlah_hari_libur'))
        ->whereRaw("(tgl BETWEEN '" . $tgl_mulai . "' AND '" . $tgl_selesai . "')")
        ->first();

    return $rs->jumlah_hari_libur;
}

/*Function Untuk Ngecek Hari Libur*/
function CheckLibur($tgl)
{
    $rs = \DB::table('a_libur_nasional')
        ->select(\DB::raw('COUNT(*) AS liburnggak'))
        ->whereRaw("tgl = '" . $tgl . "'")
        ->first();

    return $rs->liburnggak;
}
/*GET DATA RIWAYAT CUTI TERBARU*/
function getIdCutiTerbaru($nip)
{
    $rs = \DB::table('view_kuota_cuti')
        ->select(\DB::raw('id'))
        ->whereRaw("nip = '" . $nip . "'")
        ->first();

    if (count($rs) > 0) {
        return $rs->id;
    } else {
        return 0;
    }
}

function Hitung_Hari_Pada_Bulan($cabul, $tacok)
{
    return $cabul == 2 ? ($tacok % 4 ? 28 : ($tacok % 100 ? 29 : ($tacok % 400 ? 28 : 29))) : (($cabul - 1) % 7 % 2 ? 30 : 31);
}

function getJarakDuaTanggal($tanggal1, $tanggal2)
{
    $tanggal1 = new DateTime($tanggal1);
    $tanggal2   = new DateTime(); // tanggal sekarang berdasarkan tanggal di komputer
    $jarakdalamhari = $tanggal2->diff($tanggal)->format("%a");

    return $jarakdalamhari;
}

/* function untuk menampilkan usia */
function getJarakDuaTanggal2($tanggal1, $tanggal2)
{
    $today = date_create("2018/07/01");
    $birthday = date_create($dob);
    $diff = date_diff($today, $birthday);
    $umur = date_interval_format($diff, "%y tahun, %m bulan, %d hari");

    return $umur;
}

function getJarakDuaTanggal3($tanggal1, $tanggal2)
{
    $umur = "";
    $date1 = new DateTime($tanggal1);
    $date2 = new DateTime($tanggal2);
    $interval = $date1->diff($date2);
    $years = $interval->format('%y');
    $months = $interval->format('%m');
    $days = $interval->format('%d');
    if ($years != 0) {
        $umur .= $years . " Tahun ";
    }
    if ($months != 0) {
        $umur .= $months . " Bulan ";
    }
    if ($days != 0) {
        $umur .= $days . " Hari";
    }

    return $umur;
}
/*Cek Tahun Kabisat*/
function cekKabisat($tahun)
{
    if ($tahun % 400 == 0) {
        $kabisat  = 1;
    } elseif (($tahun % 4 == 0) && ($tahun % 100 != 0) && ($tahun % 400 != 0)) {
        $kabisat  =  1;
    } else {
        $kabisat  = 0;
    }
    return $kabisat;
}

/*KERJAAN NGAWUR SEBELUM PERANG 05 agustus 2019*/
function Ceksisakuotacuti($nip, $id_jenis_cuti)
{
    $rs = \DB::table('view_kuota_cuti')->where('nip', $nip)->first();
    if (count($rs) > 0) {
        if ($id_jenis_cuti == 1) {
            $sisa_kuota = ($rs->kuota_tahunan_n2 + $rs->kuota_tahunan_n1 + $rs->kuota_tahunan_n);
        } elseif ($id_jenis_cuti == 2) {
            $sisa_kuota = $rs->kuota_besar;
        } elseif ($id_jenis_cuti == 3) {
            $sisa_kuota = $rs->kuota_sakit;
        } elseif ($id_jenis_cuti == 4) {
            $sisa_kuota = $rs->kuota_melahirkan;
        } elseif ($id_jenis_cuti == 5) {
            $sisa_kuota = $rs->kuota_penting;
        } elseif ($id_jenis_cuti == 6) {
            $sisa_kuota = $rs->kuota_diluarnegara;
        }
    } else {
        $sisa_kuota = 24;
    }

    return $sisa_kuota;
}

function time_since($original)
{
    date_default_timezone_set('Asia/Jakarta');
    $chunks = array(
        array(60 * 60 * 24 * 365, 'tahun'),
        array(60 * 60 * 24 * 30, 'bulan'),
        array(60 * 60 * 24, 'hari'),
    );

    $today = time();
    $since = $original - $today;

    // if ($since > 604800)
    // {
    //   $print = date("d", $original);
    //   if ($since > 31536000)
    //   {
    //     $print .= ", " . date("Y", $original);
    //   }
    //   return $print."a";
    // }

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];

        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
    return $print;
}

function HitungCutiTerpakai($nip, $id_jenis_cuti)
{
    $tahun = date('Y');
    if ($id_jenis_cuti == 1) {
        $rs1 = \DB::table('tr_ijin_cuti')->select(\DB::raw('SUM(lama_cuti) AS terpakai'))
            ->where('nip', $nip)
            ->where('id_jenis_cuti', $id_jenis_cuti)
            ->where('wewenang_status', 1)
            ->whereRaw('YEAR(tgl_mulai) = ' . $tahun . ' ')
            ->first();
        $rs2 = \DB::table('tr_ijin_cuti')->select(\DB::raw('SUM(lama_cuti) AS terpakai'))
            ->where('nip', $nip)
            ->where('id_jenis_cuti', $id_jenis_cuti)
            ->where('wewenang_status', 1)
            ->whereRaw('YEAR(tgl_mulai) = ' . ($tahun - 1) . ' ')
            ->first();
        $rs3 = \DB::table('tr_ijin_cuti')->select(\DB::raw('SUM(lama_cuti) AS terpakai'))
            ->where('nip', $nip)
            ->where('id_jenis_cuti', $id_jenis_cuti)
            ->where('wewenang_status', 1)
            ->whereRaw('YEAR(tgl_mulai) = ' . ($tahun - 2) . ' ')
            ->first();
        $b = ($rs2->terpakai > 6) ? $rs2->terpakai = 6 : $rs2->terpakai;
        $c = ($rs3->terpakai > 6) ? $rs3->terpakai = 6 : $rs3->terpakai;
        $terpakai = ($rs1->terpakai + $b + $c);
    } else {
        $rs = \DB::table('tr_ijin_cuti')->select(\DB::raw('SUM(lama_cuti) AS terpakai'))
            ->where('nip', $nip)
            ->where('id_jenis_cuti', $id_jenis_cuti)
            ->where('wewenang_status', 1)
            ->whereRaw('YEAR(tgl_mulai) = ' . $tahun . ' ')
            ->first();
        $terpakai = ($rs->terpakai <= 0) ? $rs->terpakai = 0 : $rs->terpakai;
    }
    return $terpakai;
}
/*STATR 9 Agustus 2019*/
/*GET UNIT KERJA dan Kondisi di DISDIK, DINKES, SEKRETARIAT*/

/*Function Get SKPD SK CUTI*/
function getSkpdUntukCuti($idskpd)
{
    $dua_digit = substr($idskpd, 0, 2);
    $empat_digit = substr($idskpd, 0, 5);
    if ($dua_digit == 04 && strlen($idskpd) != 2) {
        $rs1 = \DB::table('a_skpd')->where('idskpd', $idskpd)->first();
        $rs2 = \DB::table('a_skpd')->where('idskpd', $dua_digit)->first();

        // if(strlen($idskpd) >= 5)
        // {
        //     $rs1 = \DB::table('a_skpd')->where('idskpd', substr($idskpd,0,5))->first();
        // }

        $unit_kerja = $rs1->skpd . " " . $rs2->skpd;
    } elseif ($dua_digit == 05 && strlen($idskpd) != 2) {
        $rs1 = \DB::table('a_skpd')->where('idskpd', $idskpd)->first();
        $rs2 = \DB::table('a_skpd')->where('idskpd', $dua_digit)->first();
        if (strlen($idskpd) >= 5) {
            $rs1 = \DB::table('a_skpd')->where('idskpd', substr($idskpd, 0, 5))->first();
        }
        $unit_kerja = $rs1->skpd . " " . $rs2->skpd;
    } elseif ($dua_digit == 01 && strlen($idskpd) != 2) {
        $rs1 = \DB::table('a_skpd')->where('idskpd', $idskpd)->first();
        $rs2 = \DB::table('a_skpd')->where('idskpd', $dua_digit)->first();
        if (strlen($idskpd) >= 8) {
            $rs1 = \DB::table('a_skpd')->where('idskpd', substr($idskpd, 0, 8))->first();
        }
        $unit_kerja = $rs1->skpd . " " . $rs2->skpd;
    } else {
        $rs = \DB::table('a_skpd')->where('idskpd', $dua_digit)->first();
        $unit_kerja = $rs->skpd;
    }

    // $unit_kerja .= " - ".$idskpd;
    return $unit_kerja;
}
/*ENDOF*/

/*Function Untuk hitung anak kandung*/
function Hitanakkandung($nip, $tmtcpn, $tgskcalonawal_pppk, $idstspeg)
{
    if ($idstspeg == 3) {
        $where = "nip = '" . $nip . "' AND YEAR(tglhr) > '" . substr($tgskcalonawal_pppk, 0, 4) . "' ";
    } else {
        $where = "nip = '" . $nip . "' AND YEAR(tglhr) > '" . substr($tmtcpn, 0, 4) . "' ";
    }
    /*KONDISI ANAK KANDUNG*/
    $where .= " AND stskeluarga = 'Anak Kandung'";
    $rs = \DB::table('r_anak')
        ->select(\DB::raw('COUNT(*) as jml'))
        ->whereRaw($where)
        ->first();

    return $rs->jml;
}
/*ENDOF*/

/*Function Get Jarak Kuota Cuti*/
function getTanggalKuota($kuota)
{
    $kuota = ($kuota != "") ? $kuota : 0;
    $rs1  = \DB::table('view_kuota_cuti')->select(\DB::raw("DATE_ADD(NOW(),INTERVAL FLOOR(" . $kuota . ") DAY) as tgl1"), \DB::raw("NOW() as tgl2"))->first();
    $jarak = "";
    $tgl1 = date("Y-m-d", strtotime($rs1->tgl1));
    $tgl2 = date("Y-m-d", strtotime($rs1->tgl2));
    $date1 = new DateTime($tgl1);
    $date2 = new DateTime($tgl2);
    $interval = $date1->diff($date2);
    $years = $interval->format('%y');
    $months = $interval->format('%m');
    $days = $interval->format('%d');
    if ($years != 0) {
        $jarak .= $years . " Tahun ";
    }
    if ($months != 0) {
        $jarak .= $months . " Bulan ";
    }
    if ($days != 0) {
        $jarak .= $days . " Hari";
    }
    if ($years == 0 && $months == 0 && $days == 0) {
        $jarak = "";
    }

    return $jarak;
}
/*END OF Function Get Jarak Kuota Cuti*/

/*Start Of Reza 10 Sept 2019*/
function HitungPenyusuaian($tahun, $bulan, $hari)
{
    $total = 0;
    if ($tahun != 0) {
        $total += (365.25 * $tahun);
    }
    if ($bulan != 0) {
        $total += (30.44 * $bulan);
    }
    if ($hari != 0) {
        $total += (1 * $hari);
    }
    return $total;
}
/*EndOf*/

/*GET DATA RIWAYAT CUTI By NIP*/
function CheckAdaDiRiwayatCuti($nip)
{
    $rs = \DB::table('view_kuota_cuti')
        ->select(\DB::raw('count(*) as jml'))
        ->whereRaw("nip = '" . $nip . "'")
        ->first();

    if ($rs->jml != 0) {
        return 1;
    } else {
        return 0;
    }
}

/*GETRIWAYAT CUTI BY NIP dan Where Kondisional*/
function getRiwayatcuti($nip, $id_jenis_cuti, $tahun)
{
    $where = "nip = '" . $nip . "' ";
    if ($id_jenis_cuti != "") {
        $where .= " AND jencuti = '" . $id_jenis_cuti . "' ";
    }
    if ($tahun != "") {
        $where .= " AND thn = '" . $tahun . "' ";
    }

    $rs = \DB::table('view_kuota_cuti')
        ->select('*', \DB::raw('SUM(jmlhari) as lama_cuti'), \DB::raw('COUNT(*) as jml'))
        ->whereRaw($where)
        ->first();

    return $rs;
}

function usiaTahunBulan($tanggal_lahir)
{
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime("today");
    if ($birthDate > $today) {
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y . " thn " . $m . " bln";
}
/*start function simpeg pppk 07-12-2021*/
function comboStsPegawai($id = "idstspeg", $sel = "", $required = "", $name = "idstspeg[]")
{
    $ret = "<select id=\"$id\" name=\"$name\" $required style='width: 100%;' class=\"idstspeg form-control\" data-placeholder=\".: Pilihan :.\">";
    $ret .= "<option value=\"1\" " . (($sel == '1') ? 'selected' : '') . ">CPNS</option>";
    $ret .= "<option value=\"2\" " . (($sel == '2') ? 'selected' : '') . ">PNS</option>";
    $ret .= "<option value=\"3\" " . (($sel == '3') ? 'selected' : '') . ">PPPK</option>";
    $ret .= "</select>";
    return $ret;
}

function comboGolrupppk($id = "idgolru", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('a_golruang')->orderBy('idgolru', 'asc')->get();
    foreach ($rs as $item) {
        $isSel = (($item->idgolru == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->idgolru . "\" $isSel >" . $item->golru_p3k . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}
/*end of function simpeg pppk 07-12-2021*/

// combo list  angka
function comboTambahangka($id = 'tambahangka', $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = 0;
    for ($i = 1; $i <= $rs + 40; $i++) {
        $ret .= "<option value='$i' " . (($i == $sel) ? "selected" : "") . ">$i</option>";
    }
    $ret .= "</select>";
    return $ret;
}

function comboTmtakhirkontrak($id = "tmtakhirakhir_pppk", $sel = "", $required = "")
{
    $ret = "<select id=\"$id\" name=\"$id\" $required style='width: 100%;' class=\"form-control\">";
    $ret .= "<option value=\"\">.: Pilihan :.</option>";

    $rs = \DB::table('tb_01')->select('tmtakhirakhir_pppk')->where('tmtakhirakhir_pppk', '!=', '0000-00-00')->orderBy('tmtakhirakhir_pppk', 'desc')->groupby('tmtakhirakhir_pppk')->get();
    foreach ($rs as $item) {
        $datetime = new \Datetime($item->tmtakhirakhir_pppk);
        $format = 'd-m-Y';
        $isSel = (($item->tmtakhirakhir_pppk == $sel) ? "selected" : "");
        $ret .= "<option value=\"" . $item->tmtakhirakhir_pppk . "\" $isSel >" . $datetime->format($format) . "</option>";
    }
    $ret .= "</select>";
    return $ret;
}

/*function untuk call api*/
function callApi($method, $url, $data = false)
{
    $ch = curl_init();
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $json = curl_exec($ch);
    if (!$json) {
        echo curl_error($ch);
    }

    curl_close($ch);
    $res = json_decode($json);
    return $res;
}

// konversi tanggal format ke Y-m-d by Pahamu
// @param $date = string tanggal awal yang mau diubah
// @param $awal = string format tanggal awal
// @retutn $date = string tanggal dengan format yang diinginkan
function dateParseYmd($date, $format = 'd-m-Y')
{
    $mdate = date_parse_from_format($format, $date);
    return $mdate['year'] . "-" . $mdate['month'] . "-" . $mdate['day'];
}

/*module integrasi taspen*/
function accessTokentaspen()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => env("API_TASPEN_BASE_URI") . '/user/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'email=' . env("TASPEN_ID") . '&password=' . env("TASPEN_PASSWORD"),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: cookiesession1=678B286CKLMNOPQSTUVWXYZABCDE0E41'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $obj = json_decode($response);
    $token = $obj->{'token'};
    return $token;
}

/*functio unutk menampilkan data pegawai taspen*/
function getDatapegawaitaspen()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => env("API_TASPEN_BASE_URI") . '/v1/simgaji/getSimpegKendal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "kddati1": "11",
            "kddati2": "13"
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . accessTokentaspen(),
            'Content-Type: text/plain',
            'Cookie: cookiesession1=678B286CKLMNOPQSTUVWXYZABCDE0E41'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $obj = json_decode($response);
    $data = $obj->{'result'};
    return $data->data;
}

/*function untuk simpan data integrasi taspen*/
function postSavetaspen($param = '')
{
    $curl = curl_init();
    $data = json_encode($param);
    curl_setopt_array($curl, array(
        CURLOPT_URL => env("API_TASPEN_BASE_URI") . '/v1/simgaji/postSimpegKendal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . accessTokentaspen()
        ),
    ));

    $response = curl_exec($curl);
    $json = $response;
    $obj = json_decode($json);

    curl_close($curl);
    return $obj->result;
}
/*end of module integrasi taspen*/

function comboStatusTTE($id = 'status_tte', $selected = "", $usul = true)
{
    $html = "<select id='$id' name='$id' style='width:100%' class='form-control'>";
    $html .= '<option value="">.: Status TTE :.</option>';
    if ($usul) {
        $html .= '<option ' . (($selected == 'belum_mengusulkan') ? 'selected' : '') . ' value="belum_mengusulkan">Belum mengusulkan</option>';
    }
    $html .= '<option ' . (($selected == '0') ? 'selected' : '') . ' value="0">Mengusulkan</option>';
    $html .= '<option ' . (($selected == '1') ? 'selected' : '') . ' value="1">Selesai</option>';
    $html .= '</select>';
    return $html;
}

function getNotifikasi($nip)
{
    $rs = \DB::select("
        SELECT 'Biodata' as perubahan, 'Biodata' AS tentang, '2' as idjnsaksi, status, ketditolak, created_at FROM tb_01_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat Golongan' as perubahan, nosk AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_gol_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat Jabatan' as perubahan, jab AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_jab_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat KGB' as perubahan, noskkgb AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_kgb_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat Pendidikan' as perubahan, jenjurusan AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_pend_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat Dikstru' as perubahan, dikstru AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_dikstru_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat Dikfung' as perubahan, dikfung AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_dikfung_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat Diktek' as perubahan, nmdiktek AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_diktek_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat Hukdis' as perubahan, nosk AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_hukdis_temp WHERE nip = \"" . $nip . "\" and status = 2 UNION
        SELECT 'Riwayat PPPK' as perubahan, no_spk AS tentang, idjnsaksi, status, ketditolak, created_at FROM r_pppk_temp WHERE nip = \"" . $nip . "\" and status = 2;
    ");

    return $rs;
}

/*sinkronisasi siasn*/
function getTokenWSO2($consumer_key, $consumer_secret, $mode = 'train')
{
    //    if ($mode == 'train') {
    //        $url = "https://training-apimws.bkn.go.id/oauth2/token";
    //    } else if ($mode == 'prod') {
    $url = "https://apimws.bkn.go.id/oauth2/token";
    //    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);

    curl_setopt($curl, CURLOPT_USERPWD, "$consumer_key:$consumer_secret");
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    //curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id=$consumer_key&grant_type=client_credentials");
    // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','origin: http://localhost:20000'));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    // receive server response ...
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //echo 'Sekarang '.date('Y-m-d H:i:s');
    //echo 'Coba '.date("Y-m-d H:i:s", (strtotime(date('Y-m-d H:i:s')) + 60));

    if (($jsondata = curl_exec($curl)) === false) {
        exit('Curl error: ' . curl_error($curl));
    } else {
        $obj = json_decode($jsondata, true);
        //        var_dump($obj);
        //        echo 'Token expire at '.date("Y-m-d H:i:s", (strtotime(date('Y-m-d H:i:s')) + $obj['expires_in']));
        $expired_time = date("Y-m-d H:i:s", (strtotime(date('Y-m-d H:i:s')) + $obj['expires_in'])) . "\r\n";
        if (isset($obj['access_token'])) {
            $token_file = fopen("packages/tugumuda/token/token-key.txt", "w") or die("Unable to open file!");
            //$txt = "ini-nanti-diisi-token-key";
            fwrite($token_file, $expired_time);
            fwrite($token_file, $obj['access_token']);
            fclose($token_file);
        }
    }
    curl_close($curl);
}

function getTokenSSO($client_id, $username, $password, $mode = 'train')
{
    //    if ($mode == 'train') {
    //        $url = 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token/';
    //    } else if ($mode == 'prod') {
    $url = 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token';
    //    }

    $grant_type = 'password';
    $post_data = 'client_id=' . $client_id . '&grant_type=password&username=' . $username . '&password=' . $password;
    // echo $post_data;
    // $curl = curl_init($url);
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl,CURLOPT_HEADER,false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

    if (($jsondata = curl_exec($curl)) === false) {
        exit('Curl errorss: ' . curl_error($curl));
    } else {
        $obj = json_decode($jsondata, true);
        //        var_dump($obj);
        //        echo 'Token expire at '.date("Y-m-d H:i:s", (strtotime(date('Y-m-d H:i:s')) + $obj['expires_in']));
        $expired_time = date("Y-m-d H:i:s", (strtotime(date('Y-m-d H:i:s')) + $obj['expires_in'])) . "\r\n";
        if (isset($obj['access_token'])) {
            $token_file = fopen("packages/tugumuda/token/token-sso.txt", "w") or die("Unable to open file!");
            //$txt = "ini-nanti-diisi-token-key";
            fwrite($token_file, $expired_time);
            fwrite($token_file, $obj['access_token']);
            fclose($token_file);
        }
    }
    curl_close($curl);
}

function apiResult($url = '')
{
    // $token_file = fopen("packages/tugumuda/token/token-key.txt", "r") or die("Unable to open file!");
    // $tokenKey = fread($token_file,filesize("packages/tugumuda/token/token-key.txt"));
    // $timetokenKey = fread($token_file,filesize("packages/tugumuda/token/token-key.txt"));
    // fclose($token_file);

    $lines = file('packages/tugumuda/token/token-key.txt');
    $tokenKey = $lines[1];
    $timetokenKey = $lines[0];

    $token_file = fopen("packages/tugumuda/token/token-sso.txt", "r") or die("Unable to open file!");
    $tokenSSO = fread($token_file, filesize("packages/tugumuda/token/token-sso.txt"));
    fclose($token_file);

    $lines2 = file('packages/tugumuda/token/token-sso.txt');
    $tokenSSO = $lines2[1];
    $timetokenSSO = $lines2[0];

    //    echo '<br>Token APIM : '.$tokenKey;
    //    echo '<br>Expired Token APIM : '.$timetokenKey.'<br>';
    //    echo '<br>Token SSO : '.$tokenSSO;
    //    echo '<br>Expired Token SSO : '.$timetokenSSO.'<br>';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    // curl_setopt($curl, CURLOPT_POST, true);
    $arr_header = array(
        'accept: application/json',
        'Auth: bearer ' . $tokenSSO,
        'Authorization: Bearer ' . $tokenKey
    );

    /*$arr_header = array(
         'accept: application/json',
         'Auth: bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJqSEVjQWFPcVFWemFYNGlVeExPVFJYb3lCSWp1a0Z3UHlZOFhtcTZhNkFrIn0.eyJleHAiOjE2ODI3MDIwOTIsImlhdCI6MTY4MjY2NjA5MiwianRpIjoiYmE4MGE3ZjMtMGNjNi00MWRlLTliMTctMzFkZWYwMDBhOWVmIiwiaXNzIjoiaHR0cHM6Ly9pYW0tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIzM2NjNWQ0ZS04MGNmLTRiYmUtOWZmMS01NDRhZDQ3MDU5YTUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJkZXZlbG9wZXIiLCJzZXNzaW9uX3N0YXRlIjoiOGM3YzI0Y2ItNTZiYS00NjMxLTg1MzEtZDNiNTkyMDU0MzgwIiwiYWNyIjoiMSIsInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBpOlRURSIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46VFRFIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1tb25pdG9yLXBlcmVuY2FuYWFuLWtlcGVnYXdhaWFuIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOlRURSIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBpOnBhcmFmIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDpvcGVyYXRvciIsInJvbGU6ZGFzaGJvYXJkLWtlYmlqYWthbjpia24ta2FucmVnIiwicm9sZTptYW5hamVtZW4td3M6ZGV2ZWxvcGVyIiwib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiIsInJvbGU6c2lhc24taW5zdGFuc2k6YWRtaW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmtwOlRURSIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46YmtuLXBpYy12ZXJ2YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6c2trOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOmFwcHJvdmFsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1zb3RrIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW5nYWRhYW46b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmJrbi1waWMtc290ayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLXBlbWJpbmEtcHBrIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6VFRFIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDpwYXJhZiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46cGFyYWYiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6cGFyYWYiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbWJlcmhlbnRpYW46cGFyYWYiLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIl19LCJyZXNvdXJjZV9hY2Nlc3MiOnsiYWNjb3VudCI6eyJyb2xlcyI6WyJtYW5hZ2UtYWNjb3VudCIsIm1hbmFnZS1hY2NvdW50LWxpbmtzIiwidmlldy1wcm9maWxlIl19fSwic2NvcGUiOiJwcm9maWxlIGVtYWlsIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJuYW1lIjoiSEFOSUYgUkFITUFXQU4iLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiIxOTg0MDMzMDIwMDkxMjEwMDEiLCJnaXZlbl9uYW1lIjoiSEFOSUYiLCJmYW1pbHlfbmFtZSI6IlJBSE1BV0FOIiwiZW1haWwiOiJhbHlwaDMwMDNAeWFob28uY29tIn0.fP3g6ieENf8QTedqteAzUaKeC5_09ULPFidBZbvn_uePU9ASLBeJA5rGI6MXyQHe6VFowOm8aC8LWxz9JnKSQrJ3DuCs6dddqAaxoE2fC0yXQ9km3HKH1i_8xoy3k4R3JhuuZIDdagJtl0Rp6doBQ8jKCgADoQoZmK1MIyIyYxTaByIwNLNdCUhoyMZqXC1vChjZ9fu6-5xMO72Up9Dy-g-YbzRT7oJFpKTNlf6DXk8tvuBCK30MAzMDPFE_CTJDGWVjnjTPXaMaGfozhMDJ43LkwfmCCw9ClpX-o9kg82xq8i2RFlaQEt8NG0R9AoA1T0u-F0hwf-SoIK-P12jeEw',
         'Authorization: Bearer eyJ4NXQiOiJNell4TW1Ga09HWXdNV0kwWldObU5EY3hOR1l3WW1NNFpUQTNNV0kyTkRBelpHUXpOR00wWkdSbE5qSmtPREZrWkRSaU9URmtNV0ZoTXpVMlpHVmxOZyIsImtpZCI6Ik16WXhNbUZrT0dZd01XSTBaV05tTkRjeE5HWXdZbU00WlRBM01XSTJOREF6WkdRek5HTTBaR1JsTmpKa09ERmtaRFJpT1RGa01XRmhNelUyWkdWbE5nX1JTMjU2IiwiYWxnIjoiUlMyNTYifQ.eyJzdWIiOiIxOTg0MDMzMDIwMDkxMjEwMDEiLCJhdXQiOiJBUFBMSUNBVElPTiIsImF1ZCI6ImNab2V5eGRZWHRGZmNvTnI2ajU1cl9iWE9lb2EiLCJuYmYiOjE2ODI2NjYwODgsImF6cCI6ImNab2V5eGRZWHRGZmNvTnI2ajU1cl9iWE9lb2EiLCJzY29wZSI6ImRlZmF1bHQiLCJpc3MiOiJodHRwczpcL1wvbG9jYWxob3N0Ojk0NDNcL29hdXRoMlwvdG9rZW4iLCJleHAiOjE2ODI2Njk2ODgsImlhdCI6MTY4MjY2NjA4OCwianRpIjoiMzMxOTRmYmUtNmMwYy00YzI4LWI5ZjktMmYwNjA3MmQ5MWExIn0.FcvPf5Vi5qGeec0rdEhnT06ABq0xmUyEyJdGjnTe-6Kagr_MzKWkzYPvmtAjYdXak5GWRmSKHMx6ehNitNGplLsq5dCuY7z1MYF5hsbzbvIvZXtohxv2irrbo516rSznQZtGs57VxIMlCGTC20jwythP9ehUOg7rLmgLC_q3bK7c47Q9xSiETo3_xrmzLGAbeaC7xNyInsqMBmUpPunPI4BI1ymBz2sx0h2MJv5PllaMSla7xbuiJ2cc8er8WbuGwEl8SmkCKH7AmOLkRzDZ-p-MG-GWRQj23LGMbvdSnJaH8vVxfpGCJUjmYCnSxSV3es5PoX_j3eLUg9ctUpbUGQ'
       );*/
    // var_dump($arr_header);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $arr_header);

    // receive server response ...
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    return curl_exec($curl);
}

function apiResultPost($url = '', $data, $jenis_konten)
{
    $lines = file('packages/tugumuda/token/token-key.txt');
    $tokenKey = $lines[1];
    $timetokenKey = $lines[0];

    $token_file = fopen("packages/tugumuda/token/token-sso.txt", "r") or die("Unable to open file!");
    $tokenSSO = fread($token_file, filesize("packages/tugumuda/token/token-sso.txt"));
    fclose($token_file);

    $lines2 = file('packages/tugumuda/token/token-sso.txt');
    $tokenSSO = $lines2[1];
    $timetokenSSO = $lines2[0];

    //    echo '<br>Token APIM : '.$tokenKey;
    //    echo '<br>Expired Token APIM : '.$timetokenKey.'<br>';
    //    echo '<br>Token SSO : '.$tokenSSO;
    //    echo '<br>Expired Token SSO : '.$timetokenSSO.'<br>';

    $data = json_encode($data);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/form-data'));
    //var_dump($data);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    // curl_setopt($curl, CURLOPT_POST, true);
    $arr_header = array(
        'accept: application/json',
        'Auth: bearer ' . $tokenSSO,
        'Authorization: Bearer ' . $tokenKey,
        'Content-Type: ' . $jenis_konten
    );
    //application/json
    //multipart/form-data
    //application/x-www-form-urlencoded

    // var_dump($arr_header);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $arr_header);

    // receive server response ...
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    return curl_exec($curl);
}

/*function untuk tampil data personal siasn*/
function accessDatapersonalsiasn($link = '', $param = '', $mode = 'prod')
{
    $lines = file('packages/tugumuda/token/token-key.txt');
    $kadaluarsa = strtotime(date($lines[0]));
    $skrg = strtotime(date('Y-m-d H:i:s'));
    if ($skrg > $kadaluarsa) {
        getTokenWSO2(ENV('CONSUMER_KEY'), ENV('CONSUMER_SECRET'), ENV('MODE'));
    }

    $lines2 = file('packages/tugumuda/token/token-sso.txt');
    $kadaluarsa2 = strtotime(date($lines2[0]));
    if ($skrg > $kadaluarsa2) {
        getTokenSSO(ENV('CLIENT_ID'), ENV('UNAME'), ENV('PSWD'), ENV('MODE'));
    }

    //    if ($mode == 'train') {
    //        $base_url = 'https://training-apimws.bkn.go.id:8243/api/1.0/';
    //    } else if ($mode == 'prod') {
    $base_url = 'https://apimws.bkn.go.id:8243/apisiasn/1.0/';
    //    }
    $resultApi = apiResult($base_url . $link . '/' . $param);
    $obj = json_decode($resultApi, true);

    return (object) $obj['data'];
}

/*function untuk tampil data riwayat siasn*/
function accessDatariwayatsiasn($link = '', $param = '', $mode = 'prod')
{
    $lines = file('packages/tugumuda/token/token-key.txt');
    $kadaluarsa = strtotime(date($lines[0]));
    $skrg = strtotime(date('Y-m-d H:i:s'));
    if ($skrg > $kadaluarsa) {
        getTokenWSO2(ENV('CONSUMER_KEY'), ENV('CONSUMER_SECRET'), ENV('MODE'));
    }

    $lines2 = file('packages/tugumuda/token/token-sso.txt');
    $kadaluarsa2 = strtotime(date($lines2[0]));
    if ($skrg > $kadaluarsa2) {
        getTokenSSO(ENV('CLIENT_ID'), ENV('UNAME'), ENV('PSWD'), ENV('MODE'));
    }

    //    if ($mode == 'train') {
    //        $base_url = 'https://training-apimws.bkn.go.id:8243/api/1.0/';
    //    } else if ($mode == 'prod') {
    $base_url = 'https://apimws.bkn.go.id:8243/apisiasn/1.0/';
    //    }
    $resultApi = apiResult($base_url . $link . '/' . $param);
    $obj = json_decode($resultApi);
    $data = $obj->{'data'};

    return $data;
}

/*function untuk tampil data riwayat siasn*/
function accessDatapostsiasn($link = '', $data = '', $jenis = "application/json", $mode = 'prod')
{
    $lines = file('packages/tugumuda/token/token-key.txt');
    $kadaluarsa = strtotime(date($lines[0]));
    $skrg = strtotime(date('Y-m-d H:i:s'));
    if ($skrg > $kadaluarsa) {
        getTokenWSO2(ENV('CONSUMER_KEY'), ENV('CONSUMER_SECRET'), ENV('MODE'));
    }

    $lines2 = file('packages/tugumuda/token/token-sso.txt');
    $kadaluarsa2 = strtotime(date($lines2[0]));
    if ($skrg > $kadaluarsa2) {
        getTokenSSO(ENV('CLIENT_ID'), ENV('UNAME'), ENV('PSWD'), ENV('MODE'));
    }

    //    if ($mode == 'train') {
    //        $base_url = 'https://training-apimws.bkn.go.id:8243/api/1.0/';
    //    } else if ($mode == 'prod') {
    $base_url = 'https://apimws.bkn.go.id:8243/apisiasn/1.0/';
    //    }

    $resultApi = apiResultPost($base_url . $link, $data, $jenis);
    $obj = json_decode($resultApi);

    return $obj;
}

/*function cek ketersediaan idbkn di simpeg*/
function cekBkn($idbkn = '', $table = '')
{
    switch ($table) {
        case 'r_jab':
            $id = 'idjabbkn';
            break;
        case 'r_skp':
            $id = 'idskpbkn';
            break;
        default:
            $id = 'idsapk';
    }
    $rs = \DB::table($table)->where($id, $idbkn)->get();
    if ($rs) {
        return true;
    } else {
        return false;
    }
}

/*funnction untuk mendapatkan id jabatan bkn dari service*/
function getIdjabatanbkn($idjenjab = '')
{
    /*fungsi ini haruse ngga usah karena kalau pake ws prod sudah ada isian jabatannya*/
    switch ($idjenjab) {
        case 'STRUKTURAL':
            $idjabatan = 'unorId';
            break;
        case 'FUNGSIONAL_TERTENTU':
            $idjabatan = 'jabatanFungsionalId';
            break;
        case 'FUNGSIONAL_UMUM':
            $idjabatan = 'jabatanFungsionalUmumId';
            break;
        case '1':
            $idjabatan = 'unorId';
            break;
        case '2':
            $idjabatan = 'jabatanFungsionalId';
            break;
        case '4':
            $idjabatan = 'jabatanFungsionalUmumId';
            break;
        default:
            $idjabatan = '';
    }

    return $idjabatan;
}

/*funnction untuk mendapatkan nama jabatan bkn dari service*/
function getNamajabatanbkn($idjenjab = '')
{
    /*fungsi ini haruse ngga usah karena kalau pake ws prod sudah ada isian jabatannya*/
    switch ($idjenjab) {
        case 'STRUKTURAL':
            $namajabatan = 'namaJabatan'; //namaUnor
            break;
        case 'FUNGSIONAL_TERTENTU':
            $namajabatan = 'jabatanFungsionalNama';
            break;
        case 'FUNGSIONAL_UMUM':
            $namajabatan = 'jabatanFungsionalUmumNama';
            break;
        case '1':
            $namajabatan = 'namaJabatan'; //namaUnor
            break;
        case '2':
            $namajabatan = 'jabatanFungsionalNama';
            break;
        case '4':
            $namajabatan = 'jabatanFungsionalUmumNama';
            break;
        default:
            $namajabatan = 'namaJabatan';
    }

    return $namajabatan;
}

/*funnction untuk mendapatkan jenis jabatan bkn dari service*/
function getJenisjabatanbkn($jenjab = '')
{
    /*fungsi ini haruse ngga usah karena kalau pake ws prod sudah ada isian jabatannya*/
    switch ($jenjab) {
        case 'STRUKTURAL':
            $idjenjab = '1';
            break;
        case 'FUNGSIONAL_TERTENTU':
            $idjenjab = '2';
            break;
        case 'FUNGSIONAL_UMUM':
            $idjenjab = '4';
            break;
        case '1':
            $idjenjab = 'STRUKTURAL';
            break;
        case '2':
            $idjenjab = 'FUNGSIONAL TERTENTU';
            break;
        case '4':
            $idjenjab = 'FUNGSIONAL UMUM';
            break;
        default:
            $idjenjab = '3';
    }

    return $idjenjab;
}

/*funnction untuk mendapatkan id jenis jabatan bkn dari service*/
function getIdenisjabatanbkn($idjenjab = '')
{
    /*fungsi ini haruse ngga usah karena kalau pake ws prod sudah ada isian jabatannya*/
    switch ($idjenjab) {
        case 1:
            $idjenjab = '1';
            break;
        case 2:
            $idjenjab = '2';
            break;
        case 4:
            $idjenjab = '3';
            break;
        default:
            $idjenjab = '';
    }

    return $idjenjab;
}
/*end of sinkronisasi siasn*/