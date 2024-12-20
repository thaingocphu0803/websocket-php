<button type="button" onclick="logout()">logout</button>

<script>
	const logout = async () => {
		try {
			const response = await fetch(`/${endpoint}/logout`, {
				method: 'post'
			});
			const data = await response.json();
			if (data && !data.isLogin) {
				Navigate('/login');
				return
			}
		} catch (err) {
			console.log(err)
		}
	}
</script>