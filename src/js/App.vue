<template>
	<div>
		<Navbar />
		<b-container fluid>
			<b-row>
				<b-col cols="0">
					<Sidebar />
				</b-col>
				<b-col cols="7">
					<Calendar v-on:event-click="eventClick" />
				</b-col>
				<b-col cols="5">
					<EventInfo
						:name="event.name"
						:url="event.url"
						:callUrl="event.callUrl"
						:description="event.description"
						:location="event.location"
						:categories="event.categories"
						:attendees="event.attendees"
					/>
				</b-col>
			</b-row>
		</b-container>
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

const App = Vue.extend({
	name: "App",
	components: {
		Calendar,
		EventInfo,
		Navbar,
		Sidebar
	},
	data: () => ({
		event: {
			name: "",
			url: "",
			callUrl: "",
			description: "",
			location: "",
			categories: "".split(""),
			attendees: "".split("")
		}
	}),
	methods: {
		eventClick: function(eventData: EventData) {
			this.event = eventData;
		}
	}
});

export default App;
</script>
