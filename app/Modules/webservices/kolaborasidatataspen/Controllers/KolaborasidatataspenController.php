<?php namespace App\Modules\webservices\kolaborasidatataspen\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\webservices\kolaborasidatataspen\Models\KolaborasidatataspenModel;
use Input,View, Request, Form, File;

/**
 * Kolaborasidatataspen Controller
 * @var Kolaborasidatataspen
 * Generate from Custom Laravel 5.1 by Aa Gun.
 *
 * Developed by Divisi Software Development - Dinustek.
 * Please write log when you do some modification, don't change anything unless you know what you do
 * Semarang, 2016
 */

class KolaborasidatataspenController extends Controller {
    protected $kolaborasidatataspen;

    public function __construct(KolaborasidatataspenModel $kolaborasidatataspen){
        $this->kolaborasidatataspen = $kolaborasidatataspen;
    }

    public function getIndex(){
        cekAjax();
        $where = ' tb_01.idjenkedudupeg not in (99,21)';
        if(session('role_id') > 3){
            $where.= " and tb_01.idskpd like \"".session('idskpd')."%\" ";
        }

        if ((strlen(Input::has('search')) > 0) or (Input::get('stskolab') != '') or (Input::get('idskpd') != '') or (Input::get('idstspeg') != '')) {
            (Input::get('stskolab')!='')?$where.=" and tb_01.stskolab = '".Input::get('stskolab')."'":"";
            (Input::get('idstspeg')!='')?$where.=" and tb_01.idstspeg = '".Input::get('idstspeg')."'":"";
            (Input::get('idskpd')!='')?$where.=" and tb_01.idskpd LIKE '".Input::get('idskpd')."%'":"";
            (Input::get('search')!='')?$where.=" and (tb_01.nama LIKE '%".Input::get('search')."%' or tb_01.nip LIKE '%".Input::get('search')."%')":"";

            if(session('role_id') <= 3){
                $kolaborasidatataspens = $this->kolaborasidatataspen
                    ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
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
                        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
                    )
                    ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                    ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                    ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                    ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                    ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                    ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                    ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                    ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                    ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                    ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
                    ->paginate($_ENV['configurations']['list-limit']);
            }else{
                $kolaborasidatataspens = $this->kolaborasidatataspen
                    ->select('tb_01.*','a_golruang.golru','a_skpd.path_short','a_esl.esl','a_tkpendid.tkpendid','a_jenjurusan.jenjurusan',
                        \DB::raw('CONCAT(tb_01.gdp,IF(LENGTH(tb_01.gdp)>0," ",""),tb_01.nama,IF(LENGTH(tb_01.gdb)>0,", "," "),tb_01.gdb) as namalengkap'),'a_jenkel.jenkel','a_agama.agama',
                        \DB::raw('IF(tb_01.idjenjab>4,a_skpd.jab,IF(tb_01.idjenjab=2,a_jabfung.jabfung,IF(tb_01.idjenjab=3,a_jabfungum.jabfungum,IF(tb_01.idjenjab=4,a_jabnonjob.jabnonjob,"-")))) as jabatan'),
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
                        \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tb_01.tglhr)), '%Y%m')+0 AS usia")
                    )
                    ->join('a_skpd', 'tb_01.idskpd', '=', 'a_skpd.idskpd')
                    ->leftjoin('a_esl', 'tb_01.idesljbt', '=', 'a_esl.idesl')
                    ->leftjoin('a_tkpendid', 'tb_01.idtkpendid', '=', 'a_tkpendid.idtkpendid')
                    ->leftjoin('a_jenjurusan', 'tb_01.idjenjurusan', '=', 'a_jenjurusan.idjenjurusan')
                    ->leftjoin('a_golruang', 'tb_01.idgolrupkt', '=', 'a_golruang.idgolru')
                    ->leftjoin('a_agama', 'tb_01.idagama', '=', 'a_agama.idagama')
                    ->leftjoin('a_jenkel', 'tb_01.idjenkel', '=', 'a_jenkel.idjenkel')
                    ->leftjoin('a_jabfung', 'tb_01.idjabfung', '=', 'a_jabfung.idjabfung')
                    ->leftjoin('a_jabfungum', 'tb_01.idjabfungum', '=', 'a_jabfungum.idjabfungum')
                    ->leftjoin('a_jabnonjob', 'tb_01.idjabnonjob', '=', 'a_jabnonjob.idjabnonjob')
                    ->whereRaw($where)
                    ->orderBy(\DB::raw('tb_01.idgolrupkt desc,tb_01.tmtpkt,tb_01.idjenjab,tb_01.idesljbt,tb_01.tmtesljbt,tb_01.tmtcpn,tb_01.idtkpendid desc,tb_01.thijaz,tb_01.tglhr'))
                    ->paginate($_ENV['configurations']['list-limit']);
            }
        }else{
            $kolaborasidatataspens = $this->kolaborasidatataspen->all();
        }
        return View::make('kolaborasidatataspen::index', compact('kolaborasidatataspens'));
    }


    public function getCreate(){
        cekAjax();
        return View::make('kolaborasidatataspen::create');
    }

    public function postCreate(){
        cekAjax();
        $input = Input::all();
        $validation = \Validator::make($input, KolaborasidatataspenModel::$rules);
        if ($validation->passes()){
            $input['user_id'] = \Session::get('user_id');
            $input['role_id'] = \Session::get('role_id');
            echo ($this->kolaborasidatataspen->create($input))?1:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    //{controller-show}

    public function getEdit($id = false){
        cekAjax();
        $id = ($id == false)?Input::get('id'):'';
        $kolaborasidatataspen = $this->kolaborasidatataspen->find($id);
        //if (is_null($kolaborasidatataspen)){return \Redirect::to('webservices/kolaborasidatataspen/index');}
        return View::make('kolaborasidatataspen::edit', compact('kolaborasidatataspen'));
    }

    public function postEdit(){
        cekAjax();
        $id = Input::get('id');
        $input = Input::all();
        $validation = \Validator::make($input, KolaborasidatataspenModel::$rules);

        if ($validation->passes()){
            $kolaborasidatataspen = $this->kolaborasidatataspen->find($id);
            echo ($kolaborasidatataspen->update($input))?4:"Gagal Disimpan";
        }
        else{
            echo 'Input tidak valid';
        }
    }



    public function postSinkall(){
        cekAjax();
        $ids = Input::get('id');
        $dataSends['dataPeserta'] = array();
        if (is_array($ids)){
            $x = 0; $berhasil = 0; $gagal = 0;
            foreach($ids as $id){
                $x++;
                $data = KolaborasidatataspenModel::getDatapegawai($id);
                $dataSend = $this->pegawaiSerializeData($data);
                $dataSends['dataPeserta'] = $dataSend;

                $send = postSavetaspen($dataSends);
                if ($send->status == 200) {
                    if(\DB::table('tb_01')->where('nip', $id)->update(['stskolab'=> 1])){
                        $berhasil++;
                    }else{
                        $gagal++;
                    }
                }
            }
            echo 'Total data '.$x.', Berhasil '.$berhasil.', Gagal '.$gagal;
        }
        else{
            $data = KolaborasidatataspenModel::getDatapegawai($ids);
            $dataSend = $this->pegawaiSerializeData($data);
            $dataSends['dataPeserta'] = $dataSend;

            $send = postSavetaspen($dataSends);
            if ($send->status == 200) {
                echo (\DB::table('tb_01')->where('nip', $ids)->update(['stskolab'=> 1]))?4:'Data berhasil sinkronisasi';
            }else{
                echo 'Data sinkronisasi gagal';
            }
        }
    }

    /*function simpan sinkronisasi data pegawai to taspen*/
    private function pegawaiSerializeData($data)
    {
        list($tgl, $bln, $thn)=explode(" ", formatTanggalPanjang($data->tmtpkt));
        $dataSend  = [
            'pegawai_id' => $data->id,
            'nip_lama' => (($data->niplama=='')?'0':$data->niplama),
            'nip_baru' => $data->nip,
            'nama' => $data->namalengkap,
            'status_pegawai_id' => (($data->idjenpens_taspen!='')?$data->idjenpens_taspen:(($data->idjenkedudupeg_taspen!='')?$data->idjenkedudupeg_taspen:$data->kdsatpeg_taspen)),
            'status_pegawai_nama' => (($data->jenpens_taspen!='')?$data->jenpens_taspen:(($data->jenkedudupeg_taspen!='')?$data->jenkedudupeg_taspen:$data->nmsatpeg_taspen)),
            'tipe_pegawai_id' => $data->idstspeg_taspen,
            'tipe_pegawai_nama' => $data->stspeg_taspen,
            'pangkat_id' => (($data->idgolrupkt!='')?substr($data->idgolrupkt,0,1).\KolaborasidatataspenModel::getGolalfa(substr($data->idgolrupkt,-1)):''),
            'pangkat_nama' => $data->pangkat,
            'gaji_pokok' => $data->gaji,
            'masa_kerja_tahun' => $data->mkthnpkt,
            'masa_kerja_bulan' => $data->mkblnpkt,
            'no_sk' => $data->noskpkt,
            'tanggal_sk' => $data->tgskpkt,
            'tmt_sk' => $data->tmtpkt,
            'jenis_kenaikan_id' => '2',
            'jenis_kenaikan_nama' => 'KENAIKAN PANGKAT',
            'bulan_dibayar' => $data->bulan_dibayar,
            'satuan_kerja_nama' => $data->path_short,
            'satuan_kerja_id' => $data->idskpd_taspen,
            'npwp' => $data->nonpwp,
            'no_telp' => $data->hp,
            'tanggal_update' => date('Y-m-d', strtotime(sekarang())),
            'kdjabatan' => '0',
            'kdeselon' => (($data->idesljbt!='')?substr($data->idesljbt,0,1).\KolaborasidatataspenModel::getGolalfa(substr($data->idesljbt,-1)):''),
            'pejabat_penetap' => $data->jabatan_penetap,
            'nama_jabatan' => $data->namalengkap_penetap,
            'FLAG' => $data->idjenkedudupeg,
            'kddati1' => 11,
            'kddati2' => 13,
            'tmtberkalayad' => $data->tmtberkalayad,
            'kdfungsi' => '0',
            'keterangan' => 'KP '.strtoupper($bln).' '.$thn,
        ];

        return $dataSend;
    }
}
