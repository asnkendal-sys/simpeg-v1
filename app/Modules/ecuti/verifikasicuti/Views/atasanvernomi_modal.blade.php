<?php
$nousul = Input::get('nousul');
$item 	= \DB::table('tr_ijin_cuti')->where('nousul', $nousul)->first();
?>

<section class="content">
	<form id="form-vernomiatasan" class="form-horizontal form-vernomiatasan" method="POST" action="{!!url()!!}/ecuti/verifikasicuti/verifikasinomiatasan" accept-charset="UTF-8">{!!csrf_field()!!}
		<input type="hidden" name="nousul" id="nousul" value="{!!$nousul!!}">
		<table id="tabel-cuti" class="table table-hovered table-stripped" width="100%">
			<tr>
				<td width="25%">Nomor Usulan</td>
				<td class="text-center" width="2%"> : </td>
				<td>
					<input type="text" id="nousul" name="nousul" value="{!! $item->nousul !!}" class="form-control nousul" disabled>
				</td>
			</tr>
			<tr>
				<td width="25%">Tanggal Usulan</td>
				<td class="text-center" width="2%"> : </td>
				<td>
					<div class='input-group datepicker'>
						{!! Form::text('tgl_usul', (($item->tgl_usul!='')?date('d-m-Y', strtotime($item->tgl_usul)):date('d-m-Y')), array('class'=> 'form-control date', 'placeholder'=>'dd-mm-yyyy',(($item->tgl_usul!='')?'disabled':''))) !!}
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<td width="25%">Jenis Cuti</td>
				<td class="text-center" width="2%"> : </td>
				<td><!-- {!! comboJenisCuti('id_jenis_cuti',$item->id_jenis_cuti) !!} -->
					<input type="text" id="id_jenis_cuti" name="id_jenis_cuti" class="form-control id_jenis_cuti" value="{!!getJenisCuti($item->id_jenis_cuti)!!}" disabled>
				</td>
			</tr>
			<tr>
				<td width="25%">Tanggal Mulai</td>
				<td class="text-center" width="2%"> : </td>
				<td>
					<div class='input-group datepicker'>
						{!! Form::text('tgl_mulai', (($item->tgl_mulai!='')?date('d-m-Y', strtotime($item->tgl_mulai)):date('d-m-Y')), array('class'=> 'form-control date tgl_mulai', 'placeholder'=>'dd-mm-yyyy',(($item->tgl_mulai!='')?'disabled':''))) !!}
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<td width="25%">Tanggal Selesai</td>
				<td class="text-center" width="2%"> : </td>
				<td>
					<div class='input-group datepicker'>
						{!! Form::text('tgl_selesai', (($item->tgl_selesai!='')?date('d-m-Y', strtotime($item->tgl_selesai)):date('d-m-Y')), array('class'=> 'form-control date tgl_selesai', 'placeholder'=>'dd-mm-yyyy',(($item->tgl_selesai!='')?'disabled':''))) !!}
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<td width="25%">Status Usulan</td>
				<td class="text-center" width="2%"> : </td>
				<td>
					{!! comboStatususulan('atasan_status',$item->atasan_status) !!}
					<!-- {!! comboStatususulan('atasan_status',1) !!} -->
				</td>
			</tr>
			<tr class="ketstatusatasan">
				<td width="25%">Alasan</td>
				<td class="text-center" width="2%"> : </td>
				<td>
					<textarea name="atasan_alasan" class="form-control atasan_alasan" id="atasan_alasan" rows="2">{!!$item->atasan_alasan!!}</textarea>
				</td>
			</tr>
		</table>
		<div class="box-footer">
			<div class="form-group">
				<div class="col-md-6 pull-right">
					<button class="btn btn-success form-vernomiatasan" type="submit"><i class='fa fa-floppy-o'></i> Simpan</button>
					&nbsp;
					&nbsp;
					<button class="btn btn-warning" data-dismiss="modal" aria-hidden="true"> Batalkan</button>
				</div>
			</div>
		</div>
	</form>
</section>
<script>
	$(document).ready(function(){
		$('.menuselect').select2();
		$('.ketstatusatasan').hide();

		$('#atasan_status').change(function(){
			var status = $('#atasan_status').val();
			if(status == 1){
				$('.ketstatusatasan').hide();
			}else if(status == 2 || status == 3|| status == 4){
				$('.ketstatusatasan').show();
			}else{
				$('.ketstatusatasan').hide();
			}
		}).trigger('change');

		$('.form-vernomiatasan').on('submit',function(e){
			var $this = $(this);
			e.preventDefault();
			bootbox.confirm('Simpan data?',function(a){
				if (a == true){
					$.ajax({
                       url: '{{url()}}/ecuti/verifikasicuti/verifikasinomiatasan', //ganti biar gag nabrak
                       type : 'POST',
                       data : $this.serialize(),
                       beforeSend: function(){
                       	preloader.on();
                       },
                       success:function(html){
                       	preloader.off();
                       	if(html=='1'){
                       		notification('Berhasil Disimpan','success');
                       		claravel_modal_close('main_modal');
                       		refresh_page();
                       	}else{
                       		notification(html,'danger');
                       	}
                       }
                   });
				}
			});
		});
	});
</script>