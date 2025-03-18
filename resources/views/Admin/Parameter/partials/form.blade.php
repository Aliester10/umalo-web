<div class="form-group">
    <label for="company_name">Nama Perusahaan</label>
    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $companyParameter->company_name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="short_history">Sejarah Singkat</label>
    <textarea name="short_history" class="form-control">{{ old('short_history', $companyParameter->short_history ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $companyParameter->email ?? '') }}" required>
</div>

<div class="form-group">
    <label for="no_telepon">Nomor Telepon</label>
    <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $companyParameter->no_telepon ?? '') }}" required>
</div>

<div class="form-group">
    <label for="no_wa">WhatsApp</label>
    <input type="text" name="no_wa" class="form-control" value="{{ old('no_wa', $companyParameter->no_wa ?? '') }}" required>
</div>

<div class="form-group">
    <label for="address">Alamat</label>
    <textarea name="address" class="form-control" required>{{ old('address', $companyParameter->address ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="maps_url">URL Lokasi</label>
    <input type="text" name="maps_url" class="form-control" value="{{ old('maps_url', $companyParameter->maps_url ?? '') }}">
</div>

<div class="form-group">
    <label for="maps_iframe">Iframe Lokasi</label>
    <input type="text" name="maps_iframe" class="form-control" value="{{ old('maps_iframe', $companyParameter->maps_iframe ?? '') }}">
</div>

<div class="form-group">
    <label for="visi">Visi</label>
    <textarea name="visi" class="form-control">{{ old('visi', $companyParameter->visi ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="misi">Misi</label>
    <textarea name="misi" class="form-control">{{ old('misi', $companyParameter->misi ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="logo">Logo</label>
    <input type="file" name="logo" class="form-control">
    @if(isset($companyParameter->logo))
        <img src="{{ asset($companyParameter->logo) }}" alt="Logo" width="100">
    @endif
</div>

<div class="form-group">
    <label for="logo_support_2">Logo Support 2</label>
    <input type="file" name="logo_support_2" class="form-control">
    @if(isset($companyParameter->logo_support_2))
        <img src="{{ asset($companyParameter->logo_support_2) }}" alt="Logo Support 2" width="100">
    @endif
</div>

<div class="form-group">
    <label for="logo_support_3">Logo Support 3</label>
    <input type="file" name="logo_support_3" class="form-control">
    @if(isset($companyParameter->logo_support_3))
        <img src="{{ asset($companyParameter->logo_support_3) }}" alt="Logo Support 3" width="100">
    @endif
</div>

<div class="form-group">
    <label for="instagram">Instagram</label>
    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $companyParameter->instagram ?? '') }}">
</div>

<div class="form-group">
    <label for="linkedin">LinkedIn</label>
    <input type="text" name="linkedin" class="form-control" value="{{ old('linkedin', $companyParameter->linkedin ?? '') }}">
</div>

<div class="form-group">
    <label for="ekatalog">Link E-Katalog</label>
    <input type="text" name="ekatalog" class="form-control" value="{{ old('ekatalog', $companyParameter->ekatalog ?? '') }}">
</div>

<div class="form-group">
    <label for="no_acc_bank">Nomor Rekening</label>
    <input type="text" name="no_acc_bank" class="form-control" value="{{ old('no_acc_bank', $companyParameter->no_acc_bank ?? '') }}" required>
</div>

<div class="form-group">
    <label for="bank">Bank</label>
    <input type="text" name="bank" class="form-control" value="{{ old('bank', $companyParameter->bank ?? '') }}" required>
</div>

