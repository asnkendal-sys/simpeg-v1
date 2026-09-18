<!DOCTYPE html>
<html lang="id-ID" dir="ltr">

<head>
  <title>Simpeg {!!getUtility('kab_instansi')!!}</title>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keyword" content="">
  <meta name="author" content="dinustek | Rudi Kurniawan">
  <link rel="shortcut icon" href="{{ asset('packages/login/img/favicon.png') }}">
  <!-- Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#2d2d2d">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#2d2d2d">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <link href="{{ asset('packages/login/css/font-awesome.min.css') }}" rel="stylesheet" media="screen"> <!-- v4.6.1 -->
  <link href="{{ asset('packages/login/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
  <link href="{{ asset('packages/login/css/login-style.css') }}" rel="stylesheet" media="screen">

  <script type="text/javascript" src="{{ asset('packages/login/js/jquery.js') }}"></script>
  <script type="text/javascript" src="{{ asset('packages/login/js/bootstrap.min.js') }}"></script>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="{{ asset('packages/login/js/html5shiv.js') }}"></script>
      <script src="{{ asset('packages/login/js/respond.min.js') }}"></script>
    <![endif]-->
  <style>
    .captcha-container {
      margin-top: 20px;
    }

    .captcha-container button {
      margin: 5px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    .captcha-container button:hover {
      background-color: #f0f0f0;
    }
  </style>
</head>

<body id="login-page">

  <div class="container">
    <div class="row">

      <div class="col-md-4 col-md-push-8">
        <img src="{{ asset('packages/login/img/logo.png') }}" alt="" id="logo">
        <!-- <h2 class="text-center">Nama Instansi</h2> -->
        <h4 class="text-center">{!!getUtility('alias_aplikasi')!!}</h4>
        <h4 class="text-center">{!!strtoupper(getUtility('nma_instansi'))!!}</b></h4>
        <div class="panel panel-default">
          <!-- <div class="panel-heading text-center">Login</div> -->
          @if(\Session::get('msgerr') != '')
          <div class='alert alert-danger'>{{\Session::get('msgerr')}}</div>
          @endif
          <div class="panel-body">
            {!!Form::open(array('url' => url().'/login','id'=>'tampil', 'method' => 'POST'))!!}
            {!!csrf_field()!!}
            <div class="form-group">
              <label for="username">Nama Pengguna</label>
              <input type="text" name='username' id="username" class="form-control" required placeholder="Nama Pengguna">
            </div>
            <div class="form-group">
              <label for="password">Kata Sandi</label>
              <input type="password" name='password' class="form-control" required placeholder="Kata Sandi">
            </div>
            <!--<div class="form-group">
                  <img src="{{ asset('packages/login/img/captcha.png') }}" alt="">
                </div>-->
            <div class="form-group">
              <label for="captcha">Klik Jawaban Untuk Login:</label><br>
              <strong>{{ $captchaQuestion }}</strong><br>
            </div>

            <div class="captcha-container">
              @foreach($choices as $choice)
              <button type="submit" name="captcha" value="{{ $choice }}" class="captcha-button">{{ $choice }}</button>
              @endforeach
            </div>
            <!-- 
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="reset" class="btn btn-default">Reset</button> -->
            {!!Form::close()!!}
            <hr>
            <img src="{{ asset('/packages/tte/logo-bsre.png') }}" style="max-height: 50px;">
          </div>
        </div><br>
        <p class="text-center animated fadeInUp">&copy;Pemerintah {!!getUtility('kab_instansi')!!}<br><b>{!!getUtility('nma_instansi')!!}</b><!--<br>Dikembangkan oleh <a href="http://dinustek.co.id" target="_blank">dinustek--></a></p>
      </div>
      <div class="col-md-8 col-md-pull-4">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-top:100px">
          <!-- Indicators -->
          <?php
          $i = 0;
          $rs = \DB::table('a_image_slider')->where('flag', 1)->orderBy('order')->get();
          ?>
          <ol class="carousel-indicators">
            @foreach($rs as $item)
            <li data-target="#carousel-example-generic" data-slide-to="{!!$i!!}" class="{!!($i == 0)?'active':''!!}"></li>
            <?php $i++; ?>
            @endforeach
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <?php $i = 0 ?>
            @foreach($rs as $item)
            <?php $i++; ?>
            <div class="item {!!($i == 1)?'active':''!!}">
              <img src="{{ asset('/packages/upload/photo/slider/'.$item->img) }}" alt="{!!$item->caption!!}" style="width: 100%; height: 450px">
              <div class="carousel-caption">{!!$item->caption!!}</div>
            </div>
            @endforeach
          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <!-- div class="text-center">&copy; Pemerintah Kabupaten Kendal<br><b>Badan Kepegawaian Pendidikan dan Pelatihan</b></a></div -->
      </div>
    </div>
  </div><!-- /.container -->
</body>

<!-- Layout by Rudi Kurniawan -->

</html>