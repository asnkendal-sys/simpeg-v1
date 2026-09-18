<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riwayatcuti extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'r_cuti';

    protected $fillable = [
        'nip',
        'nousul',
        'jencuti',
        'thn',
        'nosurat',
        'tgsurat',
        'tgmul',
        'tgsel',
        'jmlhari',
        'jml_hari_real',
        'ket',
        'kuota_tahunan_n2',
        'kuota_tahunan_n1',
        'kuota_tahunan_n',
        'kuota_besar',
        'kuota_sakit',
        'kuota_melahirkan',
        'kuota_penting',
        'kuota_diluarnegara',
        'kondisi',
        'user_id',
        'role_id',
    ];

}
