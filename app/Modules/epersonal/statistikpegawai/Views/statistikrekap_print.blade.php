<?php
    switch(Input::get('idkategori')){
        case 1: echo View::make('statistikpegawai::statistikrekap_jabatan_golongan'); break;
        case 2: echo View::make('statistikpegawai::statistikrekap_jabstru_golongan'); break;
        case 3: echo View::make('statistikpegawai::statistikrekap_jabfung_golongan'); break;
        case 4: echo View::make('statistikpegawai::statistikrekap_jabfungum_golongan'); break;
        case 5: echo View::make('statistikpegawai::statistikrekap_profil_pns'); break;
        default: echo "<p><br>* Pilihan kategori harus diisi.</p>"; break;
    }
?>
