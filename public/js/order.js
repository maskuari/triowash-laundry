document.addEventListener('DOMContentLoaded', () => {
    initOrderSummary();
    initOrderValidation();
    initOrderModal();
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
    const formattedPrice = formatRupiah(totalPerKg) + '/kg';

    setText('summaryPrice', formattedPrice);
    setText('mobileSummaryPrice', formattedPrice);
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
            return;
        }

        const backendReady = form.dataset.backendReady === 'true';

        if (!backendReady) {
            event.preventDefault();
            showOrderModal();
        }
    });
}

function validateOrderForm() {
    let valid = true;

    const nameInput = document.getElementById('customerName');
    const phoneInput = document.getElementById('customerPhone');
    const addressInput = document.getElementById('customerAddress');

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
        setError('customerAddress', 'Alamat lengkap wajib diisi.');
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

function initOrderModal() {
    const closeButtons = document.querySelectorAll('[data-close-modal]');

    closeButtons.forEach((button) => {
        button.addEventListener('click', hideOrderModal);
    });
}

function showOrderModal() {
    const modal = document.getElementById('orderModal');

    if (!modal) {
        return;
    }

    modal.classList.add('show');
    modal.setAttribute('aria-hidden', 'false');
}

function hideOrderModal() {
    const modal = document.getElementById('orderModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('show');
    modal.setAttribute('aria-hidden', 'true');
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