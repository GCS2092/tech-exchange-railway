<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Options de Livraison</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Options de Livraison</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Choisissez votre mode de livraison</h5>
                    </div>
                    <div class="card-body">
                        <form id="deliveryForm">
                            <div class="mb-3">
                                <label class="form-label">Mode de livraison</label>
                                <select class="form-select" id="deliveryOption" name="delivery_option_id">
                                    <option value="">Sélectionnez une option</option>
                                </select>
                            </div>
                            
                            <div class="mb-3" id="zoneSelect" style="display: none;">
                                <label class="form-label">Zone de livraison</label>
                                <select class="form-select" id="zone" name="zone">
                                    <option value="">Sélectionnez une zone</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <h5>Coût de livraison : <span id="deliveryCost">0</span> FCFA</h5>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer les options de livraison
            fetch('/api/delivery/options')
                .then(response => response.json())
                .then(data => {
                    const options = data.data.options;
                    const zones = data.data.zones;
                    
                    // Remplir le select des options de livraison
                    const deliverySelect = document.getElementById('deliveryOption');
                    options.forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option.id;
                        opt.textContent = option.name;
                        deliverySelect.appendChild(opt);
                    });
                    
                    // Remplir le select des zones
                    const zoneSelect = document.getElementById('zone');
                    Object.entries(zones).forEach(([key, value]) => {
                        const opt = document.createElement('option');
                        opt.value = key;
                        opt.textContent = value;
                        zoneSelect.appendChild(opt);
                    });
                });

            // Écouter les changements sur le select de livraison
            document.getElementById('deliveryOption').addEventListener('change', function(e) {
                const zoneSelect = document.getElementById('zoneSelect');
                if (e.target.value != 1) { // Si ce n'est pas le retrait en magasin
                    zoneSelect.style.display = 'block';
                } else {
                    zoneSelect.style.display = 'none';
                    document.getElementById('deliveryCost').textContent = '0.00';
                }
            });

            // Écouter les changements sur le select de zone
            document.getElementById('zone').addEventListener('change', function(e) {
                if (e.target.value) {
                    const deliveryOptionId = document.getElementById('deliveryOption').value;
                    
                    fetch('/api/delivery/calculate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            zone: e.target.value,
                            delivery_option_id: deliveryOptionId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('deliveryCost').textContent = data.data.cost.toFixed(2);
                    });
                }
            });
        });
    </script>
</body>
</html> 