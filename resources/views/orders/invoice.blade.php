<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - PawPal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Fraunces:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            color: #2c2825;
            background-color: #ffffff;
            margin: 0;
            padding: 40px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1.5px solid #ebe2d5;
            border-radius: 20px;
            padding: 30px;
            background-color: #faf6f0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px dashed #ebe2d5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-title {
            font-family: 'Fraunces', serif;
            font-size: 28px;
            font-weight: 700;
            color: #c06c48;
        }
        .invoice-title {
            font-family: 'Fraunces', serif;
            font-size: 24px;
            color: #2c2825;
            text-align: right;
        }
        .details-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .details-col {
            width: 48%;
        }
        .details-col h4 {
            margin: 0 0 8px 0;
            color: #756e68;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .details-col p {
            margin: 0 0 5px 0;
            font-size: 16px;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #c06c48;
            color: #ffffff;
            text-align: left;
            padding: 12px;
            font-weight: 600;
        }
        th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            text-align: right;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ebe2d5;
        }
        td:last-child {
            text-align: right;
        }
        .total-section {
            display: flex;
            justify-content: flex-end;
        }
        .total-box {
            width: 300px;
            background-color: #ffffff;
            border: 1.5px solid #ebe2d5;
            border-radius: 15px;
            padding: 15px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 15px;
        }
        .total-row.grand-total {
            border-top: 2px dashed #ebe2d5;
            padding-top: 10px;
            margin-bottom: 0;
            font-weight: 700;
            font-size: 18px;
            color: #c06c48;
        }
        .footer-note {
            text-align: center;
            color: #756e68;
            font-size: 14px;
            margin-top: 40px;
            border-top: 1px solid #ebe2d5;
            padding-top: 20px;
        }
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-btn {
            background-color: #c06c48;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 999px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(192, 108, 72, 0.2);
            transition: all 0.2s;
        }
        .print-btn:hover {
            background-color: #a2522f;
            transform: translateY(-2px);
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
            .invoice-box {
                border: none;
                padding: 0;
                background-color: transparent;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="print-btn" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div>
                <div class="logo-title">🐾 PawPal</div>
                <div style="font-size: 14px; color: #756e68; margin-top: 4px;">Pet Care & Marketplace Solution</div>
            </div>
            <div>
                <div class="invoice-title">INVOICE</div>
                <div style="font-size: 15px; margin-top: 5px;"><strong>Order ID:</strong> #{{ $order->id }}</div>
                <div style="font-size: 14px; color: #756e68;"><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        <div class="details-container">
            <div class="details-col">
                <h4>Pembeli</h4>
                <p><strong>{{ $order->user->name }}</strong></p>
                <p>{{ $order->user->email }}</p>
                <p>Status: <span style="color: #43634f; font-weight: 600;">{{ ucfirst($order->status) }}</span></p>
            </div>
            <div class="details-col">
                <h4>Alamat Pengiriman</h4>
                <p>{{ $order->shipping_address }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi Produk</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $item->product->name ?? 'Produk' }}</div>
                            <div style="font-size: 12px; color: #756e68;">Seller: {{ $item->product->seller->name ?? 'Seller' }}</div>
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right; font-weight: 600;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-box">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span>Pengiriman</span>
                    <span>Rp 0</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="footer-note">
            Terima kasih telah mempercayakan kebutuhan hewan kesayangan Anda pada PawPal! 🐶🧡
        </div>
    </div>

    <script>
        // Auto trigger print when loaded
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
