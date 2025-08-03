// Au début de votre script.js
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer la wilaya depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const wilayaParam = urlParams.get('wilaya');
    
    if (wilayaParam) {
        // Pré-remplir le sélecteur de wilaya
        const wilayaSelect = document.getElementById('wilaya');
        wilayaSelect.value = wilayaParam;
        
        // Déclencher le chargement des villages
        if (wilayaSelect.value) {
            loadVillages();
        }
    }
});



// Chargement des wilayas au démarrage
window.onload = function() {
    const wilayaSelect = document.getElementById('wilaya');
    
    // Trier les wilayas par ordre alphabétique
    const wilayasSorted = Object.keys(villagesData).sort();
    
    wilayasSorted.forEach(wilaya => {
        const option = document.createElement('option');
        option.value = wilaya;
        option.textContent = wilaya;
        wilayaSelect.appendChild(option);
    });
};

// Charger les villages en fonction de la wilaya sélectionnée
function loadVillages() {
    const wilayaSelect = document.getElementById('wilaya');
    const villageSelect = document.getElementById('village');
    const selectedWilaya = wilayaSelect.value;
    
    // Réinitialiser le select village
    villageSelect.innerHTML = '<option value="">-- Choisir un village --</option>';
    villageSelect.disabled = !selectedWilaya;
    
    // Masquer la carte météo
    document.getElementById('weather-card').classList.add('hidden');
    
    if (selectedWilaya) {
        // Trier les villages par ordre alphabétique
        const villagesSorted = villagesData[selectedWilaya].sort();
        
        villagesSorted.forEach(village => {
            const option = document.createElement('option');
            option.value = village;
            option.textContent = village;
            villageSelect.appendChild(option);
        });
    }
}

// Afficher les données météo (simulées)
function showWeather() {
    const villageSelect = document.getElementById('village');
    const selectedVillage = villageSelect.value;
    const wilayaSelect = document.getElementById('wilaya');
    const selectedWilaya = wilayaSelect.value;
    
    if (!selectedVillage) {
        document.getElementById('weather-card').classList.add('hidden');
        return;
    }
    
    // Mettre à jour les informations de localisation
    document.getElementById('village-name').textContent = selectedVillage;
    document.getElementById('wilaya-name').textContent = selectedWilaya;
    
    // Générer des données météo aléatoires (simulation)
    const weatherConditions = [
        { type: "Ensoleillé", icon: "fa-sun", tempRange: [25, 35] },
        { type: "Nuageux", icon: "fa-cloud", tempRange: [20, 25] },
        { type: "Pluie légère", icon: "fa-cloud-rain", tempRange: [15, 20] },
        { type: "Orage", icon: "fa-bolt", tempRange: [18, 22] },
        { type: "Brouillard", icon: "fa-smog", tempRange: [10, 15] }
    ];
    
    const randomCondition = weatherConditions[Math.floor(Math.random() * weatherConditions.length)];
    const randomTemp = Math.floor(Math.random() * (randomCondition.tempRange[1] - randomCondition.tempRange[0] + 1)) + randomCondition.tempRange[0];
    const randomHumidity = Math.floor(Math.random() * 30) + 50;
    const randomWind = (Math.random() * 15 + 5).toFixed(1);
    
    // Mettre à jour l'interface
    document.getElementById('temperature').textContent = randomTemp;
    document.getElementById('conditions').textContent = randomCondition.type;
    document.getElementById('humidity').textContent = randomHumidity;
    document.getElementById('wind').textContent = randomWind;
    
    // Changer l'icône
    const locationIcon = document.querySelector('#location i');
    locationIcon.className = `fas ${randomCondition.icon}`;
    
    // Afficher la carte météo
    document.getElementById('weather-card').classList.remove('hidden');
}
// Vérifier l'état de connexion au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Simuler un état de connexion (à remplacer par votre logique réelle)
    const isLoggedIn = sessionStorage.getItem('loggedIn') === 'true';
    
    if (isLoggedIn) {
        document.querySelector('.user-dropdown').classList.add('logged-in');
        document.querySelector('.login-icon-btn span').textContent = 'Mon compte';
        
        // Ajouter une option supplémentaire pour le dropdown
        const dropdownContent = document.querySelector('.dropdown-content');
        dropdownContent.innerHTML = `
            <a href="profile.html"><i class="fas fa-user"></i> Mon profil</a>
            <a href="community.html"><i class="fas fa-users"></i> Communauté</a>
            <a href="#" id="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        `;
        
        // Gérer la déconnexion
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            sessionStorage.removeItem('loggedIn');
            window.location.href = 'index.html';
        });
    }
});
// Gestion de l'état de connexion
document.addEventListener('DOMContentLoaded', function() {
    const isLoggedIn = sessionStorage.getItem('loggedIn') === 'true';
    const loginIcon = document.querySelector('.login-icon');
    
    if (isLoggedIn) {
        // Modifier l'apparence si connecté
        document.querySelector('.header-login').classList.add('logged-in');
        loginIcon.innerHTML = '<i class="fas fa-user-check"></i><span class="login-text">Mon compte</span>';
        loginIcon.href = 'profile.html';
        
        // Ajouter un tooltip
        loginIcon.title = "Accéder à mon profil";
    } else {
        // Ajouter un effet au survol pour inciter à cliquer
        loginIcon.addEventListener('mouseenter', function() {
            this.innerHTML = '<i class="fas fa-sign-in-alt"></i><span class="login-text">Se connecter</span>';
        });
        
        loginIcon.addEventListener('mouseleave', function() {
            this.innerHTML = '<i class="fas fa-user-circle"></i><span class="login-text">Connexion</span>';
        });
    }
});