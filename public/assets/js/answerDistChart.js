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
      hover: {
        animationDuration: 0
      },
      legend: { display: false },
      title: {
        display: true,
        text: "Distribution of HTTP answer codes (200, 404, 302,...)"
      },
      animation: {
        duration: 1,
        onComplete: function() {
          var chartInstance = this.chart,
            ctx = chartInstance.ctx;

          ctx.font = Chart.helpers.fontString(
            Chart.defaults.global.defaultFontSize,
            Chart.defaults.global.defaultFontStyle,
            Chart.defaults.global.defaultFontFamily
          );
          ctx.textAlign = "center";
          ctx.textBaseline = "bottom";

          this.data.datasets.forEach(function(dataset, i) {
            var meta = chartInstance.controller.getDatasetMeta(i);
            meta.data.forEach(function(bar, index) {
              var data = dataset.data[index];
              ctx.fillText(data, bar._model.x, bar._model.y - 5);
            });
          });
        }
      }
    }
  });
}
