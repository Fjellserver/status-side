<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#1b316b">
    <link rel="icon" type="image/png" sizes="36x36" href="{{url('/img/android-icon-36x36.png')}}">
    <title>Fjellserver.no | Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{url('/css/style.css')}}">
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
      <option value="✅">✅Online</option>
      <option value="❌">❌Offline</option>
      <option value="⚠️">⚠️Warning</option>
      <option value="🛠️">🛠️Fix</option>
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
  <form action="{{url('dashboard')}}" method="post" >
    @csrf
  <div class="form-group">
    <label for="tittel">Tjeneste navn:</label>
    <input type="text" class="form-control" id="host" name="host" placeholder="Skriv navnet til tjenesten">
  </div>
  <div class="form-group">
    <label for="beskrivelse">Tjeneste adresse:</label>
    <input type="text" class="form-control" id="ip" name="ip" placeholder="Skriv adressen til tjenesten">
  </div>
  <button type="submit" class="btn btn-primary">Legg til</button>
</form>
</div>

<br>

<div class="container">
  @foreach($hosts as $key => $data)
    <ul class="list-group">
      <li class="list-group-item">{{$data->name}} <form action="{{url('dashboard')}}/{{$data->id}}" method="post"> @csrf <button type="submit" class="btn btn-primary">Fjern</button> </form></li>
    </ul>
  @endforeach
  </div>


  </div>
</body>
</html>