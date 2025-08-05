<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- <link rel="stylesheet" href="{{asset('css/gosite_style.css')}}"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- <link rel="icon" href="{{asset('images/gosite/shape.png')}}"> -->
        <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->

    </head>
 
    <body class="container">
        @foreach ($jsonData as $item)
            <p>Schedule : {{ $item['schedule'] }}</p>
            <p>Estimate : {{ $item['estimate'] }}</p>
        @endforeach
        
    </body>

    <script type="text/javascript">
        
    </script>
</html>