<?php

namespace PixelYourSite;

use PixelYourSite\Events;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @var CustomEvent $event
 */

?>

<div class="card card-static">
    <div class="card-header">
        Pinterest
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
				<?php Events\renderSwitcherInput( $event, 'pinterest_enabled' ); ?>
                <h4 class="switcher-label">Enable on Pinterest</h4>
            </div>
        </div>
        <div id="pinterest_panel">
            <div class="row mt-3">
                <div class="col col-offset-left form-inline">
                    <label>Event type:</label>
                    <?php Events\renderPinterestEventTypeInput( $event, 'pinterest_event_type' ); ?>
                    <div class="pinterest-custom-event-type form-inline">
                        <?php Events\renderTextInput( $event, 'pinterest_custom_event_type', 'Enter name' ); ?>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col col-offset-left">
                    <?php Events\renderSwitcherInput( $event, 'pinterest_params_enabled' ); ?>
                    <h4 class="indicator-label">Add Parameters</h4>
                </div>
            </div>
    
            <div id="pinterest_params_panel">
                <div class="row mt-3">
                    <div class="col col-offset-left">
                        
                        <!-- Custom Pinterest Params -->
                        <div class="row mt-3 pinterest-custom-param" data-param_id="0" style="display: none;">
                            <div class="col-1"></div>
                            <div class="col-4">
                                <input name="" placeholder="Enter name" class="form-control custom-param-name" type="text">
                            </div>
                            <div class="col-4">
                                <input name="" placeholder="Enter value" class="form-control custom-param-value"
                                       type="text">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-sm remove-row">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        
                        <?php foreach ( $event->getPinterestCustomParams() as $key => $custom_param ) : ?>
                            
                            <?php $param_id = $key + 1; ?>
    
                            <div class="row mt-3 pinterest-custom-param" data-param_id="<?php echo $param_id; ?>">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-4">
                                            <input type="text" placeholder="Enter name"
                                                   class="form-control custom-param-name"
                                                   name="pys[event][pinterest_custom_params][<?php echo $param_id; ?>][name]"
                                                   value="<?php esc_attr_e( $custom_param['name'] ); ?>">
                                        </div>
                                        <div class="col-4">
                                            <input type="text" placeholder="Enter value"
                                                   class="form-control custom-param-value"
                                                   name="pys[event][pinterest_custom_params][<?php echo $param_id; ?>][value]"
                                                   value="<?php esc_attr_e( $custom_param['value'] ); ?>">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-sm remove-row">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <?php endforeach; ?>
    
                        <div class="insert-marker"></div>
    
                        <div class="row mt-3">
                            <div class="col-5"></div>
                            <div class="col-4">
                                <button class="btn btn-sm btn-block btn-primary add-pinterest-parameter" type="button">Add
                                    Custom Parameter
                                </button>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>