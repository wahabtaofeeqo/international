<template>
	<router-view></router-view>
</template>

<script>
	export default {
		data() {
			return {
				organization_id: '',
			}
		},
		created() {
			this.organization_id = this.$route.params.id
		}
	}
</script>