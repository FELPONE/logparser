$(document).ready(function() {
  $.ajax({
    url: "methodDistribution",
    success: function(value) {
      new methodDistChart(value);
    }
  });

  $.ajax({
    url: "answerDistribution",
    success: function(value) {
      new answerDistChart(value);
    }
  });

  $.ajax({
    url: "requestMinute",
    success: function(value) {
      new requestMinuteChart(value);
    }
  });

  $.ajax({
    url: "sizeDistribution",
    success: function(value) {
      new sizeDistributionChart(value);
    }
  });
});
