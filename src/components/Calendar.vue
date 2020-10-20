<template>
	<FullCalendar :options="calendarOptions" />
</template>

<script lang="ts">
import FullCalendar from "@fullcalendar/vue";
import bootstrapPlugin from "@fullcalendar/bootstrap";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";

export default {
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
					console.log(info);
					this.$emit("event-click", info);
				}
			}
		};
	}
};
</script>
