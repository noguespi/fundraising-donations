<?php

declare( strict_types = 1 );

namespace WMDE\Fundraising\DonationContext\Authorization;

/**
 * @licence GNU GPL v2+
 * @author Kai Nissen < kai.nissen@wikimedia.de >
 */
interface TokenGenerator {

	public function generateToken(): string;

	public function generateTokenExpiry(): \DateTime;

}
