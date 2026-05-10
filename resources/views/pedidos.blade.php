<x-layout title="Pedidos" subtitle="Historial de pedidos de la tienda.">
    <div class="panel">
        <div class="panel-header">
            <h3>Pedidos Recientes</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#ORD-001</td>
                    <td>María González</td>
                    <td>10 May, 2026</td>
                    <td><span class="status completed">Completado</span></td>
                    <td>€45.50</td>
                </tr>
                <tr>
                    <td>#ORD-002</td>
                    <td>Juan Pérez</td>
                    <td>10 May, 2026</td>
                    <td><span class="status pending">Pendiente</span></td>
                    <td>€120.00</td>
                </tr>
                <tr>
                    <td>#ORD-003</td>
                    <td>Laura Martínez</td>
                    <td>09 May, 2026</td>
                    <td><span class="status completed">Completado</span></td>
                    <td>€32.90</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-layout>
