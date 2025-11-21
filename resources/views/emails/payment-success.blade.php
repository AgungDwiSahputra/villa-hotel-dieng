<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran Berhasil</title>
    <style>
        body {
            font-family: 'Inter', 'Poppins', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            margin: 20px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #10b981;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #10b981;
            margin: 0;
            font-size: 24px;
        }
        .success-icon {
            font-size: 48px;
            color: #10b981;
            margin-bottom: 10px;
        }
        .booking-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #212529;
        }
        .total-amount {
            background-color: #10b981;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .contact-info {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .highlight {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1>Pembayaran Berhasil!</h1>
            <p>Terima kasih atas pembayaran Anda</p>
        </div>

        <div class="highlight">
            <strong>Pembayaran untuk booking Villa Hotel Dieng telah berhasil diproses.</strong>
            <br>
            Order ID: <strong>{{ $transaksi->order_id }}</strong>
        </div>

        <div class="booking-details">
            <h3 style="margin-top: 0; color: #10b981;">Detail Booking</h3>

            <div class="detail-row">
                <span class="detail-label">Nama Villa:</span>
                <span class="detail-value">{{ $produk->name }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Check-in:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($transaksi->start_date)->format('d M Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Check-out:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($transaksi->end_date)->format('d M Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Durasi:</span>
                <span class="detail-value">{{ $transaksi->night }} malam</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Jumlah Unit:</span>
                <span class="detail-value">{{ $transaksi->unit }} unit</span>
            </div>

            @if($transaksi->promo_code)
            <div class="detail-row">
                <span class="detail-label">Kode Promo:</span>
                <span class="detail-value">{{ $transaksi->promo_code }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Diskon:</span>
                <span class="detail-value">-Rp {{ number_format($transaksi->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>

        <div class="total-amount">
            Total Pembayaran: Rp {{ number_format($transaksi->total, 0, ',', '.') }}
        </div>

        <div class="contact-info">
            <h4 style="margin-top: 0; color: #1976d2;">Informasi Kontak</h4>
            <p><strong>Nama:</strong> {{ $transaksi->name }}</p>
            <p><strong>Email:</strong> {{ $transaksi->email }}</p>
            <p><strong>WhatsApp:</strong> {{ $transaksi->no_wa }}</p>
        </div>

        <div class="highlight">
            <strong>Petunjuk Selanjutnya:</strong><br>
            • Simpan email konfirmasi ini sebagai bukti booking<br>
            • Admin akan menghubungi Anda untuk konfirmasi lebih lanjut<br>
            • Jika ada pertanyaan, hubungi kami di <a href="wa.me/6282162622680">082162622680</a>
        </div>

        <div class="footer">
            <p>Terima kasih telah memilih Villa Hotel Dieng</p>
            <p>© 2025 Villa Hotel Dieng. All rights reserved.</p>
        </div>
    </div>
</body>
</html>