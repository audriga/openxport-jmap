<?php
declare(strict_types=1);

namespace OpenXPort\Tests\Unit;
use PHPUnit\Framework\TestCase;
use OpenXPort\Mapper\VCardToContactCardMapper;
use OpenXPort\Adapter\VCardJsContactAdapter;
use OpenXPort\Jmap\JSContact\ContactCard;
use OpenXPort\Jmap\JSContact\Name;
use OpenXPort\Jmap\JSContact\NameComponent;
use OpenXPort\Jmap\JSContact\Nickname;
use OpenXPort\Jmap\JSContact\Organization;
use OpenXPort\Jmap\JSContact\OrgUnit;
use OpenXPort\Jmap\JSContact\Title;
use OpenXPort\Jmap\JSContact\Note;
use OpenXPort\Jmap\JSContact\EmailAddress;
use OpenXPort\Jmap\JSContact\Phone;
use OpenXPort\Jmap\JSContact\OnlineService;
use OpenXPort\Jmap\JSContact\Address;
use OpenXPort\Jmap\JSContact\Anniversary;
use OpenXPort\Jmap\JSContact\Relation;
use OpenXPort\Jmap\JSContact\PersonalInformation;
use Sabre\VObject;

final class VCardToContactCardMapperRoundTripTest extends TestCase


{
    public function testVcardToContactCardAndBack()
    {
        $inputVcf =
            "BEGIN:VCARD\r\n"
            . "VERSION:4.0\r\n"
            . "FN:Ada Lovelace\r\n"
            . "N:Lovelace;Ada;Augusta;Countess;PhD\r\n"
            . "NICKNAME;TYPE=work;PREF=1:AL\r\n"
            . "ORG:ABC\\, Inc.;North American Division;Marketing\r\n"
            . "TITLE:Research Scientist\r\n"
            . "ROLE:Project Leader\r\n"
            . "NOTE:First programmer\r\n"
            . "EMAIL;TYPE=work;PREF=1:ada.work@example.org\r\n"
            . "EMAIL;TYPE=home;PREF=2:ada.home@example.org\r\n"
            . "TEL;TYPE=work,voice;PREF=1:+49 123 4567\r\n"
            . "TEL;TYPE=home,cell;PREF=2:+49 111 2222\r\n"
            . "URL;TYPE=work;PREF=1:https://example.org\r\n"
            . "IMPP;TYPE=work;PREF=1:xmpp:ada@example.org\r\n"
            . "ADR;TYPE=work;PREF=1:;;123 Main Street\\nAny Town, CA 91921;Any Town;CA;91921;USA\r\n"
            . "BDAY;VALUE=DATE:1815-12-10\r\n"
            . "ANNIVERSARY;VALUE=DATE:1835-01-01\r\n"
            . "CATEGORIES:cat1,cat2\r\n"
            . "EXPERTISE;LEVEL=expert;INDEX=1:chemistry\r\n"
            . "HOBBY;LEVEL=high;INDEX=2:reading\r\n"
            . "INTEREST;LEVEL=medium;INDEX=3:r&b music\r\n"
            . "RELATED;TYPE=friend:urn:uuid:03a0e51f-d1aa-4385-8a53-e29025acd8af\r\n"
            . "MEMBER:urn:uuid:member-1\r\n"
            . "KIND:group\r\n"
            . "END:VCARD\r\n";

        $mapper  = new VCardToContactCardMapper();
        $adapter = new VCardJsContactAdapter();

        // vCard -> JSContact
        $cards = $mapper->mapToJmap(['uid-123' => $inputVcf], $adapter);
        $this->assertCount(1, $cards);
        $card = $cards[0];
        $this->assertSame('uid-123', $card->getUid());

        // JSContact -> vCard
        $adapter2 = new VCardJsContactAdapter();
        $mapped   = $mapper->mapFromJmap(['c1' => $card], $adapter2);

        $this->assertNotEmpty($mapped);
        $outVcf = $mapped[0]['c1'];
        $this->assertIsString($outVcf);
        $this->assertNotSame('', $outVcf);

        $out = VObject\Reader::read($outVcf);

        // Name + FN in one go
        $this->assertSame('Ada Lovelace', (string)$out->FN);
        $this->assertSame(
            ['Lovelace', 'Ada', 'Augusta', 'Countess', 'PhD'],
            $out->N->getParts()
        );

        // Nickname
        $this->assertSame('AL', (string)$out->NICKNAME);

        // Organization
        $this->assertSame(
            ['ABC, Inc.', 'North American Division', 'Marketing'],
            $out->ORG->getParts()
        );

        // Titles and roles
        $this->assertSame(['Research Scientist'], array_map('strval', iterator_to_array($out->TITLE)));
        $this->assertSame(['Project Leader'], array_map('strval', iterator_to_array($out->ROLE)));

        // Note
        $this->assertSame('First programmer', (string)$out->NOTE);

        // Emails (addresses only)
        $this->assertSame(
            ['ada.work@example.org', 'ada.home@example.org'],
            array_map('strval', iterator_to_array($out->EMAIL))
        );

        // Phones (numbers only)
        $this->assertSame(
            ['+49 123 4567', '+49 111 2222'],
            array_map('strval', iterator_to_array($out->TEL))
        );

        // Online
        $this->assertSame(['https://example.org'], array_map('strval', iterator_to_array($out->URL)));
        $this->assertSame(['xmpp:ada@example.org'], array_map('strval', iterator_to_array($out->IMPP)));

        // Address
        $adrParts      = $out->ADR->getParts();
        $adrFormatted  = isset($adrParts[2]) ? (string)$adrParts[2] : null;
        $this->assertSame("123 Main Street\nAny Town, CA 91921", $adrFormatted);

        // Dates
        $this->assertSame('1815-12-10', (string)$out->BDAY);
        $this->assertSame('18350101', (string)$out->ANNIVERSARY);

        // Categories
        $this->assertSame(
            ['cat1', 'cat2'],
            $out->CATEGORIES->getParts()
        );

        // Related + group
        $this->assertSame(
            ['urn:uuid:03a0e51f-d1aa-4385-8a53-e29025acd8af'],
            array_map('strval', iterator_to_array($out->RELATED))
        );
        $this->assertMatchesRegularExpression("/\r\nKIND:group\r\n/i", $outVcf);
        $this->assertMatchesRegularExpression(
            "/\r\nMEMBER(?:;[^:]*)?:urn:uuid:member-1\r\n/i",
            $outVcf
        );
    }

    public function testJmapToVcardAndBack()
    {
        $components = [
            new NameComponent('surname', 'Lovelace'),
            new NameComponent('given',   'Ada'),
            new NameComponent('middle',  'Augusta'),
            new NameComponent('prefix',  'Countess'),
            new NameComponent('suffix',  'PhD'),
        ];

        $name = new Name($components, true, 'Ada Lovelace');
        $nick = new Nickname('AL');

        $unit1 = new OrgUnit('North American Division');
        $unit2 = new OrgUnit('Marketing');
        $org   = new Organization('ABC, Inc.', [$unit1, $unit2]);

        $t1 = new Title('Research Scientist', 'title');
        $t2 = new Title('Project Leader', 'role');

        $note = new Note('First programmer');

        $email1 = new EmailAddress('ada.work@example.org', ['work' => true], 1);
        $email2 = new EmailAddress('ada.home@example.org', ['private' => true], 2);

        $phone1 = new Phone('+49 123 4567', ['work' => true], 1);
        $phone2 = new Phone('+49 111 2222', ['private' => true], 2);

        $os1 = new OnlineService('website', 'https://example.org', ['work' => true], 1);
        $os2 = new OnlineService('im', 'xmpp:ada@example.org', ['work' => true], 1);

        $addr = new Address();
        $addr->setFullAddress("123 Main Street\nAny Town, CA 91921");
        $addr->setContexts(['work' => true]);
        $addr->setPref(1);

        $a1  = new Anniversary('birth',   '1815-12-10');
        $a2  = new Anniversary('wedding', '1835-01-01');

        $rel = new Relation(['friend' => true]);

        $pi1 = new PersonalInformation('expertise', 'chemistry', 'high', 1);
        $pi2 = new PersonalInformation('hobby', 'reading', 'high', 2);
        $pi3 = new PersonalInformation('interest', 'r&b music', 'medium', 3);

        $card = new ContactCard(
            'uid-123',
            null,
            'group',
            null,
            $name,
            ['n1' => $nick],
            ['o1' => $org],
            ['t1' => $t1, 't2' => $t2],
            ['e1' => $email1, 'e2' => $email2],
            ['p1' => $phone1, 'p2' => $phone2],
            ['os1' => $os1, 'os2' => $os2],
            ['a1' => $addr],
            [$a1, $a2],
            ['urn:uuid:03a0e51f-d1aa-4385-8a53-e29025acd8af' => $rel],
            ['urn:uuid:member-1' => true],
            ['no1' => $note],
            ['pi1' => $pi1, 'pi2' => $pi2, 'pi3' => $pi3],
            ['cat1' => true, 'cat2' => true],
            null
        );

        $mapper  = new VCardToContactCardMapper();
        $adapter = new VCardJsContactAdapter();

        // JSContact -> vCard
        $mapped = $mapper->mapFromJmap(['c1' => $card], $adapter);
        $this->assertNotEmpty($mapped);
        $vcf = $mapped[0]['c1'];
        $this->assertIsString($vcf);
        $this->assertNotSame('', $vcf);

        $out = VObject\Reader::read($vcf);

        // Name in vCard
        $this->assertSame(['Lovelace', 'Ada', 'Augusta', 'Countess', 'PhD'], $out->N->getParts());
        $this->assertSame('AL', (string)$out->NICKNAME);
        $this->assertSame('Ada Augusta Lovelace', (string)$out->FN);

        // Address in vCard
        $adrParts     = $out->ADR->getParts();
        $adrFormatted = isset($adrParts[2]) ? (string)$adrParts[2] : null;
        $this->assertSame("123 Main Street\nAny Town, CA 91921", $adrFormatted);

        // Categories in vCard
        $this->assertSame(['cat1', 'cat2'], $out->CATEGORIES->getParts());

        // Personal info in vCard
        $expVals = array_map('strval', iterator_to_array($out->EXPERTISE));
        $hobVals = array_map('strval', iterator_to_array($out->HOBBY));
        $intVals = array_map('strval', iterator_to_array($out->INTEREST));

        $this->assertContains('chemistry', $expVals);
        $this->assertContains('reading', $hobVals);
        $this->assertContains('r&b music', $intVals);

        // Round-trip back to JSContact
        $adapter2 = new VCardJsContactAdapter();
        $cards2   = $mapper->mapToJmap(['uid-123' => $vcf], $adapter2);

        $this->assertCount(1, $cards2);
        $card2 = $cards2[0];
        $this->assertSame('uid-123', $card2->getUid());

        // JSContact after round-trip 
        $this->assertSame('Ada Augusta Lovelace', $card2->getName()->getFull());
        $this->assertArrayHasKey('n1', $card2->getNicknames());
        $this->assertSame('AL', $card2->getNicknames()['n1']->getName());

        $addresses2 = $card2->getAddresses();
        $this->assertArrayHasKey('a1', $addresses2);
        $this->assertSame(
            "123 Main Street\nAny Town, CA 91921",
            $addresses2['a1']->getFullAddress()
        );

        // Keywords after round-trip
        $keywords2 = $card2->getKeywords();
        $this->assertArrayHasKey('cat1', $keywords2);
        $this->assertArrayHasKey('cat2', $keywords2);

        // Personal info after round-trip (at least presence)
        $piMap2 = $card2->getPersonalInfo();
        $this->assertNotEmpty($piMap2);
    }
}
