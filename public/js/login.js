// Fonction pour basculer la visibilité du mot de passe
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

// Gestion du formulaire de connexion
document.getElementById('loginForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Réinitialiser les erreurs
    document.querySelectorAll('.error').forEach(el => el.textContent = '');
    document.getElementById('successMessage').classList.add('d-none');
    
    // Désactiver le bouton et afficher le spinner
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    submitBtn.disabled = true;
    submitText.classList.add('d-none');
    loadingSpinner.classList.remove('d-none');
    
    try {
        // Envoyer la requête
        const response = await fetch('/login', {
            method: 'POST',
            body: new FormData(this)
        });
        
        const data = await response.json();
        
        // Réactiver le bouton
        submitBtn.disabled = false;
        submitText.classList.remove('d-none');
        loadingSpinner.classList.add('d-none');
        
        if (data.success) {
            // Succès
            const successMsg = document.getElementById('successMessage');
            successMsg.textContent = data.message || 'Connexion réussie !';
            successMsg.classList.remove('d-none');
            
            // Redirection après 1 seconde
            setTimeout(() => {
                window.location.href = data.redirect || '/dashboard';
            }, 1000);
            
        } else {
            // Afficher les erreurs
            if (data.errors) {
                for (const [field, message] of Object.entries(data.errors)) {
                    const errorElement = document.getElementById(field + 'Error');
                    if (errorElement) {
                        errorElement.textContent = message;
                    }
                }
            }
        }
        
    } catch (error) {
        console.error('Erreur:', error);
        
        // Réactiver le bouton en cas d'erreur
        submitBtn.disabled = false;
        submitText.classList.remove('d-none');
        loadingSpinner.classList.add('d-none');
        
        // Afficher une erreur générale
        document.getElementById('passwordError').textContent = 'Erreur de connexion au serveur';
    }
});

// Validation en temps réel (efface les erreurs quand l'utilisateur tape)
document.querySelectorAll('#loginForm .form-control').forEach(input => {
    input.addEventListener('input', function() {
        const errorId = this.id + 'Error';
        const errorElement = document.getElementById(errorId);
        if (errorElement) {
            errorElement.textContent = '';
        }
    });
});