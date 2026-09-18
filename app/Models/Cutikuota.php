<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiKuota extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tr_penyesuaian_cuti';

    protected $fillable = [
        'user_id',
        'role_id',
    ];

}
