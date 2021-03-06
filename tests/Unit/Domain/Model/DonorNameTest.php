<?php

declare( strict_types = 1 );

namespace WMDE\Fundraising\DonationContext\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use WMDE\Fundraising\DonationContext\Domain\Model\DonorName;

/**
 * @covers \WMDE\Fundraising\DonationContext\Domain\Model\DonorName
 *
 * @license GNU GPL v2+
 * @author Kai Nissen < kai.nissen@wikimedia.de >
 * @author Gabriel Birke < gabriel.birke@wikimedia.de >
 */
class DonorNameTest extends TestCase {

	public function testGivenPersonNameWithoutSalutation_getFullNameReturnsNameWithoutSalutation(): void {
		$personName = DonorName::newPrivatePersonName();

		$personName->setFirstName( 'Ebenezer' );
		$personName->setLastName( 'Scrooge' );

		$this->assertSame( 'Ebenezer Scrooge', $personName->getFullName() );
	}

	public function testGivenPersonNameWithSalutation_getFullNameReturnsNameWithoutSalutation(): void {
		$personName = DonorName::newPrivatePersonName();

		$personName->setFirstName( 'Ebenezer' );
		$personName->setLastName( 'Scrooge' );
		$personName->setSalutation( 'Sir' );

		$this->assertSame( 'Ebenezer Scrooge', $personName->getFullName() );
	}

	public function testGivenPersonNameWithTitle_getFullNameReturnsNameWithTitle(): void {
		$personName = DonorName::newPrivatePersonName();

		$personName->setFirstName( 'Friedemann' );
		$personName->setLastName( 'Schulz von Thun' );
		$personName->setTitle( 'Prof. Dr.' );

		$this->assertSame( 'Prof. Dr. Friedemann Schulz von Thun', $personName->getFullName() );
	}

	public function testGivenPersonNameWithTitleAndSalutation_getFullNameReturnsNameWithTitle(): void {
		$personName = DonorName::newPrivatePersonName();

		$personName->setFirstName( 'Friedemann' );
		$personName->setLastName( 'Schulz von Thun' );
		$personName->setTitle( 'Prof. Dr.' );
		$personName->setSalutation( 'Herr' );

		$this->assertSame( 'Prof. Dr. Friedemann Schulz von Thun', $personName->getFullName() );
	}

	public function testGivenPersonNameWithTitleAndCompay_getFullNameReturnsNameWithTitleAndCompany(): void {
		$personName = DonorName::newPrivatePersonName();

		$personName->setFirstName( 'Hank' );
		$personName->setLastName( 'Scorpio' );
		$personName->setCompanyName( 'Globex Corp.' );
		$personName->setTitle( 'Evil Genius' );
		$personName->setSalutation( 'Mr.' );

		$this->assertSame( 'Evil Genius Hank Scorpio, Globex Corp.', $personName->getFullName() );
	}

	public function testGivenCompanyNameWithPerson_getFullNameReturnsPersonAndCompanyName(): void {
		$companyName = DonorName::newCompanyName();

		$companyName->setFirstName( 'Hank' );
		$companyName->setLastName( 'Scorpio' );
		$companyName->setCompanyName( 'Globex Corp.' );
		$companyName->setTitle( 'Evil Genius' );
		$companyName->setSalutation( 'Mr.' );

		$this->assertSame( 'Evil Genius Hank Scorpio, Globex Corp.', $companyName->getFullName() );
	}

	public function testGivenCompanyNameOnly_getFullNameReturnsCompanyName(): void {
		$companyName = DonorName::newCompanyName();

		$companyName->setCompanyName( 'Globex Corp.' );

		$this->assertSame( 'Globex Corp.', $companyName->getFullName() );
	}

	public function testPrivatePersonNameCanBeIdentified(): void {
		$personName = DonorName::newPrivatePersonName();

		$this->assertTrue( $personName->isPrivatePerson() );
		$this->assertFalse( $personName->isCompany() );
	}

	public function testCompanyNameCanBeIdentified(): void {
		$personName = DonorName::newCompanyName();

		$this->assertFalse( $personName->isPrivatePerson() );
		$this->assertTrue( $personName->isCompany() );
	}

}
