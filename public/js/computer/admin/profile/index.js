var PROFILE = {
	updateAvatar: function(attchid) {
		API.post(ADMIN_URI+'profile/updateAvatar', {attchid: attchid}, function(res) {
			console.log(res)
		})
	}
};