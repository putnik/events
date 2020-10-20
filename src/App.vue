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
import components from "@wikimedia/wvui";
import "@wikimedia/wvui/dist/wvui.css";
import "@fortawesome/fontawesome-free/css/all.css";
import Calendar from "./components/Calendar.vue";
import EventInfo from "./components/EventInfo.vue";
import Navbar from "./components/Navbar.vue";
import Sidebar from "./components/Sidebar.vue";

export default {
	name: "App",
	components: {
		Calendar,
		EventInfo,
		Navbar,
		Sidebar,
		...components
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
		eventClick: function(info: any) {
			console.log("You clicked the button!", info);
			this.event = {
				title: info.event.title || "",
				url: info.event.url || "",
				callUrl: info.event.extendedProps.callUrl || "",
				desc: info.event.extendedProps.desc || ""
			};
		}
	}
};
</script>
