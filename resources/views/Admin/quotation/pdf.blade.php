<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quotation Letter #{{ $quotation->quotation_number }}</title>
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
            <tbody>
                <tr style="height: 60px;">
                    <td style="width: 50%; text-align: left; vertical-align: middle; padding: 10px; border: none;">
                        @if (!empty($companyParameter->logo) && file_exists(public_path($companyParameter->logo)))
                            <img src="{{ public_path($companyParameter->logo) }}" alt="Company Logo" style="height: 60px; width: auto;" />
                        @else
                            <p style="font-size: 14px; margin: 0;">No Logo Available</p>
                        @endif
                    </td>
                    <td style="width: 50%; text-align: right; vertical-align: middle; padding-right: 20px; border: none;">
                        <p style="margin: 0; font-weight: bold;">UMALO | umalo.id</p>
                        <p style="margin: 0;">{{ $companyParameter->address ?? 'Alamat belum tersedia' }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

<!-- Footer -->
<div class="footer" style="position: fixed; bottom: 0; left: 0; right: 0;  font-size: 12px; text-align: center; color: #555;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="text-align: center; width: 100%; vertical-align: middle;">
                <p style="margin: 0;">© {{ date('Y') }} {{ $companyParameter->company_name ?? 'UMALO' }}. All Rights Reserved.</p>
                <p style="margin: 0;">Powered by UMALO | <a href="https://umalo.id" style="color: #00796b; text-decoration: none;">umalo.id</a></p>
            </td>
        </tr>
    </table>
</div>

    <!-- Content -->
    <div class="content">
        <table style="width: 100%; height: 60px; border: none; border-collapse: collapse;">
            <tbody>
                <tr style="height: 60px;">
                    <td style="width: 50%; text-align: left; vertical-align: middle; padding: 10px; border: none;">
                        <p><strong>To:</strong> <span class="highlighted">{{ $quotation->user->company_name ?? 'Company Name' }}</span></p>
                        <p>Dear {{ $quotation->recipient_contact_person }},</p>

                    </td>
                    <td style="width: 50%; text-align: right; vertical-align: middle; padding-right: 20px; border: none;">
                        <div class="title">
                            <h1>QUOTATION LETTER</h1>
                            <p><strong>Application Number:</strong> {{ $quotation->application_number }}</p>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($quotation->created_at)->format('F d, Y') }}</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <p>With reference to your letter number <span class="highlighted">{{ $referenceNumber }}</span>, {{ $companyParameter->company_name }} is pleased to submit our quotation with the following terms & conditions:</p>
        
        <!-- Equipment Details Table -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-family: Arial, sans-serif;">
            <thead>
                <tr style="background-color: #f5f5f5; text-align: left; border-bottom: 2px solid #ddd;">
                    <th style="padding: 10px;">No.</th>
                    <th style="padding: 10px;">Name of Equipment</th>
                    <th style="padding: 10px;">Brand</th>
                    <th style="padding: 10px;">QTY</th>
                    <th style="padding: 10px;">Unit Price</th>
                    <th style="padding: 10px;">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotation->products as $index => $product)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;">{{ $index + 1 }}</td>
                        <td style="padding: 10px;">{{ $product->product->name ?? 'N/A' }}</td>
                        <td style="padding: 10px;">{{ $product->product->brand ?? 'N/A' }}</td>
                        <td style="padding: 10px; text-align: center;">{{ $product->quantity ?? 0 }}</td>
                        <td style="padding: 10px; text-align: right;">{{ number_format($product->unit_price, 2, ',', '.') }}</td>
                        <td style="padding: 10px; text-align: right;">{{ number_format($product->total_price, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f9f9f9; font-weight: bold;">
                    <td colspan="5" style="padding: 10px;">Sub Total Price</td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($quotation->subtotal_price, 2, ',', '.') }}</td>
                </tr>
                @if($quotation->discount > 0)
                    <tr>
                        <td colspan="5" style="padding: 10px;">Discount ({{ $quotation->discount ?? 0 }}%)</td>
                        <td style="padding: 10px; text-align: right;">-{{ number_format($quotation->subtotal_price * ($quotation->discount / 100), 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="padding: 10px;">Sub Total II (After Discount)</td>
                        <td style="padding: 10px; text-align: right;">{{ number_format($quotation->total_after_discount, 2, ',', '.') }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="5" style="padding: 10px;">PPN ({{ $quotation->ppn ?? 12 }}%)</td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($quotation->total_after_discount * ($quotation->ppn / 100), 2, ',', '.') }}</td>
                </tr>
                <tr style="background-color: #f5f5f5; font-weight: bold;">
                    <td colspan="5" style="padding: 10px;"><strong>Grand Total Price</strong></td>
                    <td style="padding: 10px; text-align: right;"><strong>{{ number_format($quotation->grand_total, 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
        
        
        
      <!-- Notes Section -->
      <div class="terms">
        @if (!empty($quotation->notes))
            <h3>Notes:</h3>
            @php
                // Ubah string menjadi array jika diperlukan
                $notes = is_array($quotation->notes) ? $quotation->notes : explode("\n", $quotation->notes);
            @endphp
            @if (!empty($notes))
                <ol>
                    @foreach ($notes as $index => $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ol>
            @endif
        @endif
    
        @if (!empty($quotation->terms_conditions))
            <h3>Terms & Conditions:</h3>
            @php
                // Ubah string menjadi array jika diperlukan
                $terms_conditions = is_array($quotation->terms_conditions) ? $quotation->terms_conditions : explode("\n", $quotation->terms_conditions);
            @endphp
            @if (!empty($terms_conditions))
                <ol>
                    @foreach ($terms_conditions as $index => $term)
                        <li>{{ $term }}</li>
                    @endforeach
                </ol>
            @endif
        @endif
    </div>
    


        <!-- Signature Section -->
        <div class="signature">
            <p>Kind Regards,</p>
            <p><strong>PT. Umalo Sedia Tekno</strong></p>
            @if(!empty($quotation->authorized_person_signature) && file_exists(public_path($quotation->authorized_person_signature)))
                <p>
                    <img src="{{ public_path($quotation->authorized_person_signature) }}" alt="Signature" width="150">
                </p>
            @else
                <p>No signature available.</p>
            @endif
            <p><strong>{{ $quotation->authorized_person_name ?? 'Signer Name' }}</strong></p>
            <p>{{ $quotation->authorized_person_position ?? 'Position' }}</p>
        </div>
    </div>
</body>
</html>
