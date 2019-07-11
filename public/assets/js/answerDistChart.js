function answerDistChart(data) {
  let labels = Object.keys(data);
  let value = [];
  let i = 0;

  for (let key in data) {
    value[i++] = data[key];
  }

  new Chart(document.getElementById("answerDist"), {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Distribution of HTTP answer codes (200, 404, 302,...)",
          backgroundColor: [
            "#3e95cd",
            "#8e5ea2",
            "#3cba9f",
            "#e23449",
            "#c45850",
            "#c43450",
            "#c45650",
            "#c47850"
          ],
          data: value
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: "Distribution of HTTP answer codes (200, 404, 302,...)"
      }
    }
  });
}
