<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fjellserver.no | Dashboard</title>
</head>
<body>
    <form action="{{url('dashboard')}}" method="post" >
    @csrf
        <label for="navn">Navn:</label>
        <input type="text" id="navn" name="navn">
        <br>
        <label for="beskrivelse">Beskrivelse:</label>
        <input type="text" id="beskrivelse" name="beskrivelse">
        <input type="submit">
    </form>
</body>
</html>