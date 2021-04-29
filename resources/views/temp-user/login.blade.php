<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Temporary Login</title>
    <style>
        .hireworks-logo{
                display: flex;
                margin-top: 22px;
                justify-content: center;
                padding-left: 26px;
        }
        .hireworks-logo > img{
                width: 166px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="h-screen">
        <div class="h-full py-32 flex justify-center content-center">
            <div class="shadow-lg w-3/12 bg-white">

                <div class="hireworks-logo">
                    <img src="/app-logo.png" alt="">
                </div>
                <div class="login text-center py-4">
                    <strong>Login</strong> <br>  <small>(One Time Login System)</small>
                </div>
                <hr>
                @if($errors->any())
                <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-pink-500">
                    <span class="inline-block align-middle mr-8">
                        {{ $errors->any() ? $errors->first() : '' }}
                    </span>
                </div>
                @endif
                <form action="/show-details" method="POST">
                    @csrf
                <div class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
                    <div class="mb-4">
                    <label class="block text-grey-darker text-sm font-bold mb-2" for="Email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="username" name="email" type="text" placeholder="Email">
                    </div>
                    <div class="mb-6">
                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" name="password" id="password" type="password" placeholder="*********">
                    </div>
                    <div class="flex items-center justify-center">
                        <button class="rounded focus:outline-none bg-purple-600 p-3 text-white">
                            Login
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>