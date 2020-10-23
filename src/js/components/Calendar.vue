<template>
	<FullCalendar :options="calendarOptions" />
</template>

<script lang="ts">
import Vue from "vue";
import FullCalendar from "@fullcalendar/vue";
import bootstrapPlugin from "@fullcalendar/bootstrap";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";
import { EventData } from "@/types";

export default Vue.extend({
	components: {
		FullCalendar
	},
	data() {
		return {
			calendarOptions: {
				locale: "ru",
				events: "/api/events",
				themeSystem: "bootstrap",
				plugins: [
					bootstrapPlugin,
					dayGridPlugin,
					interactionPlugin,
					listPlugin,
					timeGridPlugin
				],
				initialView: "listMonth",
				initialDate: "2020-10-21",
				navLinks: true,
				headerToolbar: {
					left: "prev next today",
					center: "title",
					right: "listMonth dayGridMonth timeGridWeek"
				},
				eventTimeFormat: {
					hour: "numeric",
					hour12: false,
					minute: "2-digit",
					timeZoneName: "short"
				},
				eventClick: (info: any) => {
					info.jsEvent.preventDefault();
					const eventData: EventData = {
						name: String(info.event.title),
						url: String(info.event.url),
						description: String(info.event.extendedProps.description || ""),
						location: String(info.event.extendedProps.location || ""),
						categories: Array(info.event.extendedProps.categories || []),
						attendees: Array(info.event.extendedProps.attendees || []),
						callUrl: String(info.event.extendedProps.call_url || "")
					};
					this.$emit("event-click", eventData);
				}
			}
		};
	}
});
</script>
