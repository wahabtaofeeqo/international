<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Newsletters<br>
				<div class="h6 mt-1 text-gray-500">Create a newsletter for your followers. You can dispatch them later in the <b>manage</b> section</div>
			</h1>
		</div>

		<alert-success :form="form">Request was successful!</alert-success>

		<div class="card shadow mb-4" ref="formContainer">
			<form class="user" @submit.prevent="save" @keydown="form.onKeydown($event)">
				<div class="card-header py-3">
					<div class="form-group">
						<label class="text-primary" for="subject"></label>
						<input type="text" name="subject" class="form-control form-control-user" id="subject" :class="{ 'is-invalid': form.errors.has('subject') }" placeholder="Mail subject..." v-model.trim="form.subject" required>
						<has-error :form="form" field="subject"></has-error>
					</div>
				</div>
				<div class="card-body">
						<div class="form-group">
							<tinymce id="d1" v-model="form.content"></tinymce>
							<has-error :form="form" field="content"></has-error>
						</div>

						<div class="row">
							<div class="col-lg-4 mb-3">
								<button type="submit" class="btn btn-primary btn-user btn-block">Save Now!</button>
							</div>
							<div class="col-lg-4 mb-3">
								<button type="button" class="btn btn-success btn-user btn-block" @click="saveAndTest">Save and Test</button>
							</div>
							<div class="col-lg-4">
								<button type="button" class="btn btn-warning btn-user btn-block" @click="test">Just Test</button>
							</div>
						</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: new Form({
					subject: '',
					content: `<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="left" valign="top" width="600">
<table width="600" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="40">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="#2b313d">
<tbody>
<tr>
<td align="left" valign="top" width="600">
<table style="height: 40px;" width="600" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr style="height: 40px;">
<td style="height: 40px; width: 600px;" height="40">&nbsp;</td>
</tr>
</tbody>
</table>
<table width="600" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<div>
<h2 style="text-align: center;"><strong><span style="color: #ffffff;">COMPANY MONTH NEWSLETTER</span></strong></h2>
<p>&nbsp;</p>
</div>
<div>&nbsp;</div>
</td>
</tr>
</tbody>
</table>
<table width="600" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="54">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="#2b313d">
<tbody>
<tr>
<td align="left" valign="top" width="300">
<table style="height: 446px;" width="272" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="width: 272px;">
<div>
<p><span style="color: #ffffff;">Lorem ipsum</span></p>
<p><span style="color: #ffffff;">&nbsp;Suspendisse ac ipsum id ligula commodo venenatis id ac nunc.&nbsp;Duis mollis laoreet rutrum. Morbi eget tristique ipsum.</span></p>
<p>&nbsp;</p>
<p><span style="color: #ffffff;">Lorem ipsum</span></p>
<p><span style="color: #ffffff;">&nbsp;Suspendisse ac ipsum id ligula commodo venenatis id ac nunc.&nbsp;Duis mollis laoreet rutrum. Morbi eget tristique ipsum.</span></p>
<p>&nbsp;</p>
<p><span style="color: #ffffff;">Lorem ipsum</span></p>
<p><span style="color: #ffffff;">&nbsp;Suspendisse ac ipsum id ligula commodo venenatis id ac nunc.&nbsp;Duis mollis laoreet rutrum. Morbi eget tristique ipsum.</span></p>
<p>&nbsp;</p>
</div>
<div>&nbsp;</div>
</td>
</tr>
</tbody>
</table>
</td>
<td align="left" valign="top" width="300">
<table width="300" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center"><img class="CToWUd a6T" tabindex="0" src="https://ci6.googleusercontent.com/proxy/U8QtkyYT3M7LewLoLIVbrqmjDQUBjDEFgb9oAjlSDTl7jZE4L-RDzM17tzhWgvo-rXnZAc7_1gBaK9lPyKxrpJGpS9qTwLYsGJqjjxRZOfK21Xtw18TVBXoVumJ8NwtSCZlu5JvR2U-9aY34CD0=s0-d-e1-ft#https://moosendimages.imgix.net/yannis_161223141622272.png?dpr=1&amp;fit=clip&amp;ixjsv=2.2.4&amp;w=600" alt="Email Image" width="300" height="auto" align="bottom" /></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="#e9e8de">
<tbody>
<tr>
<td align="left" valign="top" width="200">
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center"><img class="CToWUd a6T" tabindex="0" src="https://ci3.googleusercontent.com/proxy/-cu8qZAZOPlqd4krTtEOPjGC4GrLbAf6MN9_o87ILBtU8V3PgjP_neZGa6ASmmFJYl3zhKZmUmac1TGs6zovKEnfMH0sV6olGCfJhfMDqIVFZvosCvhvtWXQYYSwKxcVCtbs1IfZ1UkCPxYITTg=s0-d-e1-ft#https://moosendimages.imgix.net/yannis_161223144641936.png?dpr=1&amp;fit=clip&amp;ixjsv=2.2.4&amp;w=400" alt="Email Image" width="200" height="auto" align="bottom" /></td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center"><img class="CToWUd" src="https://ci3.googleusercontent.com/proxy/2pVrAwuTxewhdiBiuBtlxx8CnBuF_rDM3F-3DxBEjb2k8E9iZHAqmP7j8XQFjagAbUISwEvJ6zOQSt3Ga6WpRRNWcjHopmBEMayjrlAtMAyTw3giLEFUCc67a_IxYoWFHtZjDLkfjool74LNcQ=s0-d-e1-ft#https://moosendimages.imgix.net/yannis_161223144349468.png?dpr=1&amp;fit=clip&amp;ixjsv=2.2.4&amp;w=94" alt="Email Image" width="47" height="auto" align="bottom" /></td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="20">&nbsp;</td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<div>
<p>Suspendisse ac ipsum id ligula commodo venenatis id ac nunc.&nbsp;Duis mollis laoreet rutrum. Morbi eget tristique ipsum.</p>
<p>&nbsp;</p>
</div>
<div>&nbsp;</div>
</td>
</tr>
</tbody>
</table>
<table border="0" width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="12" align="center">
<tbody>
<tr>
<td align="center" width="100%"><a>READ MORE</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="20">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
<td align="left" valign="top" width="200">
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center"><img class="CToWUd a6T" tabindex="0" src="https://ci6.googleusercontent.com/proxy/kc9Q_1qcQtSox-Ogu4B273Fm9954E46B8_NW_tGNxFS2DuflbBLOlZHY-Cp0TlBu3upr9W2w8V9B2UmU-MDSxqzxM4iRx4WeL1q0rrEttvtgQ4HbSFRzBKfaKXZcOXDkuK2xRBFbfrQWNRCsBAk=s0-d-e1-ft#https://moosendimages.imgix.net/yannis_161223144646046.png?dpr=1&amp;fit=clip&amp;ixjsv=2.2.4&amp;w=400" alt="Email Image" width="200" height="auto" align="bottom" /></td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center"><img class="CToWUd" src="https://ci6.googleusercontent.com/proxy/geZ0rsvDcLc43G4wpKNJSUvU2rvHxdGb2Ufu34ogO9doIK6-Vx8y7mLjInluOjpgwZagvHWnrugwANZ_e3HzDFzu8ev9nEAJvjvG9RUzmR9Pstq3lNzErjt1-utuyPhzNH2kAjBK5l3-XWhaiQ=s0-d-e1-ft#https://moosendimages.imgix.net/yannis_161223144337109.png?dpr=1&amp;fit=clip&amp;ixjsv=2.2.4&amp;w=94" alt="Email Image" width="47" height="auto" align="bottom" /></td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="20">&nbsp;</td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<div>
<p>&nbsp;Suspendisse ac ipsum id ligula commodo venenatis id ac nunc.&nbsp;Duis mollis laoreet rutrum. Morbi eget tristique ipsum.</p>
<p>&nbsp;</p>
</div>
<div>&nbsp;</div>
</td>
</tr>
</tbody>
</table>
<table border="0" width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="12" align="center">
<tbody>
<tr>
<td align="center" width="100%"><a>READ MORE</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="20">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
<td align="left" valign="top" width="200">
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center"><img class="CToWUd a6T" tabindex="0" src="https://ci5.googleusercontent.com/proxy/MEe6GTw9lvhhx6I9m4D3Wpvdv-oDRRv4lj0j83sdDquFsdf6ISRPXZsUx_17aGP2VZE-4G0Dq3iNq4k8OgHnJsPjZ8PKNjZqLXviR2ANSvzR9tFIebfEjo12W-CAhfqxPWZG-TKto9q0F5JfxmI=s0-d-e1-ft#https://moosendimages.imgix.net/yannis_161223144649858.png?dpr=1&amp;fit=clip&amp;ixjsv=2.2.4&amp;w=400" alt="Email Image" width="200" height="auto" align="bottom" /></td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center"><img class="CToWUd" src="https://ci6.googleusercontent.com/proxy/plK01_fnJYV7vAs612AqZDkqe0v7bxY9ueGGOYcrzV9eLtde4zR00dD1QQExwkuEBQYKmsfyIX_J5YNCAgyBb_QkJohVBRR-qiAHEV5zvGGAX3D7H3IWJnQvAMZbG5JD7j7ZUwYPux21wZTM9A=s0-d-e1-ft#https://moosendimages.imgix.net/yannis_161223144322703.png?dpr=1&amp;fit=clip&amp;ixjsv=2.2.4&amp;w=94" alt="Email Image" width="47" height="auto" align="bottom" /></td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="20">&nbsp;</td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<div>
<p>&nbsp;Suspendisse ac ipsum id ligula commodo venenatis id ac nunc.&nbsp;Duis mollis laoreet rutrum. Morbi eget tristique ipsum.</p>
<p>&nbsp;</p>
</div>
<div>&nbsp;</div>
</td>
</tr>
</tbody>
</table>
<table border="0" width="200" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="12" align="center">
<tbody>
<tr>
<td align="center" width="100%"><a>READ MORE</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="200" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="20">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="#e9e8de">
<tbody>
<tr>
<td align="left" valign="top" width="600">
<table width="600" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="40">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="#333c4c">
<tbody>
<tr>
<td align="left" valign="top" width="600">
<table width="600" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="left"><img class="CToWUd a6T" tabindex="0" src="https://ci3.googleusercontent.com/proxy/Jofpjax_XMY0DFy3sBMAAioPQr2S5KlhlEp4AlUkndlL9U59off2zGb-BUDB72o8GB_WDSw3bquDI-C0n4HAsK3LYWpMkJ66nxNOV2W93-ZFi0ij1RGgFR-Oho8dUM-KRoGMKZfq_ROJuaWnrMQ=s0-d-e1-ft#https://moosendimages.imgix.net/yannis_161223145657059.png?dpr=1&amp;fit=clip&amp;ixjsv=2.2.4&amp;w=600" alt="Email Image" width="600" height="auto" align="bottom" /></td>
</tr>
</tbody>
</table>
<table width="600" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="20">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="#333c4c">
<tbody>
<tr>
<td align="left" valign="top" width="300">
<table width="300" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<div>
<p><span style="color: #ffffff;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.&nbsp;</span></p>
<p>&nbsp;</p>
</div>
<div>&nbsp;</div>
</td>
</tr>
</tbody>
</table>
</td>
<td align="left" valign="top" width="300">
<table width="300" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="10">&nbsp;</td>
</tr>
</tbody>
</table>
<table border="0" width="300" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="right">
<table border="0" cellspacing="0" cellpadding="19" align="right">
<tbody>
<tr>
<td align="center" width="100%"><span style="color: #ffffff;"><a style="color: #ffffff;">READ MORE</a></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="300" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="35">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="#2b313d">
<tbody>
<tr>
<td align="left" valign="middle" width="300">
<table width="300" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<div>
<p><span style="color: #ffffff;">Can't get enough?</span></p>
<p>&nbsp;</p>
</div>
<div>&nbsp;</div>
</td>
</tr>
</tbody>
</table>
</td>
<td align="left" valign="middle" width="300">
<table width="300" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="40">&nbsp;</td>
</tr>
</tbody>
</table>
<table width="300" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td>&nbsp;</td>
<td width="5" height="10">&nbsp;</td>
<td><a><img class="CToWUd" src="https://ci4.googleusercontent.com/proxy/9LpuCGkuGONZYFQYTTBRU1nPo4CjVS9pDJDiWlLAOHDdH2sYzEYjZyqYpil2UzNgZEyLlPOq7rVYBI3GK1XYvN-XqphfyBNUP2D1EKYRW7samRGoSFBrQkjVwq7Z0OT2g_0CZdorXPTbrKji6UXqUw9A8IJACisj-TMZzS3w=s0-d-e1-ft#https://cdn-editor.moosend.com/assets/images/social_icons/social_follow/black-half-roundsquare/facebook.png" alt="social icon" border="0" /></a></td>
<td width="5" height="10">&nbsp;</td>
<td width="5" height="10">&nbsp;</td>
<td><a><img class="CToWUd" src="https://ci6.googleusercontent.com/proxy/kxiDqIpF00tIras4MzpkdKUoOMgexRmqaIDj6VLpV5DEh4ZRK_v0EwRghbOudBdAtOoGDtVRdLhKnlVdJBjWqlKpkHsBYX8HtzEIfDloFhVtSAZGeVJH5Ik9LEJqhE1fjBX8qGc6LeBo9XemuSixQGyNZKLgPwAGT_bks3k=s0-d-e1-ft#https://cdn-editor.moosend.com/assets/images/social_icons/social_follow/black-half-roundsquare/twitter.png" alt="social icon" border="0" /></a></td>
<td width="5" height="10">&nbsp;</td>
<td width="5" height="10">&nbsp;</td>
<td><a><img class="CToWUd" src="https://ci3.googleusercontent.com/proxy/fch4ui1Ypjau6CRLbIl3_7eKWzlKegrtNH39-kk5rkFks1t2JJgrQVStH7VZwEjxnOKTdCiiC0cUXeoJTJguqInvX5WFqjzdt7MIeIGQHCZJ_fi98e5SYvzWnwOBOrD95bREsSpCCgPLNkD8U3ArQZu2exLSsnDoGyyYxtM=s0-d-e1-ft#https://cdn-editor.moosend.com/assets/images/social_icons/social_follow/black-half-roundsquare/youtube.png" alt="social icon" border="0" /></a></td>
<td width="5" height="10">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="300" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="40">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" bgcolor="transparent">
<tbody>
<tr>
<td align="left" valign="top" width="600">
<table width="600" cellspacing="0" cellpadding="0" align="top">
<tbody>
<tr>
<td height="33">&nbsp;</td>
</tr>
</tbody>
</table>
<table width="600" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<div>
<p><a>This is the way out but please don't go.</a></p>
<p>&nbsp;</p>
</div>
<div>&nbsp;</div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>`
				}),
			}
		},
		methods: {
			save() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.post('/api/newsletter')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Newsletter saved!'
					})

					this.form.reset()
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			},
			saveAndTest() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.post('/api/newsletter/save_test_newsletter')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Newsletter saved! And you can check your email for a sample.'
					})

					this.form.reset()
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			},
			test() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.post('/api/newsletter/test_newsletter')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Please check your email'
					})
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			}
		},
		created() {
			document.title = 'Create Newsletter | ILA'
		},
		mounted() {

		}
	}
</script>

<style type="text/css">
	.mce-tinymce .mce-edit-area iframe {
		min-height: 300px;
	}
</style>
