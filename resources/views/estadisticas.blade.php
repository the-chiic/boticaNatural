<x-layout title="Estadísticas" subtitle="Analiza el rendimiento de tu negocio.">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-coins"></i></div>
            <div class="stat-info">
                <h3>Ingresos del Mes</h3>
                <p>€4,520.00</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <div class="stat-info">
                <h3>Ticket Medio</h3>
                <p>€45.20</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <h3>Nuevos Clientes</h3>
                <p>128</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
            <div class="stat-info">
                <h3>Crecimiento</h3>
                <p>+12.5%</p>
            </div>
        </div>
    </div>

    <div class="panels-grid row-gap">
        <div class="panel">
            <div class="panel-header">
                <h3>Ventas Anuales (2026)</h3>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3>Ventas por Categoría</h3>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="panels-grid">
        <div class="panel">
            <div class="panel-header">
                <h3>Evolución de Clientes (Nuevos vs Recurrentes)</h3>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="customersChart"></canvas>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3>Top Productos</h3>
            </div>
            <div>
                <div class="top-product">
                    <div class="tp-info">
                        <h4>Té Matcha Premium</h4>
                        <p>Infusiones</p>
                    </div>
                    <div class="tp-sales">340 ud.</div>
                </div>
                <div class="top-product">
                    <div class="tp-info">
                        <h4>Aceite de Jojoba</h4>
                        <p>Cosmética Bio</p>
                    </div>
                    <div class="tp-sales">280 ud.</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = 'Arial, sans-serif';
        Chart.defaults.color = '#666';

        const ctxSales = document.getElementById('salesChart').getContext('2d');
        new Chart(ctxSales, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ingresos (€)',
                    data: [1200, 1900, 1500, 2200, 1800, 2500, 2100, 2600, 2300, 2800, 3100, 4520],
                    backgroundColor: '#6B7F5A',
                    borderRadius: 6,
                    hoverBackgroundColor: '#1E3A2E'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(237, 231, 219, 0.5)' }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });

        const ctxCategories = document.getElementById('categoriesChart').getContext('2d');
        new Chart(ctxCategories, {
            type: 'doughnut',
            data: {
                labels: ['Infusiones', 'Cosmética Bio', 'Aceites Esenciales', 'Suplementos'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: ['#6B7F5A', '#8B6F4A', '#A3B49A', '#1E3A2E'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, pointStyle: 'circle', font: {size: 11} } }
                }
            }
        });

        const ctxCustomers = document.getElementById('customersChart').getContext('2d');
        new Chart(ctxCustomers, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Nuevos Clientes',
                        data: [30, 45, 40, 55, 50, 75],
                        borderColor: '#8B6F4A', // brown
                        backgroundColor: 'rgba(139, 111, 74, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Clientes Recurrentes',
                        data: [15, 20, 35, 40, 60, 85],
                        borderColor: '#6B7F5A', // olive
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        tension: 0.4,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, pointStyle: 'line' } }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(237, 231, 219, 0.5)' }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });
    </script>
    @endpush
</x-layout>
