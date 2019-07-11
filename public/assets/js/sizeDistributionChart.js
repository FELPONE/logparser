function sizeDistributionChart(data) {
  let labels = Object.keys(data);
  let value = [];
  let i = 0;

  for (let key in data) {
    value[i++] = data[key];
  }

  new Chart(document.getElementById("sizeDistribution"), {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label:
            "Distribution size of the answer of all requests with code 200 and size < 1000B",

          backgroundColor: "#3c3a9f",
          data: value
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text:
          "Distribution size of the answer of all requests with code 200 and size < 1000B"
      }
    }
  });
}
