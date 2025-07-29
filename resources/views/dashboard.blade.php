<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Tableau de bord
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistiques Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white shadow-lg rounded-xl p-6 hover:scale-105 transition transform duration-300">
                    <div class="text-gray-500">Commandes en cours</div>
                    <div class="text-4xl font-bold text-yellow-500 mt-2">{{ $commandesEnCours }}</div>
                </div>
                <div class="bg-white shadow-lg rounded-xl p-6 hover:scale-105 transition transform duration-300">
                    <div class="text-gray-500">Commandes validées</div>
                    <div class="text-4xl font-bold text-green-500 mt-2">{{ $commandesValidees }}</div>
                </div>
                <div class="bg-white shadow-lg rounded-xl p-6 hover:scale-105 transition transform duration-300">
                    <div class="text-gray-500">Recettes du jour</div>
                    <div class="text-3xl font-bold text-blue-500 mt-2">{{ number_format($recettesJour, 0, ',', ' ') }} FCFA</div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-700">Commandes du mois</h3>
                <canvas id="commandesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('commandesChart').getContext('2d');
        const commandesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Nombre de commandes',
                    data: @json($data),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 8,
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
</x-app-layout>
