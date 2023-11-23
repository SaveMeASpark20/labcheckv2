const DATA_COUNT = 7;
const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};

// Replace the months with school years
const schoolYears = [];

const Utils = {
  CHART_COLORS: ['red', 'blue', 'hotpink', ]
}

// Fetch school years from the server using AJAX
fetch('../includes/getRequestBySY.php')
    .then(response => response.json())
    .then(response => {
        // Populate the schoolYears array with the fetched data
        schoolYears.push(...response.schoolYears);

        const requestCounts = response.requestCounts;
        console.log(requestCounts);
        // Continue with the rest of your chart creation code
        const labels = schoolYears;
        const datasets = Object.keys(requestCounts).map((category, index) => {
          return {
            label: category,
            data: requestCounts[category],
            borderColor: Utils.CHART_COLORS[index],
            backgroundColor: Utils.CHART_COLORS[index],
          }
        })
          const data = {
            labels: labels,
            datasets: datasets,
        };
        
        const config = {
          type: 'line',
          data: data,
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Request History'
              }
            }
          },
        };
        
        // Create the chart using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, config);
    })
    .catch(error => {
        console.error('Error fetching school years:', error);
    });
const labels = schoolYears;



