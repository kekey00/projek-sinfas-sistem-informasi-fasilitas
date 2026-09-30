<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/sinfas-logo.svg') }}">
    <title>Daftar - SINFAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="sinfas-bg">
    
    <!-- Floating Background Bubbles (Register: Card di kanan, 3 lingkaran besar di kiri) -->
    <div class="hidden lg:block">
        <!-- Lingkaran 1: Besar (Floating kiri) -->
        <div class="bubble-3d float-slow" style="width: 220px; height: 220px; top: 12%; left: 3%; opacity: 0.65;"></div>
        <!-- Lingkaran 2: Sedang (Floating kiri) -->
        <div class="bubble-3d float-reverse" style="width: 130px; height: 130px; top: 62%; left: 4%; opacity: 0.75;"></div>
        <!-- Lingkaran 3: Kecil (Floating kiri) -->
        <div class="bubble-3d float-fast" style="width: 80px; height: 80px; top: 52%; left: 24%; opacity: 0.7;"></div>
    </div>
    
    <!-- Bubble tambahan di bagian kanan/belakang card untuk kedalaman visual -->
    <div class="bubble-3d float-slow" style="width: 170px; height: 170px; bottom: -40px; right: -20px; opacity: 0.55;"></div>
    <div class="bubble-3d float-reverse" style="width: 80px; height: 80px; top: 6%; right: 8%; opacity: 0.45;"></div>

    <!-- Main Card Container -->
    <div class="container max-w-[1200px] w-full px-4 flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-8 lg:gap-12 z-10 my-auto">
        
        <!-- Left Column with WELCOME text -->
        <div class="hidden lg:flex flex-col justify-center items-start w-[380px] xl:w-[460px] z-10 py-6">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/40 backdrop-blur-md border border-white/50 text-xs font-bold text-slate-800 tracking-wider uppercase mb-4 shadow-sm font-['Outfit']">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Sistem Informasi Fasilitas
            </div>
            <h1 class="welcome-title">WELCOME</h1>
            <p class="font-['Outfit'] font-medium text-slate-900/85 text-base mt-3 leading-relaxed max-w-sm">
                Daftarkan akun siswa Anda untuk mengakses layanan peminjaman fasilitas sekolah secara mudah dan terintegrasi.
            </p>
        </div>

        <!-- The Register Card (Grid 2 Kolom, Compact & Anti-Scroll) -->
        <div class="sinfas-card max-w-[560px] w-full flex-col bg-white shadow-2xl relative overflow-hidden">
            
            <!-- Corner accent at top-left (Clean, Non-overlapping) -->
            <div class="absolute top-0 left-0 w-[90px] h-[90px] bg-gradient-to-br from-[#6B8DD6] to-[#2C4A7C] z-0 pointer-events-none opacity-85" style="border-bottom-right-radius: 100%;"></div>
            
            <!-- Card Content (form) -->
            <div class="relative z-10 p-6 sm:p-8 w-full flex flex-col justify-center">
                <div class="text-center mb-5">
                    <img src="{{ asset('images/sinfas-logo.svg') }}" alt="Logo SINFAS" class="w-16 h-16 mx-auto mb-3 drop-shadow-md">
                    <h1 class="playful-title">DAFTAR</h1>
                    <p class="text-xs sm:text-sm font-medium text-slate-500 font-['Outfit'] mt-1">
                        Lengkapi formulir di bawah ini untuk membuat akun baru
                    </p>
                </div>

                {{-- Tampilkan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-2.5 rounded-xl text-xs font-semibold mb-4">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.process') }}" method="POST" class="space-y-3.5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <!-- Nama Input -->
                        <div>
                            <label for="nama" class="sinfas-label">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="sinfas-input" placeholder="Masukkan nama..." required autofocus>
                        </div>

                        <!-- Username Input -->
                        <div>
                            <label for="username" class="sinfas-label">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" class="sinfas-input" placeholder="Buat username..." required>
                        </div>

                        <!-- NIS Input -->
                        <div>
                            <label for="nis" class="sinfas-label">NIS</label>
                            <input type="text" id="nis" name="nis" value="{{ old('nis') }}" class="sinfas-input" placeholder="Nomor Induk Siswa..." required>
                        </div>

                        <!-- Nomor Telepon Input -->
                        <div>
                            <label for="no_telepon" class="sinfas-label">Nomor Telepon</label>
                            <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" class="sinfas-input" placeholder="Contoh: 081234567890..." required>
                        </div>

                        <!-- Email Input (Full width) -->
                        <div class="sm:col-span-2">
                            <label for="email" class="sinfas-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="sinfas-input" placeholder="Alamat email aktif..." required>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="sinfas-label">Kata Sandi</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" class="sinfas-input pr-11" placeholder="Min. 6 karakter..." required>
                                <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-reg-pwd')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition cursor-pointer" title="Lihat/Sembunyikan Kata Sandi">
                                    <svg id="eye-icon-reg-pwd" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password Input -->
                        <div>
                            <label for="password_confirmation" class="sinfas-label">Konfirmasi Kata Sandi</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="sinfas-input pr-11" placeholder="Ulangi kata sandi..." required>
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-reg-conf')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition cursor-pointer" title="Lihat/Sembunyikan Kata Sandi">
                                    <svg id="eye-icon-reg-conf" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="sinfas-button py-3 text-base">Daftar Akun</button>
                    </div>
                </form>

                <!-- Link Text -->
                <div class="sinfas-link text-center mt-4">
                    Sudah memiliki akun ? <a href="{{ url('/login') }}">Masuk</a>
                </div>
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
