const isConfirm = () => {

	var metaTag = document.querySelector('meta[name="conf"]');

	if (!metaTag) {
		return false;
	}

	var content = metaTag.getAttribute('content');

	return (content.trim() !== '');

}

export default isConfirm;