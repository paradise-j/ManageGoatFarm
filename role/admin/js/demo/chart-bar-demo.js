
// Set new default font family and font color to mimic Bootstrap's default styling
window.addEventListener('DOMContentLoaded', async (event) => {
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

  async function get_total_goat() {
    const res = await fetch("api/get_goat_sale.php");
    const json = await res.json()
    return json;
  }
  // Bar Chart Example
  var ctx = document.getElementById("myBarChart");
  // const data = await get_total_goat();
  // var my_data = [];
  // var my_label = [];
  // data.forEach(item => {
  //   my_data.push(item.total)
  //   switch (item.gg_type) {
  //     case '1':
  //       my_label.push('พ่อพันธุ์')
  //       break;
  //     case '2':
  //       my_label.push('แม่พันธุ์')
  //       break;
  //     case '3':
  //       my_label.push('ขุน')
  //       break;
  //   }
  // });
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      // labels: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
      labels: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ษ.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค", "พ.ย.", "ธ.ค"],
      datasets: [{
        label: "แพะพ่อพันธุ์",
        backgroundColor: "#2a86e9",
        // hoverBackgroundColor: "#f60e0e, #ff9c00, #f2f10f, #52f20f, #0fdff2, #0f34f2",
        borderColor: "#2a86e9",
        data: [150, 120, 100, 110, 89, 115, 90, 110, 100, 120, 170, 165]
      }, {
        label: "แพะแม่พันธุ์",
        backgroundColor: "#2ae955",
        // hoverBackgroundColor: "#f60e0e, #ff9c00, #f2f10f, #52f20f, #0fdff2, #0f34f2",
        borderColor: "#2ae955",
        data: [100, 120, 100, 110, 89, 115, 90, 110, 100, 120, 170, 165]
      }, {
        label: "แพะขุน",
        backgroundColor: "#e9452a",
        // hoverBackgroundColor: "#f60e0e, #ff9c00, #f2f10f, #52f20f, #0fdff2, #0f34f2",
        borderColor: "#e9452a",
        data: [160, 120, 100, 110, 89, 115, 90, 110, 100, 120, 170, 165]
      }],
    },
    // plugins: [ChartDataLabels],
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'month'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 12
          },
          maxBarThickness: 50,
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: 200,
            maxTicksLimit: 6,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              return '$' + number_format(value);
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: true
      },
      tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + number_format(tooltipItem.yLabel) + ' ตัว';
          }
        }
      },
    }
  });
});