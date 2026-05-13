const csaiState = {
    history: [],
    isLoading: false,
};

document.addEventListener('DOMContentLoaded', () => {
    initCsaiChat();
    initCsaiQuickActions();
});

function initCsaiChat() {
    const form = document.getElementById('csaiChatForm');
    const input = document.getElementById('csaiInput');

    if (!form || !input) {
        return;
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = input.value.trim();

        if (!message || csaiState.isLoading) {
            return;
        }

        input.value = '';
        await sendCsaiMessage(message);
    });
}

function initCsaiQuickActions() {
    const buttons = document.querySelectorAll('[data-message]');

    buttons.forEach((button) => {
        button.addEventListener('click', async () => {
            const message = button.dataset.message;

            if (!message || csaiState.isLoading) {
                return;
            }

            await sendCsaiMessage(message);
        });
    });
}

async function sendCsaiMessage(message) {
    csaiState.isLoading = true;

    appendCsaiMessage('user', message);
    appendCsaiTyping();

    try {
        const response = await fetch(window.csaiConfig.endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csaiConfig.csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                message,
                history: csaiState.history.slice(-8),
            }),
        });

        const data = await response.json();

        removeCsaiTyping();

        if (!response.ok) {
            appendCsaiMessage('ai', data.message || 'Maaf, terjadi kendala pada AI Customer Service.');
            return;
        }

        appendCsaiMessage('ai', data.reply || 'Maaf, saya belum bisa menjawab pertanyaan itu.', data.cta);

        csaiState.history.push({
            role: 'user',
            content: message,
        });

        csaiState.history.push({
            role: 'assistant',
            content: data.reply || '',
        });

        csaiState.history = csaiState.history.slice(-10);
    } catch (error) {
        removeCsaiTyping();
        appendCsaiMessage('ai', 'Maaf, koneksi ke AI Customer Service sedang bermasalah.');
    } finally {
        csaiState.isLoading = false;
    }
}

function appendCsaiMessage(role, message, cta = null) {
    const body = document.getElementById('csaiChatBody');

    if (!body) {
        return;
    }

    const wrapper = document.createElement('div');
    wrapper.className = `csai-message ${role === 'user' ? 'user' : 'ai'}`;

    if (role === 'user') {
        wrapper.innerHTML = `
            <div class="csai-message-content">
                <p>${escapeHtml(message)}</p>
                <small>Baru saja</small>
            </div>
        `;
    } else {
        const ctaHtml = cta && cta.url && cta.label
            ? `<a href="${escapeHtml(cta.url)}" class="csai-message-cta">${escapeHtml(cta.label)}</a>`
            : '';

        wrapper.innerHTML = `
            <div class="csai-message-avatar">
                <i class="bi bi-robot"></i>
            </div>

            <div class="csai-message-content">
                <p>${formatAiText(message)}</p>
                ${ctaHtml}
                <small>AI Customer Service</small>
            </div>
        `;
    }

    body.appendChild(wrapper);
    scrollCsaiToBottom();
}

function appendCsaiTyping() {
    const body = document.getElementById('csaiChatBody');

    if (!body) {
        return;
    }

    const typing = document.createElement('div');
    typing.className = 'csai-message ai csai-typing';
    typing.id = 'csaiTyping';
    typing.innerHTML = `
        <div class="csai-message-avatar">
            <i class="bi bi-robot"></i>
        </div>

        <div class="csai-message-content">
            <p>Sedang mengetik...</p>
            <small>Mohon tunggu</small>
        </div>
    `;

    body.appendChild(typing);
    scrollCsaiToBottom();
}

function removeCsaiTyping() {
    const typing = document.getElementById('csaiTyping');

    if (typing) {
        typing.remove();
    }
}

function scrollCsaiToBottom() {
    const body = document.getElementById('csaiChatBody');

    if (!body) {
        return;
    }

    body.scrollTop = body.scrollHeight;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatAiText(text) {
    return escapeHtml(text).replace(/\n/g, '<br>');
}