<template>
	<div style="height:100vh">
		<Navbar />
		<b-container fluid style="height:85vh">
			<Calendar v-on:event-click="eventClick" />
		</b-container>
		<EventInfo
			id="modal-event-info"
			v-bind:name="event.name"
			v-bind:start="event.start"
			v-bind:end="event.end"
			v-bind:url="event.url"
			v-bind:callUrl="event.callUrl"
			v-bind:description="event.description"
			v-bind:location="event.location"
			v-bind:categories="event.categories"
			v-bind:attendees="event.attendees"
		/>
	</div>
</template>

<script lang="ts">
import Vue from "vue";
import "@fortawesome/fontawesome-free/css/all.css";
import Calendar from "./components/Calendar.vue";
import EventInfo from "./components/EventInfo.vue";
import Navbar from "./components/Navbar.vue";
import Sidebar from "./components/Sidebar.vue";
import { EventData } from "@/types";

Vue.component("Calendar", Calendar);
Vue.component("EventInfo", EventInfo);
Vue.component("Navbar", Navbar);
Vue.component("Sidebar", Sidebar);

const App = Vue.extend({
	name: "App",
	data: () => ({
		event: {
			name: "",
			start: new Date(),
			end: new Date(),
			url: "",
			callUrl: "",
			description: "",
			location: "",
			categories: [] as string[],
			attendees: [] as string[]
		}
	}),
	methods: {
		eventClick: function(eventData: EventData) {
			console.log("eventData", eventData);
			this.event = eventData;
			console.log("this.event", this.event);
			this.$bvModal.show("modal-event-info");
		}
	}
});

export default App;
</script>
