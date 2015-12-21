<script src="jquery.js"></script>
<script type="text/javascript" src="background.cycle.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$("header").backgroundCycle({
				imageUrls: [
					'images/beachcycling.jpg',
					'images/couples.jpg'
				],
				fadeSpeed: 2500,
				duration: 5500,
				backgroundSize: SCALING_MODE_COVER
			});
		});
</script>