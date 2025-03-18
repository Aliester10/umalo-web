@extends('layouts.Admin.master')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-5">
    <div class="card shadow-lg p-4 rounded-3">
        <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; color: #00796b;">
            Edit Quotation for: {{ $quotation->user->name ?? 'N/A' }}
        </h2>



        <form action="{{ route('admin.quotations.update', $quotation->id) }}"  method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Recipient Information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="recipient_company" class="form-label">To: Company Name (Distributor)</label>
                        <input type="text" class="form-control shadow-sm" id="recipient_company" name="recipient_company"
                               value="{{ old('recipient_company', $quotation->recipient_company) }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="recipient_contact_person" class="form-label">Dear (Contact Person)</label>
                        <input type="text" class="form-control shadow-sm" id="recipient_contact_person" name="recipient_contact_person"
                               value="{{ old('recipient_contact_person', $quotation->recipient_contact_person) }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Quotation Details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quotation_date" class="form-label">Quotation Date</label>
                        <input type="date" class="form-control shadow-sm" id="quotation_date" name="quotation_date"
                        value="{{ old('quotation_date', $quotation->created_at ? \Carbon\Carbon::parse($quotation->created_at)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>

            <!-- Equipment Details -->
            <h5 class="mt-4" style="font-family: 'Poppins', sans-serif; color: #00796b;">Equipment Details</h5>
            <div class="table-responsive">
                <table class="table table-hover shadow-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Image</th> <!-- Kolom untuk gambar -->
                            <th>Name of Equipment</th>
                            <th>Merk Type</th>
                            <th>QTY</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotation->products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if ($product->product->images->first())
                                    <img src="{{ asset($product->product->images->first()->images) }}" alt="Product Image" width="50" height="50">
                                @else
                                    <img src="{{ asset('default-image.jpg') }}" alt="Default Image" width="50" height="50">
                                @endif
                            </td>
                            <td>
                                <input type="hidden" name="products[{{ $key }}][product_id]" value="{{ $product->product_id }}">
                                {{ $product->product->name ?? 'N/A' }}
                            </td>
                            <td>{{ $product->product->brand ?? 'N/A' }}</td>
                            <td>
                                <input type="number" class="form-control shadow-sm" name="products[{{ $key }}][quantity]"
                                    value="{{ old("products.$key.quantity", $product->quantity) }}" readonly>
                            </td>
                            <td>
                                <input type="text" 
                                       class="form-control shadow-sm unit-price" 
                                       data-qty="{{ $product->quantity }}" 
                                       value="{{ old("products.$key.unit_price", number_format($product->unit_price, 0, ',', '.')) }}"  
                                       name="products[{{ $key }}][unit_price]">
                            </td>
                            <td>
                                <input type="text" 
                                       class="form-control shadow-sm total-price" 
                                       value="{{ number_format($product->total_price, 0, ',', '.') }}" 
                                       name="products[{{ $key }}][total_price]" 
                                       readonly>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Price Calculation -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="subtotal_price" class="form-label">Sub Total Price</label>
                        <input type="text" 
                            class="form-control shadow-sm" 
                            id="subtotal_price" 
                            name="subtotal_price" 
                            value="{{ number_format($quotation->subtotal_price, 0, ',', '.') }}" 
                            readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount (%)</label>
                        <input type="number" 
                               class="form-control shadow-sm" 
                               id="discount" 
                               name="discount"
                               value="{{ old('discount', $quotation->discount ?? 0) }}">
                    </div>
                </div>
                <div class="col-md-4" id="total-after-discount-container" style="display: none;">
                    <div class="mb-3">
                        <label for="total_after_discount" class="form-label">Sub Total II (After Discount)</label>
                        <input type="text" 
                               class="form-control shadow-sm" 
                               id="total_after_discount" 
                               name="total_after_discount"
                               value="{{ number_format($quotation->total_after_discount, 0, ',', '.') }}" 
                               readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ppn" class="form-label">PPN (%)</label>
                        <input type="number" class="form-control shadow-sm" id="ppn" name="ppn"
                               value="{{ old('ppn', $quotation->ppn ?? 10) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="grand_total" class="form-label">Grand Total Price</label>
                        <input type="text" 
                               class="form-control shadow-sm" 
                               id="grand_total" 
                               name="grand_total"
                               value="{{ number_format($quotation->grand_total, 0, ',', '.') }}" 
                               readonly>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            <div class="mb-3">
                <label for="notes" class="form-label">Note</label>
                <textarea class="form-control shadow-sm" id="notes" name="notes" rows="4">{{ old('notes', $quotation->notes) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="terms_conditions" class="form-label">Terms and Conditions</label>
                <textarea class="form-control shadow-sm" id="terms_conditions" name="terms_conditions" rows="4">{{ old('terms_conditions', $quotation->terms_conditions) }}</textarea>
            </div>


            <h5 class="mt-4" style="font-family: 'Poppins', sans-serif; color: #00796b;">
                Signature Information (Pihak Umalo)
            </h5>
            <p class="text-muted" style="font-family: 'Poppins', sans-serif; font-size: 14px;">
                Informasi berikut merupakan data penanggung jawab dari pihak Umalo untuk dokumen ini.
            </p>
            <div class="row">
                <!-- Signer Name -->
                <div class="col-md-4">
                    <label for="signer_name" class="form-label">Signer Name</label>
                    <input 
                        type="text" 
                        class="form-control shadow-sm" 
                        id="signer_name" 
                        name="signer_name"
                        value="{{ old('signer_name', $quotation->authorized_person_name) }}" 
                        placeholder="Enter signer name" 
                        required>
                </div>
            
                <!-- Signer Position -->
                <div class="col-md-4">
                    <label for="signer_position" class="form-label">Signer Position</label>
                    <input 
                        type="text" 
                        class="form-control shadow-sm" 
                        id="signer_position" 
                        name="signer_position"
                        value="{{ old('signer_position', $quotation->authorized_person_position) }}" 
                        placeholder="Enter signer position" 
                        required>
                </div>
            
                <!-- Authorized Person Signature -->
                <div class="col-md-4">
                    <label for="authorized_person_signature" class="form-label">Authorized Person Signature</label>
                    <input 
                        type="file" 
                        class="form-control shadow-sm" 
                        id="authorized_person_signature" 
                        name="authorized_person_signature" 
                        accept="image/*">
                    @if($quotation->authorized_person_signature)
                        <small class="form-text">Current Signature:</small>
                        <div class="mt-2">
                            <img src="{{ asset($quotation->authorized_person_signature) }}" alt="Signature Preview" style="max-height: 50px;">
                        </div>
                    @endif
                </div>
            </div>
            
            

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success rounded-pill shadow-sm w-100 mt-3">
                <i class="fas fa-save"></i> Update Quotation
            </button>
        </form>

        <form action="{{ route('admin.quotations.reject', $quotation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak quotation ini?')">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger rounded-pill shadow-sm w-100 mt-3">
                Tolak?
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function calculateTotals() {
        let subtotal = 0;

        document.querySelectorAll('.unit-price').forEach((input, index) => {
            const qty = parseFloat(input.getAttribute('data-qty')) || 0;
            const unitPrice = parseFloat(input.value.replace(/\./g, '')) || 0; // Hapus titik sebelum kalkulasi
            const totalPrice = qty * unitPrice;

            // Perbarui nilai total harga untuk baris
            document.querySelectorAll('.total-price')[index].value = new Intl.NumberFormat('id-ID').format(totalPrice);
            subtotal += totalPrice;
        });

        // Perbarui subtotal
        document.getElementById('subtotal_price').value = new Intl.NumberFormat('id-ID').format(subtotal);

        // Hitung subtotal II setelah diskon
        const discountPercent = parseFloat(document.getElementById('discount').value) || 0;
        const subTotalII = subtotal - (subtotal * (discountPercent / 100));
        document.getElementById('total_after_discount').value = new Intl.NumberFormat('id-ID').format(subTotalII);

        // Hitung grand total dengan PPN
        const ppnPercent = parseFloat(document.getElementById('ppn').value) || 0;
        const grandTotal = subTotalII + (subTotalII * (ppnPercent / 100));
        document.getElementById('grand_total').value = new Intl.NumberFormat('id-ID').format(grandTotal);
    }

    // Event listeners untuk input
    document.querySelectorAll('.unit-price, #discount, #ppn').forEach(input => {
        input.addEventListener('input', calculateTotals);
    });

    // Kalkulasi awal saat halaman dimuat
    calculateTotals();
});


</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const formatCurrency = (value) => {
        return new Intl.NumberFormat('id-ID').format(value.replace(/\D/g, ''));
    };

    const inputs = document.querySelectorAll('.unit-price, .total-price, #subtotal_price, #total_after_discount, #grand_total');

    inputs.forEach(input => {
        // Saat mengetik
        input.addEventListener('input', function (event) {
            const rawValue = event.target.value.replace(/\D/g, ''); // Hapus karakter non-digit
            event.target.value = formatCurrency(rawValue); // Format ulang
        });

        // Saat kehilangan fokus
        input.addEventListener('blur', function (event) {
            const rawValue = event.target.value.replace(/\D/g, ''); // Hapus karakter non-digit
            event.target.value = formatCurrency(rawValue); // Format ulang
        });
    });
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const discountInput = document.getElementById('discount');
        const totalAfterDiscountContainer = document.getElementById('total-after-discount-container');

        // Tampilkan elemen ketika discount diklik atau difokuskan
        discountInput.addEventListener('focus', function () {
            totalAfterDiscountContainer.style.display = '';
        });

        // Tambahkan event listener untuk perubahan nilai discount
        discountInput.addEventListener('input', function () {
            const discountValue = parseFloat(discountInput.value) || 0;
            const subtotalInput = document.getElementById('subtotal_price');
            const totalAfterDiscountInput = document.getElementById('total_after_discount');

            const subtotal = parseFloat(subtotalInput.value.replace(/\./g, '')) || 0;
            const subTotalII = subtotal - (subtotal * (discountValue / 100));

            // Perbarui nilai Sub Total II
            totalAfterDiscountInput.value = new Intl.NumberFormat('id-ID').format(subTotalII);
        });
    });
</script>

@endsection
