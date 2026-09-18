<?php
    switch(Input::get('idkategori')){
        case 1: echo View::make('statistikpegawai::statistik_pendformal'); break;
        case 2: echo View::make('statistikpegawai::statistik_ukerja_pendformal'); break;
        case 3: echo View::make('statistikpegawai::statistik_ukerja_golongan'); break;
        case 4: echo View::make('statistikpegawai::statistik_jenkel_golongan'); break;
        case 5: echo View::make('statistikpegawai::statistik_statuskedu_pegawai'); break;
        case 6: echo View::make('statistikpegawai::statistik_diklat_struktural'); break;
        case 7: echo View::make('statistikpegawai::statistik_eselon'); break;
        case 8: echo View::make('statistikpegawai::statistik_jenkel_eselon'); break;
        case 9: echo View::make('statistikpegawai::statistik_agama'); break;
        case 10: echo View::make('statistikpegawai::statistik_usia'); break;
        case 11: echo View::make('statistikpegawai::statistik_perkawinan'); break;
        case 12: echo View::make('statistikpegawai::statistik_jabfungum'); break;
        case 13: echo View::make('statistikpegawai::statistik_jabfung'); break;
        case 14: echo View::make('statistikpegawai::statistik_jabfung_guru'); break;
        default: echo "<p><br>* Pilihan kategori harus diisi.</p>"; break;
    }
?>