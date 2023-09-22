<?php
/**
 * Plugin Name: Moneybird for Easy Digital Downloads (Customizations)
 * Plugin URI: https://daan.dev/wordpress/easy-moneybird-edd/
 * Description: Customizations for Moneybird for EDD.
 * Version: 1.0.1
 * Author: Daan from Daan.dev
 * Author URI: https://daan.dev/about/
 * Text Domain: easy-moneybird-edd
 */

defined( 'ABSPATH' ) || exit;

class EDDMoneybirdCustomizations {
	public function __construct() {
		add_filter( 'edd_moneybird_purchase_sync_payment', [ $this, 'maybe_sync_payment' ], 9, 3 );
	}
	
	/**
	 * Make sure we don't sync PayPal payments.
	 *
	 * @param bool $value Return value
	 * @param array $invoice Invoice data from Moneybird API.
	 * @param EDD_Payment $payment
	 *
	 * @return bool
	 */
	public function maybe_sync_payment( $value, $invoice, $payment ) {
		$gateway = $payment->gateway ?? '';
		
		if ( ! $gateway ) {
			return $value;
		}
		
		return $gateway !== 'mollie_paypal';
	}
}

new EDDMoneybirdCustomizations();