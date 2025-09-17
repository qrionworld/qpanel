import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById("contentChart")?.getContext("2d");

    if (ctx) {
        const months = JSON.parse(document.getElementById("monthsData").value);
        const contentData = JSON.parse(document.getElementById("contentData").value);

        console.log("Months:", months);
        console.log("Content Data:", contentData);

        new Chart(ctx, {
            type: "line",
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Jumlah Content",
                        data: contentData,
                        borderColor: "#0d6efd",
                        backgroundColor: "rgba(13, 110, 253, 0.2)",
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                },
            },
        });
    }
});
