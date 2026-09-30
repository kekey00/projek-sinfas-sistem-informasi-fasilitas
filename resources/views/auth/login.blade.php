<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.svg'))) }}">
    <title>Masuk - SINFAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="sinfas-bg">
    
    <!-- Floating Background Bubbles (Login: Di kiri bawah dan kanan bawah) -->
    <!-- Bubble Kiri Bawah (Floating) -->
    <div class="bubble-3d login-bubble login-bubble--bottom-left float-slow" style="width: 180px; height: 180px; bottom: -40px; left: 80px; opacity: 0.85;"></div>
    <div class="bubble-3d login-bubble login-bubble--mid-left float-reverse" style="width: 90px; height: 90px; bottom: 80px; left: -20px; opacity: 0.7;"></div>
    
    <!-- Bubble Kanan Bawah (Floating) -->
    <div class="bubble-3d login-bubble login-bubble--bottom-right float-reverse" style="width: 220px; height: 220px; bottom: -60px; right: 60px; opacity: 0.9;"></div>
    <div class="bubble-3d login-bubble login-bubble--mid-right float-fast" style="width: 120px; height: 120px; bottom: 150px; right: -30px; opacity: 0.8;"></div>
    
    <!-- Decorative bubbles on top for balance -->
    <div class="bubble-3d login-bubble login-bubble--top-left float-slow" style="width: 100px; height: 100px; top: 10%; left: 15%; opacity: 0.4;"></div>
    <div class="bubble-3d login-bubble login-bubble--top-right float-reverse" style="width: 70px; height: 70px; top: 8%; right: 20%; opacity: 0.45;"></div>

    <!-- Main Card Container -->
    <div class="sinfas-card max-w-[95%] md:max-w-[820px] w-full mx-auto my-auto flex-col md:flex-row shadow-2xl">
        
        <!-- Left Decorative Column (Hidden on mobile) -->
        <div class="card-decor-left hidden md:flex w-[340px] relative overflow-hidden self-stretch bg-[#F8FAFC] shrink-0 p-8 flex-col justify-between">
            <div class="card-curve"></div>
            
            <!-- Branding Header inside Left Column (Over Blue Curve) -->
            <div class="relative z-10">
                @include('components.sinfas-logo', ['class' => 'w-16 h-16 mb-5 drop-shadow-lg'])
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-xs font-bold text-white tracking-wider uppercase shadow-sm font-['Outfit']">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    SINFAS PORTAL
                </div>
                <h2 class="text-2xl xl:text-3xl font-black font-['Outfit'] text-white tracking-tight mt-4 leading-snug drop-shadow-sm">
                    Fasilitas<br>Sekolah
                </h2>
                <p class="text-xs font-medium text-blue-100/90 font-['Outfit'] mt-2.5 leading-relaxed max-w-[170px]">
                    Sistem peminjaman sarana prasarana sekolah yang cepat, rapi, dan terdata.
                </p>
            </div>
            
            <!-- Floating Spheres inside Left Column (1 Besar, 2 Kecil) -->
            <div class="relative z-0 h-36 my-2">
                <!-- Lingkaran 1 (Besar) -->
                <div class="bubble-3d float-slow" style="width: 110px; height: 110px; bottom: 10px; left: 15px;"></div>
                <!-- Lingkaran 2 (Sedang/Kecil) -->
                <div class="bubble-3d float-reverse" style="width: 65px; height: 65px; bottom: 70px; left: 140px;"></div>
                <!-- Lingkaran 3 (Kecil) -->
                <div class="bubble-3d float-fast" style="width: 45px; height: 45px; bottom: 15px; left: 175px;"></div>
            </div>

            <!-- Footer info inside Left Column -->
            <div class="relative z-10 text-[11px] font-semibold text-slate-500 font-['Outfit'] tracking-wide">
                © {{ date('Y') }} SINFAS • All Rights Reserved
            </div>
        </div>

        <!-- Right Form Column -->
        <div class="flex-1 w-full p-8 md:p-10 flex flex-col justify-center bg-white">
            <div class="text-center mb-6">
                <h1 class="playful-title">MASUK</h1>
                <p class="text-xs sm:text-sm font-medium text-slate-500 font-['Outfit'] mt-1">
                    Silakan masukkan akun Anda untuk melanjutkan
                </p>
            </div>

            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Tampilkan notifikasi sukses (misal setelah registrasi) --}}
                @if (session('success'))
                    <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-2.5 rounded-xl text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tampilkan error jika username/password salah --}}
                @if ($errors->has('login_error'))
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-2.5 rounded-xl text-xs font-semibold">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif

                <!-- Username Input -->
                <div>
                    <label for="username" class="sinfas-label">Username / NIS / NIP</label>
                    <input type="text" id="username" name="username" class="sinfas-input" placeholder="Masukkan username, NIS, atau NIP..." value="{{ old('username') }}" required autofocus>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="sinfas-label">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" class="sinfas-input pr-11" placeholder="Masukkan kata sandi..." required>
                        <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-login-pwd')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition cursor-pointer" title="Lihat/Sembunyikan Kata Sandi">
                            <svg id="eye-icon-login-pwd" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <!-- Lupa Password Link -->
                    <div class="text-right mt-1.5">
                        <a href="#" class="text-[12.5px] text-[#3B5998] hover:text-[#5B8DEF] underline font-semibold transition duration-200">Lupa Kata Sandi ?</a>
                    </div>
                </div>

                <!-- Login Button -->
                <div class="pt-2">
                    <button type="submit" class="sinfas-button py-3 text-base">Masuk</button>
                </div>
            </form>

            <!-- Link Text -->
            <div class="sinfas-link text-center mt-5">
                Belum punya akun ? <a href="{{ url('/register') }}">Daftar</a>
            </div>
        </div>
        
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                if (icon) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
                }
            } else {
                input.type = 'password';
                if (icon) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                }
            }
        }
    </script>
</body>
</html>