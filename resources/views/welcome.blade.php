<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        {{-- Title --}}
        <title>CrimeAlert | Welcome</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
        
        <!-- Links -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="select-none">
        {{-- Header --}}
        <header class="flex justify-center items-center flex-col w-full h-screen bg-indigo-800 text-white">

            {{-- Links --}}
            <div class="p-3 fixed top-0 right-0 flex justify-between items-center w-full h-auto bg-indigo-800">
                <li class="list-none">
                    <a href="http://192.168.1.114:8000/register">Create An Account <i class="fas fa-user-plus"></i></a>
                </li>

                <li class="list-none">
                    <a href="http://192.168.1.114:8000/login">Login <i class="fas fa-sign-in-alt"></i></a>
                </li>
            </div>

            {{-- Title --}}
            <h1 class="sm:text-8xl text-5xl">CrimeAlert</h1>

            {{-- Slogan --}}
            <p class="mt-3 sm:text-2xl text-xl">Report a crime near you!</p>
        </header>

        {{-- Info --}}
        <div class="p-5 flex justify-center items-center flex-col w-full h-screen bg-white text-indigo-800">
            <h3 class="text-3xl">Welcome To Crime Alert!</h3>
            <p class="my-2 text-xl whitespace-pre-line text-center">
                Crime Alert is a place where we want you to feel safe to report a crime near you!

                All over the United Kingdom there are thousands of crimes taking place everyday and
                we are here to try and put a stop to it.

                If there is a crime taking place near you and you want to report it, then create an account with
                us today. We are here to help as much as we can.
            </p>
        </div>

        {{-- Steps --}}
        <div class="p-5 sm:flex block justify-center items-center w-full h-auto bg-indigo-800 text-white">
            {{-- Step 1 --}}
            <div class="sm:mb-0 mb-10 sm:mx-10 mx-auto p-2 w-4/5 h-350 bg-white text-indigo-800 sm:rounded-none rounded">
                <h4 class="p-2 w-full bg-indigo-800 text-white text-center">Step 1 | Create An Account</h4>
                <p class="flex justify-center items-center w-full h-full text-center text-xl">
                    <a href="http://192.168.1.114:8000/register">Create an account with us!</a>
                </p>
            </div>

            {{-- Step 2 --}}
            <div class="sm:mb-0 mb-10 sm:mx-10 mx-auto p-2 w-4/5 h-350 bg-white text-indigo-800 sm:rounded-none rounded">
                <h4 class="p-2 w-full bg-indigo-800 text-white text-center">Step 2 | Login</h4>
                <p class="flex justify-center items-center w-full h-full text-center text-xl">
                    <a href="http://192.168.1.114:8000/login">Login into your account!</a>
                </p>
            </div>

            {{-- Step 3 --}}
            <div class="sm:mt-0 mt-10 sm:mx-10 mx-auto p-2 w-4/5 h-350 bg-white text-indigo-800 sm:rounded-none rounded">
                <h4 class="p-2 w-full bg-indigo-800 text-white text-center">Step 3 | Report A Crime</h4>
                <p class="flex justify-center items-center w-full h-full text-center text-xl">
                    Report your crime on the posts page and wait
                    for an admin to approve your post.
                </p>
            </div>
        </div>
    </body>
</html>