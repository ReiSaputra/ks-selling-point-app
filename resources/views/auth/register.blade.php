<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white shadow-md rounded-xl p-6">
        <h2 class="text-2xl font-bold mb-5 text-center">Register</h2>

        <form method="POST" action="{{ route('register.perform') }}">
            @csrf

            <div class="mb-4">
                <label>Nama</label>
                <input type="text" name="name" required
                       class="w-full mt-1 p-2 border rounded">
            </div>

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" required
                       class="w-full mt-1 p-2 border rounded">
            </div>

            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password" required
                       class="w-full mt-1 p-2 border rounded">
            </div>

            <div class="mb-4">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full mt-1 p-2 border rounded">
            </div>

            <button class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">
                Register
            </button>

            <p class="mt-4 text-center text-sm">
                Sudah punya akun?
                <a class="text-blue-600" href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>
