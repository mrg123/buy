<?php
class ModelPaymentGobaldbill extends Model {
	public function install() {
		
	}

	public function uninstall() {

	}

	public function void($order_id) {
		
	}

	public function updateVoidStatus($sagepay_direct_order_id, $status) {
		
	}

	public function release($order_id, $amount) {
		
	}

	public function updateReleaseStatus($sagepay_direct_order_id, $status) {
		
	}

	public function rebate($order_id, $amount) {
		
	}

	public function updateRebateStatus($sagepay_direct_order_id, $status) {
		
	}

	public function getOrder($order_id) {

	}

	private function getTransactions($sagepay_direct_order_id) {
		
	}

	public function addTransaction($sagepay_direct_order_id, $type, $total) {
		
	}

	public function getTotalReleased($sagepay_direct_order_id) {

	}

	public function getTotalRebated($sagepay_direct_order_id) {

	}

	public function sendCurl($url, $payment_data) {
		
	}

	public function logger($message) {
		
	}
}