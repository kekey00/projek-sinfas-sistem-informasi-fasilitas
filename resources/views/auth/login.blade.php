<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SINFAS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="sinfas-bg">
    
    <!-- Floating Background Bubbles (Login: Di kiri bawah dan kanan bawah) -->
    <!-- Bubble Kiri Bawah (Floating) -->
    <div class="bubble-3d float-slow" style="width: 180px; height: 180px; bottom: -40px; left: 80px; opacity: 0.85;"></div>
    <div class="bubble-3d float-reverse" style="width: 90px; height: 90px; bottom: 80px; left: -20px; opacity: 0.7;"></div>
    
    <!-- Bubble Kanan Bawah (Floating) -->
    <div class="bubble-3d float-reverse" style="width: 220px; height: 220px; bottom: -60px; right: 60px; opacity: 0.9;"></div>
    <div class="bubble-3d float-fast" style="width: 120px; height: 120px; bottom: 150px; right: -30px; opacity: 0.8;"></div>
    
    <!-- Decorative bubbles on top for balance -->
    <div class="bubble-3d float-slow" style="width: 100px; height: 100px; top: 10%; left: 15%; opacity: 0.4;"></div>
    <div class="bubble-3d float-reverse" style="width: 70px; height: 70px; top: 8%; right: 20%; opacity: 0.45;"></div>

    <!-- Main Card Container -->
    <div class="sinfas-card max-w-[95%] md:max-w-[800px] w-full mx-auto my-auto flex-col md:flex-row">
        
        <!-- Left Decorative Column (Hidden on mobile) -->
        <div class="card-decor-left hidden md:flex w-[350px] relative overflow-hidden self-stretch bg-[#FDFDFD] shrink-0">
            <div class="card-curve"></div>
            
            <!-- Floating Spheres inside Left Column (1 Besar, 2 Kecil) -->
            <!-- Lingkaran 1 (Besar) -->
            <div class="bubble-3d float-slow" style="width: 130px; height: 130px; bottom: 40px; left: 30px;"></div>
            <!-- Lingkaran 2 (Sedang/Kecil) -->
            <div class="bubble-3d float-reverse" style="width: 70px; height: 70px; bottom: 150px; left: 180px;"></div>
            <!-- Lingkaran 3 (Kecil) -->
            <div class="bubble-3d float-fast" style="width: 50px; height: 50px; bottom: 30px; left: 220px;"></div>
        </div>

        <!-- Right Form Column -->
        <div class="flex-1 w-full p-8 md:p-10 flex flex-col justify-center bg-white">
            <h1 class="playful-title mb-8">LOGIN</h1>

            <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Tampilkan notifikasi sukses (misal setelah registrasi) --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tampilkan error jika username/password salah --}}
                @if ($errors->has('login_error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm font-semibold">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif

                <!-- Username Input -->
                <div>
                    <label for="username" class="sinfas-label">Username</label>
                    <input type="text" id="username" name="username" class="sinfas-input" placeholder="Masukkan username..." value="{{ old('username') }}" required autofocus>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="sinfas-label">Password</label>
                    <input type="password" id="password" name="password" class="sinfas-input" placeholder="Masukkan password..." required>
                    <!-- Lupa Password Link -->
                    <div class="text-right mt-1.5">
                        <a href="#" class="text-[13px] text-[#3B5998] hover:text-[#5B8DEF] underline font-semibold transition duration-200">Lupa Password ?</a>
                    </div>
                </div>

                <!-- Login Button -->
                <div class="pt-2">
                    <button type="submit" class="sinfas-button">Login</button>
                </div>
            </form>

            <!-- Link Text -->
            <div class="sinfas-link text-center mt-6">
                Belum punya akun ? <a href="{{ url('/register') }}">Daftar</a>
            </div>
        </div>
        
    </div>
</body>
</html>
