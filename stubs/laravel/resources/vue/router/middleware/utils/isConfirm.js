const isConfirm = () => {

	var metaTag = document.querySelector('meta[name="conf"]');

	var content = metaTag.getAttribute('content');

	return (content.trim() !== '');

}

export default isConfirm;