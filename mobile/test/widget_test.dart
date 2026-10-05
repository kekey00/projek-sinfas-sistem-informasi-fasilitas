// This is a basic Flutter widget test.
//
// To perform an interaction with a widget in your test, use the WidgetTester
// utility in the flutter_test package. For example, you can send tap and scroll
// gestures. You can also use WidgetTester to find child widgets in the widget
// tree, read text, and verify that the values of widget properties are correct.

import 'package:flutter_test/flutter_test.dart';

import 'package:mobile/main.dart';

void main() {
  test('parses the student loan summary and history', () {
    final history = LoanHistory.fromJson({
      'data': {
        'summary': {'total_dipinjam': 2, 'menunggu_verifikasi': 1, 'ditolak': 0},
        'items': [
          {
            'kode_pinjam': 'PJM-20261003-0001',
            'nama_barang': 'Proyektor',
            'status': 'menunggu',
            'tanggal_pinjam': '2026-10-03',
            'jam_pinjam': '09:30',
          },
        ],
      },
    });

    expect(history.summary['total_dipinjam'], 2);
    expect(history.items.single.namaBarang, 'Proyektor');
    expect(history.items.single.jamPinjam, '09:30');
  });
}
