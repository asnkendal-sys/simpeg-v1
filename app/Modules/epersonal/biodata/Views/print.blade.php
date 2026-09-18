<form enctype="multipart/form-data" method="post" target="_blank" action="{{url()}}/epersonal/biodata/print/biodata" class="form-horizontal" name="formprint" id="formprint">
    <input type="hidden" value="{{Input::get('nip')}}" name="nip" id="nip">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="tampilan">Tampilan Data:</label>
            <div class="col-sm-7">
                <label class="checkbox"><input type="checkbox" value="1" disabled="" checked="checked" name="p0" id="p0"> Biodata </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p1" id="p1"> Riwayat Jabatan </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p2" id="p2"> Riwayat Pangkat </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p3" id="p3"> Riwayat Pendidikan </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p4" id="p4"> Riwayat Diklat Struktural </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p5" id="p5"> Riwayat Diklat Fungsional </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p6" id="p6"> Riwayat Diklat Teknis </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p7" id="p7"> Riwayat Seminar </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p8" id="p8"> Riwayat Penghargaan </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p9" id="p9"> Riwayat Penguasaan Bahasa </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p10" id="p10"> Riwayat Hukum Disiplin </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p11" id="p11"> Riwayat Sasaran Kerja Pegawai </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p12" id="p12"> Riwayat Kenaikan Gaji Berkala </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p13" id="p13"> Riwayat Kenaikan Angka Kredit </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p14" id="p14"> Riwayat Data Anak </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p15" id="p15"> Riwayat Data Istri/Suami </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p16" id="p16"> Riwayat Data Saudara </label>
                <label class="checkbox"><input type="checkbox" value="1" checked="checked" name="p17" id="p17"> Riwayat Data Orang Tua </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="tampilan">&nbsp;</label>
            <div class="col-sm-7">
                <button class="btn btn-primary" type="submit"><i class="fa fa-print"></i> Cetak</button>
            </div>
        </div>
    </div>

</form>