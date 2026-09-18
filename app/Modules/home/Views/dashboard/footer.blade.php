    {!!modal(false,'main_modal3')!!}
    {!!modal(false,'main_modal2')!!}
    {!!modal(true,'main_modal')!!}

    <div class="modal fade" id="main_modal4" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <button onclick="claravel_modal_close('main_modal4')" type="button" aria-hidden="true" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-remove" ></i></button>
        <div id="modalPrev" class="text-center"></div>
    </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; <!--{!!getUtility('thn_develop')!!}--> <a href="http://bkpp.kendalkab.go.id/">BKPP Kab. Kendal</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<script type="text/javascript">
    $(document).ready(function(){
        claravel_modal('Pengumuman','Loading...','main_modal');
        $.ajax({
            type:'post',
            url : '{!!url()!!}/administrator/pengumuman/popinfo',
            data: {'_token' : '{!!csrf_token()!!}'},
            success:function(html){
                $('#main_modal .modal-body').html(html);
            }
        });
    })
</script>

< / body>
</html>
