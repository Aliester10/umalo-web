<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proforma Invoice #{{ $proformaInvoice->pi_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000; /* Prioritas lapisan tertinggi */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px; /* Jarak padding */
            height: auto; /* Sesuaikan tinggi otomatis */
            background-color: white; /* Tambahkan background putih agar tidak transparan */
            border-bottom: 1px solid #ddd; /* Garis bawah untuk header */
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: -100px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }


        /* Content */
        .title {
            text-align: right;
            margin-top: 5px;
        }

        .title h1 {
            margin: 0;
            font-size: 20px;
        }

        .title p {
            margin: 3px 0;
            font-size: 12px;
        }
        
        .contet{
            margin-top: 100px; /* Sesuaikan nilai margin ini agar cukup jauh dari header */
            left: 0;
            right: 0;
        }

        .content p {
            margin: 10px 0;
        }

        .highlighted {
            color: #107C10;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .terms {
            font-size: 12px;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .terms ol {
            padding-left: 20px;
        }

        .signature {
            margin-top: 30px;
            text-align: left;
            font-size: 14px;
        }

        .signature img {
            margin-top: 10px;
        }

        .flex-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        }

        .flex-container .left {
            flex: 1;
            text-align: left;
            margin-right: 20px;
        }

        .flex-container .right {
            flex: 1;
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <table style="width: 100%; height: 60px; border: none; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; text-align: left; vertical-align: middle;">
                    @if (!empty($companyParameter->logo) && file_exists(public_path($companyParameter->logo)))
                        <img src="{{ public_path($companyParameter->logo) }}" alt="Company Logo" style="height: 60px; width: auto;">
                    @else
                        <p style="font-size: 14px; margin: 0;">No Logo Available</p>
                    @endif
                </td>
                <td style="width: 50%; text-align: right; vertical-align: middle;">
                    <p style="margin: 0; font-weight: bold;">UMALO | umalo.id</p>
                    <p style="margin: 0;">{{ $companyParameter->address ?? 'Alamat belum tersedia' }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© {{ date('Y') }} {{ $companyParameter->company_name ?? 'UMALO' }}. All Rights Reserved.</p>
        <p>Powered by UMALO | <a href="https://umalo.id" style="color: #00796b; text-decoration: none;">umalo.id</a></p>
    </div>

    <!-- Content -->
    <div class="content">
        <table style="width: 100%; height: 60px; border: none; border-collapse: collapse;">
            <tbody>
                <tr style="height: 60px;">
                    <td style="width: 50%; text-align: left; vertical-align: middle; padding: 10px; border: none;">
                        <p><strong>Billed To:</strong> <span class="highlighted">{{ $vendorName ?? 'Company Name' }}</span></p>
                        <p>Address: {{ $vendorAddress }}</p>
                        <p>Phone: {{ $vendorPhone }}</p>
                    </td>
                    <td style="width: 50%; text-align: right; vertical-align: middle; padding-right: 20px; border: none;">
                        <div class="title">
                            <h1>PROFORMA INVOICE</h1>
                            <p><strong>Invoice Number:</strong> {{ $piNumberFormatted }}</p>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($proformaInvoice->pi_date)->format('F d, Y') }}</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <p>Based on Purchase Order {{ $poNumberFormatted }}, {{ $companyParameter->company_name }} submits the following proforma invoice:</p>


        <!-- Product Details -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-family: Arial, sans-serif;">
            <thead>
                <tr style="background-color: #f5f5f5; text-align: left; border-bottom: 2px solid #ddd;">
                    <th style="padding: 10px;">No.</th>
                    <th style="padding: 10px;">Product Name</th>
                    <th style="padding: 10px;">QTY</th>
                    <th style="padding: 10px;">Unit Price</th>
                    <th style="padding: 10px;">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                <tr>
                    <td style="padding: 10px;">{{ $index + 1 }}</td>
                    <td style="padding: 10px;">{{ $product['name'] }}</td>
                    <td style="padding: 10px; text-align: center;">{{ $product['qty'] }}</td>
                    <td style="padding: 10px; text-align: right;">
                        Rp {{ number_format((float) str_replace(['Rp', '.', ','], ['', '', ''], $product['unit_price']), 2, ',', '.') }}
                    </td>
                    <td style="padding: 10px; text-align: right;">
                        Rp {{ number_format((float) str_replace(['Rp', '.', ','], ['', '', ''], $product['total_price']), 2, ',', '.') }}
                    </td>
                                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f9f9f9; font-weight: bold;">
                    <td colspan="4" style="padding: 10px;">Sub Total Price</td>
                    <td style="padding: 10px;">Rp {{ number_format($proformaInvoice->subtotal, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="padding: 10px;">PPN ({{ $proformaInvoice->ppn }}%)</td>
                    <td style="padding: 10px;">Rp {{ number_format($proformaInvoice->ppn / 100 * $proformaInvoice->subtotal, 2, ',', '.') }}</td>
                </tr>
                <tr style="background-color: #f5f5f5; font-weight: bold;">
                    <td colspan="4" style="padding: 10px;"><strong>Grand Total</strong></td>
                    <td style="padding: 10px;"><strong>Rp {{ number_format($proformaInvoice->grand_total_include_ppn, 2, ',', '.') }}</strong></td>
                </tr>
                <tr style="background-color: #f5f5f5; font-weight: bold;">
                    <td colspan="4" class="right-align" style="padding: 10px;"><strong>Down Payment (DP)</strong></td>
                    <td style="padding: 10px;">{{ number_format($dpPercent, 2) }}% - Rp {{ number_format($proformaInvoice->dp, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Payment Terms -->
        <p class="terms">Please make payment to:</p>
        <p>{{ $companyParameter->company_name }}</p>
        <p>Account No: {{ $companyParameter->no_acc_bank }}</p>
        <p>{{ $companyParameter->bank }}</p>
    </div>
</body>
</html>
