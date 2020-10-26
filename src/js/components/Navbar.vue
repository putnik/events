<template>
	<b-navbar toggleable="md">
		<b-navbar-brand href="/">
			Wikimedia Events Calendar
			<b-badge variant="light">beta</b-badge>
		</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav class="ml-auto">
				<b-nav-item-dropdown text="Subscribe" right>
					<b-dropdown-item
						id="calendar-google"
						href="/export/google.ics"
						data-external-url="https://calendar.google.com/calendar/u/0/r/settings/addbyurl"
						@click="copyToClipboard"
					>
						Google
						<b-icon icon="clipboard" style="float:right"></b-icon>
					</b-dropdown-item>
					<b-tooltip target="calendar-google" triggers="hover" placement="left">
						Click to copy calendar link into clipboard and open Google Calendar in new
						tab
					</b-tooltip>
					<b-dropdown-item
						id="calendar-other"
						href="/export/other.ics"
						title="Click to copy calendar link into clipboard"
						@click="copyToClipboard"
					>
						Other
						<b-icon icon="clipboard" style="float:right"></b-icon>
					</b-dropdown-item>
					<b-tooltip target="calendar-other" triggers="hover" placement="left">
						Click to copy calendar link into clipboard
					</b-tooltip>
				</b-nav-item-dropdown>

				<b-nav-item-dropdown text="Lang" right style="display:none">
					<b-dropdown-item href="#">EN</b-dropdown-item>
					<b-dropdown-item href="#">ES</b-dropdown-item>
					<b-dropdown-item href="#">RU</b-dropdown-item>
					<b-dropdown-item href="#">FA</b-dropdown-item>
				</b-nav-item-dropdown>

				<b-nav-item-dropdown text="Timezone" right style="display:none">
					<b-dropdown-item href="#">UTC</b-dropdown-item>
					<b-dropdown-item href="#">Local</b-dropdown-item>
				</b-nav-item-dropdown>
			</b-navbar-nav>
		</b-collapse>
	</b-navbar>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
	methods: {
		copyToClipboard: (event: MouseEvent) => {
			event.preventDefault();
			const target = event.target as HTMLAnchorElement;
			navigator.clipboard.writeText(target.href).then(function() {
				const externalUrl = target.getAttribute("data-external-url") || "";
				if (externalUrl) {
					window.open(externalUrl, "_blank");
				}
			});
		}
	}
});
</script>
