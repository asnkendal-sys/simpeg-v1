<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model {

  protected $guarded = array();
  
  protected $connection = "tugumuda";

  protected $table = "tb_01";

  protected $primaryKey = 'nip'; 

  public function scopePppk($query){
        return $query->where('tb_01.idstspeg','=',3);
  }

  public function scopeAktif($query){
    return $query->where('tb_01.idjenkedudupeg','!=',99)->where('tb_01.idjenkedudupeg','!=',21);
  }

  public function scopeStruktural($query){
    return $query->where('tb_01.idjenjab','>',4);
  }

  public function getGolonganAttribute()
  {
    return $this->golruang->golru;
  }

  public function getPangkatAttribute()
  {

    return $this->golruang->pangkat;
  }

  public function getNamaSkpdAtribute()
  {
    return $this->skpd->path_short;
  }

  public function getNamaLengkapAttribute()
  {
	$nama = '';
      if($this->gdp != ''){
        $nama = $this->gdp." ".$this->nama;
      }else{
        $nama = $this->nama;
      }
     
      if($this->gdb != ''){
        $nama .= " ".$this->gdb;
      }

      return  $nama;
  }

  public function getTanggalLahirAttribute(){
    return formatTanggalPanjang($this->tglhr);
  }

  public function getJenisKelaminAttribute(){
    return $this->idjenkel==1?"Laki-laki":"Perempuan";
  }

  public function getJabatanAttribute(){
    $jabatan = '';

    if ($this->idjenjab > 4){
        $jabatan = $this->skpd->jab;
    }else if($this->idjenjab == 2){
        $jabatan = $this->jabfung->jabfung;
        // if(!empty($jabatan)){
        //     $jabatan .= " ".@$this->jabfungTingkat()->plainJenjang();
        //     $jabatan .= $this->idtugasdokter==""?"":" ".@$this->tugasdokter->tugasdokter;
        //     $jabatan .= $this->idmatkulpel==""?"":" ".@$this->matkulpel->matkulpel;
        // }
    }else if($this->idjenjab == 3){
        $jabatan = $this->jabfungum->jabfungum;
    }

    return strtoupper($jabatan);
  }

  public function skpd(){
      return $this->belongsTo('App\Models\Master\Skpd','idskpd','idskpd');
  }

  public function golruang(){
      return $this->belongsTo('App\Models\Master\Golruang','idgolrupkt','idgolru');
  }

  public function jabfung(){
      return $this->belongsTo('App\Models\Master\Jabfung','idjabfung','idjabfung');
  }

  public function riwayatSAPK()
  {
    return $this->hasMany('App\Models\RiwayatSAPK','nip','nip');
  }

  public function jabfungum(){
      return $this->belongsTo('App\Models\Master\Jabfungum','idjabfungum','idjabfungum');
  }

  public function eselon(){
    return $this->belongsTo('\App\Models\Master\Eselon','idesljbt','idesl');
  }

  public function tkpendid(){
    return $this->belongsTo('\App\Models\Master\Tkpendid','idtkpendid','idtkpendid');
  }

  public function jenjurusan(){
    return $this->belongsTo('\App\Models\Master\Jenjurusan','idjenjurusan','idjenjurusan');
  }

  public function agama(){
    return $this->belongsTo('\App\Models\Master\Agama','idagama','idagama');
  }

  public function golruangpppk(){
      return $this->belongsTo('App\Models\Master\Golruang','idgolruakhir_pppk','idgolru');
  }
  
  public function pTkpendid(){
    return $this->tkpendid->tkpendid;
  }
  
  public function pJenjurusan(){
    return $this->jenjurusan->jenjurusan;
  }

  public function pAgama(){
    return $this->agama->agama;
  }

  public function namaLengkap(){
    if($this->gdp != ''){
      $nama = $this->gdp." ".$this->nama;
    }else{
      $nama = $this->nama;
    }
   
    if($this->gdb != ''){
      $nama .= " ".$this->gdb;
    }

    return  $nama;
  }

  public function jabatan(){
    $jabatan = '';

    if ($this->idjenjab > 4){
        $jabatan = $this->skpd->jab;
    }else if($this->idjenjab == 2){
        $jabatan = $this->jabfung->jabfung;
        // if(!empty($jabatan)){
        //     $jabatan .= " ".@$this->jabfungTingkat()->plainJenjang();
        //     $jabatan .= $this->idtugasdokter==""?"":" ".@$this->tugasdokter->tugasdokter;
        //     $jabatan .= $this->idmatkulpel==""?"":" ".@$this->matkulpel->matkulpel;
        // }
    }else if($this->idjenjab == 3){
        $jabatan = $this->jabfungum->jabfungum;
    }
    return strtoupper($jabatan);
  }

  public function masaKerjaSekarang()
  {
      $rs = $this->select(
              \DB::raw("
                 CONCAT(
                     IF((LEFT(tb_01.idgolrupkt,1) != LEFT(idgolrucpn,1)),
                         (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                             (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                             -
                             (IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(tb_01.idgolrucpn,1) = 1), 11 - tb_01.mkthncpn,
                             IF((LEFT(tb_01.idgolrupkt,1) >= 3 AND LEFT(tb_01.idgolrucpn,1) = 2), 5 - tb_01.mkthncpn,
                                 IF((LEFT(tb_01.idgolrupkt,1) = 2 AND LEFT(tb_01.idgolrucpn,1) = 1), 6 - tb_01.mkthncpn, 0 ))))
                         ),
                         (SUBSTR(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0,1,
                             (LENGTH(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0)-2))
                             + tb_01.mkthncpn
                         )
                     ),
                     RIGHT(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(IF(tb_01.tmtcpn='0000-00-00',tb_01.tmtpns,tb_01.tmtcpn))), '%Y%m')+0, 2)) AS mkskr
             ")
          )->first();
      return $rs->mkskr;            
  }

  public function usia()
  {
      return $this->tglhr == '0000-00-00'?'-':usiaTahunBulan($this->tglhr);
  }

  // public function usiaTahun($tahun = date('Y'))
  // {
  //       $tahunlahir = date('Y',strtotime($this->tglhr));
  //       return  ($tahun < $tahunlahir)?0:$tahun-tahunlahir;
  // }

  public function diklatTeknis()
  {
    return $this->hasMany('App\Models\Riwayat\DiklatTeknis','nip','nip');
  }
}


// Field                  Type          Null    Key     Default              Extra   
// ---------------------  ------------  ------  ------  -------------------  --------
// nip                    varchar(18)   NO      PRI                                  
// niplama                varchar(10)   NO      MUL                                  
// nama                   varchar(80)   NO                                           
// gdp                    varchar(20)   NO                                           
// gdb                    varchar(20)   NO                                           
// tmlhr                  varchar(50)   NO                                           
// tglhr                  date          NO              0000-00-00                   
// idjenkel               char(2)       NO      MUL                                  
// idagama                char(2)       NO      MUL                                  
// idstspeg               char(2)       NO      MUL                                  
// idjenkepeg             char(2)       NO      MUL                                  
// idjenkedudupeg         char(2)       NO      MUL                                  
// ket                    text          YES             (NULL)                       
// tmtket                 date          NO              0000-00-00                   
// idstskawin             char(2)       NO      MUL                                  
// idstsdujan             varchar(2)    YES             (NULL)                       
// alm                    varchar(255)  NO                                           
// almrt                  varchar(150)  NO                                           
// almrw                  varchar(150)  NO                                           
// almdesa                varchar(150)  NO                                           
// almkec                 varchar(150)  NO                                           
// almkab                 varchar(150)  NO                                           
// almprov                varchar(150)  NO                                           
// almkdpos               varchar(5)    NO                                           
// idlokkel               varchar(20)   NO      MUL                                  
// idlokkec               varchar(8)    NO      MUL                                  
// idlokkab               varchar(8)    NO      MUL                                  
// idlokpro               varchar(8)    NO      MUL                                  
// telp                   varchar(15)   NO                                           
// hp                     varchar(15)   NO                                           
// idgoldarah             char(2)       NO      MUL                                  
// nokarpeg               varchar(20)   NO                                           
// noaskes                varchar(30)   NO                                           
// notaspen               varchar(30)   NO                                           
// nokaris                varchar(30)   NO                                           
// nonpwp                 varchar(30)   NO                                           
// noktp                  varchar(30)   NO                                           
// nobapertarum           varchar(30)   NO                                           
// photo                  varchar(150)  YES             (NULL)                       
// userin                 int(11)       NO              0                            
// tmstamp                timestamp     NO              0000-00-00 00:00:00          
// userup                 int(11)       NO              0                            
// tmstampup              timestamp     NO              0000-00-00 00:00:00          
// password               varchar(255)  YES             (NULL)                       
// lastlogin              datetime      NO              0000-00-00 00:00:00          
// nobkncpn               varchar(30)   NO                                           
// tgbkncpn               date          NO              0000-00-00                   
// pejmencpn              varchar(100)  NO      MUL                                  
// noskcpn                varchar(30)   NO                                           
// tgskcpn                date          NO              0000-00-00                   
// idgolrucpn             varchar(3)    NO      MUL                                  
// tmtcpn                 date          NO              0000-00-00                   
// mkthncpn               int(4)        NO              0                            
// mkblncpn               int(4)        NO              0                            
// tmttgscpn              date          NO              0000-00-00                   
// nosttpdikcpn           varchar(30)   NO                                           
// tgsttpdikcpn           date          NO              0000-00-00                   
// nospmtcpn              varchar(30)   YES             (NULL)                       
// tgspmtcpn              date          YES             (NULL)                       
// tmtspmtcpn             date          YES             (NULL)                       
// pejmenpns              varchar(100)  NO      MUL                                  
// noskpns                varchar(30)   NO                                           
// tgskpns                date          NO              0000-00-00                   
// idgolrupns             varchar(2)    NO                                           
// tmtpns                 date          NO              0000-00-00                   
// idsumpahpns            tinyint(4)    NO              0                            
// pejmenawal_pppk        varchar(100)  NO                                           
// noskcalonawal_pppk     varchar(35)   NO                                           
// tgskcalonawal_pppk     date          NO              0000-00-00                   
// noskawal_pppk          varchar(35)   NO                                           
// tgskawal_pppk          date          NO              0000-00-00                   
// idgolruawal_pppk       varchar(2)    NO                                           
// mkthnawal_pppk         int(4)        NO              (NULL)                       
// mkblnawal_pppk         int(4)        NO              (NULL)                       
// gajiawal_pppk          int(11)       NO              (NULL)                       
// idjenjabawal_pppk      tinyint(4)    NO              (NULL)                       
// idjabawal_pppk         varchar(75)   NO                                           
// nojanjiawal_pppk       varchar(35)   NO                                           
// tgljanjiawal_pppk      date          NO              0000-00-00                   
// tmtmulaiawal_pppk      date          NO              0000-00-00                   
// tmtakhirawal_pppk      date          NO              0000-00-00                   
// pejmenakhir_pppk       varchar(100)  NO                                           
// noskakhir_pppk         varchar(35)   NO                                           
// tgskakhir_pppk         date          NO              0000-00-00                   
// idgolruakhir_pppk      varchar(2)    NO                                           
// mkthnakhir_pppk        int(4)        NO              (NULL)                       
// mkblnakhir_pppk        int(4)        NO              (NULL)                       
// gajiakhir_pppk         int(11)       NO              (NULL)                       
// idjenjabakhir_pppk     tinyint(4)    NO              (NULL)                       
// idjabakhir_pppk        varchar(75)   NO                                           
// nojanjiakhir_pppk      varchar(35)   NO                                           
// tgljanjiakhir_pppk     date          NO              0000-00-00                   
// tmtmulaiakhir_pppk     date          NO              0000-00-00                   
// tmtakhirakhir_pppk     date          NO              0000-00-00                   
// tmtakhirkontrak        date          NO              0000-00-00                   
// nospmtpns              varchar(30)   YES             (NULL)                       
// tgspmtpns              date          YES             (NULL)                       
// tmtspmtpns             date          YES             (NULL)                       
// nobknpkt               varchar(30)   NO                                           
// tgbknpkt               date          NO              0000-00-00                   
// pejmenpkt              varchar(100)  NO      MUL                                  
// noskpkt                varchar(30)   NO                                           
// tgskpkt                date          NO              0000-00-00                   
// idgolrupkt             varchar(2)    NO      MUL                                  
// tmtpkt                 date          NO              0000-00-00                   
// mkthnpkt               int(4)        NO              0                            
// mkblnpkt               int(4)        NO              0                            
// akpkt                  double        NO              0                            
// pejmenkgb              varchar(100)  NO      MUL                                  
// nosuratkgb             varchar(30)   NO                                           
// tgsuratkgb             date          NO              0000-00-00                   
// noskkgb                varchar(30)   NO                                           
// tgskkgb                date          NO              0000-00-00                   
// idgolkgb               varchar(3)    NO                                           
// tmtkgb                 date          NO      MUL     0000-00-00                   
// mkgolthnkgb            int(4)        NO              0                            
// mkgolblnkgb            int(4)        NO              0                            
// kantorkgb              varchar(100)  NO                                           
// idsatker               varchar(10)   NO                                           
// idsekolah              varchar(14)   NO                                           
// kdunit                 varchar(35)   YES     MUL                                  
// idskpd                 varchar(35)   YES     MUL                                  
// tmpkdunit              varchar(35)   YES                                          
// tmpidskpd              varchar(35)   YES                                          
// tmtskpd                date          NO              0000-00-00                   
// almloker               varchar(100)  NO                                           
// almlokertelp           varchar(15)   NO                                           
// sekolah                varchar(255)  YES     MUL     (NULL)                       
// pejmenjbt              varchar(100)  NO      MUL                                  
// noskjbt                varchar(30)   NO                                           
// tgskjbt                date          NO              0000-00-00                   
// idjenjab               tinyint(4)    YES     MUL     (NULL)                       
// idesljbt               varchar(2)    NO      MUL                                  
// tmtesljbt              date          NO              0000-00-00                   
// stsesl                 tinyint(1)    YES             0                            
// idkeljab               tinyint(4)    NO              0                            
// idjabjbt               varchar(14)   YES     MUL                                  
// idjabfung              varchar(14)   YES     MUL                                  
// idjabfungum            varchar(14)   YES                                          
// idjabproyeksi          varchar(14)   YES                                          
// idjabnonjob            varchar(14)   YES                                          
// iddesa                 varchar(11)   YES                                          
// nmadesa                varchar(75)   YES                                          
// tmpidjenjab            varchar(4)    YES                                          
// tmpidjabjbt            varchar(14)   YES                                          
// tmpidjabfung           varchar(14)   YES                                          
// tmpidjabfungum         varchar(14)   YES                                          
// tmpidesljbt            varchar(14)   YES                                          
// tmtjbt                 date          NO              0000-00-00                   
// tmtjabfung             date          NO              0000-00-00                   
// nolantikjbt            varchar(30)   NO                                           
// tglantikjbt            date          NO              0000-00-00                   
// tunjjbt                double        NO              0                            
// idsumpahjbt            tinyint(4)    NO              0                            
// noskmutasijbt          varchar(30)   YES             (NULL)                       
// tglskmutasijbt         date          YES             0000-00-00                   
// tmtmutasijbt           date          YES             0000-00-00                   
// idtkpendid             char(3)       NO      MUL                                  
// idjenjurusan           varchar(11)   NO      MUL                                  
// idalmamater            varchar(11)   NO                                           
// thijaz                 varchar(4)    NO                                           
// noijaz                 varchar(30)   NO                                           
// namasekolah            varchar(100)  NO                                           
// almsekolah             varchar(100)  NO                                           
// kepsek                 varchar(100)  NO                                           
// idtkpendidawal         char(2)       NO                                           
// idjenjurusanawal       varchar(11)   NO      MUL                                  
// thijazawal             varchar(4)    NO                                           
// noijazawal             varchar(30)   NO                                           
// namasekolahawal        varchar(100)  NO                                           
// almsekolahawal         varchar(100)  NO                                           
// kepsekawal             varchar(100)  NO                                           
// flag_dikprajab         tinyint(1)    YES             0                            
// iddikstru              varchar(35)   NO      MUL                                  
// nmdikstru              varchar(250)  NO                                           
// tmdikstru              varchar(150)  NO                                           
// penyelenggara_dikstru  varchar(150)  NO                                           
// angkatan_dikstru       varchar(35)   NO                                           
// tgmul_dikstru          date          NO              (NULL)                       
// tgsel_dikstru          date          NO              (NULL)                       
// jamhari_dikstru        varchar(11)   NO                                           
// nosttp_dikstru         varchar(75)   NO                                           
// tgsttp_dikstru         date          NO              (NULL)                       
// iddikfung              varchar(35)   NO                                           
// nmdikfung              varchar(250)  NO                                           
// tmdikfung              varchar(150)  NO                                           
// penyelenggara_dikfung  varchar(150)  NO                                           
// angkatan_dikfung       varchar(35)   NO                                           
// tgmul_dikfung          date          NO              (NULL)                       
// tgsel_dikfung          date          NO              (NULL)                       
// jamhari_dikfung        varchar(35)   NO                                           
// nosttp_dikfung         varchar(35)   NO                                           
// tgsttp_dikfung         datetime      NO              (NULL)                       
// iddiktek               varchar(35)   NO                                           
// nmdiktek               varchar(250)  NO                                           
// tmdiktek               varchar(150)  NO                                           
// penyelenggara_diktek   varchar(150)  NO                                           
// angkatan_diktek        varchar(35)   NO                                           
// tgmul_diktek           datetime      NO              (NULL)                       
// tgsel_diktek           datetime      NO              (NULL)                       
// jamhari_diktek         varchar(35)   NO                                           
// nosttp_diktek          varchar(35)   NO                                           
// tgsttp_diktek          date          NO              (NULL)                       
// gaji                   double        NO              0                            
// gajidasar              double        NO              0                            
// flagkaris              tinyint(4)    NO              0                            
// tmtpensiun             date          YES     MUL     (NULL)                       
// mkthnpns               varchar(2)    NO                                           
// mkblnpns               varchar(2)    NO                                           
// nmissu                 varchar(50)   NO                                           
// tmlhrissu              varchar(50)   NO                                           
// tglhrissu              date          NO              0000-00-00                   
// tgnikah                date          NO              0000-00-00                   
// pendidumissu           varchar(50)   YES             (NULL)                       
// pekerissu              varchar(50)   YES             (NULL)                       
// nipnrpissu             varchar(10)   YES             (NULL)                       
// tunjissu               varchar(1)    YES             (NULL)                       
// rwthukdis              varchar(255)  YES             (NULL)                       
// tgcerai                date          YES             (NULL)                       
// noskcerai              varchar(40)   YES             (NULL)                       
// tmtkgbnext             date          YES             (NULL)                       
// mkblnkgb               int(11)       NO              0                            
// mkthnkgb               int(11)       NO              0                            
// pejkgb                 varchar(100)  YES             (NULL)                       
// pejpkt                 varchar(100)  YES             (NULL)                       
// idgaji                 varchar(5)    YES             (NULL)                       
// kdgaji                 varchar(5)    YES             (NULL)                       
// karpeg_bu              varchar(20)   YES             (NULL)                       
// idjenhukum             varchar(2)    YES             (NULL)                       
// tmthukdis1             date          YES             (NULL)                       
// tmthukdis2             date          YES             (NULL)                       
// email                  varchar(100)  YES             (NULL)                       
// kel                    varchar(30)   NO                                           
// nopak                  float(16,3)   NO              0.000                        
// tgpak                  date          YES             (NULL)                       
// tghonorer              date          YES             (NULL)                       
// lokdikstru             varchar(40)   NO                                           
// idjenharga             varchar(3)    NO                                           
// tgjenharga             date          NO              0000-00-00                   
// tgjenhukum             date          NO              0000-00-00                   
// lokber                 varchar(3)    NO                                           
// idskpd1                varchar(10)   NO                                           
// idjenpens              int(11)       NO              (NULL)                       
// tmtpens                date          NO              0000-00-00                   
// noskpens               varchar(25)   NO              (NULL)                       
// tglskpens              date          NO              (NULL)                       
// tglpens                date          NO              0000-00-00                   
// jbtpenetapens          varchar(255)  NO              (NULL)                       
// ketpens                varchar(255)  NO                                           
// tglmeninggal           date          NO              0000-00-00                   
// tglujikesehatan        date          NO              0000-00-00                   
// penerimapensiun        varchar(255)  YES                                          
// tmtmasuk               date          NO              0000-00-00                   
// iskepsek               tinyint(1)    NO              0                            
// idkepsek               varchar(25)   NO                                           
// tmtkepsek              datetime      YES             (NULL)                       
// noskkepsek             varchar(35)   YES             (NULL)                       
// idmatkulpel            varchar(11)   NO              (NULL)                       
// idtugasgurudosen       varchar(11)   NO              (NULL)                       
// idtugasdokter          varchar(11)   NO              (NULL)                       
// isdiperbantukan        tinyint(1)    NO              0                            
// iddiperbantukan        varchar(11)   NO              (NULL)                       
// tinggi                 int(11)       YES             (NULL)                       
// berat                  int(11)       YES             (NULL)                       
// rambut                 varchar(250)  YES             (NULL)                       
// muka                   varchar(250)  YES             (NULL)                       
// kulit                  varchar(250)  YES             (NULL)                       
// ciri                   varchar(250)  YES             (NULL)                       
// cacat                  varchar(250)  YES             (NULL)                       
// hobby1                 varchar(250)  YES             (NULL)                       
// hobby2                 varchar(250)  YES             (NULL)                       
// hobby3                 varchar(250)  YES             (NULL)                       
// mkthpns                int(11)       YES             0                            
// mktbpns                int(11)       YES             0                            
// akret                  float(11,2)   YES             0.00                         
// usiapens               int(11)       NO              0                            
// id_presensi            bigint(9)     YES             (NULL)                       
// imei                   varchar(50)   YES             (NULL)                       
// id_sapk                varchar(35)   NO                                           
// hari_kerja             int(11)       NO              5                            
// user_id                int(11)       NO              (NULL)                       
// role_id                int(11)       NO              (NULL)                       
// created_at             timestamp     NO              0000-00-00 00:00:00          
// updated_at             timestamp     NO              0000-00-00 00:00:00          
