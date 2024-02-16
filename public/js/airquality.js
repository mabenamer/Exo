$(document).ready(function() {
    var airQualityChart; // Variable pour stocker le graphique
    var ctx = document.getElementById('airQualityChart').getContext('2d');
        
    // Détruire le graphique existant s'il existe
    if (airQualityChart) {
        airQualityChart.destroy();
    }
    var select = document.getElementById('locality');

    // Ajouter un écouteur d'événements pour le changement de sélection dans le sélecteur de localité
    select.addEventListener('change', function() {
        var selectedLocality = select.value;
        
        // Soumettre le formulaire
        document.getElementById('localityForm').submit();
    });
    // Créer un nouveau graphique
    var airQualityChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Air Quality Index',
                data: aqiValues,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
