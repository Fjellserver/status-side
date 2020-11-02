<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fjellserver.no | Status side</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{url('/css/app.css')}}">
</head>
<body>

<section class="bannerarea">
  <div class="container">
      <div class="row">
        <div class="d-flex flex-row">
            <h1 class="text-white p-2">Fjellserver.no</h1>
            <img class="p-2" src="{{url('/img/Fjellserver-logo-icon-transparent.svg')}}" alt="Fjellserver logo" width="60" height="60">
       </div>
  </div>
</section>

  <br>
  <div class="container">
  @foreach($status as $key => $data)
    @if($data->up_down == 'online')
    <div class="alert alert-success" role="alert">
      <div class="row">
        <div class="col-md-6">{{$data->host}}</div>
        <div class="col-md-6 text-right">{{$data->up_down}}</div>
      </div>
    </div>
    @endif
    @if($data->up_down == 'offline')
    <div class="alert alert-danger" role="alert">
      <div class="row">
          <div class="col-md-6">{{$data->host}}</div>
          <div class="col-md-6 text-right">{{$data->up_down}}</div>
        </div>
    </div>
    @endif
  @endforeach

  <div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<h4>Siste hendelser</h4>
			<ul class="timeline">
				<li>
        <a href="#">FEIL!</a>
					<a href="#" class="float-right">1 April, 2020</a>
					<p>bæbæbæbæ</p>
				</li>
				<li>
        <a href="#">FEIL!</a>
					<a href="#" class="float-right">1 April, 2020</a>
					<p>daada dfdaffa f af af  fa fa fa </p>
				</li>
				<li>
					<a href="#">FEIL!</a>
					<a href="#" class="float-right">1 April, 2020</a>
					<p>fa ffa a fa f af ewe ax</p>
				</li>
			</ul>
		</div>
	</div>
</div>

  </div>
</body>
</html>