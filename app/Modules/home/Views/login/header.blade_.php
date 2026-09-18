<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Simpeg {!!getUtility('kab_instansi')!!}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{ asset('packages/tugumuda/img/favicon.png') }}" rel='icon' type='image/x-icon'/>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/bootstrap.min.css')!!}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/font-awesome.min.css')!!}">
  <!-- Animate CSS -->
  <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/animate.css')!!}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/ionicons.min.css')!!}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{!!asset('packages/tugumuda/css/AdminLTE.min.css')!!}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src='https://www.google.com/recaptcha/api.js?hl=id'></script>

  <style>
    html{
      <?php if(\Request::segment(1) === 'login') { ?>
      background: #ffffff;
      background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjM5JSIgc3RvcC1jb2xvcj0iI2RiZjRmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9Ijg4JSIgc3RvcC1jb2xvcj0iIzY4OTE5ZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM1YTdlOGEiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
      background: -moz-linear-gradient(top,  #ffffff 0%, #dbf4fc 39%, #68919f 88%, #5a7e8a 100%);
      background: -webkit-linear-gradient(top,  #ffffff 0%,#dbf4fc 39%,#68919f 88%,#5a7e8a 100%);
      background: linear-gradient(to bottom,  #ffffff 0%,#dbf4fc 39%,#68919f 88%,#5a7e8a 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#5a7e8a',GradientType=0 );
      <?php } elseif(\Request::segment(1) === 'login-eksekutif') { ?>
      /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#fefcea+0,f95339+100 */
      background: #fefcea; /* Old browsers */
      background: -moz-linear-gradient(top,  #fefcea 0%, #f95339 100%); /* FF3.6-15 */
      background: -webkit-linear-gradient(top,  #fefcea 0%,#f95339 100%); /* Chrome10-25,Safari5.1-6 */
      background: linear-gradient(to bottom,  #fefcea 0%,#f95339 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefcea', endColorstr='#f95339',GradientType=0 ); /* IE6-9 */
      <?php } elseif(\Request::segment(1) === 'login-pegawai') { ?>
      background: #f8ffe8; /* Old browsers */
      background: -moz-linear-gradient(top,  #f8ffe8 0%, #e3f5ab 33%, #b7df2d 100%); /* FF3.6-15 */
      background: -webkit-linear-gradient(top,  #f8ffe8 0%,#e3f5ab 33%,#b7df2d 100%); /* Chrome10-25,Safari5.1-6 */
      background: linear-gradient(to bottom,  #f8ffe8 0%,#e3f5ab 33%,#b7df2d 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8ffe8', endColorstr='#b7df2d',GradientType=0 ); /* IE6-9 */
      <?php } else { ?>
      background: #ffffff;
      background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjM5JSIgc3RvcC1jb2xvcj0iI2RiZjRmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9Ijg4JSIgc3RvcC1jb2xvcj0iIzY4OTE5ZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM1YTdlOGEiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
      background: -moz-linear-gradient(top,  #ffffff 0%, #dbf4fc 39%, #68919f 88%, #5a7e8a 100%);
      background: -webkit-linear-gradient(top,  #ffffff 0%,#dbf4fc 39%,#68919f 88%,#5a7e8a 100%);
      background: linear-gradient(to bottom,  #ffffff 0%,#dbf4fc 39%,#68919f 88%,#5a7e8a 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#5a7e8a',GradientType=0 );
      <?php } ?>
    }
    body{
        padding-top: .62em;
        height: 100%;
        height: 100vh;
        background-color: transparent;
        background-image: url('{!!url()!!}/packages/tugumuda/img/bg-simpeg.png');
        background-position: bottom center;
        background-repeat: repeat-x;
    }
    .login-logo{
      font-size: 23px;
      text-transform: uppercase;
      line-height: 1.1em;
      font-weight: 400;
      -webkit-animation-delay: .3s;
           -o-animation-delay: .3s;
              animation-delay: .3s;
    }
    .login-logo img{
      display: block;
      margin: 10px auto;
    }
    .login-box{
      margin: 4% auto;
    }
    .login-box-body{
      margin-bottom: 15px;
      -webkit-animation-delay: .6s;
           -o-animation-delay: .6s;
              animation-delay: .6s;
    }
    .login-box-body .form-group{
      -webkit-animation-delay: .9s;
           -o-animation-delay: .9s;
              animation-delay: .9s;
    }
    .login-box-body .form-group+.form-group{
      -webkit-animation-delay: 1.2s;
           -o-animation-delay: 1.2s;
              animation-delay: 1.2s;
    }
    .login-box-body .row{
      -webkit-animation-delay: 1.5s;
           -o-animation-delay: 1.5s;
              animation-delay: 1.5s;
    }
    .login-box p{
      -webkit-animation-delay: 1.8s;
           -o-animation-delay: 1.8s;
              animation-delay: 1.8s;
    }
    .login-box p a{
      color: inherit;
    }
  </style>
    
</head>