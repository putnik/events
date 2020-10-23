<template>
	<b-modal size="lg" v-bind:id="id" v-bind:title="name">
		<div v-if="categories.length" style="float: right">
			<b-badge
				v-for="category in categories"
				v-bind:key="category[0]"
				variant="light"
				style="margin-left: 1em"
			>
				{{ category[0] }}
			</b-badge>
		</div>
		<p>
			<b-icon icon="calendar3"></b-icon>
			{{ start.toLocaleString() }}
			<span v-if="end && end !== start">— {{ end.toLocaleString() }}</span>
		</p>
		<p v-if="location" style="margin-top: 1em">
			<b-icon icon="geo-alt"></b-icon>
			{{ location }}
		</p>
		<p v-if="description" style="white-space: pre-wrap; margin-top: 1em">{{ description }}</p>
		<p v-if="attendees.length" style="margin-top: 1em">
			{{ attendees.join(", ") }}
		</p>

		<template #modal-footer="{ open, cancel }">
			<b-button size="sm" variant="outline-primary" v-bind:href="url">
				Event page
			</b-button>
			<b-button size="sm" variant="outline-secondary" @click="cancel()">
				Close
			</b-button>
		</template>
	</b-modal>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
	props: {
		id: { required: true },
		name: { required: true },
		start: { required: true },
		end: { required: true },
		url: { default: "" },
		callUrl: { default: "" },
		description: { default: "" },
		location: { default: "" },
		categories: { default: "".split("") },
		attendees: { default: "".split("") }
	}
});
</script>
