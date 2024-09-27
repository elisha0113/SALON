document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            events: 'fetch_appointments.php',  // Fetch events from the server
            dateClick: function(info) {
                alert('Date clicked: ' + info.dateStr);
            },
            eventClick: function(info) {
                alert('Event clicked: ' + info.event.title);
            }
        });

        calendar.render();
    } else {
        console.error("Calendar element not found!");
    }
});
