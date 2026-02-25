<?php

namespace OpenXPort\Adapter;

use OpenXPort\Jmap\JSContact\ContactCard;
use OpenXPort\Jmap\JSContact\Name;
use OpenXPort\Jmap\JSContact\NameComponent;
use OpenXPort\Jmap\JSContact\Nickname;
use OpenXPort\Jmap\JSContact\Organization;
use OpenXPort\Jmap\JSContact\Title;
use OpenXPort\Jmap\JSContact\Note;
use OpenXPort\Jmap\JSContact\EmailAddress;
use OpenXPort\Jmap\JSContact\Phone;
use OpenXPort\Jmap\JSContact\OnlineService;
use OpenXPort\Jmap\JSContact\Address;
use OpenXPort\Jmap\JSContact\Anniversary;
use OpenXPort\Jmap\JSContact\Relation;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;
use Sabre\VObject;

/**
 * Adapter that converts between vCard and JSContact ContactCard.
 */
class VCardJsContactAdapter extends AbstractAdapter
{
    /** @var VObject\Component\VCard */
    protected $vcard;

    /** @var Logger|null */
    protected $logger;

    /**
     * Create a new adapter with an empty vCard.
     */
    public function __construct()
    {
        $this->vcard  = new VObject\Component\VCard();
        $this->logger = Logger::getInstance();
    }

    /**
     * Return the current vCard as a string.
     */
    public function getContact()
    {
        return $this->vcard->serialize();
    }

    /**
     * Load vCard data from a string.
     */
    public function setContact($vCardString)
    {
        $this->vcard = VObject\Reader::read($vCardString);
    }

    /**
     * Map JSContact ContactCard to vCard.
     */
    public function setFromJmap(ContactCard $card)
    {
        $this->setNameFromJmap($card);
        $this->setFnFromJmap($card);

        $this->setNicknameFromJmap($card);
        $this->setOrganizationFromJmap($card);
        $this->setTitlesFromJmap($card);
        $this->setNotesFromJmap($card);

        $this->setEmailsFromJmap($card);
        $this->setPhonesFromJmap($card);
        $this->setOnlineFromJmap($card);
        $this->setAddressesFromJmap($card);

        $this->setAnniversariesFromJmap($card);
        $this->setRelatedToFromJmap($card);
        $this->setMembersFromJmap($card);
    }

    /**
     * Map vCard to JSContact ContactCard.
     */
    public function setOnJmap(ContactCard $card)
    {
        $this->setNameOnJmap($card);
        $this->setNicknameOnJmap($card);
        $this->setOrganizationOnJmap($card);
        $this->setTitlesOnJmap($card);
        $this->setNotesOnJmap($card);

        $this->setEmailsOnJmap($card);
        $this->setPhonesOnJmap($card);
        $this->setOnlineOnJmap($card);
        $this->setAddressesOnJmap($card);

        $this->setAnniversariesOnJmap($card);
        $this->setRelatedToOnJmap($card);
        $this->setMembersOnJmap($card);
    }

    /**
     * Set the vCard N value.
     */
    protected function setName($lastName, $firstName, $middleName, $prefix, $suffix)
    {
        $lastName   = AdapterUtil::isSetAndNotNull($lastName)   && $lastName   !== '' ? $lastName   : '';
        $firstName  = AdapterUtil::isSetAndNotNull($firstName)  && $firstName  !== '' ? $firstName  : '';
        $middleName = AdapterUtil::isSetAndNotNull($middleName) && $middleName !== '' ? $middleName : '';
        $prefix     = AdapterUtil::isSetAndNotNull($prefix)     && $prefix     !== '' ? $prefix     : '';
        $suffix     = AdapterUtil::isSetAndNotNull($suffix)     && $suffix     !== '' ? $suffix     : '';

        $prop = $this->vcard->createProperty(
            'N',
            array($lastName, $firstName, $middleName, $prefix, $suffix)
        );
        $this->vcard->add($prop);
    }

    /**
     * Get the given name from vCard N.
     */
    protected function getFirstName()
    {
        $n = $this->vcard->N;
        if (AdapterUtil::isSetAndNotNull($n)) {
            $parts = $n->getParts();
            return isset($parts[1]) ? $parts[1] : null;
        }
        return null;
    }

    /**
     * Get the family name from vCard N.
     */
    protected function getLastName()
    {
        $n = $this->vcard->N;
        if (AdapterUtil::isSetAndNotNull($n)) {
            $parts = $n->getParts();
            return isset($parts[0]) ? $parts[0] : null;
        }
        return null;
    }

    /**
     * Get the middle name from vCard N.
     */
    protected function getMiddlename()
    {
        $n = $this->vcard->N;
        if (AdapterUtil::isSetAndNotNull($n)) {
            $parts = $n->getParts();
            if (isset($parts[2])) {
                $middle = $parts[2];
                if (AdapterUtil::isSetAndNotNull($middle) && $middle !== '') {
                    return $middle;
                }
            }
        }
        return null;
    }

    /**
     * Get the prefix from vCard N.
     */
    protected function getPrefix()
    {
        $n = $this->vcard->N;
        if (AdapterUtil::isSetAndNotNull($n)) {
            $parts = $n->getParts();
            return isset($parts[3]) ? $parts[3] : null;
        }
        return null;
    }

    /**
     * Get the suffix from vCard N.
     */
    protected function getSuffix()
    {
        $n = $this->vcard->N;
        if (AdapterUtil::isSetAndNotNull($n)) {
            $parts = $n->getParts();
            return isset($parts[4]) ? $parts[4] : null;
        }
        return null;
    }

    /**
     * Set the vCard FN value.
     */
    protected function setDisplayname($displayname)
    {
        if (AdapterUtil::isSetAndNotNull($displayname) && $displayname !== '') {
            $this->vcard->add('FN', $displayname);
        }
    }

    /**
     * Get the vCard FN value.
     */
    protected function getDisplayname()
    {
        $fn = $this->vcard->FN;
        if (AdapterUtil::isSetAndNotNull($fn) && !empty($fn)) {
            $parts = $fn->getParts();
            return isset($parts[0]) ? $parts[0] : null;
        }
        return null;
    }

    /**
     * Map JSContact name to vCard N.
     */
    public function setNameFromJmap(ContactCard $card)
    {
        $name    = $card->getName();
        $family  = null;
        $given   = null;
        $middle  = null;
        $prefix  = null;
        $suffix  = null;

        if ($name instanceof Name) {
            $components = $name->getComponents();
            if (is_array($components)) {
                foreach ($components as $component) {
                    $kind  = method_exists($component, 'getKind') ? $component->getKind() : null;
                    $value = method_exists($component, 'getValue') ? $component->getValue() : null;

                    if ($kind === 'surname') {
                        $family = $value;
                    } elseif ($kind === 'given') {
                        $given = $value;
                    } elseif ($kind === 'middle') {
                        $middle = $value;
                    } elseif ($kind === 'prefix') {
                        $prefix = $value;
                    } elseif ($kind === 'suffix') {
                        $suffix = $value;
                    }
                }
            }
        }

        $this->setName($family, $given, $middle, $prefix, $suffix);
    }

    /**
     * Map JSContact name.full to vCard FN.
     */
    public function setFnFromJmap(ContactCard $card)
    {
        $name = $card->getName();
        $full = ($name instanceof Name && method_exists($name, 'getFull'))
            ? $name->getFull()
            : null;

        if ($full !== null) {
            $this->setDisplayname($full);
        }
    }

    /**
     * Map vCard N/FN to JSContact name.
     */
    public function setNameOnJmap(ContactCard $card)
    {
        $family = $this->getLastName();
        $given  = $this->getFirstName();
        $middle = $this->getMiddlename();
        $prefix = $this->getPrefix();
        $suffix = $this->getSuffix();
        $fn     = $this->getDisplayname();

        $name = new Name();

        if ($fn !== null && method_exists($name, 'setFull')) {
            $name->setFull($fn);
        }

        $components = array();

        if ($prefix) {
            $c = new NameComponent();
            $c->setKind('prefix');
            $c->setValue($prefix);
            $components[] = $c;
        }
        if ($given) {
            $c = new NameComponent();
            $c->setKind('given');
            $c->setValue($given);
            $components[] = $c;
        }
        if ($middle) {
            $c = new NameComponent();
            $c->setKind('middle');
            $c->setValue($middle);
            $components[] = $c;
        }
        if ($family) {
            $c = new NameComponent();
            $c->setKind('surname');
            $c->setValue($family);
            $components[] = $c;
        }
        if ($suffix) {
            $c = new NameComponent();
            $c->setKind('suffix');
            $c->setValue($suffix);
            $components[] = $c;
        }

        if (!empty($components)) {
            $name->setIsOrdered(true);
            $name->setComponents($components);
        }

        $card->setName($name);
    }

    /**
     * Set vCard NICKNAME from a string.
     */
    protected function setNickname($nickname)
    {
        if (AdapterUtil::isSetAndNotNull($nickname) && $nickname !== '') {
            $this->vcard->add('NICKNAME', $nickname);
        }
    }

    /**
     * Get vCard NICKNAME as a string.
     */
    protected function getNickname()
    {
        $nn = $this->vcard->NICKNAME;
        if (AdapterUtil::isSetAndNotNull($nn)) {
            $parts = $nn->getParts();
            return isset($parts[0]) ? $parts[0] : null;
        }
        return null;
    }

    /**
     * Map JSContact nicknames to vCard NICKNAME.
     */
    public function setNicknameFromJmap(ContactCard $card)
    {
        $nicks = $card->getNicknames();
        if (!is_array($nicks) || empty($nicks)) {
            return;
        }
        $first = reset($nicks);
        if ($first instanceof Nickname && method_exists($first, 'getName')) {
            $this->setNickname($first->getName());
        }
    }

    /**
     * Map vCard NICKNAME to JSContact nicknames.
     */
    public function setNicknameOnJmap(ContactCard $card)
    {
        $nickname = $this->getNickname();
        if (!empty($nickname)) {
            $nickObj = new Nickname();
            $nickObj->setName($nickname);
            $card->setNicknames(array('n1' => $nickObj));
        }
    }

    /**
     * Set vCard ORG from a string.
     */
    protected function setOrganization($organization)
    {
        if (AdapterUtil::isSetAndNotNull($organization) && $organization !== '') {
            $this->vcard->add('ORG', $organization);
        }
    }

    /**
     * Get vCard ORG as a string.
     */
    protected function getOrganization()
    {
        $org = $this->vcard->ORG;
        if (AdapterUtil::isSetAndNotNull($org) && !empty($org)) {
            $parts = $org->getParts();
            return isset($parts[0]) ? $parts[0] : null;
        }
        return null;
    }

    /**
     * Map JSContact organizations to vCard ORG.
     */
    public function setOrganizationFromJmap(ContactCard $card)
    {
        $orgs = $card->getOrganizations();
        if (!is_array($orgs) || empty($orgs)) {
            return;
        }
        $first = reset($orgs);
        if ($first instanceof Organization && method_exists($first, 'getName')) {
            $this->setOrganization($first->getName());
        }
    }

    /**
     * Map vCard ORG to JSContact organizations.
     */
    public function setOrganizationOnJmap(ContactCard $card)
    {
        $orgName = $this->getOrganization();
        if (!empty($orgName)) {
            $org = new Organization();
            $org->setName($orgName);
            $card->setOrganizations(array('o1' => $org));
        }
    }

    /**
     * Map JSContact titles to vCard TITLE and ROLE.
     */
    public function setTitlesFromJmap(ContactCard $card)
    {
        $titles = $card->getTitles();
        if (!is_array($titles) || empty($titles)) {
            return;
        }

        foreach ($titles as $titleObj) {
            if (!($titleObj instanceof Title)) {
                continue;
            }

            $kind = method_exists($titleObj, 'getKind') ? $titleObj->getKind() : null;
            $name = method_exists($titleObj, 'getName') ? $titleObj->getName() : null;

            if ($name === null || $name === '') {
                continue;
            }

            if ($kind === 'role') {
                $this->vcard->add('ROLE', $name);
            } else {
                $this->vcard->add('TITLE', $name);
            }
        }
    }

    /**
     * Map vCard TITLE and ROLE to JSContact titles.
     */
    public function setTitlesOnJmap(ContactCard $card)
    {
        $map = array();
        $idx = 1;

        $vTitles = $this->vcard->TITLE;
        if (AdapterUtil::isSetAndNotNull($vTitles) && !empty($vTitles)) {
            foreach ($vTitles as $vTitle) {
                $parts = $vTitle->getParts();
                if (!isset($parts[0]) || $parts[0] === '') {
                    continue;
                }
                $name = $parts[0];

                $t = new Title();
                if (method_exists($t, 'setKind')) {
                    $t->setKind('title');
                }
                $t->setName($name);

                $map['t' . $idx++] = $t;
            }
        }

        $vRoles = $this->vcard->ROLE;
        if (AdapterUtil::isSetAndNotNull($vRoles) && !empty($vRoles)) {
            foreach ($vRoles as $vRole) {
                $parts = $vRole->getParts();
                if (!isset($parts[0]) || $parts[0] === '') {
                    continue;
                }
                $name = $parts[0];

                $t = new Title();
                if (method_exists($t, 'setKind')) {
                    $t->setKind('role');
                }
                $t->setName($name);

                $map['t' . $idx++] = $t;
            }
        }

        if (!empty($map)) {
            $card->setTitles($map);
        }
    }

    /**
     * Set vCard NOTE from a string.
     */
    protected function setNotes($notes)
    {
        if (AdapterUtil::isSetAndNotNull($notes) && $notes !== '') {
            $this->vcard->add('NOTE', $notes);
        }
    }

    /**
     * Get vCard NOTE as a string.
     */
    protected function getNotes()
    {
        $note = $this->vcard->NOTE;
        if (AdapterUtil::isSetAndNotNull($note)) {
            return $note->getValue();
        }
        return null;
    }

    /**
     * Map JSContact notes to vCard NOTE.
     */
    public function setNotesFromJmap(ContactCard $card)
    {
        $notes = $card->getNoteObjects();
        if (!is_array($notes) || empty($notes)) {
            return;
        }
        $first = reset($notes);
        if ($first instanceof Note && method_exists($first, 'getNote')) {
            $this->setNotes($first->getNote());
        }
    }

    /**
     * Map vCard NOTE to JSContact notes.
     */
    public function setNotesOnJmap(ContactCard $card)
    {
        $noteText = $this->getNotes();
        if (!empty($noteText)) {
            $note = new Note();
            $note->setNote($noteText);
            $card->setNoteObjects(array('n1' => $note));
        }
    }

    /**
     * Get birthday from vCard BDAY.
     */
    protected function getBirthday()
    {
        $bday = $this->vcard->BDAY;
        if (!AdapterUtil::isSetAndNotNull($bday)) {
            return '0000-00-00';
        }

        $parts = $bday->getParts();
        if (!isset($parts[0])) {
            return '0000-00-00';
        }

        $input  = 'Y-m-d';
        $output = 'Y-m-d';
        $alt    = 'Ymd';
        $jmap   = AdapterUtil::parseDateTime($parts[0], $input, $output, $alt);
        if ($jmap === null) {
            return '0000-00-00';
        }
        return $jmap;
    }

    /**
     * Set vCard BDAY from a date string.
     */
    protected function setBirthday($birthday)
    {
        if (!AdapterUtil::isSetAndNotNull($birthday) || $birthday === '' || $birthday === '0000-00-00') {
            return;
        }

        $input  = 'Y-m-d';
        $output = 'Y-m-d';
        $vDate  = AdapterUtil::parseDateTime($birthday, $input, $output);

        if ($vDate === null) {
            return;
        }

        $this->vcard->add(
            'BDAY',
            $vDate,
            array('value' => 'date')
        );
    }

    /**
     * Get anniversary from vCard ANNIVERSARY.
     */
    protected function getAnniversary()
    {
        $ann = $this->vcard->__get('ANNIVERSARY');
        if (!AdapterUtil::isSetAndNotNull($ann)) {
            return '0000-00-00';
        }

        $parts = $ann->getParts();
        if (!isset($parts[0])) {
            return '0000-00-00';
        }

        $input  = 'Ymd';
        $alt    = 'Y-m-d';
        $output = 'Y-m-d';
        $jmap   = AdapterUtil::parseDateTime($parts[0], $input, $output, $alt);
        if ($jmap === null) {
            return '0000-00-00';
        }
        return $jmap;
    }

    /**
     * Set vCard ANNIVERSARY from a date string.
     */
    protected function setAnniversary($anniversary)
    {
        if (
            !AdapterUtil::isSetAndNotNull($anniversary)
            || $anniversary === ''
            || $anniversary === '0000-00-00'
        ) {
            return;
        }

        $input  = 'Y-m-d';
        $output = 'Ymd';
        $vDate  = AdapterUtil::parseDateTime($anniversary, $input, $output);
        if ($vDate === null) {
            return;
        }

        $this->vcard->add(
            'ANNIVERSARY',
            $vDate,
            array('value' => 'date')
        );
    }

    /**
     * Map JSContact anniversaries to vCard dates.
     */
    public function setAnniversariesFromJmap(ContactCard $card)
    {
        $anns = $card->getAnniversaries();
        if (!is_array($anns)) {
            return;
        }

        $birth = null;
        $other = null;

        foreach ($anns as $ann) {
            if (!($ann instanceof Anniversary)) {
                continue;
            }
            $kind = method_exists($ann, 'getKind') ? $ann->getKind() : null;
            $date = method_exists($ann, 'getDate') ? $ann->getDate() : null;
            if ($kind === 'birth' && $birth === null) {
                $birth = $date;
            } elseif ($kind === 'other' && $other === null) {
                $other = $date;
            }
        }

        if ($birth) {
            $this->setBirthday($birth);
        }
        if ($other) {
            $this->setAnniversary($other);
        }
    }

    /**
     * Map vCard dates to JSContact anniversaries.
     */
    public function setAnniversariesOnJmap(ContactCard $card)
    {
        $anns = array();

        $birthday = $this->getBirthday();
        if ($birthday !== '0000-00-00') {
            $a = new Anniversary();
            $a->setKind('birth');
            $a->setDate($birthday);
            $anns[] = $a;
        }

        $anniv = $this->getAnniversary();
        if ($anniv !== '0000-00-00') {
            $a = new Anniversary();
            $a->setKind('other');
            $a->setDate($anniv);
            $anns[] = $a;
        }

        if (!empty($anns)) {
            $card->setAnniversaries($anns);
        }
    }

    /**
     * Add vCard EMAIL properties.
     */
    protected function setEmails(array $emails)
    {
        foreach ($emails as $e) {
            $value = isset($e['value']) ? $e['value'] : null;
            if (!AdapterUtil::isSetAndNotNull($value) || $value === '') {
                continue;
            }
            $this->vcard->add(
                'EMAIL',
                $value,
                array('type' => array('internet'))
            );
        }
    }

    /**
     * Get vCard EMAIL values.
     */
    protected function getEmails()
    {
        $result  = array();
        $vEmails = $this->vcard->EMAIL;

        if (!AdapterUtil::isSetAndNotNull($vEmails) || empty($vEmails)) {
            return $result;
        }

        foreach ($vEmails as $email) {
            $parts = $email->getParts();
            if (!isset($parts[0])) {
                continue;
            }
            $value = $parts[0];
            if (!AdapterUtil::isSetAndNotNull($value) || $value === '') {
                continue;
            }
            $result[] = array('value' => $value);
        }

        return $result;
    }

    /**
     * Map JSContact emails to vCard EMAIL.
     */
    public function setEmailsFromJmap(ContactCard $card)
    {
        $emails = $card->getEmails();
        if (!is_array($emails)) {
            return;
        }

        $vcard = array();
        foreach ($emails as $email) {
            if (!($email instanceof EmailAddress)) {
                continue;
            }

            $vcard[] = array(
                'value' => method_exists($email, 'getAddress') ? $email->getAddress() : null,
            );
        }

        $this->setEmails($vcard);
    }

    /**
     * Map vCard EMAIL to JSContact emails.
     */
    public function setEmailsOnJmap(ContactCard $card)
    {
        $emails = $this->getEmails();
        if (empty($emails)) {
            return;
        }

        $map = array();
        foreach ($emails as $idx => $email) {
            $e = new EmailAddress();
            if (is_array($email)) {
                $e->setAddress(isset($email['value']) ? $email['value'] : null);
            } else {
                $e->setAddress($email);
            }
            $map['e' . $idx] = $e;
        }

        $card->setEmails($map);
    }

    /**
     * Add vCard TEL properties.
     */
    protected function setPhones(array $phones)
    {
        foreach ($phones as $p) {
            $value = isset($p['value']) ? $p['value'] : null;
            if (!AdapterUtil::isSetAndNotNull($value) || $value === '') {
                continue;
            }
            $this->vcard->add('TEL', $value);
        }
    }

    /**
     * Get vCard TEL values.
     */
    protected function getPhones()
    {
        $result   = array();
        $vPhones  = $this->vcard->TEL;

        if (!AdapterUtil::isSetAndNotNull($vPhones) || empty($vPhones)) {
            return $result;
        }

        foreach ($vPhones as $phone) {
            $parts = $phone->getParts();
            if (!isset($parts[0])) {
                continue;
            }
            $value = $parts[0];
            if (!AdapterUtil::isSetAndNotNull($value) || $value === '') {
                continue;
            }
            $result[] = array('value' => $value);
        }

        return $result;
    }

    /**
     * Map JSContact phones to vCard TEL.
     */
    public function setPhonesFromJmap(ContactCard $card)
    {
        $phones = $card->getPhones();
        if (!is_array($phones)) {
            return;
        }

        $vcard = array();
        foreach ($phones as $phone) {
            if (!($phone instanceof Phone)) {
                continue;
            }

            $vcard[] = array(
                'value' => method_exists($phone, 'getNumber') ? $phone->getNumber() : null,
            );
        }

        $this->setPhones($vcard);
    }

    /**
     * Map vCard TEL to JSContact phones.
     */
    public function setPhonesOnJmap(ContactCard $card)
    {
        $phones = $this->getPhones();
        if (empty($phones)) {
            return;
        }

        $map = array();
        foreach ($phones as $idx => $phone) {
            $p = new Phone();
            if (is_array($phone)) {
                $p->setNumber(isset($phone['value']) ? $phone['value'] : null);
            } else {
                $p->setNumber($phone);
            }
            $map['p' . $idx] = $p;
        }

        $card->setPhones($map);
    }

    /**
     * Add vCard URL properties.
     */
    protected function setWebsites(array $websites)
    {
        foreach ($websites as $w) {
            $value = isset($w['value']) ? $w['value'] : null;
            if (!AdapterUtil::isSetAndNotNull($value) || $value === '') {
                continue;
            }
            $this->vcard->add('URL', $value, array('value' => 'uri'));
        }
    }

    /**
     * Get vCard URL values.
     */
    protected function getWebsites()
    {
        $result = array();
        $vUrls  = $this->vcard->URL;

        if (!AdapterUtil::isSetAndNotNull($vUrls) || empty($vUrls)) {
            return $result;
        }

        foreach ($vUrls as $url) {
            $parts = $url->getParts();
            if (!isset($parts[0])) {
                continue;
            }
            $value = $parts[0];
            if (!AdapterUtil::isSetAndNotNull($value) || $value === '') {
                continue;
            }
            $result[] = array('value' => $value);
        }

        return $result;
    }

    /**
     * Add vCard IMPP properties.
     */
    protected function setIm(array $ims)
    {
        foreach ($ims as $im) {
            $value = isset($im['value']) ? $im['value'] : null;
            if (!AdapterUtil::isSetAndNotNull($value) || $value === '') {
                continue;
            }
            $this->vcard->add('IMPP', $value);
        }
    }

    /**
     * Get vCard IMPP values.
     */
    protected function getIm()
    {
        $result = array();
        $vIms   = $this->vcard->IMPP;

        if (!AdapterUtil::isSetAndNotNull($vIms) || empty($vIms)) {
            return $result;
        }

        foreach ($vIms as $im) {
            $parts = $im->getParts();
            if (!isset($parts[0])) {
                continue;
            }
            $value = $parts[0];
            if (!AdapterUtil::isSetAndNotNull($value) || $value === '') {
                continue;
            }
            $result[] = array('value' => $value);
        }

        return $result;
    }

    /**
     * Map JSContact onlineServices to vCard URL/IMPP.
     */
    public function setOnlineFromJmap(ContactCard $card)
    {
        $online = $card->getOnlineServices();
        if (!is_array($online)) {
            return;
        }

        $websites = array();
        $ims      = array();

        foreach ($online as $os) {
            if (!($os instanceof OnlineService) || !method_exists($os, 'getUri')) {
                continue;
            }
            $entry = array('value' => $os->getUri());
            $kind  = method_exists($os, 'getService') ? $os->getService() : null;

            if ($kind === 'im') {
                $ims[] = $entry;
            } else {
                $websites[] = $entry;
            }
        }

        $this->setWebsites($websites);
        $this->setIm($ims);
    }

    /**
     * Map vCard URL/IMPP to JSContact onlineServices.
     */
    public function setOnlineOnJmap(ContactCard $card)
    {
        $websites = $this->getWebsites();
        $ims      = $this->getIm();

        if (empty($websites) && empty($ims)) {
            return;
        }

        $map = array();
        $idx = 1;

        foreach ($websites as $entry) {
            $o = new OnlineService();
            $uri = is_array($entry) && isset($entry['value']) ? $entry['value'] : $entry;
            $o->setUri($uri);
            $map['os' . $idx++] = $o;
        }

        foreach ($ims as $entry) {
            $o = new OnlineService();
            $uri = is_array($entry) && isset($entry['value']) ? $entry['value'] : $entry;
            $o->setUri($uri);
            if (method_exists($o, 'setService')) {
                $o->setService('im');
            }
            $map['os' . $idx++] = $o;
        }

        $card->setOnlineServices($map);
    }

    /**
     * Add vCard ADR properties.
     */
    protected function setAddresses(array $addresses)
    {
        foreach ($addresses as $addr) {
            $formatted = isset($addr['formatted']) ? $addr['formatted'] : '';
            if ($formatted === '') {
                continue;
            }

            $this->vcard->add(
                'ADR',
                array('', '', $formatted, '', '', '', '')
            );
        }
    }

    /**
     * Get vCard ADR values.
     */
    protected function getAddresses()
    {
        $result  = array();
        $vAddrs  = $this->vcard->ADR;

        if (!AdapterUtil::isSetAndNotNull($vAddrs) || empty($vAddrs)) {
            return $result;
        }

        foreach ($vAddrs as $vAddr) {
            $parts = $vAddr->getParts();
            if (!AdapterUtil::isSetAndNotNull($parts) || empty($parts)) {
                continue;
            }
            $result[] = array('formatted' => isset($parts[2]) ? $parts[2] : '');
        }

        return $result;
    }

    /**
     * Map JSContact addresses to vCard ADR.
     */
    public function setAddressesFromJmap(ContactCard $card)
    {
        $addresses = $card->getAddresses();
        if (!is_array($addresses)) {
            return;
        }

        $vcard = array();
        foreach ($addresses as $address) {
            if (!($address instanceof Address)) {
                continue;
            }
            $formatted = method_exists($address, 'getFullAddress')
                ? $address->getFullAddress()
                : null;
            $vcard[] = array('formatted' => $formatted);
        }

        $this->setAddresses($vcard);
    }

    /**
     * Map vCard ADR to JSContact addresses.
     */
    public function setAddressesOnJmap(ContactCard $card)
    {
        $addresses = $this->getAddresses();
        if (empty($addresses)) {
            return;
        }

        $map = array();
        foreach ($addresses as $idx => $addr) {
            $a = new Address();
            if (is_array($addr) && isset($addr['formatted']) && method_exists($a, 'setFullAddress')) {
                $a->setFullAddress($addr['formatted']);
            }
            $map['a' . $idx] = $a;
        }

        $card->setAddresses($map);
    }

    /**
     * Map JSContact relatedTo to vCard RELATED.
     */
    public function setRelatedToFromJmap(ContactCard $card)
    {
        if (!method_exists($card, 'getRelatedTo')) {
            return;
        }

        $relatedTo = $card->getRelatedTo();
        if (!is_array($relatedTo) || empty($relatedTo)) {
            return;
        }

        foreach ($relatedTo as $key => $relationObj) {
            if ($key === null || $key === '') {
                continue;
            }

            if (!is_object($relationObj) || !method_exists($relationObj, 'getRelation')) {
                $this->vcard->add('RELATED', $key);
                continue;
            }

            $relationMap = $relationObj->getRelation();
            $types = array();
            if (is_array($relationMap)) {
                foreach ($relationMap as $type => $flag) {
                    if ($flag) {
                        $types[] = $type;
                    }
                }
            }

            if (empty($types)) {
                $this->vcard->add('RELATED', $key);
            } else {
                $this->vcard->add(
                    'RELATED',
                    $key,
                    array('TYPE' => $types)
                );
            }
        }
    }

    /**
     * Map vCard RELATED to JSContact relatedTo.
     */
    public function setRelatedToOnJmap(ContactCard $card)
    {
        if (!method_exists($card, 'setRelatedTo')) {
            return;
        }

        $vRelated = $this->vcard->RELATED;
        if (!AdapterUtil::isSetAndNotNull($vRelated) || empty($vRelated)) {
            return;
        }

        $relatedMap = array();

        foreach ($vRelated as $rel) {
            $parts = $rel->getParts();
            if (!isset($parts[0]) || $parts[0] === '') {
                continue;
            }
            $key = $parts[0];

            $relationTypes = array();
            if (isset($rel['TYPE'])) {
                $typeParam = $rel['TYPE'];
                $typeParts = $typeParam->getParts();
                if (is_array($typeParts)) {
                    foreach ($typeParts as $type) {
                        if ($type === '' || $type === null) {
                            continue;
                        }
                        $relationTypes[$type] = true;
                    }
                }
            }

            $relationObj = new Relation();
            $relationObj->setRelation($relationTypes);

            $relatedMap[$key] = $relationObj;
        }

        if (!empty($relatedMap)) {
            $card->setRelatedTo($relatedMap);
        }
    }

    /**
     * Map JSContact members to vCard MEMBER.
     */
    public function setMembersFromJmap(ContactCard $card)
    {
        if (!method_exists($card, 'getMembers')) {
            return;
        }

        $members = $card->getMembers();
        if (!is_array($members) || empty($members)) {
            return;
        }

        $wroteMember = false;

        foreach ($members as $uid => $flag) {
            if ($uid === null || $uid === '' || $flag !== true) {
                continue;
            }

            $this->vcard->add(
                'MEMBER',
                $uid,
                array('VALUE' => 'uri')
            );
            $wroteMember = true;
        }

        if ($wroteMember) {
            if (isset($this->vcard->KIND)) {
                $this->vcard->KIND = 'group';
            } else {
                $this->vcard->add('KIND', 'group');
            }
        }
    }

    /**
     * Map vCard MEMBER to JSContact members.
     */
    public function setMembersOnJmap(ContactCard $card)
    {
        if (!method_exists($card, 'setMembers')) {
            return;
        }

        $vMembers = $this->vcard->MEMBER;
        if (!AdapterUtil::isSetAndNotNull($vMembers) || empty($vMembers)) {
            return;
        }

        $members = array();

        foreach ($vMembers as $m) {
            $parts = $m->getParts();
            if (!isset($parts[0]) || $parts[0] === '') {
                continue;
            }
            $uri = $parts[0];
            $members[$uri] = true;
        }

        if (!empty($members)) {
            $card->setMembers($members);
            if (method_exists($card, 'setKind')) {
                $card->setKind('group');
            }
        }
    }
}
