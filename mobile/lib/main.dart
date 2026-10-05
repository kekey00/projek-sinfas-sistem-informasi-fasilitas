import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:http/http.dart' as http;

const _ink = Color(0xFF0F172A);
const _primary = Color(0xFF4F46E5);
const _primaryDark = Color(0xFF2C4A7C);
const _primarySoft = Color(0xFFEEF2FF);
const _paper = Color(0xFFF1F5FA);
const _storage = FlutterSecureStorage();

void main() {
  runApp(const SinfasMobileApp());
}

class SinfasMobileApp extends StatefulWidget {
  const SinfasMobileApp({super.key});

  @override
  State<SinfasMobileApp> createState() => _SinfasMobileAppState();
}

class _SinfasMobileAppState extends State<SinfasMobileApp> {
  String? _token;
  bool _checkingSession = true;

  @override
  void initState() {
    super.initState();
    _restoreSession();
  }

  Future<void> _restoreSession() async {
    String? token;
    try {
      token = await _storage.read(key: 'access_token');
    } catch (_) {
      token = null;
    }
    if (!mounted) return;
    setState(() {
      _token = token;
      _checkingSession = false;
    });
  }

  Future<void> _signedIn(String token) async {
    await _storage.write(key: 'access_token', value: token);
    if (mounted) setState(() => _token = token);
  }

  Future<void> _signedOut() async {
    await _storage.delete(key: 'access_token');
    if (mounted) setState(() => _token = null);
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'SINFAS Mobile',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: _primary, primary: _primary, surface: _paper),
        textTheme: GoogleFonts.plusJakartaSansTextTheme(),
        scaffoldBackgroundColor: _paper,
        appBarTheme: const AppBarTheme(
          backgroundColor: _paper,
          foregroundColor: _ink,
          elevation: 0,
          centerTitle: false,
        ).copyWith(titleTextStyle: GoogleFonts.outfit(fontSize: 17, fontWeight: FontWeight.w800, color: _ink)),
        inputDecorationTheme: InputDecorationTheme(
          filled: true,
          fillColor: Colors.white,
          contentPadding: const EdgeInsets.symmetric(horizontal: 15, vertical: 12),
          border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(9),
              borderSide: const BorderSide(color: Color(0xFF3B5998), width: 1.4),
          ),
          enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(9),
              borderSide: const BorderSide(color: Color(0xFF3B5998), width: 1.4),
          ),
        ),
      ),
      home: _checkingSession
          ? const _LoadingPage()
          : _token == null
              ? _LoginPage(onSignedIn: _signedIn)
              : _HistoryPage(token: _token!, onSignedOut: _signedOut),
    );
  }
}

class _LoadingPage extends StatelessWidget {
  const _LoadingPage();

  @override
  Widget build(BuildContext context) => const Scaffold(
        body: Center(child: CircularProgressIndicator()),
      );
}

class _SinfasMark extends StatelessWidget {
  const _SinfasMark({this.size = 58});

  final double size;

  @override
  Widget build(BuildContext context) => Container(
        width: size,
        height: size,
        clipBehavior: Clip.antiAlias,
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(size * .24),
          boxShadow: [BoxShadow(color: _primaryDark.withValues(alpha: .18), blurRadius: 14, offset: const Offset(0, 5))],
        ),
        child: Image.asset('assets/sinfas-logo.png', fit: BoxFit.cover),
      );
}

class _GridPainter extends CustomPainter {
  const _GridPainter();

  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()
      ..color = const Color(0x084F46E5)
      ..strokeWidth = 1;
    for (double x = 0; x < size.width; x += 34) {
      canvas.drawLine(Offset(x, 0), Offset(x, size.height), paint);
    }
    for (double y = 0; y < size.height; y += 34) {
      canvas.drawLine(Offset(0, y), Offset(size.width, y), paint);
    }
  }

  @override
  bool shouldRepaint(covariant _GridPainter oldDelegate) => false;
}

class _LoginPage extends StatefulWidget {
  const _LoginPage({required this.onSignedIn});

  final ValueChanged<String> onSignedIn;

  @override
  State<_LoginPage> createState() => _LoginPageState();
}

class _LoginBubble extends StatelessWidget {
  const _LoginBubble({required this.size});

  final double size;

  @override
  Widget build(BuildContext context) => Container(
        width: size,
        height: size,
        decoration: BoxDecoration(
          shape: BoxShape.circle,
          gradient: const RadialGradient(
            center: Alignment(-.35, -.35),
            radius: 1,
            colors: [Color(0xFF7BA7D9), Color(0xFF3B5998), Color(0xFF2C4A7C), Color(0xFF152644)],
            stops: [0, .45, .85, 1],
          ),
          border: Border.all(color: Colors.white.withValues(alpha: .24)),
          boxShadow: [BoxShadow(color: _primaryDark.withValues(alpha: .28), blurRadius: 18, offset: const Offset(0, 8))],
        ),
      );
}

class _GradientButton extends StatelessWidget {
  const _GradientButton({required this.onPressed, required this.loading, required this.label});

  final VoidCallback? onPressed;
  final bool loading;
  final String label;

  @override
  Widget build(BuildContext context) => Container(
        height: 52,
        decoration: BoxDecoration(
          gradient: const LinearGradient(colors: [Color(0xFF6B8DD6), _primaryDark]),
          borderRadius: BorderRadius.circular(12),
          boxShadow: [BoxShadow(color: _primaryDark.withValues(alpha: .22), blurRadius: 14, offset: const Offset(0, 5))],
        ),
        child: Material(
          color: Colors.transparent,
          borderRadius: BorderRadius.circular(12),
          child: InkWell(
            onTap: onPressed,
            borderRadius: BorderRadius.circular(12),
            child: Center(
              child: loading
                  ? const SizedBox.square(dimension: 21, child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white))
                  : Text(label, style: const TextStyle(color: Colors.white, fontWeight: FontWeight.w800)),
            ),
          ),
        ),
      );
}

class _LoginPageState extends State<_LoginPage> {
  final _formKey = GlobalKey<FormState>();
  final _identifierController = TextEditingController();
  final _passwordController = TextEditingController();
  bool _loading = false;
  bool _obscurePassword = true;
  String? _error;

  @override
  void dispose() {
    _identifierController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() {
      _loading = true;
      _error = null;
    });

    try {
      final token = await StudentApi.login(
        identifier: _identifierController.text.trim(),
        password: _passwordController.text,
      );
      widget.onSignedIn(token);
    } on ApiException catch (exception) {
      setState(() => _error = exception.message);
    } catch (_) {
      setState(() => _error = 'Tidak dapat terhubung ke server. Periksa alamat API dan jaringan.');
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
            colors: [Color(0xFF4A6FA5), Color(0xFF6B8DD6), Color(0xFF8E9AAF)],
          ),
        ),
        child: Stack(
          children: [
            const Positioned(left: -25, top: 14, child: _LoginBubble(size: 90)),
            const Positioned(right: -20, top: 45, child: _LoginBubble(size: 72)),
            const Positioned(left: -32, bottom: 24, child: _LoginBubble(size: 112)),
            const Positioned(right: -18, bottom: 8, child: _LoginBubble(size: 130)),
            SafeArea(
              child: Center(
                child: SingleChildScrollView(
                  padding: const EdgeInsets.all(18),
                  child: ConstrainedBox(
                    constraints: const BoxConstraints(maxWidth: 430),
                    child: Container(
                      padding: const EdgeInsets.all(22),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(22),
                        boxShadow: [BoxShadow(color: _primaryDark.withValues(alpha: .22), blurRadius: 30, offset: const Offset(0, 16))],
                      ),
                      child: Form(
                        key: _formKey,
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.stretch,
                          children: [
                            Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                const _SinfasMark(size: 56),
                                const SizedBox(width: 12),
                                Text('MASUK', style: GoogleFonts.outfit(color: _ink, fontSize: 38, fontWeight: FontWeight.w800)),
                              ],
                            ),
                            const SizedBox(height: 7),
                            const Text(
                              'Silakan masukkan akun untuk melihat status peminjaman.',
                              textAlign: TextAlign.center,
                              style: TextStyle(color: Color(0xFF64748B), fontSize: 12, height: 1.5),
                            ),
                            const SizedBox(height: 19),
                            const Text('Username / NIS', style: TextStyle(color: Color(0xFF1E293B), fontSize: 13, fontWeight: FontWeight.w600)),
                            const SizedBox(height: 6),
                            TextFormField(
                              controller: _identifierController,
                              textInputAction: TextInputAction.next,
                              decoration: const InputDecoration(
                                hintText: 'Masukkan username atau NIS...',
                              ),
                              validator: (value) => value == null || value.trim().isEmpty ? 'Isi username atau NIS.' : null,
                            ),
                            const SizedBox(height: 12),
                            const Text('Kata Sandi', style: TextStyle(color: Color(0xFF1E293B), fontSize: 13, fontWeight: FontWeight.w600)),
                            const SizedBox(height: 6),
                            TextFormField(
                              controller: _passwordController,
                              obscureText: _obscurePassword,
                              onFieldSubmitted: (_) => _login(),
                              decoration: InputDecoration(
                                hintText: 'Masukkan kata sandi...',
                                suffixIcon: IconButton(
                                  tooltip: _obscurePassword ? 'Tampilkan kata sandi' : 'Sembunyikan kata sandi',
                                  onPressed: () => setState(() => _obscurePassword = !_obscurePassword),
                                  icon: Icon(_obscurePassword ? Icons.visibility_outlined : Icons.visibility_off_outlined),
                                ),
                              ),
                              validator: (value) => value == null || value.isEmpty ? 'Isi kata sandi.' : null,
                            ),
                            if (_error != null) ...[
                              const SizedBox(height: 12),
                              Text(_error!, style: const TextStyle(color: Color(0xFFB42318), fontSize: 12, height: 1.4)),
                            ],
                            const SizedBox(height: 18),
                            _GradientButton(onPressed: _loading ? null : _login, loading: _loading, label: 'Masuk'),
                          ],
                        ),
                      ),
                    ),
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _HistoryPage extends StatefulWidget {
  const _HistoryPage({required this.token, required this.onSignedOut});

  final String token;
  final VoidCallback onSignedOut;

  @override
  State<_HistoryPage> createState() => _HistoryPageState();
}

class _HistoryPageState extends State<_HistoryPage> {
  late Future<LoanHistory> _history;

  @override
  void initState() {
    super.initState();
    _history = StudentApi.history(widget.token);
  }

  Future<void> _refresh() async {
    final request = StudentApi.history(widget.token);
    setState(() => _history = request);
    await request;
  }

  Future<void> _logout() async {
    try {
      await StudentApi.logout(widget.token);
    } catch (_) {
      // Hapus token lokal meskipun server tidak dapat dijangkau.
    }
    widget.onSignedOut();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Row(
          children: [
            const _SinfasMark(size: 38),
            const SizedBox(width: 10),
            const Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text('SINFAS', style: TextStyle(fontSize: 17, fontWeight: FontWeight.w800)),
                Text('Riwayat siswa', style: TextStyle(fontSize: 11, color: Color(0xFF63737C))),
              ],
            ),
          ],
        ),
        actions: [
          IconButton(
            tooltip: 'Keluar',
            onPressed: _logout,
            icon: const Icon(Icons.logout_rounded),
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: CustomPaint(
        painter: const _GridPainter(),
        child: FutureBuilder<LoanHistory>(
        future: _history,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting && !snapshot.hasData) {
            return const Center(child: CircularProgressIndicator());
          }
          if (snapshot.hasError) {
            final error = snapshot.error;
            if (error is ApiException && error.statusCode == 401) {
              WidgetsBinding.instance.addPostFrameCallback((_) => widget.onSignedOut());
            }
            return _ErrorView(message: error is ApiException ? error.message : 'Gagal memuat riwayat peminjaman.', onRetry: _refresh);
          }

          final history = snapshot.data!;
          return RefreshIndicator(
            onRefresh: _refresh,
            child: CustomScrollView(
              physics: const AlwaysScrollableScrollPhysics(),
              slivers: [
                SliverPadding(
                  padding: const EdgeInsets.fromLTRB(18, 12, 18, 28),
                  sliver: SliverList(
                    delegate: SliverChildListDelegate([
                      const Text('Aktivitas peminjaman', style: TextStyle(color: _ink, fontSize: 23, fontWeight: FontWeight.w800)),
                      const SizedBox(height: 5),
                      const Text('Status verifikasi dan catatan setiap barang.', style: TextStyle(color: Color(0xFF63737C))),
                      const SizedBox(height: 20),
                      _SummaryStrip(summary: history.summary),
                      const SizedBox(height: 28),
                      Row(
                        children: [
                          const Expanded(child: Text('Riwayat barang', style: TextStyle(color: _ink, fontSize: 18, fontWeight: FontWeight.w800))),
                          Text('${history.items.length} pengajuan', style: const TextStyle(color: Color(0xFF63737C), fontSize: 12, fontWeight: FontWeight.w600)),
                        ],
                      ),
                      const SizedBox(height: 12),
                      if (history.items.isEmpty)
                        const _EmptyHistory()
                      else
                        ...history.items.map((item) => Padding(
                              padding: const EdgeInsets.only(bottom: 12),
                              child: _LoanCard(item: item),
                            )),
                    ]),
                  ),
                ),
              ],
            ),
          );
        },
        ),
      ),
    );
  }
}

class _SummaryStrip extends StatelessWidget {
  const _SummaryStrip({required this.summary});

  final Map<String, dynamic> summary;

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Expanded(child: _SummaryTile(value: '${summary['total_dipinjam'] ?? 0}', label: 'Disetujui', color: _primary)),
        const SizedBox(width: 9),
        Expanded(child: _SummaryTile(value: '${summary['menunggu_verifikasi'] ?? 0}', label: 'Menunggu', color: const Color(0xFF9A6700))),
        const SizedBox(width: 9),
        Expanded(child: _SummaryTile(value: '${summary['ditolak'] ?? 0}', label: 'Ditolak', color: const Color(0xFFB42318))),
      ],
    );
  }
}

class _SummaryTile extends StatelessWidget {
  const _SummaryTile({required this.value, required this.label, required this.color});

  final String value;
  final String label;
  final Color color;

  @override
  Widget build(BuildContext context) {
    return Container(
      constraints: const BoxConstraints(minHeight: 82),
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 13),
      decoration: BoxDecoration(color: Colors.white, border: Border.all(color: const Color(0xFFE2EAE8)), borderRadius: BorderRadius.circular(12)),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(value, style: TextStyle(color: color, fontSize: 23, fontWeight: FontWeight.w800, height: 1)),
          const SizedBox(height: 6),
          FittedBox(
            alignment: Alignment.centerLeft,
            fit: BoxFit.scaleDown,
            child: Text(label, style: const TextStyle(color: Color(0xFF63737C), fontSize: 11, fontWeight: FontWeight.w600)),
          ),
        ],
      ),
    );
  }
}

class _LoanCard extends StatelessWidget {
  const _LoanCard({required this.item});

  final LoanRecord item;

  @override
  Widget build(BuildContext context) {
    final statusStyle = _statusStyle(item.status);
    final returned = item.status == 'selesai';
    final returnDate = returned ? item.tanggalPengembalian : item.tanggalKembali;
    final returnTime = returned ? item.waktuLaporanPengembalian : item.jamKembali;

    return Container(
      padding: const EdgeInsets.all(15),
      decoration: BoxDecoration(color: Colors.white, border: Border.all(color: const Color(0xFFE2EAE8)), borderRadius: BorderRadius.circular(14)),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Container(
                width: 42,
                height: 42,
                decoration: BoxDecoration(color: _primarySoft, borderRadius: BorderRadius.circular(11)),
                child: const Icon(Icons.inventory_2_outlined, color: _primary, size: 21),
              ),
              const SizedBox(width: 11),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(item.namaBarang, style: const TextStyle(color: _ink, fontSize: 15, fontWeight: FontWeight.w800)),
                    const SizedBox(height: 3),
                    Text(item.kodePinjam, style: const TextStyle(color: Color(0xFF75858C), fontSize: 11)),
                  ],
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
            decoration: BoxDecoration(color: statusStyle.background, borderRadius: BorderRadius.circular(7)),
            child: Text(statusStyle.label, style: TextStyle(color: statusStyle.foreground, fontSize: 11, fontWeight: FontWeight.w700)),
          ),
          const SizedBox(height: 13),
          _DateRow(label: 'Diajukan', value: _formatDateTime(item.tanggalPengajuan, includeDate: true)),
          const SizedBox(height: 7),
          _DateRow(label: 'Waktu pinjam', value: _formatDateTime(item.tanggalPinjam, time: item.jamPinjam)),
          const SizedBox(height: 7),
          _DateRow(label: returned ? 'Dilaporkan kembali' : 'Rencana kembali', value: _formatDateTime(returnDate, time: returnTime)),
        ],
      ),
    );
  }
}

class _DateRow extends StatelessWidget {
  const _DateRow({required this.label, required this.value});

  final String label;
  final String value;

  @override
  Widget build(BuildContext context) => Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(width: 128, child: Text(label, style: const TextStyle(color: Color(0xFF63737C), fontSize: 11))),
          Expanded(child: Text(value, style: const TextStyle(color: _ink, fontSize: 11, fontWeight: FontWeight.w600))),
        ],
      );
}

class _EmptyHistory extends StatelessWidget {
  const _EmptyHistory();

  @override
  Widget build(BuildContext context) => Container(
        width: double.infinity,
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 30),
        decoration: BoxDecoration(color: Colors.white, border: Border.all(color: const Color(0xFFE2EAE8)), borderRadius: BorderRadius.circular(14)),
        child: const Column(
          children: [
            Icon(Icons.inventory_2_outlined, color: _primary, size: 30),
            SizedBox(height: 10),
            Text('Belum ada riwayat', style: TextStyle(color: _ink, fontWeight: FontWeight.w700)),
            SizedBox(height: 4),
            Text('Pengajuan peminjamanmu akan tampil di sini.', textAlign: TextAlign.center, style: TextStyle(color: Color(0xFF63737C), fontSize: 12)),
          ],
        ),
      );
}

class _ErrorView extends StatelessWidget {
  const _ErrorView({required this.message, required this.onRetry});

  final String message;
  final VoidCallback onRetry;

  @override
  Widget build(BuildContext context) => Center(
        child: Padding(
          padding: const EdgeInsets.all(28),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              const Icon(Icons.cloud_off_outlined, color: Color(0xFF63737C), size: 34),
              const SizedBox(height: 12),
              Text(message, textAlign: TextAlign.center, style: const TextStyle(color: _ink, height: 1.45)),
              const SizedBox(height: 14),
              OutlinedButton.icon(onPressed: onRetry, icon: const Icon(Icons.refresh), label: const Text('Coba lagi')),
            ],
          ),
        ),
      );
}

class _StatusStyle {
  const _StatusStyle(this.label, this.foreground, this.background);

  final String label;
  final Color foreground;
  final Color background;
}

_StatusStyle _statusStyle(String status) => switch (status) {
      'disetujui' => const _StatusStyle('Disetujui · Sedang dipinjam', Color(0xFF087569), Color(0xFFE5F3F0)),
      'menunggu' => const _StatusStyle('Menunggu verifikasi', Color(0xFF946200), Color(0xFFFFF4D6)),
      'ditolak' => const _StatusStyle('Pengajuan ditolak', Color(0xFFB42318), Color(0xFFFFE9E7)),
      'menunggu_pengembalian' => const _StatusStyle('Menunggu verifikasi pengembalian', Color(0xFF946200), Color(0xFFFFF4D6)),
      'selesai' => const _StatusStyle('Selesai dikembalikan', Color(0xFF087569), Color(0xFFE5F3F0)),
      _ => const _StatusStyle('Status tidak diketahui', Color(0xFF63737C), Color(0xFFEEF2F2)),
    };

String _formatDateTime(String? date, {String? time, bool includeDate = false}) {
  if (date == null || date.isEmpty) return '-';
  final parsed = DateTime.tryParse(date);
  final displayed = parsed == null ? null : includeDate ? parsed.toLocal() : parsed;
  final formattedDate = displayed == null ? date : '${displayed.day.toString().padLeft(2, '0')} ${_months[displayed.month - 1]} ${displayed.year}';
  if (includeDate) {
    final created = displayed;
    if (created == null) return formattedDate;
    return '$formattedDate · ${created.hour.toString().padLeft(2, '0')}:${created.minute.toString().padLeft(2, '0')}';
  }
  if (time == null || time.isEmpty) return formattedDate;
  return '$formattedDate · ${time.substring(0, time.length >= 5 ? 5 : time.length)}';
}

const _months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

class LoanHistory {
  const LoanHistory({required this.summary, required this.items});

  final Map<String, dynamic> summary;
  final List<LoanRecord> items;

  factory LoanHistory.fromJson(Map<String, dynamic> json) {
    final data = json['data'] as Map<String, dynamic>? ?? const {};
    final summary = data['summary'] as Map<String, dynamic>? ?? const {};
    final items = data['items'] as List<dynamic>? ?? const [];
    return LoanHistory(
      summary: summary,
      items: items.map((item) => LoanRecord.fromJson(item as Map<String, dynamic>)).toList(),
    );
  }
}

class LoanRecord {
  const LoanRecord({
    required this.kodePinjam,
    required this.namaBarang,
    required this.status,
    this.tanggalPengajuan,
    this.tanggalPinjam,
    this.jamPinjam,
    this.tanggalKembali,
    this.jamKembali,
    this.tanggalPengembalian,
    this.waktuLaporanPengembalian,
  });

  final String kodePinjam;
  final String namaBarang;
  final String status;
  final String? tanggalPengajuan;
  final String? tanggalPinjam;
  final String? jamPinjam;
  final String? tanggalKembali;
  final String? jamKembali;
  final String? tanggalPengembalian;
  final String? waktuLaporanPengembalian;

  factory LoanRecord.fromJson(Map<String, dynamic> json) => LoanRecord(
        kodePinjam: json['kode_pinjam'] as String? ?? '-',
        namaBarang: json['nama_barang'] as String? ?? 'Barang',
        status: json['status'] as String? ?? '',
        tanggalPengajuan: json['tanggal_pengajuan'] as String?,
        tanggalPinjam: json['tanggal_pinjam'] as String?,
        jamPinjam: json['jam_pinjam'] as String?,
        tanggalKembali: json['tanggal_kembali'] as String?,
        jamKembali: json['jam_kembali'] as String?,
        tanggalPengembalian: json['tanggal_pengembalian'] as String?,
        waktuLaporanPengembalian: json['waktu_laporan_pengembalian'] as String?,
      );
}

class ApiException implements Exception {
  const ApiException(this.message, {this.statusCode});

  final String message;
  final int? statusCode;

  @override
  String toString() => message;
}

class StudentApi {
  static const _baseUrl = String.fromEnvironment(
    'API_BASE_URL',
    defaultValue: 'http://10.0.2.2:8000/api',
  );

  static Uri _uri(String path) => Uri.parse('${_baseUrl.replaceFirst(RegExp(r'/+$'), '')}/$path');

  static Future<String> login({required String identifier, required String password}) async {
    final response = await http.post(
      _uri('mobile/login'),
      headers: const {'Accept': 'application/json', 'Content-Type': 'application/json'},
      body: jsonEncode({'identifier': identifier, 'password': password}),
    );
    final body = _decode(response);
    if (response.statusCode != 200) throw ApiException(body['message'] as String? ?? 'Gagal masuk.', statusCode: response.statusCode);
    final data = body['data'] as Map<String, dynamic>? ?? const {};
    final token = data['token'] as String?;
    if (token == null || token.isEmpty) throw const ApiException('Token login tidak ditemukan.');
    return token;
  }

  static Future<LoanHistory> history(String token) async {
    final response = await http.get(
      _uri('mobile/riwayat'),
      headers: {'Accept': 'application/json', 'Authorization': 'Bearer $token'},
    );
    final body = _decode(response);
    if (response.statusCode != 200) throw ApiException(body['message'] as String? ?? 'Gagal mengambil riwayat.', statusCode: response.statusCode);
    return LoanHistory.fromJson(body);
  }

  static Future<void> logout(String token) async {
    await http.post(
      _uri('mobile/logout'),
      headers: {'Accept': 'application/json', 'Authorization': 'Bearer $token'},
    );
  }

  static Map<String, dynamic> _decode(http.Response response) {
    try {
      return jsonDecode(response.body) as Map<String, dynamic>;
    } on FormatException {
      throw ApiException('Respons server tidak dapat dibaca.', statusCode: response.statusCode);
    }
  }
}