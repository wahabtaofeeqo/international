<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
	export default {
		mounted() {
			$('.sidebar .collapse#membership').addClass('show')
			$('#membershipparent').removeClass('collapsed')
			$('#membershipparent').parent().addClass('active')
		}
	}
</script>
