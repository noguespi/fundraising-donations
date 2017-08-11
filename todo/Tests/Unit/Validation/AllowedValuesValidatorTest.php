<?php

declare( strict_types = 1 );

namespace WMDE\Fundraising\Frontend\Tests\Unit\Validation;

use WMDE\Fundraising\Frontend\Validation\AllowedValuesValidator;

/**
 * @covers WMDE\Fundraising\Frontend\Validation\AllowedValuesValidator
 *
 * @license GNU GPL v2+
 * @author Gabriel Birke < gabriel.birke@wikimedia.de >
 */
class AllowedValuesValidatorTest extends ValidatorTestCase {

	public function testGivenNoAllowedValues_constructionFails(): void {
		$this->expectException( \UnexpectedValueException::class );
		new AllowedValuesValidator( [] );
	}

	public function testGivenAllowedValues_theyAreAccepted(): void {
		$validator = new AllowedValuesValidator( ['kittens', 'unicorns'] );
		$this->assertTrue( $validator->validate( 'kittens' )->isSuccessful() );
		$this->assertTrue( $validator->validate( 'unicorns' )->isSuccessful() );

		$this->assertFalse( $validator->validate( 'dragons' )->isSuccessful() );
	}

	public function testAllowedValuesAreCheckedStrictly(): void {
		$validator = new AllowedValuesValidator( ['1', '2'] );
		$this->assertTrue( $validator->validate( '1' )->isSuccessful() );
		$this->assertFalse( $validator->validate( 1 )->isSuccessful() );
	}
}
