$(document).ready(function() {
    var airQualityChart; // Variable pour stocker le graphique

    // Fonction pour effectuer la requête AJAX et générer le graphique
    function fetchDataAndRenderChart(selectedLocality) {
        // Récupérer les coordonnées de la localité sélectionnée
        var coordinates = selectedLocality.split(','); // Diviser la chaîne de coordonnées



        // Obtenez la date actuelle
        var currentDate = new Date();
            
        // Soustrayez 30 jours de la date actuelle pour obtenir la date de début
        currentDate.setDate(currentDate.getDate() - 29);
        var startTime = currentDate.toISOString();
        currentDate.setDate(currentDate.getDate() + 28);
        
        // Convertissez la date actuelle en format ISO 8601 pour obtenir la date de fin
        var endTime = currentDate.toISOString();

        // Créer l'objet de données pour la requête
        var requestData = {
            period: {
                   startTime: startTime,
                   endTime: endTime
            },
      
            location: {
                latitude: parseFloat(coordinates[0]), // Convertir en nombre
                longitude: parseFloat(coordinates[1]) // Convertir en nombre
            },
            universalAqi: true,
            languageCode: 'fr'
        };

        // Effectuer la requête AJAX avec jQuery
        $.ajax({
            url: 'https://airquality.googleapis.com/v1/history:lookup?key=AIzaSyDSXC0jFd9yAPUdc1kT1_c_h39czvPTwmw',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(requestData),
            success: function(airQualityData) {
                console.log(airQualityData);
                var labels = airQualityData.hoursInfo.map(function(hourInfo) {
                    return hourInfo.dateTime;
                });
               
                var aqiValues = airQualityData.hoursInfo.map(function(hourInfo) {
                    return hourInfo.indexes[0].aqi;
                });
               
                var ctx = document.getElementById('airQualityChart').getContext('2d');
                
                // Détruire le graphique existant s'il existe
                if (airQualityChart) {
                    airQualityChart.destroy();
                }

                // Créer un nouveau graphique
                airQualityChart = new Chart(ctx, {
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
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error('Erreur lors de la requête:', textStatus);
            }
        });
    }

    // Appeler la fonction fetchDataAndRenderChart lorsque la page est chargée
    var selectedLocality = $('#locality').val();
    fetchDataAndRenderChart(selectedLocality);

    // Appeler la fonction fetchDataAndRenderChart lorsque la valeur de la localité est modifiée
    $('#locality').change(function() {
        var selectedLocality = $(this).val();
        fetchDataAndRenderChart(selectedLocality);
    });
});
