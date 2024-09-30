<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Master Wilayah</title>
    <link rel="icon" href="{{ asset("rsu-umm.png") }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body
    class="min-h-screen bg-gradient-to-br from-red-100 to-blue-300 flex items-center justify-center p-4 font-['Poppins']">
    {{ $slot }}
    @livewireScripts
</body>

</html>
