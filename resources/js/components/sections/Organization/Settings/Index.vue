<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
	export default {
		mounted() {
			$('.sidebar .collapse#settings').addClass('show')
			$('#settingsparent').removeClass('collapsed')
			$('#settingsparent').parent().addClass('active')
		}
	}
</script>
