document.addEventListener("DOMContentLoaded", () => {
    // ==========================================
    // GRÁFICO DE CONDICIONES (Chart.js)
    // ==========================================
    const ctx = document.getElementById("conditionChart");
    const rawData = window.condicionesChart || [];

    if (ctx && typeof Chart !== "undefined") {
        const labels = rawData.map((item) => item.diagnostico_principal || "Sin diagnóstico");
        const dataValues = rawData.map((item) => item.total || 0);

        const colors = [
            "#2563eb", // Azul primario
            "#ef4444", // Rojo riesgo alto
            "#f59e0b", // Ámbar medio
            "#10b981", // Esmeralda estable
            "#8b5cf6", // Violeta
            "#06b6d4", // Cian
        ];

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: labels.length ? labels : ["Sin datos registrados"],
                datasets: [
                    {
                        data: dataValues.length ? dataValues : [1],
                        backgroundColor: dataValues.length ? colors.slice(0, dataValues.length) : ["#e2e8f0"],
                        borderWidth: 2,
                        borderColor: "#ffffff",
                        hoverOffset: 6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            boxWidth: 12,
                            padding: 16,
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 12,
                                weight: "500",
                            },
                            color: "#475569",
                        },
                    },
                    tooltip: {
                        backgroundColor: "#0f172a",
                        titleFont: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 13,
                            weight: "700",
                        },
                        bodyFont: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 12,
                        },
                        padding: 10,
                        cornerRadius: 8,
                    },
                },
                cutout: "68%",
            },
        });
    }
});