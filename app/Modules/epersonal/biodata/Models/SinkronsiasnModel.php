<?php namespace App\Modules\epersonal\biodata\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Biodata Model
 * @var Biodata
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class SinkronsiasnModel extends Model
{
    protected $guarded = array();

    protected $table = "tb_01";
    protected $primaryKey = 'nip'; // or null

    /*start of function validation form*/
    public static $rdikstrusync = array(
        'nip' => 'required',
        'latihanStrukturalId' => 'required',
        'tahun' => 'required',
        'latihanStrukturalNama' => 'required',
        'nomor' => 'required',
        'tanggal' => 'required',
    );

    public static $rseminarsync = array(
        'nip' => 'required',
        'institusiPenyelenggara' => 'required',
        'namaKursus' => 'required',
        'noSertipikat' => 'required',
        'tanggalKursus' => 'required',
        //'tanggalSelesaiKursus' => 'required',
    );

    public static $rdikfungsync = array(
        'nip' => 'required',
        'tahun' => 'required',
        'institusiPenyelenggara' => 'required',
        'namaKursus' => 'required',
        'noSertipikat' => 'required',
        'tanggalKursus' => 'required',
        'tanggalSelesaiKursus' => 'required',
    );

    public static $rdikteksync = array(
        'nip' => 'required',
        'tahun' => 'required',
        'institusiPenyelenggara' => 'required',
        'namaKursus' => 'required',
        'noSertipikat' => 'required',
        'tanggalKursus' => 'required',
        'tanggalSelesaiKursus' => 'required',
    );

    public static $rakreditsync = array(
        'nip' => 'required',
        'nomorSk' => 'required',
        'tanggalSk' => 'required',
        'kreditBaruTotal' => 'required',
        'kreditPenunjangBaru' => 'required',
        'kreditUtamaBaru' => 'required',
    );

    public static $rskp22sync = array(
        'nip' => 'required',
        'tahun' => 'required',
        'nipNrpPenilai' => 'required',
        'namaPenilai' => 'required',
    );
}
