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
						:title="event.title"
						:url="event.url"
						:callUrl="event.callUrl"
						:desc="event.desc"
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
			title: "",
			url: "",
			callUrl: "",
			desc: ""
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
