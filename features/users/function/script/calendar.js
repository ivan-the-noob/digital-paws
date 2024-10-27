document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('appointmentCalendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: '',
      center: 'title',
      right: '',
    },
    dayCellDidMount: function (info) {
      var dayCell = info.el;
      var date = new Date(info.date);
      var today = new Date();
      today.setHours(0, 0, 0, 0);
      var maxDate = new Date(today);
      maxDate.setDate(today.getDate() + 14);

      if (date < today) {
        dayCell.style.visibility = 'hidden';
      } else if (date > maxDate) {
        dayCell.style.opacity = '0.5';
        dayCell.style.pointerEvents = 'none';
      } else {
        dayCell.classList.add('fc-daygrid-day-button');
        dayCell.addEventListener('click', function () {
          var options = { year: 'numeric', month: 'long', day: 'numeric' };
          var formattedDate = new Date(info.date).toLocaleDateString('en-US', options);
          document.getElementById('modalContent').textContent = formattedDate;
          var modal = new bootstrap.Modal(document.getElementById('dayModal'));
          modal.show();
        });
      }
    }
  });

  calendar.render();
});