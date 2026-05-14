document.addEventListener('DOMContentLoaded', () => {
    initOrderSummary();
    initOrderValidation();
    initOrderModal();
});

function initOrderSummary() {
    const watchedInputs = document.querySelectorAll(
        '#customerName, #customerPhone, input[name="service_package"], input[name="perfume"], input[name="delivery_option"]'
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

    const selectedService = document.querySelector('input[name="service_package"]:checked');
    const selectedPerfume = document.querySelector('input[name="perfume"]:checked');
    const selectedDelivery = document.querySelector('input[name="delivery_option"]:checked');

    setText('summaryName', name || 'Belum diisi');
    setText('summaryPhone', phone || 'Belum diisi');
    setText('summaryService', selectedService?.dataset.name || '-');
    setText('summaryPerfume', selectedPerfume?.dataset.name || '-');
    setText('summaryDelivery', selectedDelivery?.dataset.name || '-');

    const servicePrice = Number(selectedService?.dataset.price || 0);
    const perfumePrice = Number(selectedPerfume?.dataset.price || 0);
    const totalPerKg = servicePrice + perfumePrice;

    setText('summaryPrice', formatRupiah(totalPerKg) + '/kg');
}

function initOrderValidation() {
    const form = document.getElementById('orderForm');

    if (!form) {
        return;
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        clearErrors();

        const isValid = validateOrderForm();

        if (!isValid) {
            scrollToFirstError();
            return;
        }

        showOrderModal();
    });
}

function validateOrderForm() {
    let valid = true;

    const nameInput = document.getElementById('customerName');
    const phoneInput = document.getElementById('customerPhone');
    const addressInput = document.getElementById('customerAddress');

    const name = nameInput.value.trim();
    const phone = phoneInput.value.trim();
    const address = addressInput.value.trim();

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
    document.querySelectorAll('.order-input').forEach((input) => {
        input.classList.remove('is-invalid');
    });

    document.querySelectorAll('.order-error').forEach((error) => {
        error.textContent = '';
    });
}

function scrollToFirstError() {
    const firstInvalid = document.querySelector('.order-input.is-invalid');

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