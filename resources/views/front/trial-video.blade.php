<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Video Check

    <form action="{{route('jobs.saveApplication')}}" method="post">
        @csrf
        <input type="text" name="name" id="name">
        <input type="file" accept="video/*" capture="camera" id="recorder">
        <video id="player" controls></video>
        <input type="submit" name="Submit" id="">
    </form>
        <script>
        var recorder = document.getElementById('recorder');
        var player = document.getElementById('player');

        recorder.addEventListener('change', function(e) {
            var file = e.target.files[0];
            // Do something with the video file.
            player.src = URL.createObjectURL(file);
        });
        </script>
</body>
</html>