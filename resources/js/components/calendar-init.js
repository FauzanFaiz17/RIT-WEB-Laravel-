import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

export function calendarInit() {
    const calendarEl = document.getElementById("calendar");
    if (!calendarEl) return;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",

        selectable: true,
        editable: true,

        dateClick(info) {
            alert("Klik tanggal: " + info.dateStr);
        },

        select(info) {
            alert(
                "Range dipilih:\n" +
                info.startStr + " sampai " + info.endStr
            );
        },

        eventClick(info) {
            alert("Event diklik: " + info.event.title);
        },

        events: [
            {
                id: "1",
                title: "Test Event",
                start: new Date().toISOString().split("T")[0],
            },
        ],
    });

    calendar.render();
}
