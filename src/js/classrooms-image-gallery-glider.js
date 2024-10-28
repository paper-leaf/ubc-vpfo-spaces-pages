import Glider from 'glider-js';

window.addEventListener(
	'load',
	function () {
		const glider = new Glider(
			document.querySelector( '.classroom-image-gallery .glider' ),
			{
				slidesToShow: 1,
				slidesToScroll: 1,
				draggable: false,
				dots: false, // Disable default dots
				arrows: {
					prev: document.querySelector( '.glider-prev' ),
					next: document.querySelector( '.glider-next' )
				}
			}
		);

		const thumbnails = document.querySelectorAll( '.classroom-image-gallery .glider-thumbnails .glider-thumbnail img' );

		// Function to update the active class on thumbnails
		function updateActiveThumbnail(index) {
			thumbnails.forEach(
				(thumb, i) => {
					thumb.parentElement.classList.toggle( 'active', i === index ); // Add 'active' class to the current thumbnail
				}
			);
		}

		// Set initial active thumbnail
		updateActiveThumbnail( 0 );

		// Update active thumbnail on slide change
		thumbnails.forEach(
			( thumb, index ) => {
				thumb.addEventListener(
					'click',
					() => {
						glider.scrollItem( index ); // Scroll to the slide on thumbnail click
						updateActiveThumbnail( index ); // Update active class on click
					}
				);
			}
		);

		// Listen for slide changes
		glider.ele.addEventListener(
			'glider-slide-visible',
			function (event) {
				updateActiveThumbnail( event.detail.slide ); // Update active class when the slide changes
			}
		);
	}
);
