
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
  var ctx = document.getElementById("myBarChart2");
  const data = await get_total_goat();
  var my_data = [];
  var my_label = [];
  data.forEach(item => {
    my_data.push(item.total)
    switch (item.month) {
      case '1':
        my_label.push('มกราคม')
        break;
      case '2':
        my_label.push('กุมภาพันธ์')
        break;
      case '3':
        my_label.push('มีนาคม')
        break;
      case '4':
        my_label.push('เมษายน')
        break;
      case '5':
        my_label.push('พฤษภาคม')
        break;
      case '6':
        my_label.push('มิถุนายน')
        break;
      case '7':
        my_label.push('กรกฎาคม')
        break;
      case '8':
        my_label.push('สิงหาคม')
        break;
      case '9':
        my_label.push('กันยายน')
        break;
      case '10':
        my_label.push('ตุลาคม')
        break;
      case '11':
        my_label.push('พฤศจิกายน')
        break;
      case '12':
        my_label.push('ธันวาคม')
        break; 
    }
  });
  var myBarChart2 = new Chart(ctx, {
    type: 'bar',
    data: {
      // labels: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
      labels: my_label,
      // labels: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ษ.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค", "พ.ย.", "ธ.ค"],
      datasets: [{
        label: "ยอดขายสุทธิ",
        backgroundColor: "#f34c29",
        hoverBackgroundColor: "#b12c10",
        borderColor: "#f34c29",
        data: my_data
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
            max: 500000,
            maxTicksLimit: 6,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              return number_format(value);
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
            return datasetLabel+' ' + number_format(tooltipItem.yLabel) + ' บาท ';
          }
        }
      },
    }
  });
});