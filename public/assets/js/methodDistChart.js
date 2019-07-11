function methodDistChart(data) {
  let value = [
    data.POST,
    data.GET,
    data.HEAD,
    data.PUT,
    data.DELETE,
    data.PATCH
  ];

  new Chart(document.getElementById("methodDist"), {
    type: "horizontalBar",
    data: {
      labels: ["POST", "GET", "HEAD", "PUT", "DELETE", "PATCH"],
      datasets: [
        {
          label: "Distribution of HTTP methods (GET, POST, HEAD,...)",
          backgroundColor: [
            "#3e95cd",
            "#8e5ea2",
            "#3cba9f",
            "#e8c3b9",
            "#c45850",
            "#c23450"
          ],
          data: value
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: "Distribution of HTTP methods (GET, POST, HEAD,...)"
      }
    }
  });
}
