<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="theme-color" content="#1b316b"/>
    <title>Systemstatus | Fjellserver.no</title>
    <meta name="description" content="Er serveren din nede? Sjekk Systemstatus på systemer hos fjellserver.no">
    @include('layouts.meta')
    <link rel="stylesheet" href="{{url('/css/style.css')}}">
</head>
<body>
<div class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-light navbar-expand-lg navbar-static-top bg-secondary text-uppercase" style="padding-top: 0%; padding-bottom: 0%;" id="mainNav">
        <div class="container"><a class="navbar-brand js-scroll-trigger" href="https://fjellserver.no">FJELLSERVER&nbsp;<img id="nav-logo" alt="logo" src="https://fjellserver.no/assets/img/Fjellserver%20-logo%20icon%20transparent.svg"></a>
        </div>
</nav>

  <div class="container" style="margin-top: 16px;">
  @foreach($status as $key => $data)
    @if($data->down_count < 2)
    <div class="alert alert-success" role="alert">
      <div class="d-flex justify-content-between">
        <div>
          <div class="col-12">{{$data->host}}</div>
        </div>
        <div>
          <div class="circle pulse green"></div>
        </div>
      </div>
    </div>
    @endif
    @if($data->down_count > 2)
    <div class="alert alert-danger" role="alert">
      <div class="d-flex justify-content-between">
          <div>
            <div class="col-12">{{$data->host}}</div>
          </div>
          <div>
            <div class="circle pulse red"></div>
          </div>
        </div>
    </div>
    @endif
  @endforeach
  </div>

  <div class="container">
		<div class="col-md-6 offset-md-3">
			<h4>Siste hendelser:</h4>
			<ul class="timeline">
      @foreach($info as $key => $data)
				<li>
          <p>{{date("d.m.Y, H:i", strtotime($data->created_at))}}</p>
          <p class="font-weight-bold">{{$data->name}}</p>  
					<p class="font-weight-normal">{!! nl2br(e($data->description)) !!}</p>
          <p class="font-weight-normal">{!! nl2br(e($data->signatur)) !!}</p>
				</li>
      @endforeach
			</ul>
  </div>
</div>

@include('layouts.footer')
</body>
</html>