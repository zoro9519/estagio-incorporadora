const aguardandoAprov = "#f39c12";
const aprovado = "#65b473";
const recusado = "#a54242";


var calendarEl = document.getElementById('calendar');

var date = new Date()
var d    = date.getDate(),
    m    = date.getMonth(),
    y    = date.getFullYear()

var Calendar = FullCalendar.Calendar;

var calendar = new Calendar(calendarEl, {
    headerToolbar: {
      left  : 'prev,next today',
      center: 'title',
      right : 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    themeSystem: 'bootstrap',
    //Random default events
    events: [
      {
        title          : 'Visita Lote #3132',
        start          : new Date(y, m, 1),
        backgroundColor: aguardandoAprov, //red
        borderColor    : aguardandoAprov, //red
      },
      {
        title          : 'Visita Lote #4132',
        start          : new Date(y, m, d - 4, 12, 15),
        backgroundColor: aprovado, //yellow
        borderColor    : aprovado //yellow
      },
      {
        title          : 'Visita Lote #2432',
        start          : new Date(y, m, d, 10, 30),
        allDay         : false,
        backgroundColor: recusado, //Blue
        borderColor    : recusado //Blue
      },
      
      {
        title          : 'Visita Lote #412',
        start          : new Date(y, m, 28),
        backgroundColor: aprovado, //Primary (light-blue)
        borderColor    : aprovado //Primary (light-blue)
      }
    ],
    
    eventClick: function(calEvent, jsEvent, view) {
    },

    editable  : false,
    droppable : false, 
    
  });

  calendar.render();