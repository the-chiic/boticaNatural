<x-admin.layout title="Estadísticas" subtitle="Analiza el rendimiento de tu negocio.">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-coins"></i></div>
            <div class="stat-info">
                <h3>Ingresos de 2026</h3>
                <p>€{{ number_format($monthlyRevenue, 2) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <div class="stat-info">
                <h3>Ticket Medio</h3>
                <p>€{{ number_format($averageTicket, 2) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <h3>Clientes Nuevos (Mes)</h3>
                <p>{{ $newCustomers }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
            <div class="stat-info">
                <h3>Crecimiento</h3>
                <p>+14.8%</p>
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
                @forelse($topProducts as $tp)
                    <div class="top-product">
                        <div class="tp-info">
                            <h4>{{ $tp->name }}</h4>
                            <p>{{ $tp->category_name }}</p>
                        </div>
                        <div class="tp-sales">{{ $tp->total_units }} ud.</div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 20px; color: #888;">No hay ventas registradas.</div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Instrument Sans', sans-serif";
        Chart.defaults.color = '#6B7F5A';

        const ctxSales = document.getElementById('salesChart').getContext('2d');
        new Chart(ctxSales, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ingresos (€)',
                    data: @json($salesByMonth),
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
                labels: @json($categoryLabels),
                datasets: [{
                    data: @json($categoryData),
                    backgroundColor: ['#6B7F5A', '#8B6F4A', '#A3B49A', '#1E3A2E', '#4A5B3E'],
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
                        data: @json($newClientsData),
                        borderColor: '#8B6F4A',
                        backgroundColor: 'rgba(139, 111, 74, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Clientes Recurrentes',
                        data: @json($recurrentClientsData),
                        borderColor: '#6B7F5A',
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
</x-admin.layout>
