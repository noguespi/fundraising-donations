<?php

declare( strict_types = 1 );

namespace WMDE\Fundraising\Frontend\DonationContext\Tests\Unit\Validation;

use WMDE\Fundraising\Frontend\DonationContext\Domain\Model\DonorName;
use WMDE\Fundraising\Frontend\DonationContext\Validation\DonorNameValidator;
use WMDE\Fundraising\Frontend\Tests\Unit\Validation\ValidatorTestCase;

/**
 * @covers \WMDE\Fundraising\Frontend\DonationContext\Validation\DonorNameValidator
 *
 * @licence GNU GPL v2+
 * @author Kai Nissen < kai.nissen@wikimedia.de >
 */
class DonorNameValidatorTest extends ValidatorTestCase {

	public function testGivenValidPersonName_validationSucceeds(): void {
		$validator = new DonorNameValidator();
		$personName = DonorName::newPrivatePersonName();
		$personName->setSalutation( 'Mr.' );
		$personName->setTitle( '' );
		$personName->setFirstName( 'Hank' );
		$personName->setLastName( 'Scorpio' );

		$this->assertTrue( $validator->validate( $personName )->isSuccessful() );
	}

	public function testGivenEmptyPersonName_validationFails(): void {
		$validator = new DonorNameValidator();
		$personName = DonorName::newPrivatePersonName();

		$result = $validator->validate( $personName );
		$this->assertConstraintWasViolated( $result, 'salutation' );
		$this->assertConstraintWasViolated( $result, 'firstName' );
		$this->assertConstraintWasViolated( $result, 'lastName' );
	}

	public function testGivenValidCompanyName_validationSucceeds(): void {
		$validator = new DonorNameValidator();
		$personName = DonorName::newCompanyName();
		$personName->setCompanyName( 'Globex Corp.' );

		$this->assertTrue( $validator->validate( $personName )->isSuccessful() );
	}

	public function testGivenEmptyCompanyName_validationFails(): void {
		$validator = new DonorNameValidator();

		$this->assertConstraintWasViolated(
			$validator->validate( DonorName::newCompanyName() ),
			'company'
		);
	}

}
