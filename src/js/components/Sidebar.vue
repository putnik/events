<template>
	<b-nav vertical>
		<b-nav-text v-if="availableLanguages.length">Languages</b-nav-text>
		<b-nav v-if="availableLanguages.length" vertical>
			<b-nav-item active>Russian</b-nav-item>
			<b-nav-item>English</b-nav-item>
		</b-nav>
	</b-nav>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
	props: {
		availableLanguages: { default: [] },
		selectedLanguages: { default: [] }
	}
});
</script>
