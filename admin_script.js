document.addEventListener('DOMContentLoaded', function () {
    console.log("Document is ready, attempting to load FullCalendar");

    var calendarEl = document.getElementById('calendar');
    
    if (!calendarEl) {
        console.log("Calendar element not found");
        return;
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: function(fetchInfo, successCallback, failureCallback) {
            console.log("Attempting to fetch appointments...");
            
            fetch('fetch_appointments.php')
                .then(response => {
                    console.log("Fetch request sent, waiting for response...");
                    return response.json();
                })
                .then(data => {
                    console.log("Response received: ", data);
                    successCallback(data);  // Pass the data to FullCalendar
                })
                .catch(error => {
                    console.error("Error fetching appointments:", error);
                    failureCallback(error);
                });
        }
    });

    calendar.render();
});
