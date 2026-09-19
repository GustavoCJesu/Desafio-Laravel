function applyCpfMask() {
    document.querySelectorAll('.cpf').forEach((cpf) => {
        cpf.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');

            // Limita a 11 números
            value = value.substring(0, 11);

            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

            this.value = value;
        });
    });
}

function validatePasswordConfirmation() {
    document.querySelectorAll('input[name="password"]').forEach((password) => {
        const confirmation = password.closest('form')?.querySelector('input[name="password_confirmation"]');

        if (!confirmation) {
            return;
        }

        const checkMatch = () => {
            const matches = confirmation.value === '' || password.value === confirmation.value;
            confirmation.setCustomValidity(matches ? '' : 'As senhas não coincidem.');
        };

        password.addEventListener('input', checkMatch);
        confirmation.addEventListener('input', checkMatch);
    });
}

function toggleModal(id) {
    const modal = document.getElementById(id);

    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');
}

function selectEmployee(row) {
    const radio = row.querySelector('input[type="radio"]');

    radio.checked = true;
}

function sendForm() {
    document.getElementById('filter').requestSubmit();
}

function closeMessage(card) {
    card.classList.toggle('hidden');
}

window.toggleModal = toggleModal;
window.selectEmployee = selectEmployee;
window.sendForm = sendForm;
window.closeMessage = closeMessage;

applyCpfMask();
validatePasswordConfirmation();
lucide.createIcons();
