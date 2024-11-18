const salesCtx = document.getElementById('sales-chart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Sales',
            data: [12, 19, 3, 5, 2, 3],
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Monthly Sales'
            }
        }
    }
});

const productsCtx = document.getElementById('products-chart').getContext('2d');
new Chart(productsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Product A', 'Product B', 'Product C', 'Product D'],
        datasets: [{
            data: [300, 50, 100, 80],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Top Products'
            }
        }
    }
});

// Calendar
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
            {
                title: 'Meeting',
                start: '2023-05-15T10:30:00',
                end: '2023-05-15T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2023-05-16T12:00:00'
            },
            {
                title: 'Conference',
                start: '2023-05-18',
                end: '2023-05-20'
            }
        ]
    });
    calendar.render();
});

new SimpleBar(document.querySelector('main'));