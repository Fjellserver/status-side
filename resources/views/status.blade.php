<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status side</title>
</head>
<body>
    @foreach($status as $key => $data)
    <tr>    
      <th>{{$data->host}}</th>
      <th>{{$data->up_down}}</th> 
      <th>{{$data->last_checked}}</th>
      <br>            
    </tr>
@endforeach
</body>
</html>