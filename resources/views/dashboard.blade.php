<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="theme-color" content="#1b316b"/>
    <title>Systemstatus Dashboard | Fjellserver.no</title>
    <meta property="og:type" content="website">
    <link rel="icon" type="image/png" sizes="36x36" href="https://fjellserver.no/assets/img/android-icon-36x36.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://fjellserver.no/assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="https://fjellserver.no/assets/img/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://fjellserver.no/assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="mask-icon" href="https://fjellserver.no/assets/img/safari-pinned-tab.svg" color="#1b316b">
    <link rel="shortcut icon" href="https://fjellserver.no/assets/img/favicon.ico">
    <meta name="msapplication-config" content="https://fjellserver.no/assets/img/browserconfig.xml">
    <link rel="stylesheet" href="https://fjellserver.no/assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://fjellserver.no/assets/css/logo.css">
    <link rel="stylesheet" href="https://fjellserver.no/assets/css/main.css">
    <link rel="stylesheet" href="{{url('/css/style.css')}}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MHEBZGDRYE"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-MHEBZGDRYE');
    </script>
</head>
<body>
<div class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-light navbar-expand-lg navbar-static-top bg-secondary text-uppercase" style="padding-top: 0%; padding-bottom: 0%;" id="mainNav">
        <div class="container"><a class="navbar-brand js-scroll-trigger" href="https://fjellserver.no">FJELLSERVER&nbsp;<img id="nav-logo" alt="logo" src="https://fjellserver.no/assets/img/Fjellserver%20-logo%20icon%20transparent.svg"></a>
        </div>
</nav>

  <br>

  <div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <h1>Hendelse:</h1>
  <form action="{{url('dashboard')}}" method="post" >
    @csrf
  <div class="form-group">
    <label for="tittel">Tittel:</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Skriv tittel på hendelse">
  </div>
  <div class="form-group">
    <label for="category">Kategori:</label>
    <select class="form-control" id="category" name="category">
      <option value="good">✅Online</option>
      <option value="bad">❌Offline</option>
      <option value="warning">⚠️Warning</option>
      <option value="fix">🛠️Fix</option>
    </select>
  </div>
  <div class="form-group">
    <label for="beskrivelse">Beskrivelse:</label>
    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Publiser</button>
</form>
</div>

<div class="container">
  <h1>Legg til tjeneste:</h1>
  <form action="{{url('dashboard/update')}}" method="post" >
    @csrf
  <div class="form-group">
    <label for="tittel">Tjeneste navn:</label>
    <input type="text" class="form-control" id="host" name="host" placeholder="Skriv navnet til tjenesten">
  </div>
  <div class="form-group">
    <label for="beskrivelse">Tjeneste adresse:</label>
    <input type="text" class="form-control" id="ip" name="ip" placeholder="Skriv adressen til tjenesten">
  </div>
  <div class="form-group">
    <label for="beskrivelse">Port til tjeneste:</label>
    <input type="number" class="form-control" id="port" name="port" placeholder="Skriv porten til tjenesten">
  </div>
  <div class="form-group">
    <label for="beskrivelse">Tjeneste rank: <small>1 kommer øverst på siden</small></label>
    <input type="number" class="form-control" id="rank" name="rank" placeholder="1 kommer øverst på siden">
  </div>
  <button type="submit" class="btn btn-primary">Legg til</button>
</form>
</div>

<br>

<div class="container">
  <h1>Fjern tjeneste:</h1>
  @foreach($hosts as $key => $data)
    <ul class="list-group">
      <li class="list-group-item">
        <h5>{{$data->name}}</h5>
        <p>{{$data->created_at}}</p>
        <p>{{$data->ip}}</p>
        <p>Port: {{$data->port}}</p>
        <p>Rank: {{$data->rank}}</p>
        <a type="submit" class="btn btn-primary" href="{{ url('dashboard')}}/hostedit?host={{$data->id}}">Endre</a>
         <form action="{{url('dashboard')}}/host/{{$data->id}}" method="post"> @csrf 
          <button type="submit" class="btn btn-primary float-right">Fjern</button>
         </form>
      </li>
    </ul>
  @endforeach
  </div>

  <div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<h4>Fjern infomelding:</h4>
			<ul class="timeline">
      @foreach($info as $key => $data)
				<li>
        <a href="#">{{$data->name}}</a>
					<a class="float-right">{{$data->created_at}}</a>
					<p>{{$data->description}}</p>
          <a><form action="{{url('dashboard')}}/info/{{$data->id}}" method="post"> @csrf <button type="submit" class="btn btn-primary">Fjern</button></form></a>
				</li>
      @endforeach
			</ul>
		</div>
	</div>
</div>
</div>

<main class="flex-fill"></main>
<footer class="footer text-center" style="background-color: #1B316B; padding-bottom: 0%; padding-top: 0%;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-5 mb-lg-0">
                <h4 class="text-uppercase mb-4"></h4>
                <p></p>
            </div>
            <div class="col-md-4 mb-5 mb-lg-0">
                <h4 class="text-uppercase"><strong>sosialt</strong></h4>
                <ul class="list-inline">
                    <li class="list-inline-item"><a class="btn btn-outline-light btn-social text-center rounded-circle" role="button" aria-label="Facebook" href="https://www.facebook.com/fjellserver/" target="_blank" rel="noopener"><i class="fab fa-facebook-f fa-fw"></i></a></li>
                    <li class="list-inline-item"><a class="btn btn-outline-light btn-social text-center rounded-circle" role="button" aria-label="Instagram" href="https://www.instagram.com/fjellserver/"><i class="fab fa-instagram fa-fw"></i></a></li>
                    <li class="list-inline-item"><a class="btn btn-outline-light btn-social text-center rounded-circle" role="button" aria-label="Discord" href="https://discord.gg/STX8gt6"><i class="fab fa-discord fa-fw"></i></a></li>
                    <li class="list-inline-item"><a class="btn btn-outline-light btn-social text-center rounded-circle" role="button" aria-label="YouTube" href="https://www.youtube.com/channel/UCTLsqpKLdkaYBMEgY2Ogpzg/"><i class="fab fa-youtube fa-fw"></i></a></li>
                    <li class="list-inline-item"><a class="btn btn-outline-light btn-social text-center rounded-circle" role="button" aria-label="E-post" href="mailto:kontakt@fjellserver.no"><i class="fas fa-envelope fa-fw"></i></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4 class="text-uppercase mb-4"></h4>
                <p class="lead mb-0"><span></span></p>
            </div>
        </div>
    </div>
    <div class="copyright py-4 text-center text-white" style="background-color: #2c3e50;">
        <div class="container">
        <small id="year">Opphavsrett © Fjellserver 2019 -&nbsp;</small>
        <br>
        <small>Fjellserver.no er på ingen måte tilknyttet/levert/drevet/støttet av Mojang AB eller Microsoft.</small>
        </div>
    </div>
</footer>
</div>
    <script src="https://fjellserver.no/assets/js/jquery.min.js"></script>
    <script src="https://fjellserver.no/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://fjellserver.no/assets/js/year.js"></script>
</body>
</html>