<?php

/**
 * @link: https://developers.pinterest.com/docs/ad-tools/conversion-tag/
 */

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Pinterest extends Settings implements Pixel, Plugin {

	private static $_instance;
	
	private $configured;
    
    private $core_compatible;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public function __construct() {
        
        // cache status
        if ( Pinterest\isPysProActive()) {
            $this->core_compatible = Pinterest\pysProVersionIsCompatible();
        } else {
            $this->core_compatible = Pinterest\pysFreeVersionIsCompatible();
        }
        
		parent::__construct( 'pinterest' );
		
		$this->locateOptions(
			PYS_PINTEREST_PATH . '/modules/pinterest/options_fields.json',
			PYS_PINTEREST_PATH . '/modules/pinterest/options_defaults.json'
		);
		
		// migrate after event post type registered
		add_action( 'pys_register_pixels', 'PixelYourSite\Pinterest\maybeMigrate' );
		
		add_action( 'pys_register_plugins', function( $core ) {
			/** @var PYS $core */
			$core->registerPlugin( $this );
		} );
        
        if ( ! $this->core_compatible ) {
            return;
        }
        
		add_action( 'pys_register_pixels', function( $core ) {
			/** @var PYS $core */
			$core->registerPixel( $this );
		} );
		
		if ( $this->configured() ) {
			
			// output debug info
			add_action( 'wp_head', function() {
				echo "<script type='text/javascript'>console.log('PixelYourSite Pinterest version " . PYS_PINTEREST_VERSION . "');</script>\r\n";
			}, 2 );

			// load addon's public JS
			add_action( 'wp_enqueue_scripts', function() {
				wp_enqueue_script( 'pys-pinterest', PYS_PINTEREST_URL . '/dist/scripts/public.js', array( 'pys' ),
					PYS_PINTEREST_VERSION );
			} );

		}
        
        add_action( 'pys_admin_pixel_ids', 'PixelYourSite\Pinterest\renderPixelIdField' );
        add_filter( 'pys_admin_secondary_nav_tabs', 'PixelYourSite\Pinterest\adminSecondaryNavTabs' );
        add_action( 'pys_admin_pinterest_settings', 'PixelYourSite\Pinterest\renderSettingsPage' );
		
	}
    
    /**
     * Returns cached core compatibility status.
     *
     * @return bool
     */
    public function getCoreCompatible() {
        return $this->core_compatible;
    }
	
	public function enabled() {
		return $this->getOption( 'enabled' );
	}
	
	public function configured() {
		
		if ( $this->configured === null ) {
			
			$license_status = $this->getOption( 'license_status' );
			$pixel_id = $this->getOption( 'pixel_id' );
			
			$this->configured = $this->enabled()
			                    && ! empty( $license_status ) // license was activated before
			                    && ! empty( $pixel_id )
			                    && ! apply_filters( 'pys_pixel_disabled', false, $this->getSlug() );
			
		}
		
		return $this->configured;
		
	}
	
	public function getPixelIDs() {
		
		$ids = (array) $this->getOption( 'pixel_id' );
		
		if ( isSuperPackActive() && SuperPack()->getOption( 'enabled' ) && SuperPack()->getOption( 'additional_ids_enabled' ) ) {
			return $ids;
		} else {
			return (array) reset( $ids ); // return first id only
		}
		
	}
	
	public function getPixelOptions() {
		
		return array(
			'pixelIds'            => $this->getPixelIDs(),
			'advancedMatching'    => $this->getOption( 'enhanced_matching_enabled' ) ? Pinterest\getEnhancedMatchingParams() : array(),
			'contentParams'       => Pinterest\getTheContentParams(),
			'clickEventEnabled'   => $this->getOption( 'click_event_enabled' ),
			'watchVideoEnabled'   => $this->getOption( 'watchvideo_event_enabled' ),
			'adSenseEventEnabled' => $this->getOption( 'adsense_enabled' ),
			'commentEventEnabled' => $this->getOption( 'comment_event_enabled' ),
			'formEventEnabled'    => $this->getOption( 'form_event_enabled' ),
			'downloadEnabled'     => $this->getOption( 'download_event_enabled' ),
		);
		
	}
	
	public function getPluginName() {
		return 'PixelYourSite Pinterest Add-On';
	}
	
	public function getPluginFile() {
		return PYS_PINTEREST_PLUGIN_FILE;
	}
	
	public function getPluginVersion() {
		return PYS_PINTEREST_VERSION;
	}

	public function adminUpdateLicense() {

		if ( PYS()->adminSecurityCheck() ) {
			updateLicense( $this );
		}
		
	}
    
    public function adminRenderPluginOptions() {
        // for backward compatibility with PRO < 7.0.6
    }
    
    public function updatePlugin() {
        // for backward compatibility with PRO < 7.0.6
    }
	
	/**
	 * @param CustomEvent $event
	 */
	public function renderCustomEventOptions( $event ) {
		
		/** @noinspection PhpIncludeInspection */
		include PYS_PINTEREST_PATH . '/modules/pinterest/views/html-main-events-edit.php';
		
	}

	public function getEventData( $eventType, $args = null ) {
		
		if ( ! $this->configured() ) {
			return false;
		}
		
		switch ( $eventType ) {
			case 'init_event':
				return false;

			case 'general_event':
				return $this->getGeneralEventParams();

			case 'search_event':
				return $this->getSearchEventParams();

			case 'custom_event':
				return $this->getCustomEventParams( $args );

			case 'woo_view_content':
				return $this->getWooPageVisitEventParams();

			case 'woo_add_to_cart_on_button_click':
				return $this->getWooAddToCartOnButtonClickEventParams( $args );

			case 'woo_add_to_cart_on_cart_page':
			case 'woo_add_to_cart_on_checkout_page':
				return $this->getWooAddToCartOnCartEventParams();

			case 'woo_remove_from_cart':
				return $this->getWooRemoveFromCartParams( $args );

			case 'woo_view_category':
				return $this->getWooViewCategoryEventParams();

			case 'woo_initiate_checkout':
				return $this->getWooInitiateCheckoutEventParams();

			case 'woo_purchase':
				return $this->getWooCheckoutEventParams();

			case 'woo_affiliate_enabled':
				return $this->getWooAffiliateEventParams( $args );

			case 'woo_paypal':
				return $this->getWooPayPalEventParams();

			case 'woo_frequent_shopper':
			case 'woo_vip_client':
			case 'woo_big_whale':
				return $this->getWooAdvancedMarketingEventParams( $eventType );

			case 'edd_view_content':
				return $this->getEddPageVisitEventParams();

			case 'edd_add_to_cart_on_button_click':
				return $this->getEddAddToCartOnButtonClickEventParams( $args );

			case 'edd_add_to_cart_on_checkout_page':
				return $this->getEddCartEventParams( 'AddToCart' );

			case 'edd_remove_from_cart':
				return $this->getEddRemoveFromCartParams( $args );

			case 'edd_view_category':
				return $this->getEddViewCategoryEventParams();

			case 'edd_initiate_checkout':
				return $this->getEddCartEventParams( 'InitiateCheckout' );

			case 'edd_purchase':
				return $this->getEddCartEventParams( 'Checkout' );

			case 'edd_frequent_shopper':
			case 'edd_vip_client':
			case 'edd_big_whale':
				return $this->getEddAdvancedMarketingEventParams( $eventType );

			case 'complete_registration':
				return $this->getCompleteRegistrationEventParams();

			default:
				return false;   // event does not supported
		}

	}
	
	public function outputNoScriptEvents() {
		
		if ( ! $this->configured() ) {
			return;
		}
		
		$eventsManager = PYS()->getEventsManager();
		
		foreach ( $eventsManager->getStaticEvents( 'pinterest' ) as $eventName => $events ) {
			foreach ( $events as $event ) {
				foreach ( $this->getPixelIDs() as $pixelID ) {
					
					$args = array(
						'tid'      => $pixelID,
						'event'    => urlencode( $eventName ),
						'noscript' => 1,
					);
					
					foreach ( $event['params'] as $param => $value ) {
						@$args[ 'ed[' . $param . ']' ] = urlencode( $value );
					}
					
					// ALT tag used to pass ADA compliance
					printf( '<noscript><img height="1" width="1" style="display: none;" src="%s" alt="pinterest_pixel"></noscript>',
						add_query_arg( $args, 'https://ct.pinterest.com/v3' ) );
					
					echo "\r\n";
					
				}
			}
		}
		
		
	}
	
	public function renderAddonNotice() {}
	
	private function getGeneralEventParams() {

		if ( ! $this->getOption( 'general_event_enabled' ) ) {
			return false;
		}

		$eventName = PYS()->getOption( 'general_event_name' );
		$eventName = sanitizeKey( $eventName );

		if ( empty( $eventName ) ) {
			$eventName = 'GeneralEvent';
		}

		$allowedContentTypes = array(
			'on_posts_enabled'      => PYS()->getOption( 'general_event_on_posts_enabled' ),
			'on_pages_enables'      => PYS()->getOption( 'general_event_on_pages_enabled' ),
			'on_taxonomies_enabled' => PYS()->getOption( 'general_event_on_tax_enabled' ),
			'on_cpt_enabled'        => PYS()->getOption( 'general_event_on_' . get_post_type() . '_enabled', false ),
			'on_woo_enabled'        => PYS()->getOption( 'general_event_on_woo_enabled' ),
			'on_edd_enabled'        => PYS()->getOption( 'general_event_on_edd_enabled' ),
		);
		
		$params = Pinterest\getTheContentParams( $allowedContentTypes );

		return array(
			'name'  => $eventName,
			'data'  => $params,
			'delay' => (int) PYS()->getOption( 'general_event_delay' ),
		);

	}

	private function getSearchEventParams() {

		if ( ! $this->getOption( 'search_event_enabled' ) ) {
			return false;
		}

		$params['search_query'] = empty( $_GET['s'] ) ? null : $_GET['s'];

		return array(
			'name'  => 'search',
			'data'  => $params,
		);

	}

	private function getWooPageVisitEventParams() {
		global $post;
		
		if ( ! $this->getOption( 'woo_page_visit_enabled' ) ) {
			return false;
		}

		$params = array(
			'post_type' => 'product',
			'product_id' => $post->ID,
			'product_price' => getWooProductPriceToDisplay( $post->ID )
		);
		
		// content_name, category_name, tags
		$params['tags'] = implode( ', ', getObjectTerms( 'product_tag', $post->ID ) );
		$params = array_merge( $params, Pinterest\getWooCustomAudiencesOptimizationParams( $post->ID ) );

		// currency, value
		if ( PYS()->getOption( 'woo_view_content_value_enabled' ) ) {

			if( PYS()->getOption( 'woo_event_value' ) == 'custom' ) {
				$amount = getWooProductPrice( $post->ID );
			} else {
				$amount = getWooProductPriceToDisplay( $post->ID );
			}

			$value_option   = PYS()->getOption( 'woo_view_content_value_option' );
			$global_value   = PYS()->getOption( 'woo_view_content_value_global', 0 );
			$percents_value = PYS()->getOption( 'woo_view_content_value_percent', 100 );

			$params['value']    = getWooEventValue( $value_option, $amount, $global_value, $percents_value );
			$params['currency'] = get_woocommerce_currency();

		}

		return array(
			'name'  => 'PageVisit',
			'data'  => $params,
			'delay' => (int) PYS()->getOption( 'woo_view_content_delay' ),
		);

	}

	private function getWooAddToCartOnButtonClickEventParams( $product_id ) {

		if ( ! $this->getOption( 'woo_add_to_cart_enabled' ) || ! PYS()->getOption( 'woo_add_to_cart_on_button_click' ) ) {
			return false;
		}

		$params = Pinterest\getWooSingleAddToCartParams( $product_id, 1, false );

		return array(
			'data' => $params,
		);

	}

	private function getWooAddToCartOnCartEventParams() {

		if ( ! $this->getOption( 'woo_add_to_cart_enabled' ) ) {
			return false;
		}

		$params = Pinterest\getWooCartParams();

		return array(
				'name' => 'AddToCart',
			'data' => $params,
		);

	}

	private function getWooRemoveFromCartParams( $cart_item ) {

		if ( ! $this->getOption( 'woo_remove_from_cart_enabled' ) ) {
			return false;
		}
		
		if ( ! empty( $cart_item['variation_id'] ) ) {
			$product_id = (int) $cart_item['variation_id'];
		} else {
			$product_id = (int) $cart_item['product_id'];
		}
		
		// content_name, category_name, tags
		$cd_params = Pinterest\getWooCustomAudiencesOptimizationParams( $product_id );
		
		$params = array(
			'post_type'        => 'product',
			'product_id'       => $product_id,
			'product_quantity' => $cart_item['quantity'],
			'product_price' => getWooProductPriceToDisplay( $product_id ),
			'product_name'     => $cd_params['content_name'],
			'product_category' => $cd_params['category_name'],
			'tags' => implode( ', ', getObjectTerms( 'product_tag', $product_id ) )
		);

		return array( 'data' => $params );

	}

	private function getWooViewCategoryEventParams() {
		global $posts;

		if ( ! $this->getOption( 'woo_view_category_enabled' ) ) {
			return false;
		}
		
		$params = array(
			'post_type' => 'product',
		);
		
		$term = get_term_by( 'slug', get_query_var( 'term' ), 'product_cat' );
		$params['content_name'] = $term->name;

		$parent_ids = get_ancestors( $term->term_id, 'product_cat', 'taxonomy' );
		$params['content_category'] = array();

		foreach ( $parent_ids as $term_id ) {
			$term = get_term_by( 'id', $term_id, 'product_cat' );
			$params['content_category'][] = $term->name;
		}

		$params['content_category'] = implode( ', ', $params['content_category'] );

		$product_ids = array();
		$limit = min( count( $posts ), 5 );

		for ( $i = 0; $i < $limit; $i ++ ) {
			$product_ids[] = $posts[ $i ]->ID;
		}

		$params['product_ids'] = implode( ', ', $product_ids);

		return array(
			'name' => 'ViewCategory',
			'data' => $params,
		);

	}

	private function getWooInitiateCheckoutEventParams() {

		if ( ! $this->getOption( 'woo_initiate_checkout_enabled' ) ) {
			return false;
		}

		$params = Pinterest\getWooCartParams( 'InitiateCheckout' );

		return array(
			'name' => 'InitiateCheckout',
			'data' => $params,
		);

	}

	private function getWooCheckoutEventParams() {

		if ( ! $this->getOption( 'woo_checkout_enabled' ) ) {
			return false;
		}

		$params = Pinterest\getWooPurchaseParams( 'Purchase' );

		return array(
			'name' => 'Checkout',
			'data' => $params,
		);

	}

	private function getWooAffiliateEventParams( $product_id ) {

		if ( ! $this->getOption( 'woo_affiliate_enabled' ) ) {
			return false;
		}

		$params = Pinterest\getWooSingleAddToCartParams( $product_id, 1, true );

		return array(
			'data' => $params,
		);

	}

	private function getWooPayPalEventParams() {

		if ( ! $this->getOption( 'woo_paypal_enabled' ) ) {
			return false;
		}

		// we're using Cart date as of Order not exists yet
		$params = Pinterest\getWooCartParams( 'PayPal' );

		return array(
			'name' => '', // will be set on front-end
			'data' => $params,
		);

	}

	private function getWooAdvancedMarketingEventParams( $eventType ) {

		if ( ! $this->getOption( $eventType . '_enabled' ) ) {
			return false;
		}

		$params = Pinterest\getWooPurchaseParams( $eventType );

		switch ( $eventType ) {
			case 'woo_frequent_shopper':
				$eventName = 'FrequentShopper';
				break;

			case 'woo_vip_client':
				$eventName = 'VipClient';
				break;

			default:
				$eventName = 'BigWhale';
		}

		return array(
			'name' => $eventName,
			'data' => $params,
		);

	}

	/**
	 * @param CustomEvent $customEvent
	 *
	 * @return array|bool
	 */
	private function getCustomEventParams( $customEvent ) {

		$event_type = $customEvent->getPinterestEventType();
		
		if ( ! $customEvent->isPinterestEnabled() || empty( $event_type ) ) {
			return false;
		}

		$params = array();

		// add pixel params
		if ( $customEvent->isPinterestParamsEnabled() ) {
			
			// add custom params
			foreach ( $customEvent->getPinterestCustomParams() as $custom_param ) {
				$params[ $custom_param['name'] ] = $custom_param['value'];
			}

		}
		
		// SuperPack Dynamic Params feature
		$params = apply_filters( 'pys_superpack_dynamic_params', $params, 'pinterest' );

		return array(
			'name'  => $customEvent->getPinterestEventType(),
			'data'  => $params,
			'delay' => $customEvent->getDelay(),
		);

	}

	private function getCompleteRegistrationEventParams() {

		if ( ! $this->getOption( 'complete_registration_event_enabled' ) ) {
			return false;
		}

		return array(
			'name'  => 'Signup',
			'data'  => array(),
		);

	}

	private function getEddPageVisitEventParams() {
		global $post;

		if ( ! $this->getOption( 'edd_page_visit_enabled' ) ) {
			return false;
		}
		
		$params = array(
			'post_type'  => 'product',
			'product_id' => $post->ID
		);
		
		// content_name, category_name, tags
		$params['tags'] = implode( ', ', getObjectTerms( 'download_tag', $post->ID ) );
		$params = array_merge( $params, Pinterest\getEddCustomAudiencesOptimizationParams( $post->ID ) );
		
		// currency, value
		if ( PYS()->getOption( 'edd_view_content_value_enabled' ) ) {

			if( PYS()->getOption( 'edd_event_value' ) == 'custom' ) {
				$amount = getEddDownloadPrice( $post->ID );
			} else {
				$amount = getEddDownloadPriceToDisplay( $post->ID );
			}

			$value_option   = PYS()->getOption( 'edd_view_content_value_option' );
			$global_value   = PYS()->getOption( 'edd_view_content_value_global', 0 );
			$percents_value = PYS()->getOption( 'edd_view_content_value_percent', 100 );

			$params['value'] = getEddEventValue( $value_option, $amount, $global_value, $percents_value );
			$params['currency'] = edd_get_currency();

		}
		
		$params['product_price'] = getEddDownloadPriceToDisplay( $post->ID );
		
		return array(
			'name'  => 'PageVisit',
			'data'  => $params,
			'delay' => (int) PYS()->getOption( 'edd_view_content_delay' ),
		);

	}

	private function getEddAddToCartOnButtonClickEventParams( $download_id ) {
		global $post;

		if ( ! $this->getOption( 'edd_add_to_cart_enabled' ) || ! PYS()->getOption( 'edd_add_to_cart_on_button_click' ) ) {
			return false;
		}

		// maybe extract download price id
		if ( strpos( $download_id, '_') !== false ) {
			list( $download_id, $price_index ) = explode( '_', $download_id );
		} else {
			$price_index = null;
		}
		
		// content_name, category_name, tags
		$cd_params = Pinterest\getEddCustomAudiencesOptimizationParams( $download_id );
		
		$params = array(
			'post_type'        => 'product',
			'product_id'       => $download_id,
			'product_quantity' => 1,
			'product_name'     => $cd_params['content_name'],
			'product_category' => $cd_params['category_name'],
			'product_price' => getEddDownloadPriceToDisplay( $download_id, $price_index ),
			'tags' => implode( ', ', getObjectTerms( 'download_tag', $download_id ) ),
		);
		
		// currency, value
		if ( PYS()->getOption( 'edd_add_to_cart_value_enabled' ) ) {

			if( PYS()->getOption( 'edd_event_value' ) == 'custom' ) {
				$amount = getEddDownloadPrice( $download_id, $price_index );
			} else {
				$amount = getEddDownloadPriceToDisplay( $download_id, $price_index );
			}

			$value_option   = PYS()->getOption( 'edd_add_to_cart_value_option' );
			$percents_value = PYS()->getOption( 'edd_add_to_cart_value_percent', 100 );
			$global_value   = PYS()->getOption( 'edd_add_to_cart_value_global', 0 );

			$params['value'] = getEddEventValue( $value_option, $amount, $global_value, $percents_value );
			$params['currency'] = edd_get_currency();

		}

		$license = getEddDownloadLicenseData( $download_id );
		$params  = array_merge( $params, $license );

		return array(
			'data' => $params,
		);

	}

	private function getEddCartEventParams( $context = 'AddToCart' ) {

		if ( $context == 'AddToCart' && ! $this->getOption( 'edd_add_to_cart_enabled' ) ) {
			return false;
		} elseif ( $context == 'InitiateCheckout' && ! $this->getOption( 'edd_initiate_checkout_enabled' ) ) {
			return false;
		} elseif ( $context == 'Checkout' && ! $this->getOption( 'edd_checkout_enabled' ) ) {
			return false;
		} else {
			// AM events allowance checked by themselves
		}

		if ( $context == 'AddToCart' ) {
			$value_enabled  = PYS()->getOption( 'edd_add_to_cart_value_enabled' );
			$value_option   = PYS()->getOption( 'edd_add_to_cart_value_option' );
			$percents_value = PYS()->getOption( 'edd_add_to_cart_value_percent', 100 );
			$global_value   = PYS()->getOption( 'edd_add_to_cart_value_global', 0 );
		} elseif ( $context == 'InitiateCheckout' ) {
			$value_enabled  = PYS()->getOption( 'edd_initiate_checkout_value_enabled' );
			$value_option   = PYS()->getOption( 'edd_initiate_checkout_value_option' );
			$percents_value = PYS()->getOption( 'edd_initiate_checkout_value_percent', 100 );
			$global_value   = PYS()->getOption( 'edd_initiate_checkout_global', 0 );
		} else {
			$value_enabled  = PYS()->getOption( 'edd_purchase_value_enabled' );
			$value_option   = PYS()->getOption( 'edd_purchase_value_option' );
			$percents_value = PYS()->getOption( 'edd_purchase_value_percent', 100 );
			$global_value   = PYS()->getOption( 'edd_purchase_value_global', 0 );
		}
		
		$params = array(
			'post_type' => 'product',
		);

		if ( $context == 'AddToCart' || $context == 'InitiateCheckout' ) {
			$cart = edd_get_cart_contents();
		} else {
			$cart = edd_get_payment_meta_cart_details( edd_get_purchase_id_by_key( getEddPaymentKey() ), true );
		}
		
		$line_items = array();
		
		$num_items   = 0;
		$total       = 0;
		$total_as_is = 0;
		
		$licenses = array(
			'transaction_type'   => null,
			'license_site_limit' => null,
			'license_time_limit' => null,
			'license_version'    => null
		);
		
		foreach ( $cart as $cart_item_key => $cart_item ) {
			
			$download_id = (int) $cart_item['id'];
			
			$price_index = ! empty( $cart_item['options'] ) ? $cart_item['options']['price_id'] : null;
			
			// content_name, category_name, tags
			$cd_params = Pinterest\getEddCustomAudiencesOptimizationParams( $download_id );
			$tags = getObjectTerms( 'download_tag', $download_id );
			
			$line_item = array(
				'product_id'       => $download_id,
				'product_quantity' => $cart_item['quantity'],
				'product_price'    => getEddDownloadPriceToDisplay( $download_id, $price_index ),
				'product_name'     => $cd_params['content_name'],
				'product_category' => $cd_params['category_name'],
				'tags'             => implode( ', ', $tags )
			);
			
			$line_items[] = $line_item;
			
			$num_items += $cart_item['quantity'];

			// calculate cart items total
			if ( $value_enabled ) {

				if ( $context == 'Checkout' ) {

					if ( PYS()->getOption( 'edd_tax_option' ) == 'included' ) {
						$total += $cart_item['subtotal'] + $cart_item['tax'] - $cart_item['discount'];
					} else {
						$total += $cart_item['subtotal'] - $cart_item['discount'];
					}

					$total_as_is += $cart_item['price'];

				} else {

					$total += getEddDownloadPrice( $download_id, $price_index ) * $cart_item['quantity'];
					$total_as_is += edd_get_cart_item_final_price( $cart_item_key );

				}

			}

			// get download license data
			array_walk( $licenses, function( &$value, $key, $license ) {

				if ( ! isset( $license[ $key ] ) ) {
					return;
				}

				if ( $value ) {
					$value = $value . ', ' . $license[ $key ];
				} else {
					$value = $license[ $key ];
				}

			}, getEddDownloadLicenseData( $download_id ) );
			
		}
		
		$params['line_items'] = $line_items;
		$params['num_items'] = $num_items;

		// currency, value
		if ( $value_enabled ) {

			if( PYS()->getOption( 'edd_event_value' ) == 'custom' ) {
				$amount = $total;
			} else {
				$amount = $total_as_is;
			}

			$params['value']    = getEddEventValue( $value_option, $amount, $global_value, $percents_value );
			$params['currency'] = edd_get_currency();

		}

		$params = array_merge( $params, $licenses );

		if ( $context == 'Checkout' ) {

			$payment_key = getEddPaymentKey();
			$payment_id = (int) edd_get_purchase_id_by_key( $payment_key );
			$session  = edd_get_purchase_session();

			$user = edd_get_payment_meta_user_info( $payment_id );
			$meta = edd_get_payment_meta( $payment_id );

			// town, state, country
			if ( isset( $user['address'] ) ) {

				if ( ! empty( $user['address']['city'] ) ) {
					$params['town'] = $user['address']['city'];
				}

				if ( ! empty( $user['address']['state'] ) ) {
					$params['state'] = $user['address']['state'];
				}

				if ( ! empty( $user['address']['country'] ) ) {
					$params['country'] = $user['address']['country'];
				}

			}

			// payment method
			if ( isset( $session['gateway'] ) ) {
				$params['payment'] = $session['gateway'];
			}

			// coupons
			$coupons = isset( $user['discount'] ) && $user['discount'] != 'none' ? $user['discount'] : null;

			if ( ! empty( $coupons ) ) {
				$coupons = explode( ', ', $coupons );
				$params['coupon'] = $coupons[0];
			}

			// add transaction date
			$params['transaction_year']  = strftime( '%Y', strtotime( $meta['date'] ) );
			$params['transaction_day']   = strftime( '%d', strtotime( $meta['date'] ) );

			$params['order_id'] = $payment_id;
			$params['currency'] = edd_get_currency();

			// calculate value
			if ( PYS()->getOption( 'edd_event_value' ) == 'custom' ) {
				$params['value'] = getEddOrderTotal( $payment_id );
			} else {
				$params['value'] = edd_get_payment_amount( $payment_id );
			}

			if ( edd_use_taxes() ) {
				$params['tax'] = edd_get_payment_tax( $payment_id );
			} else {
				$params['tax'] = 0;
			}

		}

		return array(
			'name' => $context,
			'data' => $params,
		);

	}

	private function getEddRemoveFromCartParams( $cart_item ) {

		if ( ! $this->getOption( 'edd_remove_from_cart_enabled' ) ) {
			return false;
		}

		$download_id = $cart_item['id'];
		$price_index = ! empty( $cart_item['options'] ) ? $cart_item['options']['price_id'] : null;
	
		// content_name, category_name, tags
		$cd_params = Pinterest\getEddCustomAudiencesOptimizationParams( $download_id );
		
		$params = array(
			'post_type'        => 'product',
			'product_id'       => $download_id,
			'product_quantity' => $cart_item['quantity'],
			'product_price'    => getEddDownloadPriceToDisplay( $download_id, $price_index ),
			'product_name'     => $cd_params['content_name'],
			'product_category' => $cd_params['category_name'],
			'tags'             => implode( ', ', getObjectTerms( 'download_tag', $download_id ) )
		);

		return array( 'data' => $params );

	}

	private function getEddViewCategoryEventParams() {
		global $posts;

		if ( ! $this->getOption( 'edd_view_category_enabled' ) ) {
			return false;
		}
		
		$params = array(
			'post_type' => 'product',
		);
		
		$term = get_term_by( 'slug', get_query_var( 'term' ), 'download_category' );
		$params['content_name'] = $term->name;

		$parent_ids = get_ancestors( $term->term_id, 'download_category', 'taxonomy' );
		$params['content_category'] = array();

		foreach ( $parent_ids as $term_id ) {
			$term = get_term_by( 'id', $term_id, 'download_category' );
			$params['content_category'][] = $term->name;
		}

		$params['content_category'] = implode( ', ', $params['content_category'] );
		
		$product_ids = array();
		$limit       = min( count( $posts ), 5 );
		
		for ( $i = 0; $i < $limit; $i ++ ) {
			$product_ids[] = $posts[ $i ]->ID;
		}
		
		$params['product_ids'] = implode( ', ', $product_ids );
		
		return array(
			'name' => 'ViewCategory',
			'data' => $params,
		);

	}

	private function getEddAdvancedMarketingEventParams( $eventType ) {

		if ( ! $this->getOption( $eventType . '_enabled' ) ) {
			return false;
		}

		switch ( $eventType ) {
			case 'edd_frequent_shopper':
				$eventName = 'FrequentShopper';
				break;

			case 'edd_vip_client':
				$eventName = 'VipClient';
				break;

			default:
				$eventName = 'BigWhale';
		}

		$params = $this->getEddCartEventParams( $eventName );

		return array(
			'name' => $eventName,
			'data' => $params['data'],
		);

	}

}

/**
 * @return Pinterest
 */
function Pinterest() {
	return Pinterest::instance();
}

Pinterest();