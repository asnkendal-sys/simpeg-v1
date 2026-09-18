@if(Input::get('role_id') > 1)
<div class="form-group">
    {!! Form::label('role_id', 'Context Module:', array('class' => 'col-sm-3 control-label')) !!}
    <div class="col-sm-7">
        <table class="table table-stripped">
            <tr class="bg-primary">
                <td class="text-center" width="10%">No</td>
                <td class="text-center" width="70%">Context Module</td>
                <td class="text-center" width="20%">
                    Aktifkan<br>
                    <input type="checkbox" name="checkall" id="checkall" class="checkall" value="1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pilih Semua">
                </td>
            </tr>
            <?php
                $x = 0;
                $context = explode(",", $context_id);
            ?>
            @foreach($rs as $item)
            <?php
                $x++;
                if (in_array($item->id, $context)) {
                    $isCheck = "checked";
                }else{
                    $isCheck = "";
                }
            ?>
            <tr>
                <td class="text-center">{!!$x!!}</td>
                <td class="text-left"><i class="fa {!!$item->icons!!}"></i> {!!$item->name!!}</td>
                <td class="text-center"><input type="checkbox" class="checkme" name="idcontexts[{!!$x!!}]" value="{!!$item->id!!}" {!!$isCheck!!}></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@else
<input type="hidden" name="idcontexts" value="">
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('.checkme,.checkall').on('change',function(){
            $(this).is(':checked');
        });
    });
</script>