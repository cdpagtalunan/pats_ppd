import React from 'react';

function Basketball(props) {
	const title = props.title || "basketball";

	return (
		<svg height="64" width="64" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
	<title>{title}</title>
	<g fill="#000000">
		<path d="M57 14.2c-3.8-5.4-9.4-9.5-15.7-11.5-4.2-1.3-8.5-1.7-13.1-1.3-5.3.7-10 2.6-14.1 5.5-4.2 3.1-7.5 7-9.8 11.6-2 4.1-3 8.5-3.1 12.7-.1 6.7 1.9 13.2 5.8 18.7s9.4 9.5 15.7 11.5c3 .9 6.2 1.4 9.3 1.4 1.3 0 2.5-.1 3.8-.2 5.3-.7 10.1-2.6 14.1-5.5 4.3-3.1 7.5-7 9.8-11.6 2-4.1 3-8.5 3.1-12.7.1-6.7-1.9-13.1-5.8-18.6zm2.2 18.5c0 1.5-.2 3-.5 4.6-5.9.6-11.6 2.6-16.7 5.8l-7.6-10.6 20.7-14.7c2.8 4.5 4.3 9.6 4.1 14.9zm-6.1-17.8L32.5 29.6 24.9 19c4.7-3.7 8.5-8.5 11-14 1.4.2 2.9.5 4.3 1 5.1 1.6 9.6 4.7 12.9 8.9zm-24.5-10c1.1-.1 2.1-.2 3.2-.2h.5C30 9.1 26.8 13 23 16.1l-5.3-7.4c3.2-1.9 6.9-3.2 10.9-3.8zm-13.8 5.9l5.3 7.4c-4.2 2.7-9 4.5-13.9 5.1.3-1.1.8-2.2 1.3-3.3 1.7-3.6 4.2-6.6 7.3-9.2zm-10 20.5c0-1.4.2-2.8.4-4.3 6-.6 11.8-2.6 16.9-5.9l7.5 10.6L8.9 46.4c-2.8-4.5-4.3-9.7-4.1-15.1zm6.2 18l20.7-14.8 7.6 10.6c-4.7 3.7-8.5 8.4-11 13.8-1.5-.2-3-.5-4.5-1-5.1-1.5-9.5-4.5-12.8-8.6zM35.3 59c-1.1.1-2.2.2-3.4.2 2.3-4.3 5.4-8.2 9.3-11.2l5.1 7.2c-3.2 2-6.9 3.3-11 3.8zm13.9-5.9L44.1 46c4.1-2.6 8.8-4.4 13.6-5.1-.4 1-.8 2.1-1.2 3.1-1.7 3.5-4.2 6.6-7.3 9.1z"/>
	</g>
</svg>
	);
};

export default Basketball;