<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<h2 class="section-title">Pinterest Settings</h2>

<!-- General -->
<div class="card card-static">
    <div class="card-header">
        General
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col">
                <?php Pinterest()->render_switcher_input( 'enabled' ); ?>
                <h4 class="switcher-label">Enable Pinterest Pixel</h4>
            </div>
        </div>
        <div class="row">
            <div class="col">
				<?php Pinterest()->render_switcher_input( 'enhanced_matching_enabled' ); ?>
                <h4 class="switcher-label">Enable Enhanced Matching</h4>
            </div>
        </div>
    </div>
</div>

<hr>
<div class="row justify-content-center">
    <div class="col-4">
        <button class="btn btn-block btn-sm btn-save">Save Settings</button>
    </div>
</div>