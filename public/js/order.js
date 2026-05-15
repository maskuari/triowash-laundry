document.addEventListener('DOMContentLoaded', () => {
    initOrderSummary();
    initOrderValidation();
    initOrderMap();
});

function initOrderSummary() {
    const watchedInputs = document.querySelectorAll(
        '#customerName, #customerPhone, #serviceSelect, #fragranceSelect, #pickupSelect'
    );

    watchedInputs.forEach((input) => {
        input.addEventListener('input', updateOrderSummary);
        input.addEventListener('change', updateOrderSummary);
    });

    updateOrderSummary();
}

function updateOrderSummary() {
    const name = document.getElementById('customerName')?.value.trim();
    const phone = document.getElementById('customerPhone')?.value.trim();

    const selectedService = getSelectedOption('serviceSelect');
    const selectedFragrance = getSelectedOption('fragranceSelect');
    const selectedPickup = getSelectedOption('pickupSelect');

    setText('summaryName', name || 'Belum diisi');
    setText('summaryPhone', phone || 'Belum diisi');
    setText('summaryService', selectedService?.dataset.displayName || selectedService?.dataset.name || '-');
    setText('summaryPerfume', selectedFragrance?.dataset.name || '-');
    setText('summaryDelivery', selectedPickup?.dataset.name || '-');

    const servicePrice = Number(selectedService?.dataset.price || 0);
    const fragrancePrice = Number(selectedFragrance?.dataset.price || 0);
    const totalPerKg = servicePrice + fragrancePrice;

    setText('summaryPrice', formatRupiah(totalPerKg) + '/kg');
}

function getSelectedOption(selectId) {
    const select = document.getElementById(selectId);

    if (!select) {
        return null;
    }

    return select.options[select.selectedIndex];
}

function initOrderValidation() {
    const form = document.getElementById('orderForm');

    if (!form) {
        return;
    }

    form.addEventListener('submit', (event) => {
        clearErrors();

        const isValid = validateOrderForm();

        if (!isValid) {
            event.preventDefault();
            scrollToFirstError();
        }
    });
}

function validateOrderForm() {
    let valid = true;

    const nameInput = document.getElementById('customerName');
    const phoneInput = document.getElementById('customerPhone');
    const addressInput = document.getElementById('addressDetail');

    const name = nameInput?.value.trim();
    const phone = phoneInput?.value.trim();
    const address = addressInput?.value.trim();

    if (!name) {
        setError('customerName', 'Nama lengkap wajib diisi.');
        valid = false;
    }

    if (!phone) {
        setError('customerPhone', 'Nomor telepon wajib diisi.');
        valid = false;
    } else if (!isValidPhone(phone)) {
        setError('customerPhone', 'Nomor telepon tidak valid, minimal 10 digit.');
        valid = false;
    }

    if (!address) {
        setError('addressDetail', 'Detail alamat wajib diisi.');
        valid = false;
    }

    return valid;
}

function isValidPhone(phone) {
    const cleanPhone = phone.replace(/\D/g, '');

    return cleanPhone.length >= 10 && cleanPhone.length <= 15;
}

function setError(inputId, message) {
    const input = document.getElementById(inputId);
    const error = document.querySelector(`[data-error="${inputId}"]`);

    if (input) {
        input.classList.add('is-invalid');
    }

    if (error) {
        error.textContent = message;
    }
}

function clearErrors() {
    document.querySelectorAll('.order-field input, .order-field textarea').forEach((input) => {
        input.classList.remove('is-invalid');
    });

    document.querySelectorAll('.order-error').forEach((error) => {
        error.textContent = '';
    });
}

function scrollToFirstError() {
    const firstInvalid = document.querySelector('.is-invalid');

    if (!firstInvalid) {
        return;
    }

    firstInvalid.scrollIntoView({
        behavior: 'smooth',
        block: 'center',
    });
}

function initOrderMap() {
    const mapElement = document.getElementById('orderMap');

    if (!mapElement || typeof L === 'undefined') {
        console.warn('Leaflet belum terbaca atau elemen orderMap tidak ditemukan.');
        return;
    }

    const oldLat = Number(document.getElementById('latitude')?.value);
    const oldLng = Number(document.getElementById('longitude')?.value);

    const defaultLocation = {
        lat: !Number.isNaN(oldLat) && oldLat ? oldLat : -3.318606,
        lng: !Number.isNaN(oldLng) && oldLng ? oldLng : 114.594378,
    };

    const map = L.map('orderMap', {
        scrollWheelZoom: false,
    }).setView([defaultLocation.lat, defaultLocation.lng], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap',
    }).addTo(map);

    const marker = L.marker([defaultLocation.lat, defaultLocation.lng], {
        draggable: true,
    }).addTo(map);

    setTimeout(() => {
        map.invalidateSize();
    }, 300);

    updateLocation(defaultLocation.lat, defaultLocation.lng);

    map.on('click', (event) => {
        const { lat, lng } = event.latlng;

        marker.setLatLng([lat, lng]);
        updateLocation(lat, lng);
    });

    marker.on('dragend', () => {
        const position = marker.getLatLng();

        updateLocation(position.lat, position.lng);
    });

    const locationButton = document.getElementById('useMyLocationBtn');

    locationButton?.addEventListener('click', () => {
        if (!navigator.geolocation) {
            alert('Browser kamu tidak mendukung fitur lokasi.');
            return;
        }

        locationButton.disabled = true;
        locationButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Mencari...';

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                updateLocation(lat, lng);

                setTimeout(() => {
                    map.invalidateSize();
                }, 200);

                locationButton.disabled = false;
                locationButton.innerHTML = '<i class="bi bi-geo-alt"></i> Lokasi Saya';
            },
            () => {
                alert('Gagal mengambil lokasi. Pastikan izin lokasi diaktifkan.');

                locationButton.disabled = false;
                locationButton.innerHTML = '<i class="bi bi-geo-alt"></i> Lokasi Saya';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0,
            }
        );
    });
}

async function updateLocation(lat, lng) {
    setValue('latitude', lat.toFixed(7));
    setValue('longitude', lng.toFixed(7));
    setValue('googleMapsLink', `https://www.google.com/maps?q=${lat},${lng}`);

    try {
        const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&addressdetails=1`,
            {
                headers: {
                    'Accept': 'application/json',
                },
            }
        );

        const data = await response.json();
        const address = data.address || {};

        const country = address.country || 'Indonesia';
        const province = address.state || address.region || '-';
        const city = address.city || address.town || address.county || address.municipality || '-';
        const district = address.suburb || address.city_district || address.district || address.village || address.hamlet || '-';
        const village = address.village || address.hamlet || address.neighbourhood || '-';

        setValue('country', country);
        setValue('province', province);
        setValue('city', city);
        setValue('district', district);
        setValue('village', village);

        setText('previewCountry', country);
        setText('previewProvince', province);
        setText('previewCity', city);
        setText('previewDistrict', district);
    } catch (error) {
        setText('previewCountry', 'Gagal membaca');
        setText('previewProvince', 'Gagal membaca');
        setText('previewCity', 'Gagal membaca');
        setText('previewDistrict', 'Gagal membaca');
    }
}

function setValue(id, value) {
    const element = document.getElementById(id);

    if (element) {
        element.value = value;
    }
}

function setText(id, value) {
    const element = document.getElementById(id);

    if (element) {
        element.textContent = value;
    }
}

function formatRupiah(value) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(value);
}