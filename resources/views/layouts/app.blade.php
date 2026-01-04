<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ADFix - Gestión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-black text-white p-4 mb-6">
        <div class="max-w-6xl mx-auto flex gap-6">
            <span class="font-bold">ADFix</span>

            <a href="{{ route('repairs.index') }}" class="underline">
                Trabajos
            </a>

            <a href="{{ route('summary.index') }}" class="underline">
                Resumen
            </a>
        </div>
    </nav>


    <main class="px-4">
        @yield('content')
    </main>

</body>
</html>
