const isAuth = () => {

	var metaTag = document.querySelector('meta[name="usr"]');

	var content = metaTag.getAttribute('content');

	return (content.trim() !== '');

}

export default isAuth;