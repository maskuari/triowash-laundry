<div class="admin-manage-item">
    <div class="admin-manage-item-head">
        <div class="admin-service-icon">
            <i class="bi {{ $service->icon_class }}"></i>
        </div>

        <div>
            <strong>{{ $service->service_name }}</strong>
            <span>
                {{ $service->category_label }}
                • Rp{{ number_format($service->price_per_kg, 0, ',', '.') }}/kg
            </span>
        </div>

        <form method="POST" action="{{ route('admin.services.delete', $service->id) }}" class="ms-auto">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Hapus data ini?')">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.services.update', $service->id) }}" class="admin-setting-form admin-edit-form">
        @csrf
        @method('PATCH')

        <div>
            <label>Nama</label>
            <input type="text" name="service_name" value="{{ $service->service_name }}">
        </div>

        <div>
            <label>Kategori</label>
            <select name="category">
                <option value="paket" @selected($service->category === 'paket')>Paket</option>
                <option value="layanan" @selected($service->category === 'layanan')>Layanan</option>
                <option value="wangi" @selected($service->category === 'wangi')>Wangi</option>
            </select>
        </div>

        <div>
            <label>Harga per Kg</label>
            <input type="number" name="price_per_kg" value="{{ $service->price_per_kg }}">
        </div>

        <button type="submit" class="admin-btn-secondary">
            Simpan Edit
        </button>
    </form>
</div>