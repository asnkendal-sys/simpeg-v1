<?php namespace App\Modules\pppkpw\perpanjangankontrakpw\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\PPPKPW\UsulanPPPKPW;

class PerpanjangankontrakpwModel extends UsulanPPPKPW {
	protected $guarded = array();
	
	protected $table = "tr_pppkpw";

	public static $rules = array(
        'bulan' => 'required',
		'tahun' => 'required'
    );

    public static $rule_updates = array(
        'tmtawal' => 'required',
        'tmtakhir' => 'required',
        'thkerja' => 'required',
        'blkerja' => 'required',
        'gaji' => 'required',
        'idgolru' => 'required'
    );

    public static $rule_verifikasi = array(
        'statususul' => 'required',
        // 'statussk' => 'required'
    );

	public static function all($columns = array('*')){
		$instance = new static;
		if (\PermissionsLibrary::hasPermission('mod-perpanjangankontrak-listall')){
			return $instance->newQuery()->paginate($_ENV['configurations']['list-limit']);
		}else{
			return $instance->newQuery()
			->where('role_id', \Session::get('role_id'))
			->paginate($_ENV['configurations']['list-limit']);	
			
		}
	}

    /*function get attribut kgb*/
    public static function getattpppkpw($nip){
        $rs = \DB::table("tb_01 as a")->select(
            'a.nip', 'a.niplama', 'a.nokarpeg', 'a.tmtmulaiakhir_pppk', 'a.tmtakhirakhir_pppk', 'a.nojanjiakhir_pppk', 'a.tgljanjiakhir_pppk', 'k.tkpendid', 'a.idtkpendid', 'a.idjenjurusan', 'a.noskcalonawal_pppk', 'a.tgskcalonawal_pppk', 'a.noskawal_pppk', 'a.tgskawal_pppk',
            'a.idgolruakhir_pppk', 'a.mkthnakhir_pppk', 'a.mkblnakhir_pppk', 'a.gajiakhir_pppk', 'a.tmtmulaiakhir_pppk', 'a.tmtakhirakhir_pppk', 'a.idgolruakhir_pppk', 'a.mkthnakhir_pppk', 'a.mkblnakhir_pppk', 'a.gajiakhir_pppk', 'a.pejmenakhir_pppk',            
            \DB::raw("CONCAT(a.gdp,IF(LENGTH(a.gdp)>0,' ',''),a.nama,IF(LENGTH(a.gdb)>0,', ',''),a.gdb) AS nama"),
            'a.tmlhr', 'a.tglhr', 'a.idgolrupkt', 'a.tmtpkt', 'f.golru_p3k',\DB::raw("IFNULL(g.esl,'-') AS esl"),'a.idesljbt','a.tmtjbt',
            \DB::raw("IF(a.idesljbt BETWEEN '11' AND '52',a.tmtesljbt,'') AS tmtesljbt"),            
            'h.jenjurusan','a.thijaz','i.agama','a.mkthnpkt','a.mkblnpkt',
            \DB::raw("IF(LENGTH(a.mkthnpkt)=1,CONCAT('0',a.mkthnpkt),IF(LENGTH(a.mkthnpkt)=0,'00',a.mkthnpkt)) AS mkthnpkt_"),
            \DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tglhr)), '%Y%m')+0 AS usia"),'a.mkthnpkt',
            \DB::raw("IF(LENGTH(a.mkgolthnkgb)=1,CONCAT('0',a.mkgolthnkgb),IF(LENGTH(a.mkgolthnkgb)=0,'00',a.mkgolthnkgb)) AS mkgolthnkgb_"),
            \DB::raw("CONCAT(a.idgolrupkt, IF(LENGTH(a.mkgolthnkgb)>1, a.mkgolthnkgb, CONCAT(0,a.mkgolthnkgb))) AS kodegolmktkgbl"),
            'a.nosuratkgb','a.tgsuratkgb', 'a.idjenjab','a.iddiperbantukan','j.nmasekolah','a.tmtkgb as tmtkgbl',

            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkthnpkt, a.mkgolthnkgb) AS gkgbl"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.pejmenpkt, a.pejmenkgb) AS pejmenkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.noskpkt, a.noskkgb) AS noskkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.tgskpkt, a.tgskkgb) AS tgskkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.tmtpkt, a.tmtkgb) AS tmtkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkthnpkt, a.mkgolthnkgb) AS mkgolthnkgb"),
            \DB::raw("IF(a.tmtpkt>a.tmtkgb, a.mkblnpkt, a.mkgolblnkgb) AS mkgolblnkgb"),

            \DB::raw("IF(a.idjenjab>=20,a.idjabjbt,IF(a.idjenjab=2,a.idjabfung,IF(a.idjenjab=3,a.idjabfungum,''))) AS kdjabskr"),
            \DB::raw("IF(a.idjenjab=2,b.jabfung,IF(a.idesljbt BETWEEN '11' AND '51',c.jab,IF(a.idjenjab=3,d.jabfungum,''))) AS namajab"),
            \DB::raw("TIMESTAMPDIFF(YEAR, a.tmtmulaiakhir_pppk, tmtakhirakhir_pppk) AS selisih_tahunkerja"),            
            \DB::raw("TIMESTAMPDIFF(MONTH, a.tmtakhirakhir_pppk, CONCAT(LEFT(DATE_ADD(DATE_ADD(a.tglhr, INTERVAL IF(a.idjenjab>4,c.bup,IF(a.idjenjab=2,b.pens,IF(a.idjenjab=3,d.pens,58))) YEAR), INTERVAL 1 MONTH),8),'01')) AS selisih_bulankerja"),
            \DB::raw("CONCAT(LEFT(DATE_ADD(DATE_ADD(a.tglhr, INTERVAL IF(a.idjenjab>4,c.bup,IF(a.idjenjab=2,b.pens,IF(a.idjenjab=3,d.pens,58))) YEAR), INTERVAL 1 MONTH),8),'01') AS pensiunnext"),            
            \DB::raw("
                  CONCAT(
                        IF((LEFT(a.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tgskcalonawal_pppk)), '%Y%m')+0,1,
                              (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tgskcalonawal_pppk)), '%Y%m')+0)-2))
                              -
                              (IF((LEFT(a.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 1), 11 - a.mkthncpn,
                              IF((LEFT(a.idgolrupkt,1) >= 3 AND LEFT(idgolrucpn,1) = 2), 5 - a.mkthncpn,
                                    IF((LEFT(a.idgolrupkt,1) = 2 AND LEFT(idgolrucpn,1) = 1), 6 - a.mkthncpn, 0 ))))
                        ),
                        (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tgskcalonawal_pppk)), '%Y%m')+0,1,
                              (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tgskcalonawal_pppk)), '%Y%m')+0)-2))
                              + a.mkthncpn
                        )
                        ),
                        RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(a.tgskcalonawal_pppk)), '%Y%m')+0, 2)) AS mkskr
            "),
            \DB::raw("TIMESTAMPDIFF(YEAR, tmtakhirakhir_pppk, CONCAT(LEFT(DATE_ADD(DATE_ADD(a.tglhr, INTERVAL IF(a.idjenjab>=20,c.bup,IF(a.idjenjab=2,b.pens,IF(a.idjenjab=3,d.pens,58))) YEAR), INTERVAL 1 MONTH),8),'01')) AS selisih_tahun"),
            'a.idskpd','c.skpd', \DB::raw("a.idgolrupkt AS golruskr"), \DB::raw("a.idskpd AS idskpdskr, if(a.idskpd=LEFT(a.idskpd, 2), c.skpd, concat(c.skpd, ' - ', e.skpd)) AS skpdskr")
        )
            ->join('a_skpd as c', 'a.idskpd', '=', 'c.idskpd')
            ->leftJoin('a_jabfung as b', 'a.idjabfung','=','b.idjabfung')
            ->leftJoin('a_jabfungum as d', 'a.idjabfungum', '=', 'd.idjabfungum')
            ->leftJoin('a_skpd as e', function($join) {
                $join->on(\DB::raw('LEFT(a.idskpd, 2)'), '=', 'e.idskpd');
            })
            ->leftJoin('a_golruang as f', 'a.idgolrupkt', '=','f.idgolru')
            ->leftJoin('a_esl as g', 'a.idesljbt', '=', 'g.idesl')
            ->leftJoin('a_tkpendid as k', 'a.idtkpendid', '=', 'k.idtkpendid')
            ->leftJoin('a_jenjurusan as h', 'a.idjenjurusan', '=', 'h.idjenjurusan')
            ->leftJoin('a_agama as i', 'a.idagama', '=', 'i.idagama')
            ->leftJoin('a_sekolahswasta as j', 'a.iddiperbantukan', '=', 'j.id')
            ->where('a.nip', $nip)
            ->orderBy('e.idskpd', 'desc')
            ->first();

        return $rs;
    }

    /* function untuk menaplikan lama kontrak */
    public static function getKontrak($data_awal = "", $date_akhir="", $status=""){        
		$data_awal = date_create($data_awal);
        $date_akhir = date('d-m-Y', strtotime($date_akhir. ' +1 day'));
		$date_akhir = date_create($date_akhir);
		$diff = date_diff($data_awal, $date_akhir);
		$kontrak = date_interval_format($diff, "%y-%m-%d");
        list($tahun,$bulan,$hari)=explode("-",$kontrak);

        if($status == 1){
            if(@$tahun > 0){
                return $tahun;
            }else {
                return 0;
            }
        }else{
            if(@$tahun > 0){
                return $tahun." Tahun";
            }else if(@$tahun == 0){
                return $bulan." Bulan";
            }else{
                return '-';
            }            
        }        		
    }

    /* nominatif perpanjangan kontrak verifikasi */
    public static function getNominatifver($idpppkpw, $nip){
        $rs =  \DB::table('tr_pppkpw')
            ->select('tr_pppkpw.*',\DB::raw("DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(tr_pppkpw.tglhr)), '%Y%m')+0 AS usia"))                    
            ->where('idpppk', $idpppkpw)
            ->where('nip', $nip)
            ->orderBy('tmtawal', 'desc')->orderBy('idskpd')
            ->first();

        return $rs;
    }

    /*combo status usulan*/
    public static function comboStatususulan($id="status",$sel="",$required="",$holder=".: Pilihan :."){
        $html ="<select name=\"$id\" id=\"$id\" $required style='width: 100%;' class=\"form-control\">";
        $html.="<option value=\"\">".$holder."</option>";        
        $html.="<option value=\"1\" ".(($sel=='1')?"selected":"").">Diusulkan</option>";
        $html.="<option value=\"2\" ".(($sel=='2')?"selected":"").">Tidak Diusulkan</option>";
        $html.="</select>";
        return $html;
    }

    /*function cek file kinerja dan pengangkatan*/
    public static function cekDokumen($nip="", $sts_kontrak=""){
        if($sts_kontrak == 2 or $sts_kontrak == 3){
            $cek1 = \DB::connection('efile_2017')->table('files')
                ->select('kat.nama AS jenis', \DB::raw('COUNT(*) AS jml'))
                ->join('kategori_jenis AS kat', 'kat.id', '=', 'files.jenis')
                ->where('files.nip', $nip)
                ->where('files.subjenis', '101')
                ->groupBy('kat.id', 'files.subjenis')
                ->count();

            $message = ($cek1 > 0)?'':'SK Pengangkatan belum tersedia.';
        }

        if($sts_kontrak == 2){
            $cek2 = \DB::connection('efile_2017')->table('files')
                ->select('r_kinerjaasn.tahun', \DB::raw('COUNT(*) AS jml'))
                ->join(env('DB_DATABASE').'.r_kinerjaasn AS r_kinerjaasn', 'r_kinerjaasn.id', '=', 'files.subjenis')
                ->where('files.nip', '=', $nip)
                ->where('files.jenis', '=', '116')
                ->groupBy('files.subjenis')
                ->orderBy('r_kinerjaasn.tahun', 'desc')
                ->get();
            $message .= (count($cek2) > 1 and $cek2[0]->tahun >= (date('Y')))?'':' Berkas Kinerja Tahun 2025 Bulan November,Desember dan Tahun 2026 TW 1,2 belum tersedia.';

//            $cek3 = \DB::connection('efile_2017')->table('files')
//                ->select('kat.nama AS jenis', \DB::raw('COUNT(*) AS jml'))
//                ->join('kategori_jenis AS kat', 'kat.id', '=', 'files.jenis')
//                ->where('files.nip', $nip)
//                ->where('files.subjenis', '120')
//                ->groupBy('kat.id', 'files.subjenis')
//                ->count();
//
//            $message .= ($cek3 > 0)?'':' Perjanjian Kerja belum tersedia.';

            $cek4 = \DB::connection('efile_2017')->table('files')
                ->select('kat.nama AS jenis', \DB::raw('COUNT(*) AS jml'))
                ->join('kategori_jenis AS kat', 'kat.id', '=', 'files.jenis')
                ->where('files.nip', $nip)
                ->where('files.subjenis', '122')
                ->groupBy('kat.id', 'files.subjenis')
                ->count();

            $message .= ($cek4 > 0)?'':' SPK Terakhir belum tersedia.';

            $cek5 = \DB::connection('efile_2017')->table('files')
                ->select('kat.nama AS jenis', \DB::raw('COUNT(*) AS jml'))
                ->join('kategori_jenis AS kat', 'kat.id', '=', 'files.jenis')
                ->where('files.nip', $nip)
                ->where('files.subjenis', '127')
                ->groupBy('kat.id', 'files.subjenis')
                ->count();

$cek6 = \DB::connection('efile_2017')->table('files')
                ->select('kat.nama AS jenis', \DB::raw('COUNT(*) AS jml'))
                ->join('kategori_jenis AS kat', 'kat.id', '=', 'files.jenis')
                ->where('files.nip', $nip)
                ->where('files.subjenis', '128')
                ->groupBy('kat.id', 'files.subjenis')
                ->count();

            $message .= ($cek6 > 0)?'':' Rekap Presensi/Kehadiran november,desember 2025 dan januari - juli 2026 belum tersedia.';

            $message .= ($cek5 > 0)?'':' Surat Pernyataan Tanggung Jawab Mutlak (SPTJM) belum tersedia  belum tersedia.';
        }

        return $message;
        // return '';
    }

    /* function untuk cek data verifikasi sk induk */
    public static function cekSkinduk($bulan="", $tahun=""){        
        $rs = \DB::table('tr_pppkpw')
        ->whereRaw("status = 1 and sts_kontrak = 2 and statussk != 1 and MONTH(tr_pppkpw.tmtawal) = \"".$bulan."\" and YEAR(tr_pppkpw.tmtawal) = \"".$tahun."\"")        
        ->count();
        
        return $rs;
    }
}
