function chartComp1() {
    return {
        // Define your chart data here
        chartData1: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Sales',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },

        renderChart1() {
            const ctx = document.getElementById('myChart1');
            new Chart(ctx, {
                type: 'line', // You can change this to 'bar', 'pie', etc.
                data: this.chartData1,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    }
}
function chartComp2() {
    return {
        // Define your chart data here
        chartData2: {
            labels: ['CreditCard', 'Cash', 'Debit', 'DP'],
                datasets: [{
                    backgroundColor: [ /* backgroundColor is optional */
                        "#2ecc71",
                        "#3498db",
                        "#95a5a6",
                        "#9b59b6"
                    ], 
                data: [400, 100, 50, 2]
            }]
        },
        renderChart2() {
            const ctx = document.getElementById('myChart2');
            new Chart(ctx, {
                type: 'pie', // You can change this to 'bar', 'pie', etc.
                data: this.chartData2,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    }
}
function chartComp3() {
    return {
        // Define your chart data here
        chartData3: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Sales',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },

        renderChart3() {
            const ctx = document.getElementById('myChart3');
            new Chart(ctx, {
                type: 'line', // You can change this to 'bar', 'pie', etc.
                data: this.chartData3,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    }
}
function chartComp4() {
    return {
        // Define your chart data here
        chartData4: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Sales',
                data: [75, 39, 50, 61, 46, 35, 60],
                fill: false,
                borderColor: 'rgba(197, 30, 22, 1)',
                tension: 0.1
            }]
        },

        renderChart4() {
            const ctx = document.getElementById('myChart4');
            new Chart(ctx, {
                type: 'line', // You can change this to 'bar', 'pie', etc.
                data: this.chartData4,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    }
}