<template>
	<b-jumbotron v-if="title">
		<h4>{{ title }}</h4>
		<b-button-group>
			<b-button v-if="url" variant="primary" :href="url">Open</b-button>
			<b-button v-if="callUrl" variant="success" :href="callUrl">
				<b-icon icon="camera-video"></b-icon>
				Call
			</b-button>
		</b-button-group>
		<p v-if="desc" style="white-space: pre-wrap; margin-top: 1em">{{ desc }}</p>
	</b-jumbotron>
</template>

<script lang="ts">
export default {
	props: {
		title: { default: "" },
		url: { default: "" },
		callUrl: { default: "" },
		desc: { default: "" }
	}
};
</script>
