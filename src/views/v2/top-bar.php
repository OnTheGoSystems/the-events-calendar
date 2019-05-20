<?php
/**
 * View: Top Bar
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/views/v2/top-bar.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version TBD
 *
 */
?>
<div class="tribe-events__top-bar">

	<?php $this->template( 'top-bar/nav' ); ?>

	<?php $this->template( 'top-bar/today' ); ?>

	<?php $this->template( 'top-bar/actions' ); ?>

</div>