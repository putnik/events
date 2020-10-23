<template>
	<b-navbar toggleable="md">
		<b-navbar-brand href="#">
			Wikimedia Events Calendar
			<b-badge variant="light">beta</b-badge>
		</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav class="ml-auto">
				<b-nav-item-dropdown text="Lang" right>
					<b-dropdown-item href="#">EN</b-dropdown-item>
					<b-dropdown-item href="#">ES</b-dropdown-item>
					<b-dropdown-item href="#">RU</b-dropdown-item>
					<b-dropdown-item href="#">FA</b-dropdown-item>
				</b-nav-item-dropdown>

				<b-nav-item-dropdown text="Timezone" right>
					<b-dropdown-item href="#">UTC</b-dropdown-item>
					<b-dropdown-item href="#">Local</b-dropdown-item>
				</b-nav-item-dropdown>
			</b-navbar-nav>
		</b-collapse>
	</b-navbar>
</template>
