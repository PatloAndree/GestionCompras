<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/base/pages/app-calendar.css') }}">
	<style>
		html, body {
			margin: 0;
			padding: 0;
			font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
			font-size: 14px;
		}

		#external-events {
			position: fixed;
			z-index: 2;
			top: 20px;
			left: 20px;
			width: 150px;
			padding: 0 10px;
			border: 1px solid #ccc;
			background: #eee;
		}

		#external-events .fc-event {
			cursor: move;
			margin: 3px 0;
		}

		#calendar-container {
			position: relative;
			z-index: 1;
			margin-left: 200px;
		}

		#calendar {
			max-width: 1100px;
			margin: 20px auto;
		}
	</style>
</head>
<body>
	<div id='external-events'>
  <p>
    <strong>Draggable Events</strong>
  </p>
  <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event alert alert-danger" data-event='{ "title": "Tiempo completo", "jornada": "1" }' role="alert">
	<div class="alert-body"><strong>Tiempo completo</strong></div>
</div>
  <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
    <div class='fc-event-main'>My Event 1</div>
  </div>
  <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
    <div class='fc-event-main'>My Event 2</div>
  </div>
  <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
    <div class='fc-event-main'>My Event 3</div>
  </div>
  <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
    <div class='fc-event-main'>My Event 4</div>
  </div>
  <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
    <div class='fc-event-main'>My Event 5</div>
  </div>

  <p>
    <input type='checkbox' id='drop-remove' />
    <label for='drop-remove'>remove after drop</label>
  </p>
</div>

<div id='calendar-container'>
  <div id='calendar'></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="{{ asset(mix('vendors/js/calendar/es.js')) }}"></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendar.Draggable;

  var containerEl = document.getElementById('external-events');
  var calendarEl = document.getElementById('calendar');
  var checkbox = document.getElementById('drop-remove');

  // initialize the external events
  // -----------------------------------------------------------------

  new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function(eventEl) {
      return {
        title: eventEl.innerText
      };
    }
  });

  // initialize the calendar
  // -----------------------------------------------------------------

  var calendar = new Calendar(calendarEl, {
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    editable: true,
    droppable: true, // this allows things to be dropped onto the calendar
    drop: function(info) {
      // is the "remove after drop" checkbox checked?
      if (checkbox.checked) {
        // if so, remove the element from the "Draggable Events" list
        info.draggedEl.parentNode.removeChild(info.draggedEl);
      }
    }
  });

  calendar.render();
});
</script>
</body>
</html>