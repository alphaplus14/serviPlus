fetch("../controller/datos_graficoCargo.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.nombreCargo);
    const valores = data.map((item) => item.cantidad);

    const ctx = document.getElementById("grafico2").getContext("2d");
    new Chart(ctx, {
      type: "bar", // Puede ser line, pie, doughnut, etc.
      data: {
        labels: labels,
        datasets: [
          {
            label: "Cantidad de Empleados por Cargo",
            data: valores,
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(255, 206, 86, 0.2)",
            ],
            borderColor: "rgba(75, 192, 192, 1)",

            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  })

  .catch((error) => console.error("Error al cargar los datos:", error));
