@extends('layouts.distributor.master')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h1 class="h4 mb-0">Ajukan Quotation Baru</h1>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('distributor.quotations.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="topic" class="form-label">Topik</label>
                        <input type="text" name="topic" id="topic" class="form-control" value="{{ old('topic') }}" required>
                    </div>

                    <div id="product-container">
                        <h5>Produk yang Akan Diajukan</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="product-list">
                                <tr>
                                    <td>
                                        <img 
                                            src="{{ $products[0]->images->first() ? asset('storage/' . $products[0]->images->first()->images) : 'default-image.jpg' }}" 
                                            alt="Produk" 
                                            class="product-image" 
                                            width="50" 
                                            height="50">
                                    </td>
                                    <td>
                                        <select name="products[0][product_id]" class="form-select product-select" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" data-images="{{ $product->images->first() ? asset($product->images->first()->images) : 'default-image.jpg' }}">
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="products[0][quantity]" class="form-control quantity-input" min="1" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                            
                        </table>
                        <button type="button" id="add-product" class="btn btn-secondary mb-3">Tambah Produk</button>
                    </div>
                    

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('distributor.quotations.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Ajukan Quotation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let productIndex = 1;

    // Tambah produk baru
    document.getElementById('add-product').addEventListener('click', () => {
        const productList = document.getElementById('product-list');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
    <td>
        <img src="" alt="Produk" class="product-image" width="50" height="50">
    </td>
    <td>
        <select name="products[${productIndex}][product_id]" class="form-select product-select" required>
            <option value="">Pilih Produk</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" data-images="{{ $product->images->first() ? asset($product->images->first()->images) : asset('default-image.jpg') }}">
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" min="1" required>
    </td>
    <td>
        <button type="button" class="btn btn-danger btn-remove">Hapus</button>
    </td>
`;


        productList.appendChild(newRow);
        productIndex++;
    });

    // Hapus produk
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('tr').remove();
        }
    });

    // Hitung total harga
    document.addEventListener('input', (e) => {
        if (e.target.classList.contains('quantity-input') || e.target.classList.contains('price-input')) {
            const row = e.target.closest('tr');
            const quantity = row.querySelector('.quantity-input').value || 0;
            const price = row.querySelector('.price-input').value || 0;
            const totalPrice = row.querySelector('.total-price');
            totalPrice.textContent = (quantity * price).toFixed(2);
        }
    });

    document.addEventListener('change', (e) => {
    if (e.target.classList.contains('product-select')) {
        const selectedOption = e.target.selectedOptions[0];
        const imageURL = selectedOption.getAttribute('data-images');
        const row = e.target.closest('tr');
        const imageElement = row.querySelector('.product-image');
        if (imageElement) {
            imageElement.src = imageURL;
        } else {
            const img = document.createElement('img');
            img.src = imageURL;
            img.alt = "Produk";
            img.className = "product-image";
            img.width = 50;
            img.height = 50;
            row.cells[0].appendChild(img);
        }
    }
});

</script>

@endsection
