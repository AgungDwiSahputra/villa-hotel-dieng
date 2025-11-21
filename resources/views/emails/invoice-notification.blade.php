<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Villa Hotel Dieng</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1a202c;
            background: #f8fafc;
            min-height: 100vh;
            padding: 8px;
            margin: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 32px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .header h1 {
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }

        /* Content Section */
        .content {
            padding: 32px;
        }

        /* Admin Notice */
        .admin-notice {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            position: relative;
        }

        .admin-notice::before {
            content: '📋';
            font-size: 24px;
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .admin-notice strong {
            color: #92400e;
            font-weight: 600;
            margin-left: 32px;
            display: block;
        }

        /* Invoice Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            gap: 24px;
        }

        .invoice-info h2 {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 12px;
        }

        .invoice-meta div {
            font-size: 14px;
            color: #718096;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background: #c6f6d5;
            color: #22543d;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge::before {
            content: '✓';
            margin-right: 6px;
            font-weight: bold;
        }

        .company-info {
            text-align: right;
            flex-shrink: 0;
        }

        .company-name {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .company-details {
            font-size: 13px;
            color: #718096;
            line-height: 1.4;
        }

        /* Card Components */
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .card-title::before {
            content: '';
            width: 4px;
            height: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
            margin-right: 12px;
        }

        /* Detail Rows */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .detail-label {
            font-size: 12px;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 15px;
            font-weight: 500;
            color: #2d3748;
        }

        /* Customer Info */
        .customer-info {
            background: linear-gradient(135deg, #ebf8ff 0%, #bee3f8 100%);
            border: 1px solid #90cdf4;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .customer-title {
            font-weight: 600;
            color: #2b6cb0;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .customer-title::before {
            content: '👤';
            margin-right: 8px;
        }

        .customer-details {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .customer-details div {
            font-size: 14px;
            color: #2d3748;
        }

        /* Total Section */
        .total-section {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .total-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="80" cy="80" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="60" cy="40" r="0.5" fill="%23ffffff" opacity="0.1"/></svg>');
        }

        .total-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .total-amount {
            color: white;
            font-size: 28px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        /* Instructions */
        .instructions {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .instructions h4 {
            color: #2d3748;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .instructions.customer h4::before {
            content: '💡';
            margin-right: 8px;
        }

        .instructions.admin h4::before {
            content: '⚙️';
            margin-right: 8px;
        }

        .instructions ul {
            margin: 0;
            padding-left: 20px;
        }

        .instructions li {
            color: #4a5568;
            margin-bottom: 6px;
            font-size: 14px;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 24px 32px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .footer p {
            color: #718096;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .footer .timestamp {
            font-size: 12px;
            color: #a0aec0;
            font-style: italic;
        }

        /* Mobile-First Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 0;
                background: #f8fafc;
            }

            .email-container {
                border-radius: 0;
                box-shadow: none;
                max-width: 100%;
                margin: 0;
            }

            .header {
                padding: 20px 16px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .header h1 {
                font-size: 24px;
                margin-bottom: 4px;
            }

            .header p {
                font-size: 14px;
            }

            .content {
                padding: 16px;
            }

            .admin-notice {
                padding: 16px;
                margin-bottom: 16px;
                border-radius: 8px;
            }

            .admin-notice::before {
                font-size: 20px;
                left: 16px;
            }

            .admin-notice strong {
                margin-left: 28px;
                font-size: 14px;
                line-height: 1.4;
            }

            .invoice-header {
                flex-direction: column;
                align-items: stretch;
                padding: 16px;
                gap: 16px;
                margin-bottom: 16px;
            }

            .invoice-info h2 {
                font-size: 18px;
                margin-bottom: 8px;
            }

            .invoice-meta div {
                font-size: 13px;
            }

            .company-info {
                text-align: left;
                padding-left: 0;
            }

            .company-name {
                font-size: 16px;
                margin-bottom: 6px;
            }

            .company-details {
                font-size: 12px;
                line-height: 1.3;
            }

            .card {
                padding: 16px;
                margin-bottom: 16px;
                border-radius: 8px;
            }

            .card-title {
                font-size: 16px;
                margin-bottom: 12px;
            }

            .card-title::before {
                width: 3px;
                height: 16px;
                margin-right: 8px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .detail-label {
                font-size: 11px;
                letter-spacing: 0.3px;
            }

            .detail-value {
                font-size: 14px;
                line-height: 1.3;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }

            .customer-info {
                padding: 16px;
                margin-bottom: 16px;
                border-radius: 8px;
            }

            .customer-title {
                font-size: 14px;
                margin-bottom: 8px;
            }

            .customer-title::before {
                font-size: 16px;
                margin-right: 6px;
            }

            .customer-details div {
                font-size: 13px;
                line-height: 1.4;
            }

            .total-section {
                padding: 20px 16px;
                margin-bottom: 16px;
                border-radius: 8px;
            }

            .total-label {
                font-size: 13px;
                margin-bottom: 6px;
            }

            .total-amount {
                font-size: 24px;
            }

            .instructions {
                padding: 16px;
                margin-bottom: 16px;
                border-radius: 8px;
            }

            .instructions h4 {
                font-size: 15px;
                margin-bottom: 10px;
            }

            .instructions h4::before {
                font-size: 16px;
                margin-right: 6px;
            }

            .instructions li {
                font-size: 13px;
                margin-bottom: 8px;
                line-height: 1.4;
                padding-left: 4px;
            }

            .instructions ul {
                padding-left: 16px;
            }

            .footer {
                padding: 20px 16px;
            }

            .footer p {
                font-size: 13px;
                margin-bottom: 6px;
            }

            .footer .timestamp {
                font-size: 11px;
            }
        }

        /* Extra Small Mobile */
        @media (max-width: 480px) {
            .header {
                padding: 16px 12px;
            }

            .header h1 {
                font-size: 20px;
            }

            .header p {
                font-size: 13px;
            }

            .content {
                padding: 12px;
            }

            .card {
                padding: 12px;
            }

            .invoice-header {
                padding: 12px;
            }

            .total-section {
                padding: 16px 12px;
            }

            .total-amount {
                font-size: 20px;
            }

            .instructions {
                padding: 12px;
            }

            .footer {
                padding: 16px 12px;
            }
        }

        /* Very Small Mobile */
        @media (max-width: 360px) {
            .header h1 {
                font-size: 18px;
            }

            .header p {
                font-size: 12px;
            }

            .content {
                padding: 8px;
            }

            .card {
                padding: 8px;
            }

            .invoice-header {
                padding: 8px;
            }

            .detail-value {
                font-size: 13px;
                word-break: break-word;
                hyphens: auto;
            }

            .customer-info {
                padding: 12px;
            }

            .customer-details div {
                font-size: 12px;
                word-break: break-word;
            }

            .total-section {
                padding: 12px 8px;
            }

            .total-amount {
                font-size: 18px;
            }

            .instructions {
                padding: 8px;
            }

            .instructions li {
                font-size: 12px;
                margin-bottom: 6px;
            }

            .footer {
                padding: 12px 8px;
            }

            .footer p {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>INVOICE</h1>
            <p>Villa Hotel Dieng</p>
        </div>

        <!-- Content -->
        <div class="content">
            @if($isAdminCopy)
            <div class="admin-notice">
                <strong>Pemberitahuan Admin: Invoice baru telah dibuat untuk produk yang Anda kelola. Silakan cek detail booking di bawah ini.</strong>
            </div>
            @endif

            <!-- Invoice Header -->
            <div class="invoice-header">
                <div class="invoice-info">
                    <h2>Invoice #{{ $transaksi->order_id }}</h2>
                    <div class="invoice-meta">
                        <div>Tanggal: {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y H:i') }}</div>
                        <div>Status: <span class="status-badge">Lunas</span></div>
                    </div>
                </div>
                {{-- <div class="company-info">
                    <div class="company-name">Villa Hotel Dieng</div>
                    <div class="company-details">
                        Jl. Raya Dieng No. 123<br>
                        Dieng, Jawa Tengah 54353<br>
                        Email: info@villahoteldieng.com<br>
                        Telp: +62 812-3456-7890
                    </div>
                </div> --}}
            </div>

            <!-- Booking Details -->
            <div class="card">
                <h3 class="card-title">Detail Booking</h3>
                <div class="detail-grid">
                    <div class="detail-item" style="margin-bottom: 8px;">
                        <div class="detail-label">Produk</div>
                        <div class="detail-value">{{ $produk->name }}</div>
                    </div>
                    <div class="detail-item" style="margin-bottom: 8px;">
                        <div class="detail-label">Check-in</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($transaksi->start_date)->format('d M Y') }}</div>
                    </div>
                    <div class="detail-item" style="margin-bottom: 8px;">
                        <div class="detail-label">Check-out</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($transaksi->end_date)->format('d M Y') }}</div>
                    </div>
                    <div class="detail-item" style="margin-bottom: 8px;">
                        <div class="detail-label">Durasi</div>
                        <div class="detail-value">{{ $transaksi->night }} malam</div>
                    </div>
                    <div class="detail-item" style="margin-bottom: 8px;">
                        <div class="detail-label">Jumlah Unit</div>
                        <div class="detail-value">{{ $transaksi->unit }} unit</div>
                    </div>
                    @if($transaksi->promo_code)
                    <div class="detail-item" style="margin-bottom: 8px;">
                        <div class="detail-label">Kode Promo</div>
                        <div class="detail-value">{{ $transaksi->promo_code }}</div>
                    </div>
                    <div class="detail-item" style="margin-bottom: 8px;">
                        <div class="detail-label">Diskon</div>
                        <div class="detail-value" style="color: #e53e3e;">-Rp {{ number_format($transaksi->discount_amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="detail-item" style="margin-bottom: 8px;">
                        <div class="detail-label">Total Sebelum Diskon</div>
                        <div class="detail-value" style="text-decoration: line-through; color: #a0aec0;">Rp {{ number_format($transaksi->original_total, 0, ',', '.') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Customer Information -->
            <div class="customer-info">
                <div class="customer-title">Informasi Tamu</div>
                <div class="customer-details">
                    <div><strong>Nama:</strong> {{ $transaksi->name }}</div>
                    <div><strong>Email:</strong> {{ $transaksi->email }}</div>
                    <div><strong>WhatsApp:</strong> {{ $transaksi->no_wa }}</div>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="total-section">
                <div class="total-label">Total Pembayaran</div>
                <div class="total-amount">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
            </div>

            <!-- Instructions -->
            @if(!$isAdminCopy)
            <div class="instructions customer">
                <h4>Instruksi untuk Tamu</h4>
                <ul>
                    <li>Simpan invoice ini sebagai bukti pembayaran yang sah</li>
                    <li>Admin akan menghubungi Anda dalam 24 jam untuk konfirmasi</li>
                    <li>Check-in dapat dilakukan sesuai tanggal yang telah dipesan</li>
                    <li>Untuk pertanyaan mendesak, hubungi: {{ $transaksi->no_wa }}</li>
                </ul>
            </div>
            @else
            <div class="instructions admin">
                <h4>Instruksi untuk Admin</h4>
                <ul>
                    <li>Silakan konfirmasi booking dengan tamu dalam 24 jam</li>
                    <li>Persiapkan unit villa sesuai pesanan tamu</li>
                    <li>Kirim detail check-in dan informasi lokasi ke tamu</li>
                    <li>Update status booking di sistem management</li>
                </ul>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah memilih Villa Hotel Dieng</p>
            <p>© 2025 Villa Hotel Dieng. All rights reserved.</p>
            <p class="timestamp">Invoice ini dibuat secara otomatis oleh sistem pada {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>