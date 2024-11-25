const logout = async () => {
	const response = await fetch(`/${endpoint}/logout`, {
		method: 'post'
	});
	const data = await response.json();
	if(data && !data.isLogin){
		Navigate('/login');
		return
	}
}