<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario con Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        .banner {
            width: 100%;
            background-color: #2196F3;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 28px;
            position: fixed;
            top: 0;
        }
        .footer-banner {
            width: 100%;
            background-color: #2196F3;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 18px;
            position: fixed;
            bottom: 0;
        }
        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 80%;
            max-width: 1200px;
            margin-top: 100px; /* Espacio para el banner superior */
            margin-bottom: 100px; /* Espacio para el banner inferior */
        }
        .calendar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 70%;
            position: relative;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .calendar-header button {
            padding: 5px 10px;
            font-size: 18px;
            cursor: pointer;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
        }
        .calendar-header button:hover {
            background-color: #1976D2;
        }
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        .calendar-day {
            padding: 15px;
            cursor: pointer;
            border-radius: 8px;
            background-color: #f9f9f9;
            position: relative;
            transition: background-color 0.3s;
            font-size: 16px;
        }
        .calendar-day:hover {
            background-color: #e0e0e0;
        }
        .calendar-day.selected {
            background-color: #2196F3;
            color: white;
        }
        .calendar-day.has-event {
            color: white;
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.5);
        }
        .calendar-day .event-preview {
            position: absolute;
            bottom: 5px;
            left: 5px;
            padding: 3px 5px;
            border-radius: 4px;
            font-size: 12px;
        }
        .editor {
            margin-left: 30px;
            width: 25%;
            display: none;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .editor input, .editor textarea, .editor select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .editor button {
            background-color: #2196F3;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
            width: 100%;
        }
        .editor button:hover {
            background-color: #1976D2;
        }
        .editor .close-button {
            background-color: #e74c3c;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        .editor .close-button:hover {
            background-color: #c0392b;
        }
        .legend {
            margin-left: 30px;
            width: 20%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        .legend .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .legend .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 10px;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
    </style>
</head>
<body>

    <div class="banner">
        CALENDARIO
    </div>

    <div class="container">
        <div class="calendar">
            <div class="calendar-header">
                <button onclick="changeYear(-1)">«</button>
                <span id="year"></span>
                <button onclick="changeYear(1)">»</button>
            </div>
            <div class="calendar-header">
                <button onclick="changeMonth(-1)">‹</button>
                <span id="month"></span>
                <button onclick="changeMonth(1)">›</button>
            </div>
            <div class="calendar-days" id="days"></div>
        </div>

        <div class="editor" id="editor">
            <h3>Agregar/Editar Evento</h3>
            <select id="eventType">
                <option value="Entrega de Anteproyecto">Entrega de Anteproyecto</option>
                <option value="Entrega de Proyecto">Entrega de Proyecto</option>
                <option value="Presentación de Proyecto">Presentación de Proyecto</option>
                <option value="Entrega Nota de Proyecto">Entrega Nota de Proyecto</option>
                <option value="Asistencia para realización de TFG">Asistencia para realización de TFG</option>
            </select>
            <textarea id="eventDescription" placeholder="Descripción del evento..."></textarea>
            <button onclick="addEvent()">Agregar Evento</button>
            <div class="event-list" id="eventList"></div>
            <button class="close-button" onclick="closeEditor()">Cerrar Editor</button>
        </div>

        <div class="legend">
            <h3>Leyenda de Eventos</h3>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #FFEB3B;"></div>
                <span>Entrega de Anteproyecto</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #2196F3;"></div>
                <span>Entrega de Proyecto</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #4CAF50;"></div>
                <span>Presentación de Proyecto</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #FF9800;"></div>
                <span>Entrega Nota de Proyecto</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #9C27B0;"></div>
                <span>Asistencia para realización de TFG</span>
            </div>
        </div>
    </div>

    <div class="footer-banner">
        © 2025 Todos los derechos reservados
    </div>

    <div class="overlay" id="overlay"></div>

    <script>
        let events = {};
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let selectedDay = null;
        const eventColors = {
            "Entrega de Anteproyecto": "#FFEB3B",
            "Entrega de Proyecto": "#2196F3",
            "Presentación de Proyecto": "#4CAF50",
            "Entrega Nota de Proyecto": "#FF9800",
            "Asistencia para realización de TFG": "#9C27B0"
        };

        const renderCalendar = () => {
            const daysContainer = document.getElementById("days");
            const monthName = new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long' });
            const yearElement = document.getElementById("year");
            const monthElement = document.getElementById("month");
            yearElement.innerText = currentYear;
            monthElement.innerText = monthName;

            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth, daysInMonth(currentYear, currentMonth));

            daysContainer.innerHTML = "";

            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyCell = document.createElement("div");
                daysContainer.appendChild(emptyCell);
            }

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dayElement = document.createElement("div");
                dayElement.classList.add("calendar-day");
                dayElement.innerText = day;
                dayElement.setAttribute("data-date", `${currentYear}-${currentMonth + 1}-${day}`);
                
                // Add event previews
                if (events[`${currentYear}-${currentMonth + 1}-${day}`]) {
                    events[`${currentYear}-${currentMonth + 1}-${day}`].forEach(event => {
                        const eventPreview = document.createElement("div");
                        eventPreview.classList.add("event-preview");
                        eventPreview.style.backgroundColor = eventColors[event.type];
                        eventPreview.innerText = event.type.slice(0, 3);  // Show short version
                        dayElement.appendChild(eventPreview);
                        dayElement.classList.add("has-event");
                    });
                }

                dayElement.addEventListener("click", () => selectDay(dayElement));
                daysContainer.appendChild(dayElement);
            }
        };

        const daysInMonth = (year, month) => {
            return new Date(year, month + 1, 0).getDate();
        };

        const changeMonth = (delta) => {
            currentMonth += delta;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            } else if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        };

        const changeYear = (delta) => {
            currentYear += delta;
            renderCalendar();
        };

        const selectDay = (dayElement) => {
            const date = dayElement.getAttribute("data-date");
            selectedDay = date;
            document.getElementById("editor").style.display = "block";
            const eventsForDay = events[date] || [];
            document.getElementById("eventList").innerHTML = eventsForDay.map(event => `<p>${event.type} - ${event.description}</p>`).join("");
        };

        const addEvent = () => {
            const eventType = document.getElementById("eventType").value;
            const eventDescription = document.getElementById("eventDescription").value;
            if (selectedDay && eventDescription) {
                const event = { type: eventType, description: eventDescription };
                if (!events[selectedDay]) {
                    events[selectedDay] = [];
                }
                events[selectedDay].push(event);
                renderCalendar();
                closeEditor();
            }
        };

        const closeEditor = () => {
            document.getElementById("editor").style.display = "none";
            selectedDay = null;
        };

        renderCalendar();
    </script>

</body>
</html>
