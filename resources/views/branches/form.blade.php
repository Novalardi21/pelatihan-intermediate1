<form method="POST" action="{{ $action }}">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="field">
        <label>Nama Cabang</label>
        <input type="text" name="nama" value="{{ old('nama', $branch->nama ?? '') }}" required>
        @error('nama')
            <small>{{ $message }}</small>
        @enderror
    </div>

    <div class="field">
        <label>Jenis Lokasi</label>
        <select name="jenis" required>
            <option value="toko" @selected(old('jenis', $branch->jenis ?? 'toko') === 'toko')>
                Toko
            </option>
            <option value="bengkel" @selected(old('jenis', $branch->jenis ?? '') === 'bengkel')>
                Bengkel
            </option>
        </select>
        @error('jenis')
            <small>{{ $message }}</small>
        @enderror
    </div>

    <div class="field">
        <label>Alamat</label>
        <textarea name="alamat" rows="3" required>{{ old('alamat', $branch->alamat ?? '') }}</textarea>
        @error('alamat')
            <small>{{ $message }}</small>
        @enderror
    </div>

    <div class="field">
        <label>Nomor Telepon</label>
        <input type="tel" name="telepon" value="{{ old('telepon', $branch->telepon ?? '') }}">
        @error('telepon')
            <small>{{ $message }}</small>
        @enderror
    </div>

    <div class="coordinates">

        <!-- Pilih lokasi melalui peta -->
        <div class="field">
            <label>Pilih Lokasi Cabang</label>
            <p style="color:gray; font-size:13px;">
                Klik pada peta untuk menentukan lokasi cabang.
                Klik kembali untuk memindahkan marker.
            </p>

            <div id="map-picker"
                style="
        height: 350px;
        width: 100%;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
        z-index: 0;
    ">
            </div>
        </div>

        <div class="coordinates">
            <div class="field">
                <label>Latitude</label>
                <input type="number" name="latitude" id="latitude" step="any" min="-90" max="90"
                    value="{{ old('latitude', $branch->latitude ?? '') }}" readonly required>
                @error('latitude')
                    <small>{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <label>Longitude</label>
                <input type="number" name="longitude" id="longitude" step="any" min="-180" max="180"
                    value="{{ old('longitude', $branch->longitude ?? '') }}" readonly required>
                @error('longitude')
                    <small>{{ $message }}</small>
                @enderror
            </div>
        </div>


    </div>

    <div class="buttons">
        <a href="{{ route('branches.index') }}" class="btn back">
            Batal
        </a>
        <button type="submit" class="btn save">
            Simpan Cabang
        </button>
    </div>
</form>
