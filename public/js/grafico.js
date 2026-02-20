fetch("../controller/datos_grafico.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.nombreDepartamento);
    const valores = data.map((item) => item.cantidad);

    const ctx = document.getElementById("grafico1").getContext("2d");
    new Chart(ctx, {
      type: "bar", // Puede ser line, pie, doughnut, etc.
      data: {
        labels: labels,
        datasets: [
          {
            label: "Cantidad de Empleados por Departamento",
            data: valores,
            backgroundColor: "rgba(75, 192, 192, 0.5)",
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
