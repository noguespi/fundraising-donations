<?php

declare( strict_types = 1 );

namespace WMDE\Fundraising\PaymentContext\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use WMDE\Fundraising\PaymentContext\Domain\Model\Iban;

/**
 * @covers \WMDE\Fundraising\PaymentContext\Domain\Model\Iban
 *
 * @licence GNU GPL v2+
 * @author Gabriel Birke < gabriel.birke@wikimedia.de >
 */
class IbanTest extends TestCase {

	private const TEST_IBAN_WITH_WHITESPACE = 'DE12 5001 0517 0648 4898 90 ';
	private const TEST_IBAN = 'DE12500105170648489890';
	private const TEST_LOWERCASE_IBAN = 'de12500105170648489890';

	/**
	 * @dataProvider getValidIbansWithDisallowedCharacters
	 */
	public function testGivenIbanWithDisallowedCharacters_onlySaneCharactersAreConsidered( string $input, string $expected ): void {
		$iban = new Iban( $input );
		$this->assertSame( $expected, $iban->toString() );
	}

	public function getValidIbansWithDisallowedCharacters(): array {
		return [
			[ "AT\xc2\xa7022050302101023600", 'AT022050302101023600' ],
			[ "DE\xe2\x80\xaa1250010517064\xe2\x80\xac8489890", 'DE12500105170648489890' ],
			[ self::TEST_IBAN_WITH_WHITESPACE, self::TEST_IBAN ],
			[ 'CH17  12341234  1234123419', 'CH17123412341234123419' ],
			[ '  DE12500105170648489890 ', 'DE12500105170648489890' ]
		];
	}

	public function testCountryCodeIsReturnedCorrectly(): void {
		$iban = new Iban( self::TEST_IBAN );
		$this->assertSame( 'DE', $iban->getCountryCode() );
	}

	public function testCountryCodeIsReturnedCorrectlyForLowercase(): void {
		$iban = new Iban( self::TEST_LOWERCASE_IBAN );
		$this->assertSame( 'DE', $iban->getCountryCode() );
	}

	public function testGivenSameIbanWithDifferentCapitalization_objectsAreEqual(): void {
		$this->assertEquals(
			new Iban( self::TEST_IBAN ),
			new Iban( self::TEST_LOWERCASE_IBAN )
		);
	}

}
