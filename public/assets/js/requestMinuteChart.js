function requestMinuteChart(data) {
  let labels = [];
  let value = [];

  for (let day in data) {
    if (data[day] != null) {
      for (let hour in data[day]) {
        if (data[day][hour] != null) {
          for (let minute in data[day][hour]) {
            let index = day + "-" + hour + "-" + minute;
            labels.push(index);
            value.push(data[day][hour][minute]);
          }
        }
      }
    }
  }

  new Chart(document.getElementById("requestMinute"), {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Requests per minute over the entire time span",
          backgroundColor: "#3cba9f",
          data: value
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: "Requests per minute over the entire time span"
      }
    }
  });
}
