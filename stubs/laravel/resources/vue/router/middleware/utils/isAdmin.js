const isAdmin = () => {
	var metaTag = document.querySelector('meta[name="adm"]');
	if (!metaTag) {
		return false;
	}
	var content = metaTag.getAttribute('content');
	return (content.trim() !== '');
}

export default isAdmin;