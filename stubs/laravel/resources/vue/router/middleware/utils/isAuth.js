const isAuth = () => {

	var metaTag = document.querySelector('meta[name="usr"]');

	if (!metaTag) {
		return false;
	}

	var content = metaTag.getAttribute('content');

	return (content.trim() !== '');

}

export default isAuth;