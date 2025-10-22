<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="theme-color" content="#1b316b"/>
    <title>Fjellserver.no | Systemstatus Dashboard</title>
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
  <h1>Endre tjeneste:</h1>
  @foreach($host as $key => $data)
  <form action="{{url('dashboard/hostedit/update')}}" method="post" >
    @csrf
  <div class="form-group">
    <label for="tittel">Tjeneste navn:</label>
    <input type="text" class="form-control" id="host" name="host" placeholder="Skriv navnet til tjenesten" value="{{$data->name}}">
  </div>
  <div class="form-group">
    <label for="beskrivelse">Tjeneste adresse:</label>
    <input type="text" class="form-control" id="ip" name="ip" placeholder="Skriv adressen til tjenesten" value="{{$data->ip}}">
  </div>
  <div class="form-group">
    <label for="beskrivelse">Port til tjeneste:</label>
    <input type="number" class="form-control" id="port" name="port" placeholder="Skriv porten til tjenesten" value="{{$data->port}}">
  </div>
  <div class="form-group">
    <label for="beskrivelse">Tjeneste rank: <small>1 kommer øverst på siden</small></label>
    <input type="number" class="form-control" id="rank" name="rank" placeholder="1 kommer øverst på siden" value="{{$data->rank}}">
  </div>
  <div class="form-group">
    <label for="beskrivelse">ID:</label>
    <input type="number" class="form-control" id="id" name="id" placeholder="Id" value="{{$data->id}}" readonly>
  </div>
  <button type="submit" class="btn btn-primary">Oppdater</button>
</form>
@endforeach
</div>

<main class="flex-fill"></main>
@include('layouts.footer')
</body>
</html>