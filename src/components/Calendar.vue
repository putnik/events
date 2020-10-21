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
				events: "events.json",
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
						title: String(info.event.title),
						url: String(info.event.url),
						desc: String(info.event.extendedProps.desc || ""),
						callUrl: String(info.event.extendedProps.callUrl || "")
					};
					this.$emit("event-click", eventData);
				}
			}
		};
	}
});
</script>
