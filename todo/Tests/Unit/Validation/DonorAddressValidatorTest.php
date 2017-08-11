<?php

declare( strict_types = 1 );

namespace WMDE\Fundraising\Frontend\Tests\Unit\Validation;

use WMDE\Fundraising\Frontend\DonationContext\Domain\Model\DonorAddress;
use WMDE\Fundraising\Frontend\DonationContext\Validation\DonorAddressValidator;
use WMDE\Fundraising\Frontend\Tests\Unit\Validation\ValidatorTestCase;

/**
 * @covers \WMDE\Fundraising\Frontend\DonationContext\Validation\DonorAddressValidator
 *
 * @licence GNU GPL v2+
 * @author Kai Nissen < kai.nissen@wikimedia.de >
 */
class DonorAddressValidatorTest extends ValidatorTestCase {

	public function testGivenValidAddress_validatorReturnsTrue_andConstraintViolationsAreEmpty(): void {
		$validator = new DonorAddressValidator();
		$physicalAddress = new DonorAddress();
		$physicalAddress->setStreetAddress( 'Stiftstr. 50' );
		$physicalAddress->setPostalCode( '20099' );
		$physicalAddress->setCity( 'Hamburg' );
		$physicalAddress->setCountryCode( 'DE' );
		$physicalAddress->freeze()->assertNoNullFields();

		$this->assertTrue( $validator->validate( $physicalAddress )->isSuccessful() );
	}

	public function testGivenEmptyAddress_validatorReturnsFalse(): void {
		$validator = new DonorAddressValidator();
		$this->assertFalse( $validator->validate( new DonorAddress() )->isSuccessful() );
	}

	public function testGivenEmptyAddress_violationsContainsRequiredFieldNames(): void {
		$validator = new DonorAddressValidator();
		$result = $validator->validate( new DonorAddress() );

		$this->assertConstraintWasViolated( $result, 'street' );
		$this->assertConstraintWasViolated( $result, 'postcode' );
		$this->assertConstraintWasViolated( $result, 'city' );
		$this->assertConstraintWasViolated( $result, 'country' );
	}

}
