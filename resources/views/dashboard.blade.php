<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="theme-color" content="#1b316b"/>
    <title>Systemstatus Dashboard | Fjellserver.no</title>
    @include('layouts.meta')
    <link rel="stylesheet" href="{{url('/css/style.css')}}">
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
  <a class="btn btn-primary btn-lg float-right" style="margin-top: 8px;" href="/user/profile" role="button">Din bruker</a>
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
      <option value="good">✅Tjenesten er online</option>
      <option value="bad">❌Tjenesten er offline</option>
      <option value="warning">⚠️Advarsel</option>
      <option value="fix">🛠️Planlagt vedlikehold</option>
    </select>
  </div>
  <div class="form-group">
    <label for="beskrivelse">Beskrivelse:</label>
    <textarea class="form-control" id="description" name="description" rows="5"></textarea>
  </div>
  <div class="form-group">
    <label for="signatur">Signatur:</label>
    <textarea type="text" class="form-control" id="signatur" name="signatur" placeholder="Skriv en signatur her" rows="3" required>{{ $infoone->signatur }}</textarea>
  
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
          <p>{{$data->signatur}}</p>
          <a><form action="{{url('dashboard')}}/info/{{$data->id}}" method="post"> @csrf <button type="submit" class="btn btn-primary">Fjern</button></form></a>
				</li>
      @endforeach
			</ul>
		</div>
	</div>
</div>
</div>

<main class="flex-fill"></main>
@include('layouts.footer')
</body>
</html>