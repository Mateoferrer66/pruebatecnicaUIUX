document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    const messageBox = document.getElementById('messageBox');

    // Validation patterns
    const patterns = {
        name: /^[a-zA-Z\s]{2,50}$/, // Name: 2-50 characters, letters and spaces
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, // Email: basic email format
        message: /.{10,}/ // Message: at least 10 characters
    };

    function validateForm() {
        let isValid = true;

        // Validate name
        const nameInput = document.getElementById('name');
        const nameError = document.getElementById('nameError');
        if (!patterns.name.test(nameInput.value.trim())) {
            isValid = false;
            nameError.textContent = 'El nombre debe tener entre 2 y 50 caracteres.';
        } else {
            nameError.textContent = '';
        }

        // Validate email
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        if (!patterns.email.test(emailInput.value.trim())) {
            isValid = false;
            emailError.textContent = 'Debes ingresar un correo válido.';
        } else {
            emailError.textContent = '';
        }

        // Validate message
        const messageInput = document.getElementById('message');
        const messageError = document.getElementById('messageError');
        if (!patterns.message.test(messageInput.value.trim())) {
            isValid = false;
            messageError.textContent = 'El mensaje debe tener al menos 10 caracteres.';
        } else {
            messageError.textContent = '';
        }

        return isValid; // Return true if all fields are valid
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        if (validateForm()) {
            // Send form data to the server using AJAX
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        messageBox.style.display = 'block';
                        messageBox.style.backgroundColor = '#d4edda';
                        messageBox.style.color = '#155724';
                        messageBox.innerText = data.message;
                        form.reset(); // Reset the form after successful submission
                    } else {
                        // Show error message from the server
                        messageBox.style.display = 'block';
                        messageBox.style.backgroundColor = '#f8d7da';
                        messageBox.style.color = '#721c24';
                        messageBox.innerText = data.message;
                    }
                })
                .catch(error => {
                    // Handle network or server errors
                    messageBox.style.display = 'block';
                    messageBox.style.backgroundColor = '#f8d7da';
                    messageBox.style.color = '#721c24';
                    messageBox.innerText = 'Ocurrió un error al enviar el formulario. Inténtalo de nuevo más tarde.';
                    console.error('Error:', error);
                });
        } else {
            // Show error message if the form is invalid
            messageBox.style.display = 'block';
            messageBox.style.backgroundColor = '#f8d7da';
            messageBox.style.color = '#721c24';
            messageBox.innerText = 'Por favor, corrige los errores antes de enviar el formulario.';
        }
    });
});