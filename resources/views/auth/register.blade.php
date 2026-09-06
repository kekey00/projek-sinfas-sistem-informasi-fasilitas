<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SINFAS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="sinfas-bg">
    
    <!-- Floating Background Bubbles (Register: Card di kanan, 3 lingkaran besar di kiri) -->
    <div class="hidden lg:block">
        <!-- Lingkaran 1: Besar (Floating kiri) -->
        <div class="bubble-3d float-slow" style="width: 250px; height: 250px; top: 15%; left: 8%; opacity: 0.95;"></div>
        <!-- Lingkaran 2: Sedang (Floating kiri) -->
        <div class="bubble-3d float-reverse" style="width: 140px; height: 140px; top: 55%; left: 5%; opacity: 0.85;"></div>
        <!-- Lingkaran 3: Kecil (Floating kiri) -->
        <div class="bubble-3d float-fast" style="width: 90px; height: 90px; top: 48%; left: 22%; opacity: 0.8;"></div>
    </div>
    
    <!-- Bubble tambahan di bagian kanan/belakang card untuk kedalaman visual -->
    <div class="bubble-3d float-slow" style="width: 180px; height: 180px; bottom: -50px; right: -30px; opacity: 0.65;"></div>
    <div class="bubble-3d float-reverse" style="width: 80px; height: 80px; top: 5%; right: 10%; opacity: 0.5;"></div>

    <!-- Main Card Container -->
    <div class="container max-w-[1200px] w-full px-4 flex flex-col lg:flex-row items-center justify-center lg:justify-end gap-12 z-10 my-auto">
        
        <!-- Left Column with WELCOME text -->
        <div class="hidden lg:flex flex-col justify-start items-start w-[400px] xl:w-[450px] z-10 self-stretch pt-24">
            <h1 class="text-7xl font-bold text-black font-['Gorditas'] tracking-widest select-none" style="text-shadow: 6px 6px 16px rgba(0, 0, 0, 0.95);">WELCOME</h1>
        </div>

        <!-- The Register Card (Width 450px, padding 40px) -->
        <div class="sinfas-card max-w-[450px] w-full flex-col bg-white">
            
            <!-- Corner curve at the top-left of the card -->
            <div class="absolute top-0 left-0 w-[180px] h-[180px] bg-gradient-to-br from-[#6B8DD6] to-[#2C4A7C] z-0" style="border-bottom-right-radius: 100%; border-right: 3px solid #3B5998; border-bottom: 3px solid #3B5998;"></div>
            
            <!-- Inner card bubbles at the bottom-left just like reference image -->
            <div class="absolute bottom-6 left-6 flex items-end gap-2.5 z-0 pointer-events-none">
                <div class="bubble-3d float-slow relative" style="width: 50px; height: 50px;"></div>
                <div class="bubble-3d float-reverse relative" style="width: 30px; height: 30px; bottom: 10px;"></div>
            </div>

            <!-- Card Content (form) -->
            <div class="relative z-10 p-6 md:p-8 w-full flex flex-col justify-center">
                <h1 class="playful-title mb-4">REGISTER</h1>

                {{-- Tampilkan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-xs font-semibold mb-3">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.process') }}" method="POST" class="space-y-3">
                    @csrf
                    <!-- Nama Input -->
                    <div>
                        <label for="nama" class="sinfas-label">Nama</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="sinfas-input" placeholder="Masukkan nama lengkap..." required autofocus>
                    </div>

                    <!-- Username Input -->
                    <div>
                        <label for="username" class="sinfas-label">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" class="sinfas-input" placeholder="Buat username untuk login..." required>
                    </div>

                    <!-- NIS Input -->
                    <div>
                        <label for="nis" class="sinfas-label">NIS</label>
                        <input type="text" id="nis" name="nis" value="{{ old('nis') }}" class="sinfas-input" placeholder="Masukkan NIS..." required>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="sinfas-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="sinfas-input" placeholder="Masukkan email..." required>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="sinfas-label">Password</label>
                        <input type="password" id="password" name="password" class="sinfas-input" placeholder="Buat password (min. 6 karakter)..." required>
                    </div>

                    <!-- Konfirmasi Password Input -->
                    <div>
                        <label for="password_confirmation" class="sinfas-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="sinfas-input" placeholder="Ulangi password..." required>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" class="sinfas-button">Daftar</button>
                    </div>
                </form>

                <!-- Link Text -->
                <div class="sinfas-link text-center mt-5">
                    Sudah memiliki akun ? <a href="{{ url('/login') }}">Masuk</a>
                </div>
            </div>
            
        </div>
        
    </div>
</body>
</html>
