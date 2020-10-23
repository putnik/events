<template>
	<b-jumbotron v-if="title">
		<h4>{{ title }}</h4>
		<p v-if="categories.length" style="margin-top: 1em">
			<b-badge variant="light" v-for="category in categories" :key="category">
				{{ category }}
			</b-badge>
		</p>
		<p v-if="location" style="margin-top: 1em">{{ location }}</p>
		<b-button-group>
			<b-button v-if="url" variant="primary" :href="url">Open</b-button>
			<b-button v-if="callUrl" variant="success" :href="callUrl">
				<b-icon icon="camera-video"></b-icon>
				Call
			</b-button>
		</b-button-group>
		<p v-if="description" style="white-space: pre-wrap; margin-top: 1em">{{ description }}</p>
		<p v-if="attendees.length" style="margin-top: 1em">{{ attendees.join(", ") }}</p>
	</b-jumbotron>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
	props: {
		title: { default: "" },
		url: { default: "" },
		callUrl: { default: "" },
		description: { default: "" },
		location: { default: "" },
		categories: { default: "".split("") },
		attendees: { default: "".split("") }
	}
});
</script>
