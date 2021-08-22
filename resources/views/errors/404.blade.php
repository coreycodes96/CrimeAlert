<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        {{-- Title --}}
        <title>Debatevolution | Error!</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        
        <!-- Links -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        {{-- Error container --}}
        <div class="flex justify-center items-center flex-col w-full h-screen bg-indigo-800 select-none">
            {{-- Title --}}
            <h1 class="text-white text-3xl">Sorry Page Not Found <i class="fas fa-bomb text-red-500"></i></h1>

            @if(Auth::check())
                {{-- If the user is logged in --}}
                <a href="http://192.168.1.114:8000/announcements" class="mt-10 p-2 bg-white text-indigo-800 rounded">Go Back!</a>
            @else
                {{-- If the user is logged out --}}
                <a href="http://192.168.1.114:8000/" class="mt-10 p-2 bg-white text-indigo-800 rounded">Go Back!</a>
            @endif
        </div>
    </body>
</html>