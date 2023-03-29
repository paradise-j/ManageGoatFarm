window.addEventListener('DOMContentLoaded', async (event) => {
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    async function get_total_goat() {
      const res = await fetch("api/get_Gfarm_total.php");
      const json = await res.json()
      return json;
    }

    var ctx = document.getElementById("myPieChart2");
    const data = await get_total_goat();
    var my_data = [];
    var my_label = [];
    data.forEach(item => {
      my_data.push(item.total)
      my_label.push(item.gf_name)

    });
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: my_label,
        datasets: [{
          data: my_data,
          backgroundColor: ['#2a86e9', '#2ae955', '#e9452a'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        plugins: {
          datalabels: {
            color: '#36A2EB'
          }
        },
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true
        },
        cutoutPercentage: 50,
      },
    });

});

