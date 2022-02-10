<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>blog</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>

<body>

    <div id="app">
        <div class="container">
            <div class="row">

                <v-header></v-header>

            </div>
        </div>
        <router-view></router-view>
    </div>

</body>
<script src="{{ asset('/js/app.js') }}"></script>

</html>
