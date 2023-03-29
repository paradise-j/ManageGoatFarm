
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
    const res = await fetch("api/get_sum_price.php");
    const json = await res.json()
    return json;
  }


  // Bar Chart Example
  var ctx = document.getElementById("myBarChart");
  const data = await get_total_goat();
  var my_data1 = [];
  var my_data2 = [];
  var my_data3 = [];
  var my_label = [];
  var Unique_label = [];
  data.forEach(item => {
    switch (item.gg_type) {
      case '1':
        switch (item.month) {
          case '1':
            my_data1.push(item.total)
            break;
          case '2':
            my_data1.push(item.total)
            break;
          case '3':
            my_data1.push(item.total)
            break;
          case '4':
            my_data1.push(item.total)
            break;
          case '5':
            my_data1.push(item.total)
            break;
          case '6':
            my_data1.push(item.total)
            break;
          case '7':
            my_data1.push(item.total)
            break;
          case '8':
            my_data1.push(item.total)
            break;
          case '9':
            my_data1.push(item.total)
            break;
          case '10':
            my_data1.push(item.total)
            break;
          case '11':
            my_data1.push(item.total)
            break;
          case '12':
            my_data1.push(item.total)
            break;
        }
      break;
      case '2':
        switch (item.month) {
          case '1':
            my_data2.push(item.total)
            break;
          case '2':
            my_data2.push(item.total)
            break;
          case '3':
            my_data2.push(item.total)
            break;
          case '4':
            my_data2.push(item.total)
            break;
          case '5':
            my_data2.push(item.total)
            break;
          case '6':
            my_data2.push(item.total)
            break;
          case '7':
            my_data2.push(item.total)
            break;
          case '8':
            my_data2.push(item.total)
            break;
          case '9':
            my_data2.push(item.total)
            break;
          case '10':
            my_data2.push(item.total)
            break;
          case '11':
            my_data2.push(item.total)
            break;
          case '12':
            my_data2.push(item.total)
            break;
        }
      break;
      case '3':
        switch (item.month) {
          case '1':
            my_data3.push(item.total)
            break;
          case '2':
            my_data3.push(item.total)
            break;
          case '3':
            my_data3.push(item.total)
            break;
          case '4':
            my_data3.push(item.total)
            break;
          case '5':
            my_data3.push(item.total)
            break;
          case '6':
            my_data3.push(item.total)
            break;
          case '7':
            my_data3.push(item.total)
            break;
          case '8':
            my_data3.push(item.total)
            break;
          case '9':
            my_data3.push(item.total)
            break;
          case '10':
            my_data3.push(item.total)
            break;
          case '11':
            my_data3.push(item.total)
            break;
          case '12':
            my_data3.push(item.total)
            break;
        }
      break;
      
    }
    switch (item.month) {
      case '1':
        my_label.push('ม.ค.')
        break;
      case '2':
        my_label.push('ก.พ.')
        break;
      case '3':
        my_label.push('มี.ค.')
        break;
      case '4':
        my_label.push('เม.ษ.')
        break;
      case '5':
        my_label.push('พ.ค.')
        break;
      case '6':
        my_label.push('มิ.ย.')
        break;
      case '7':
        my_label.push('ก.ค.')
        break;
      case '8':
        my_label.push('ส.ค.')
        break;
      case '9':
        my_label.push('ก.ย.')
        break;
      case '10':
        my_label.push('ต.ค.')
        break;
      case '11':
        my_label.push('พ.ย.')
        break;
      case '12':
        my_label.push('ธ.ค.')
        break; 
    }
  });

  for( var i=0; i<my_label.length; i++ ) {
    if ( Unique_label.indexOf( my_label[i] ) < 0 ) {
      Unique_label.push( my_label[i] );
    }
  } 

  // console.log("my_data1 => "+ my_data1);
  // console.log("my_data2 => "+ my_data2);
  // console.log("my_data3 => "+ my_data3);
  // console.log("my_label => "+ Unique_label);

  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      // labels: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
      labels: Unique_label,
      datasets: [{
        label: "แพะพ่อพันธุ์",
        backgroundColor: "#2a86e9",
        // hoverBackgroundColor: "#f60e0e, #ff9c00, #f2f10f, #52f20f, #0fdff2, #0f34f2",
        borderColor: "#2a86e9",
        data: my_data1
      }, {
        label: "แพะแม่พันธุ์",
        backgroundColor: "#2ae955",
        // hoverBackgroundColor: "#f60e0e, #ff9c00, #f2f10f, #52f20f, #0fdff2, #0f34f2",
        borderColor: "#2ae955",
        data: my_data2
      }, {
        label: "แพะขุน",
        backgroundColor: "#e9452a",
        // hoverBackgroundColor: "#f60e0e, #ff9c00, #f2f10f, #52f20f, #0fdff2, #0f34f2",
        borderColor: "#e9452a",
        data: my_data3
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
            max: 50000,
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
            return datasetLabel +' '+ number_format(tooltipItem.yLabel) + ' บาท';
          }
        }
      },
    }
  });


});