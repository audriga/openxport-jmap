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
use OpenXPort\Jmap\JSContact\AddressComponent;
use OpenXPort\Jmap\JSContact\Anniversary;
use OpenXPort\Jmap\JSContact\Relation;
use OpenXPort\Jmap\JSContact\LanguagePref;
use OpenXPort\Jmap\JSContact\PersonalInformation;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;
use Sabre\VObject;

class VCardJsContactAdapter extends AbstractAdapter
{
    protected $vcard;
    protected $logger;
    protected $rawVCard;

    protected $placeTextAsFullAddress = false;
    protected $mapVcardAnniversaryToWedding = true;

    /**
     * Initializes the adapter with an empty vCard and logger instance.
     */
    public function __construct()
    {
        $this->vcard  = new VObject\Component\VCard();
        $this->logger = Logger::getInstance();
        $this->rawVCard = null;
    }

    /**
     * Returns the current vCard as a serialized string.
     */
    public function getContact()
    {
        return $this->vcard->serialize();
    }

    /**
     * Parses and sets the internal vCard from a vCard string.
     */
    public function setContact($vCardString)
    {
        $this->rawVCard = is_string($vCardString) ? $vCardString : null;
        $this->vcard = VObject\Reader::read($vCardString);
    }

    /**
     * Populates vCard fields from a JSContact ContactCard (https://datatracker.ietf.org/doc/rfc9553/).
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
        $this->setPreferredLanguagesFromJmap($card);
        $this->setKeywordsFromJmap($card);
        $this->setPersonalInfoFromJmap($card);
    }

    /**
     * Converts a vCard TYPE parameter into a JSContact contexts map.
     */
    protected function vcardTypeParamToContexts($prop)
    {
        $contexts = array();

        if (isset($prop['TYPE'])) {
            $types = $prop['TYPE']->getParts();
            if (is_array($types)) {
                foreach ($types as $t) {
                    $t = strtolower(trim((string) $t));
                    if ($t === 'home') {
                        $contexts['private'] = true;
                    } elseif ($t === 'work') {
                        $contexts['work'] = true;
                    }
                }
            }
        }

        return $contexts;
    }

    /**
     * Converts a vCard PREF parameter to an integer preference value.
     */
    protected function vcardPrefParamToInt($prop)
    {
        if (!isset($prop['PREF'])) {
            return null;
        }
        $raw = trim((string) $prop['PREF']);
        if ($raw === '' || !ctype_digit($raw)) {
            return null;
        }
        $n = (int) $raw;
        return $n > 0 ? $n : null;
    }

    /**
     * Converts JSContact contexts into a vCard TYPE parameter list.
     */
    protected function contextsToVcardTypeParam($obj)
    {
        $types = array();

        if (is_object($obj)) {
            $ctx = $obj->getContexts();
            if (is_array($ctx)) {
                if (!empty($ctx['private'])) {
                    $types[] = 'home';
                }
                if (!empty($ctx['work'])) {
                    $types[] = 'work';
                }
            }
        }

        return $types;
    }

    /**
     * Converts a JSContact pref value into a vCard PREF parameter string.
     */
    protected function prefToVcardParam($obj)
    {
        if (!is_object($obj)) {
            return null;
        }
        $pref = $obj->getPref();
        if ($pref === null) {
            return null;
        }
        $pref = (int) $pref;
        return $pref > 0 ? (string) $pref : null;
    }

    /**
     * Sets the vCard N property from individual name components.
     */
    protected function setName($lastName, $firstName, $middleName, $prefix, $suffix)
    {
        $lastName   = AdapterUtil::isSetAndNotNull($lastName)   && $lastName   !== '' ? $lastName   : '';
        $firstName  = AdapterUtil::isSetAndNotNull($firstName)  && $firstName  !== '' ? $firstName  : '';
        $middleName = AdapterUtil::isSetAndNotNull($middleName) && $middleName !== '' ? $middleName : '';
        $prefix     = AdapterUtil::isSetAndNotNull($prefix)     && $prefix     !== '' ? $prefix     : '';
        $suffix     = AdapterUtil::isSetAndNotNull($suffix)     && $suffix     !== '' ? $suffix     : '';

        $prop = $this->vcard->createProperty('N', array($lastName, $firstName, $middleName, $prefix, $suffix));
        $this->vcard->add($prop);
    }

    /**
     * Returns the given name from the vCard N property.
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
     * Returns the surname from the vCard N property.
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
     * Returns the middle name from the vCard N property.
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
     * Returns the name prefix from the vCard N property.
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
     * Returns the name suffix from the vCard N property.
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
     * Sets the vCard FN property.
     */
    protected function setDisplayname($displayname)
    {
        if (AdapterUtil::isSetAndNotNull($displayname) && $displayname !== '') {
            $this->vcard->add('FN', $displayname);
        }
    }

    /**
     * Returns the vCard FN value.
     */
    protected function getDisplayname()
    {
        $fn = $this->vcard->FN;
        if (AdapterUtil::isSetAndNotNull($fn) && !empty($fn)) {
            return (string) $fn;
        }
        return null;
    }

    /**
     * Copies the JSContact Name object into the vCard N property.
     * JSContact -> vCard: write N and FN from ContactCard.name.
     *
     * - Reads card->getName().
     * - Uses Name.components/full to build vCard N (family, given, middle, prefix, suffix).
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
                    $kind  = $component->getKind();
                    $value = $component->getValue();

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
     * Copies the JSContact full name into the vCard FN property.
     */
    public function setFnFromJmap(ContactCard $card)
    {
        $name = $card->getName();
        $full = ($name instanceof Name)
            ? $name->getFull()
            : null;

        if (($full === null || $full === '') && $name instanceof Name) {
            $components = $name->getComponents();
            if (is_array($components)) {
                $given   = [];
                $middle  = [];
                $surname = [];

                foreach ($components as $component) {
                    $kind  = $component->getKind();
                    $value = $component->getValue();
                    if ($value === null || $value === '') {
                        continue;
                    }

                    if ($kind === 'given') {
                        $given[] = $value;
                    } elseif ($kind === 'middle') {
                        $middle[] = $value;
                    } elseif ($kind === 'surname') {
                        $surname[] = $value;
                    }
                }

                $parts = array_merge($given, $middle, $surname);
                if (!empty($parts)) {
                    $full = implode(' ', $parts);
                }
            }
        }

        if ($full !== null && $full !== '') {
            $this->setDisplayname($full); // FN
        }
    }

    /**
     * vCard -> JSContact: read N into ContactCard.name.
     *
     * - Reads N parts (family, given, middle, prefix, suffix) and FN.
     * - Creates a Name object with components for each non-empty part.
     * - Also sets Name.isOrdered=true and keeps parts in order.
     */
    public function getNameToJmap(ContactCard $card)
    {
        $family = $this->getLastName();
        $given  = $this->getFirstName();
        $middle = $this->getMiddlename();
        $prefix = $this->getPrefix();
        $suffix = $this->getSuffix();
        $fn     = $this->getDisplayname();

        $name = new Name();

        if ($fn !== null && $fn !== '') {
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
     * Sets the vCard NICKNAME property.
     * JSContact -> vCard: write NICKNAME from ContactCard.nicknames.
     */
    protected function setNickname($nickname)
    {
        if (AdapterUtil::isSetAndNotNull($nickname) && $nickname !== '') {
            $this->vcard->add('NICKNAME', $nickname);
        }
    }

    /**
     * Returns the vCard NICKNAME value.
     */
    protected function getNickname()
    {
        $nn = $this->vcard->NICKNAME;
        if (AdapterUtil::isSetAndNotNull($nn)) {
            return (string) $nn;
        }
        return null;
    }

    /**
     * Copies the first JSContact nickname into the vCard.
     * JSContact -> vCard: write NICKNAME from ContactCard.nicknames.
     *
     * - Takes the first Nickname object from card->getNicknames().
     * - Writes its name into a single NICKNAME property.
     */
    public function setNicknameFromJmap(ContactCard $card)
    {
        $nicks = $card->getNicknames();
        if (!is_array($nicks) || empty($nicks)) {
            return;
        }
        $first = reset($nicks);
        if ($first instanceof Nickname) {
            $this->setNickname($first->getName());
        }
    }

    /**
     * vCard -> JSContact: read NICKNAME into ContactCard.nicknames.
     *
     * - Reads the NICKNAME value (string).
     * - Creates one Nickname object and stores it under an Id (e.g. "n1").
     * - If NICKNAME is empty or missing, does nothing.
     */
    public function getNicknameToJmap(ContactCard $card)
    {
        $nickname = $this->getNickname();
        if (!empty($nickname)) {
            $nickObj = new Nickname();
            $nickObj->setName($nickname);
            $card->setNicknames(array('n1' => $nickObj));
        }
    }

    /**
     * Sets the vCard ORG property from name and unit parts.
     */
    protected function setOrganizationFromParts($name, array $units)
    {
        if (!AdapterUtil::isSetAndNotNull($name)) {
            $name = '';
        }
        $name = (string) $name;

        $parts = array_merge(array($name), $units);

        $hasAny = false;
        foreach ($parts as $p) {
            if (is_string($p) && trim($p) !== '') {
                $hasAny = true;
                break;
            }
        }
        if (!$hasAny) {
            return;
        }

        $this->vcard->add('ORG', $parts);
    }

    /**
     * Returns the vCard ORG property split into name and units.
     */
    protected function getOrganizationParts()
    {
        $org = $this->vcard->ORG;
        if (!AdapterUtil::isSetAndNotNull($org) || empty($org)) {
            return null;
        }

        $parts = $org->getParts();
        if (!is_array($parts) || empty($parts)) {
            $raw = trim((string) $org);
            if ($raw === '') {
                return null;
            }
            return array('name' => $raw, 'units' => array());
        }

        $name = isset($parts[0]) ? (string) $parts[0] : '';
        $units = array();
        for ($i = 1; $i < count($parts); $i++) {
            $u = (string) $parts[$i];
            if ($u !== '') {
                $units[] = $u;
            }
        }

        return array('name' => $name, 'units' => $units);
    }

    /**
     * JSContact -> vCard: write ORG from ContactCard.organizations.
     *
     * - Uses the first Organization from card->getOrganizations().
     * - Writes name and additional units into ORG parts.
     */
    public function setOrganizationFromJmap(ContactCard $card)
    {
        $orgs = $card->getOrganizations();
        if (!is_array($orgs) || empty($orgs)) {
            return;
        }

        $first = reset($orgs);
        if (!($first instanceof Organization)) {
            return;
        }

        $name = $first->getName();
        $units = array();

        $u = $first->getUnits();
        if (is_array($u)) {
            foreach ($u as $unitObj) {
                if (is_object($unitObj)) {
                    $unitName = $unitObj->getName();
                    if (is_string($unitName) && $unitName !== '') {
                        $units[] = $unitName;
                    }
                } elseif (is_string($unitObj) && $unitObj !== '') {
                    $units[] = $unitObj;
                }
            }
        }

        $this->setOrganizationFromParts($name, $units);
    }

    /**
     * Sets JSContact Organizations from the vCard ORG property.
     * vCard -> JSContact: read ORG into ContactCard.organizations.
     *
     * - Reads ORG parts: first as name, remaining as units.
     * - Builds a single Organization object with this data.
     * - If ORG is missing or empty, leaves organizations unset.
     */
    public function getOrganizationToJmap(ContactCard $card)
    {
        $parts = $this->getOrganizationParts();
        if ($parts === null) {
            return;
        }

        $org = new Organization();
        $org->setName($parts['name']);

        $unitObjs = array();
        foreach ($parts['units'] as $unitName) {
            $unitObjs[] = $unitName;
        }
        $org->setUnits($unitObjs);

        $card->setOrganizations(array('o1' => $org));
    }

    /**
     * Copies JSContact Titles into vCard TITLE and ROLE properties.
     * JSContact -> vCard: write TITLE properties from ContactCard.titles.
     *
     * - For each Title in card->getTitles(), writes its value as a TITLE line.
     * - Does not map any extra metadata (contexts, pref).
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

            $kind =  $titleObj->getKind();
            $name =  $titleObj->getName();

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
     * Sets JSContact Titles from vCard TITLE and ROLE properties.
     * - Creates one Title object per TITLE value.
     * - Stores them in an Id map on the ContactCard.
     */
    public function getTitlesToJmap(ContactCard $card)
    {
        $map = array();
        $idx = 1;

        $vTitles = $this->vcard->TITLE;
        if (AdapterUtil::isSetAndNotNull($vTitles) && !empty($vTitles)) {
            foreach ($vTitles as $vTitle) {
                $name = trim((string) $vTitle);
                if ($name === '') {
                    continue;
                }

                $t = new Title();
                $t->setKind('title');

                $t->setName($name);

                $map['t' . $idx++] = $t;
            }
        }

        $vRoles = $this->vcard->ROLE;
        if (AdapterUtil::isSetAndNotNull($vRoles) && !empty($vRoles)) {
            foreach ($vRoles as $vRole) {
                $name = trim((string) $vRole);
                if ($name === '') {
                    continue;
                }

                $t = new Title();
                $t->setKind('role');

                $t->setName($name);

                $map['t' . $idx++] = $t;
            }
        }

        if (!empty($map)) {
            $card->setTitles($map);
        }
    }

    /**
     * Sets the vCard NOTE property.
     */
    protected function setNotes($notes)
    {
        if (AdapterUtil::isSetAndNotNull($notes) && $notes !== '') {
            $this->vcard->add('NOTE', $notes);
        }
    }

    /**
     * Returns the vCard NOTE value.
     */
    protected function getNotes()
    {
        $note = $this->vcard->NOTE;
        if (AdapterUtil::isSetAndNotNull($note)) {
            return (string) $note;
        }
        return null;
    }

    /**
     * Copies the first JSContact Note into the vCard NOTE property.
     *
     * - Takes the first Note from card->getNoteObjects().
     * - Writes its text into a single NOTE property.
     */
    public function setNotesFromJmap(ContactCard $card)
    {
        $notes = $card->getNoteObjects();
        if (!is_array($notes) || empty($notes)) {
            return;
        }
        $first = reset($notes);
        if ($first instanceof Note) {
            $this->setNotes($first->getNote());
        }
    }

    /**
     * Sets JSContact Note objects from the vCard NOTE property.
     * - Reads the NOTE text.
     * - Creates one Note object and stores it in noteObjects.
     * - Does not parse multiple NOTE lines or ALTID/LANGUAGE variants.
     */
    public function getNotesToJmap(ContactCard $card)
    {
        $noteText = $this->getNotes();
        if (!empty($noteText)) {
            $note = new Note();
            $note->setNote($noteText);
            $card->setNoteObjects(array('n1' => $note));
        }
    }

    /**
     * Returns the birthday in JMAP date format or a default value.
     */
    protected function getBirthday()
    {
        $bday = $this->vcard->BDAY;
        if (!AdapterUtil::isSetAndNotNull($bday)) {
            return '0000-00-00';
        }

        $raw = trim((string) $bday);
        if ($raw === '') {
            return '0000-00-00';
        }

        $jmap = AdapterUtil::parseDateTime($raw, 'Y-m-d', 'Y-m-d', 'Ymd');
        return $jmap === null ? '0000-00-00' : $jmap;
    }

    /**
     * Sets the vCard BDAY property from a JMAP date.
     */
    protected function setBirthday($birthday)
    {
        if (!AdapterUtil::isSetAndNotNull($birthday) || $birthday === '' || $birthday === '0000-00-00') {
            return;
        }

        $vDate = AdapterUtil::parseDateTime($birthday, 'Y-m-d', 'Y-m-d');
        if ($vDate === null) {
            return;
        }

        $this->vcard->add('BDAY', $vDate, array('VALUE' => 'date'));
    }

    /**
     * Returns the ANNIVERSARY date in JMAP format or a default value.
     */
    protected function getAnniversary()
    {
        $ann = $this->vcard->__get('ANNIVERSARY');
        if (!AdapterUtil::isSetAndNotNull($ann)) {
            return '0000-00-00';
        }

        $raw = trim((string) $ann);
        if ($raw === '') {
            return '0000-00-00';
        }

        $jmap = AdapterUtil::parseDateTime($raw, 'Ymd', 'Y-m-d', 'Y-m-d');
        return $jmap === null ? '0000-00-00' : $jmap;
    }

    /**
     * Sets the vCard ANNIVERSARY property from a JMAP date.
     */
    protected function setAnniversary($anniversary)
    {
        if (!AdapterUtil::isSetAndNotNull($anniversary) || $anniversary === '' || $anniversary === '0000-00-00') {
            return;
        }

        $vDate = AdapterUtil::parseDateTime($anniversary, 'Y-m-d', 'Ymd');
        if ($vDate === null) {
            return;
        }

        $this->vcard->add('ANNIVERSARY', $vDate, array('VALUE' => 'date'));
    }

    /**
     * Returns the raw BIRTHPLACE text if present.
     */
    protected function getBirthPlaceRaw()
    {
        $p = $this->vcard->__get('BIRTHPLACE');
        if (!AdapterUtil::isSetAndNotNull($p)) {
            return null;
        }
        $raw = (string) $p;
        $raw = str_replace("\\n", "\n", $raw);
        $raw = trim($raw);
        return $raw === '' ? null : $raw;
    }

    /**
     * Returns the DEATHDATE in JMAP date format or a default value.
     */
    protected function getDeathDate()
    {
        $p = $this->vcard->__get('DEATHDATE');
        if (!AdapterUtil::isSetAndNotNull($p)) {
            return '0000-00-00';
        }

        $raw = trim((string) $p);
        if ($raw === '') {
            return '0000-00-00';
        }

        $jmap = AdapterUtil::parseDateTime($raw, 'Y-m-d', 'Y-m-d', 'Ymd');
        return $jmap === null ? '0000-00-00' : $jmap;
    }

    /**
     * Sets the vCard DEATHDATE property from a JMAP date.
     */
    protected function setDeathDate($deathDate)
    {
        if (!AdapterUtil::isSetAndNotNull($deathDate) || $deathDate === '' || $deathDate === '0000-00-00') {
            return;
        }
        $vDate = AdapterUtil::parseDateTime($deathDate, 'Y-m-d', 'Ymd');
        if ($vDate === null) {
            return;
        }
        $this->vcard->add('DEATHDATE', $vDate, array('VALUE' => 'date'));
    }

    /**
     * Returns the raw DEATHPLACE text if present.
     */
    protected function getDeathPlaceRaw()
    {
        $p = $this->vcard->__get('DEATHPLACE');
        if (!AdapterUtil::isSetAndNotNull($p)) {
            return null;
        }
        $raw = (string) $p;
        $raw = str_replace("\\n", "\n", $raw);
        $raw = trim($raw);
        return $raw === '' ? null : $raw;
    }

    /**
     * Converts a raw place string into a JSContact Address object.
     */
    protected function placeRawToAddress($raw)
    {
        if (!is_string($raw)) {
            return null;
        }
        $raw = trim($raw);
        if ($raw === '') {
            return null;
        }

        // geo: URI -> coordinates only
        if (stripos($raw, 'geo:') === 0) {
            $addr = new Address();
            $addr->setCoordinates(substr($raw, 4));
            return $addr;
        }

        // Non-geo textual value -> fullAddress, if enabled
        if ($this->placeTextAsFullAddress) {
            $addr = new Address();
            $addr->setFullAddress($raw);
            return $addr;
        }

        return null;
    }

    /**
     * Sets the vCard BIRTHPLACE property from an Address object.
     */
    protected function setBirthPlaceFromAddress(Address $addr)
    {
        $text = $addr->getFullAddress();
        if (!is_string($text) || trim($text) === '') {
            return;
        }
        $text = trim($text);
        if (stripos($text, 'geo:') === 0 || $this->placeTextAsFullAddress) {
            $this->vcard->add('BIRTHPLACE', $text);
        }
    }

    /**
     * Sets the vCard DEATHPLACE property from an Address object.
     */
    protected function setDeathPlaceFromAddress(Address $addr)
    {
        $text = $addr->getFullAddress();
        if (!is_string($text) || trim($text) === '') {
            return;
        }
        $text = trim($text);
        if (stripos($text, 'geo:') === 0 || $this->placeTextAsFullAddress) {
            $this->vcard->add('DEATHPLACE', $text);
        }
    }

    /**
     * JSContact -> vCard: write BDAY/DEATHDATE/ANNIVERSARY and places.
     *
     * - Anniversary(kind='birth') -> BDAY and optional BIRTHPLACE (from place).
     * - Anniversary(kind='death') -> DEATHDATE and optional DEATHPLACE.
     * - Anniversary(kind='other') -> ANNIVERSARY (if mapping enabled).
     * - Place Address.coordinates (geo: URI) and fullAddress are used.
     */
    public function setAnniversariesFromJmap(ContactCard $card)
    {
        $anns = $card->getAnniversaries();
        if (!is_array($anns) || empty($anns)) {
            return;
        }

        $birth   = null;
        $death   = null;
        $wedding = null;

        foreach ($anns as $ann) {
            if (!($ann instanceof Anniversary)) {
                continue;
            }

            $kind = $ann->getKind();

            if ($kind === 'birth' && $birth === null) {
                $birth = $ann;
            } elseif ($kind === 'death' && $death === null) {
                $death = $ann;
            } elseif (($kind === 'wedding' || $kind === 'other') && $wedding === null) {
                // JSContact kind "wedding" or generic "other" as a wedding anniversary
                $wedding = $ann;
            }
        }

        if ($birth instanceof Anniversary) {
            $this->setBirthday($birth->getDate());
            $place = $birth->getPlace();
            if ($place instanceof Address) {
                $this->setBirthPlaceFromAddress($place);
            }
        }

        if ($death instanceof Anniversary) {
            $this->setDeathDate($death->getDate());
            $place = $death->getPlace();
            if ($place instanceof Address) {
                $this->setDeathPlaceFromAddress($place);
            }
        }

        if ($this->mapVcardAnniversaryToWedding && $wedding instanceof Anniversary) {
            $this->setAnniversary($wedding->getDate());
        }
    }

    /**
     * Sets JSContact anniversaries from vCard birth, death and anniversary fields.
     * vCard -> JSContact: read BDAY/DEATHDATE/ANNIVERSARY into anniversaries.
     *
     * - BDAY/BIRTHPLACE -> Anniversary kind='birth'.
     * - DEATHDATE/DEATHPLACE -> Anniversary kind='death'.
     * - ANNIVERSARY -> Anniversary kind='other' (wedding).
     * - Place is stored as an Address (coordinates or fullAddress).
     */
    public function getAnniversariesToJmap(ContactCard $card)
    {
        $anns = array();

        $bday = $this->getBirthday();
        $bplace = $this->getBirthPlaceRaw();
        if ($bday !== '0000-00-00' || $bplace !== null) {
            $a = new Anniversary();
            $a->setKind('birth');
            if ($bday !== '0000-00-00') {
                $a->setDate($bday);
            }
            if ($bplace !== null) {
                $addr = $this->placeRawToAddress($bplace);
                if ($addr instanceof Address) {
                    $a->setPlace($addr);
                }
            }
            $anns[] = $a;
        }

        $ddate = $this->getDeathDate();
        $dplace = $this->getDeathPlaceRaw();
        if ($ddate !== '0000-00-00' || $dplace !== null) {
            $a = new Anniversary();
            $a->setKind('death');
            if ($ddate !== '0000-00-00') {
                $a->setDate($ddate);
            }
            if ($dplace !== null) {
                $addr = $this->placeRawToAddress($dplace);
                if ($addr instanceof Address) {
                    $a->setPlace($addr);
                }
            }
            $anns[] = $a;
        }

        if ($this->mapVcardAnniversaryToWedding) {
            $anniv = $this->getAnniversary();
            if ($anniv !== '0000-00-00') {
                $a = new Anniversary();
                $a->setKind('other');
                $a->setLabel('marriage date');
                $a->setDate($anniv);
                $anns[] = $a;
            }
        }

        if (!empty($anns)) {
            $card->setAnniversaries($anns);
        }
    }

    /**
     * Copies JSContact email addresses into vCard EMAIL properties.
     *
     * - For each EmailAddress:
     *   - email -> EMAIL value
     *   - contexts.private/work -> TYPE=home/work
     *   - pref -> PREF
     */
    public function setEmailsFromJmap(ContactCard $card)
    {
        $emails = $card->getEmails();
        if (!is_array($emails) || empty($emails)) {
            return;
        }

        foreach ($emails as $email) {
            if (!($email instanceof EmailAddress)) {
                continue;
            }

            $addr = $email->getAddress();
            if (!is_string($addr) || trim($addr) === '') {
                continue;
            }

            $params = array();

            $types = $this->contextsToVcardTypeParam($email);
            if (!empty($types)) {
                $params['TYPE'] = $types;
            }

            $pref = $this->prefToVcardParam($email);
            if ($pref !== null) {
                $params['PREF'] = $pref;
            }

            $this->vcard->add('EMAIL', $addr, $params);
        }
    }

    /**
     * Sets JSContact email addresses from vCard EMAIL properties.
     * vCard -> JSContact: read EMAIL into ContactCard.emails.
     *
     * - For each EMAIL:
     *   - value -> EmailAddress.email
     *   - TYPE home/work -> contexts.private/work
     *   - PREF -> pref
     */
    public function getEmailsToJmap(ContactCard $card)
    {
        $vEmails = $this->vcard->EMAIL;
        if (!AdapterUtil::isSetAndNotNull($vEmails) || empty($vEmails)) {
            return;
        }

        $map = array();
        $i = 1;

        foreach ($vEmails as $prop) {
            $value = trim((string) $prop);
            if ($value === '') {
                continue;
            }

            $e = new EmailAddress();
            $e->setAddress($value);

            $ctx = $this->vcardTypeParamToContexts($prop);
            if (!empty($ctx)) {
                $e->setContexts($ctx);
            }

            $pref = $this->vcardPrefParamToInt($prop);
            if ($pref !== null) {
                $e->setPref($pref);
            }
            $map['e' . $i++] = $e;
        }

        if (!empty($map)) {
            $card->setEmails($map);
        }
    }

    /**
     * Copies JSContact phone numbers into vCard TEL properties.
     * JSContact -> vCard: write TEL from ContactCard.phones.
     *
     * - For each Phone:
     *   - number -> TEL value
     *   - contexts.private/work -> TYPE=home/work
     *   - features -> TYPE flags (mobile, voice, fax, text, video, pager, textphone, main-number)
     *   - pref -> PREF
     */
    public function setPhonesFromJmap(ContactCard $card)
    {
        $phones = $card->getPhones();
        if (!is_array($phones) || empty($phones)) {
            return;
        }

        foreach ($phones as $phone) {
            if (!($phone instanceof Phone)) {
                continue;
            }

            $num = $phone->getNumber();
            if (!is_string($num) || trim($num) === '') {
                continue;
            }

            $params = array();

            // Contexts
            $types = $this->contextsToVcardTypeParam($phone);

            // Features
            if (method_exists($phone, 'getFeatures')) {
                $feat = $phone->getFeatures();
                if (is_array($feat)) {
                    foreach ($feat as $name => $flag) {
                        if (!$flag) {
                            continue;
                        }
                        $name = strtolower((string) $name);
                        if (
                            in_array($name, array('voice', 'fax', 'cell',
                            'text', 'video', 'pager', 'textphone'), true)
                        ) {
                            $types[] = $name;
                        }
                    }
                }
            }

            if (!empty($types)) {
                $params['TYPE'] = $types;
            }

            $pref = $this->prefToVcardParam($phone);
            if ($pref !== null) {
                $params['PREF'] = $pref;
            }

            $this->vcard->add('TEL', $num, $params);
        }
    }

    /**
     * Sets JSContact phone numbers from vCard TEL properties.
     * vCard -> JSContact: read TEL into ContactCard.phones.
     *
     * - For each TEL:
     *   - value -> Phone.number
     *   - TYPE home/work -> contexts.private/work
     *   - TYPE mobile/voice/text/video/main-number/textphone/fax/pager -> Phone.features
     *   - other TYPEs -> Phone.label text
     *   - PREF -> pref
     */
    public function getPhonesToJmap(ContactCard $card)
    {
        $vPhones = $this->vcard->TEL;
        if (!AdapterUtil::isSetAndNotNull($vPhones) || empty($vPhones)) {
            return;
        }

        $map = array();
        $i = 1;

        foreach ($vPhones as $prop) {
            $value = trim((string) $prop);
            if ($value === '') {
                continue;
            }

            $p = new Phone();
            $p->setNumber($value);

            // Generic TYPE -> contexts (home/work)
            $ctx = $this->vcardTypeParamToContexts($prop);
            if (!empty($ctx)) {
                $p->setContexts($ctx);
            }

            // TEL-specific TYPEs -> features / label
            $features = array();
            $labels = array();

            if (isset($prop['TYPE'])) {
                $types = $prop['TYPE']->getParts();
                if (is_array($types)) {
                    foreach ($types as $t) {
                        $t = strtolower(trim((string) $t));
                        if ($t === '' || $t === null) {
                            continue;
                        }

                        if ($t === 'home' || $t === 'work') {
                            continue;
                        }

                        // Known JSContact Phone.features keys (RFC 9553)
                        if (
                            in_array(
                                $t,
                                array('mobile', 'voice', 'text', 'video', 'main-number', 'textphone', 'fax', 'pager'),
                                true
                            )
                        ) {
                            $features[$t] = true;
                        } else {
                            $labels[] = $t;
                        }
                    }
                }
            }

            if (!empty($features)) {
                $p->setFeatures($features);
            }

            if (!empty($labels)) {
                $p->setLabel(implode(', ', $labels));
            }

            $pref = $this->vcardPrefParamToInt($prop);
            if ($pref !== null) {
                $p->setPref($pref);
            }

            $map['p' . $i++] = $p;
        }

        if (!empty($map)) {
            $card->setPhones($map);
        }
    }

    /**
     * Adds website entries as vCard URL properties.
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
     * Returns website entries derived from vCard URL properties.
     */
    protected function getWebsites()
    {
        $result = array();
        $vUrls  = $this->vcard->URL;

        if (!AdapterUtil::isSetAndNotNull($vUrls) || empty($vUrls)) {
            return $result;
        }

        foreach ($vUrls as $url) {
            $value = trim((string) $url);
            if ($value === '') {
                continue;
            }
            $result[] = array('value' => $value);
        }

        return $result;
    }

    /**
     * Adds instant messaging entries as vCard IMPP properties.
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
     * Returns instant messaging entries derived from vCard IMPP properties.
     */
    protected function getIm()
    {
        $result = array();
        $vIms   = $this->vcard->IMPP;

        if (!AdapterUtil::isSetAndNotNull($vIms) || empty($vIms)) {
            return $result;
        }

        foreach ($vIms as $im) {
            $value = trim((string) $im);
            if ($value === '') {
                continue;
            }
            $result[] = array('value' => $value);
        }

        return $result;
    }

    /**
     * Copies JSContact online services into vCard URL and IMPP properties.
     * JSContact -> vCard: write URL/IMPP from ContactCard.onlineServices.
     *
     * - OnlineService.service == 'im' -> IMPP with uri.
     * - Otherwise -> URL with value=uri.
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
            if (!($os instanceof OnlineService)) {
                continue;
            }
            $entry = array('value' => $os->getUri());
            $kind  = $os->getService();

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
     * Sets JSContact online services from vCard URL and IMPP properties.
     * vCard -> JSContact: read URL/IMPP into ContactCard.onlineServices.
     *
     * - URL -> OnlineService with uri (generic website).
     * - IMPP -> OnlineService with uri and service='im'.
     */
    public function getOnlineToJmap(ContactCard $card)
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
            $o->setService('im');
            $map['os' . $idx++] = $o;
        }

        $card->setOnlineServices($map);
    }

    /**
     * Adds formatted address entries as vCard ADR properties.
     */
    protected function setAddresses(array $addresses)
    {
        foreach ($addresses as $addr) {
            $parts = array(
                isset($addr['postOfficeBox']) ? $addr['postOfficeBox'] : '',
                isset($addr['extension'])     ? $addr['extension']     : '',
                isset($addr['street'])        ? $addr['street']        : '',
                isset($addr['locality'])      ? $addr['locality']      : '',
                isset($addr['region'])        ? $addr['region']        : '',
                isset($addr['postcode'])      ? $addr['postcode']      : '',
                isset($addr['country'])       ? $addr['country']       : '',
            );

            $hasAny = false;
            foreach ($parts as $p) {
                if ($p !== '') {
                    $hasAny = true;
                    break;
                }
            }
            if (!$hasAny) {
                continue;
            }

            $params = array();

            if (!empty($addr['countryCode'])) {
                $params['CC'] = $addr['countryCode'];
            }
            if (!empty($addr['coordinates'])) {
                $params['GEO'] = $addr['coordinates'];
            }
            if (!empty($addr['timeZone'])) {
                $params['TZ'] = $addr['timeZone'];
            }

            $this->vcard->add('ADR', $parts, $params);
        }
    }

    /**
     * Returns formatted address entries derived from vCard ADR properties.
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

            $entry = array(
                'postOfficeBox' => isset($parts[0]) ? $parts[0] : '',
                'extension'     => isset($parts[1]) ? $parts[1] : '',
                'street'        => isset($parts[2]) ? $parts[2] : '',
                'locality'      => isset($parts[3]) ? $parts[3] : '',
                'region'        => isset($parts[4]) ? $parts[4] : '',
                'postcode'      => isset($parts[5]) ? $parts[5] : '',
                'country'       => isset($parts[6]) ? $parts[6] : '',
            );

            if (isset($vAddr['CC'])) {
                $entry['countryCode'] = (string) $vAddr['CC'];
            }
            if (isset($vAddr['GEO'])) {
                $entry['coordinates'] = (string) $vAddr['GEO'];
            }
            if (isset($vAddr['TZ'])) {
                $entry['timeZone'] = (string) $vAddr['TZ'];
            }

            $result[] = $entry;
        }

        return $result;
    }

    /**
     * Copies JSContact addresses into vCard ADR properties.
     *
     * - Uses Address.components when available to build ADR parts:
     *   number+name -> street; subdistrict+district -> extended; locality, region, postcode, country.
     * - If no components, uses fullAddress as street.
     * - countryCode -> ADR CC; coordinates -> GEO; timeZone -> TZ.
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

            $entry = array(
                'postOfficeBox' => '',
                'extension'     => '',
                'street'        => '',
                'locality'      => '',
                'region'        => '',
                'postcode'      => '',
                'country'       => '',
                'countryCode'   => $address->getCountryCode(),
                'coordinates'   => $address->getCoordinates(),
                'timeZone'      => $address->getTimeZone(),
            );

            $components = $address->getComponents();
            if (is_array($components) && !empty($components)) {
                $number      = '';
                $name        = '';
                $subdistrict = '';
                $district    = '';
                $locality    = '';
                $region      = '';
                $postcode    = '';
                $country     = '';

                foreach ($components as $comp) {
                    if (!is_object($comp)) {
                        continue;
                    }
                    $kind  = $comp->getKind();
                    $value = $comp->getValue();
                    if (!is_string($value) || $value === '') {
                        continue;
                    }

                    switch ($kind) {
                        case 'number':
                            $number = $value;
                            break;
                        case 'name':
                            $name = $value;
                            break;
                        case 'subdistrict':
                            $subdistrict = $value;
                            break;
                        case 'district':
                            $district = $value;
                            break;
                        case 'locality':
                            $locality = $value;
                            break;
                        case 'region':
                            $region = $value;
                            break;
                        case 'postcode':
                            $postcode = $value;
                            break;
                        case 'country':
                            $country = $value;
                            break;
                        default:
                            break;
                    }
                }

                $streetParts = array();
                if ($number !== '') {
                    $streetParts[] = $number;
                }
                if ($name !== '') {
                    $streetParts[] = $name;
                }
                $entry['street'] = implode(' ', $streetParts);

                $extParts = array();
                if ($subdistrict !== '') {
                    $extParts[] = $subdistrict;
                }
                if ($district !== '') {
                    $extParts[] = $district;
                }
                $entry['extension'] = implode(', ', $extParts);

                $entry['locality'] = $locality;
                $entry['region']   = $region;
                $entry['postcode'] = $postcode;
                $entry['country']  = $country;
            }

            $hasAny = false;
            foreach (array('postOfficeBox','extension','street','locality','region','postcode','country') as $k) {
                if ($entry[$k] !== '') {
                    $hasAny = true;
                    break;
                }
            }
            if (!$hasAny) {
                $full = $address->getFullAddress();
                if (is_string($full) && $full !== '') {
                    $entry['street'] = $full;
                }
            }

            $hasAny = false;
            foreach (array('postOfficeBox','extension','street','locality','region','postcode','country') as $k) {
                if ($entry[$k] !== '') {
                    $hasAny = true;
                    break;
                }
            }
            if (!$hasAny) {
                continue;
            }

            $vcard[] = $entry;
        }

        $this->setAddresses($vcard);
    }

    /**
     * Sets JSContact addresses from vCard ADR properties.
     * vCard -> JSContact: read ADR into ContactCard.addresses.
     *
     * - ADR parts -> Address.full and Address.components (name/district/locality/region/postcode/country).
     * - ADR CC/GEO/TZ -> countryCode/coordinates/timeZone.
     */
    public function getAddressesToJmap(ContactCard $card)
    {
        $addresses = $this->getAddresses();
        if (empty($addresses)) {
            return;
        }

        $map = array();
        $i = 1;

        foreach ($addresses as $addr) {
            $a = new Address();

            if (is_array($addr)) {
                $street   = isset($addr['street']) ? $addr['street'] : '';
                $ext      = isset($addr['extension']) ? $addr['extension'] : '';
                $local    = isset($addr['locality']) ? $addr['locality'] : '';
                $region   = isset($addr['region']) ? $addr['region'] : '';
                $postcode = isset($addr['postcode']) ? $addr['postcode'] : '';
                $country  = isset($addr['country']) ? $addr['country'] : '';

                // Build fullAddress
                $parts = array();
                foreach (array($street, $ext, $local, $region, $postcode, $country) as $part) {
                    if (is_string($part) && $part !== '') {
                        $parts[] = $part;
                    }
                }
                if (!empty($parts)) {
                    $a->setFullAddress(implode(', ', $parts));
                }

                // Build components from ADR parts
                $components = array();

                if ($street !== '') {
                    $c = new AddressComponent($street, 'name');
                    $components[] = $c;
                }

                if ($ext !== '') {
                    $c = new AddressComponent($ext, 'district');
                    $components[] = $c;
                }

                if ($local !== '') {
                    $c = new AddressComponent($local, 'locality');
                    $components[] = $c;
                }

                if ($region !== '') {
                    $c = new AddressComponent($region, 'region');
                    $components[] = $c;
                }

                if ($postcode !== '') {
                    $c = new AddressComponent($postcode, 'postcode');
                    $components[] = $c;
                }

                if ($country !== '') {
                    $c = new AddressComponent($country, 'country');
                    $components[] = $c;
                }

                if (!empty($components)) {
                    $a->setIsOrdered(true);
                    $a->setDefaultSeparator(', ');
                    $a->setComponents($components);
                }

                if (!empty($addr['countryCode'])) {
                    $a->setCountryCode($addr['countryCode']);
                }
                if (!empty($addr['coordinates'])) {
                    $a->setCoordinates($addr['coordinates']);
                }
                if (!empty($addr['timeZone'])) {
                    $a->setTimeZone($addr['timeZone']);
                }
            }

            $map['a' . $i++] = $a;
        }

        $card->setAddresses($map);
    }

    /**
     * Copies JSContact related-to entries into vCard RELATED properties.
     * JSContact -> vCard: write RELATED from ContactCard.relatedTo.
     *
     * - Each key in relatedTo -> RELATED value.
     * - Relation.relation map -> TYPE list on RELATED.
     * - Only relation types (keys) are preserved; any extra data is dropped.
     */
    public function setRelatedToFromJmap(ContactCard $card)
    {
        $relatedTo = $card->getRelatedTo();
        if (!is_array($relatedTo) || empty($relatedTo)) {
            return;
        }

        foreach ($relatedTo as $key => $relationObj) {
            if ($key === null || $key === '') {
                continue;
            }

            if (!is_object($relationObj)) {
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
                $this->vcard->add('RELATED', $key, array('TYPE' => $types));
            }
        }
    }

    /**
     * Sets JSContact related-to entries from vCard RELATED properties.
     * vCard -> JSContact: read RELATED into ContactCard.relatedTo.
     *
     * - RELATED value -> map key.
     * - TYPE parameters -> Relation.relation{type: true}.
     */
    public function getRelatedToToJmap(ContactCard $card)
    {
        $vRelated = $this->vcard->RELATED;
        if (!AdapterUtil::isSetAndNotNull($vRelated) || empty($vRelated)) {
            return;
        }

        $relatedMap = array();

        foreach ($vRelated as $rel) {
            $key = trim((string) $rel);
            if ($key === '') {
                continue;
            }

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
     * Copies JSContact members into vCard MEMBER properties and sets KIND=group.
     * JSContact -> vCard: write MEMBER and KIND=group from ContactCard.members.
     *
     * - Each member uid with flag=true -> MEMBER VALUE=uri.
     * - If at least one member is written, sets KIND=group.
     */
    public function setMembersFromJmap(ContactCard $card)
    {
        $members = $card->getMembers();
        if (!is_array($members) || empty($members)) {
            return;
        }

        $wroteMember = false;

        foreach ($members as $uid => $flag) {
            if ($uid === null || $uid === '' || $flag !== true) {
                continue;
            }

            $this->vcard->add('MEMBER', $uid, array('VALUE' => 'uri'));
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
     * Sets JSContact members by parsing MEMBER lines from the raw vCard.
     * vCard -> JSContact: read MEMBER into ContactCard.members.
     *
     * - Parses MEMBER lines from raw vCard.
     * - Each MEMBER value -> members[uri] = true.
     * - KIND is not inspected.
     */
    public function getMembersToJmap(ContactCard $card)
    {
        if (!is_string($this->rawVCard) || $this->rawVCard === '') {
            return;
        }

        $members = array();
        $vcf = preg_replace("/\r\n[ \t]/", "", $this->rawVCard);

        if (preg_match_all('/^MEMBER(?:;[^:]*)?:(.+)$/im', $vcf, $matches)) {
            foreach ($matches[1] as $value) {
                $uri = trim($value);
                if ($uri === '') {
                    continue;
                }
                $members[$uri] = true;
            }
        }

        if (!empty($members)) {
            $card->setMembers($members);
        }
    }

    /**
     * Sets JSContact preferredLanguages from vCard LANG properties.
     * vCard -> JSContact: read LANG into ContactCard.preferredLanguages.
     *
     * - Each LANG line:
     *   - value -> LanguagePref.language
     *   - TYPE home/work -> contexts.private/work
     *   - PREF -> pref
     * - Stored in an Id map (e.g. "lp1", "lp2").
     */
    public function getPreferredLanguagesToJmap(ContactCard $card)
    {
        $vLangs = $this->vcard->LANG;
        if (!AdapterUtil::isSetAndNotNull($vLangs) || empty($vLangs)) {
            return;
        }

        $map = array();
        $idx = 1;

        foreach ($vLangs as $prop) {
            $tag = trim((string) $prop);
            if ($tag === '') {
                continue;
            }

            $lp = new LanguagePref();
            $lp->setLanguage($tag);

            $ctx = $this->vcardTypeParamToContexts($prop);
            if (!empty($ctx)) {
                $lp->setContexts($ctx);
            }

            $pref = $this->vcardPrefParamToInt($prop);
            if ($pref !== null) {
                $lp->setPref($pref);
            }

            $id = 'lp' . $idx++;
            $map[$id] = $lp;
        }

        if (!empty($map)) {
            $card->setPreferredLanguages($map);
        }
    }

    /**
     * Copies JSContact preferredLanguages into vCard LANG properties.
     * JSContact -> vCard: write LANG from ContactCard.preferredLanguages.
     *
     * - Each LanguagePref:
     *   - language -> LANG value
     *   - contexts.private/work -> TYPE=home/work
     *   - pref -> PREF
     */
    public function setPreferredLanguagesFromJmap(ContactCard $card)
    {
        $langs = $card->getPreferredLanguages();
        if (!is_array($langs) || empty($langs)) {
            return;
        }

        foreach ($langs as $id => $lp) {
            if (!($lp instanceof LanguagePref)) {
                continue;
            }

            $tag = trim((string) $lp->getLanguage());
            if ($tag === '') {
                continue;
            }

            $params = array();

            // contexts -> TYPE home/work
            if (method_exists($lp, 'getContexts')) {
                $ctx = $lp->getContexts();
                if (is_array($ctx)) {
                    $types = array();
                    if (!empty($ctx['private'])) {
                        $types[] = 'home';
                    }
                    if (!empty($ctx['work'])) {
                        $types[] = 'work';
                    }
                    if (!empty($types)) {
                        $params['TYPE'] = $types;
                    }
                }
            }

            // pref -> PREF
            if (method_exists($lp, 'getPref')) {
                $pref = $lp->getPref();
                if (is_int($pref) && $pref > 0) {
                    $params['PREF'] = (string) $pref;
                }
            }

            $this->vcard->add('LANG', $tag, $params);
        }
    }

    /**
     * Sets JSContact keywords from vCard CATEGORIES properties.
     * vCard -> JSContact: read CATEGORIES into ContactCard.keywords.
     *
     * - Each CATEGORIES value -> keywords[value] = true.
     * - Merges values from all CATEGORIES lines.
     */
    public function getKeywordsToJmap(ContactCard $card)
    {
        $vCats = $this->vcard->CATEGORIES;
        if (!AdapterUtil::isSetAndNotNull($vCats) || empty($vCats)) {
            return;
        }

        $keywords = array();

        foreach ($vCats as $catProp) {
            $parts = $catProp->getParts();
            if (!is_array($parts) || empty($parts)) {
                $val = trim((string) $catProp);
                if ($val !== '') {
                    $keywords[$val] = true;
                }
                continue;
            }

            foreach ($parts as $p) {
                $p = trim((string) $p);
                if ($p === '') {
                    continue;
                }
                $keywords[$p] = true;
            }
        }

        if (!empty($keywords)) {
            $card->setKeywords($keywords);
        }
    }

    /**
     * Copies JSContact keywords into vCard CATEGORIES properties.
     * JSContact -> vCard: write CATEGORIES from ContactCard.keywords.
     *
     * - All keyword keys with value=true -> CATEGORIES values.
     * - Written as a single CATEGORIES with multiple values.
     */
    public function setKeywordsFromJmap(ContactCard $card)
    {
        $keywords = $card->getKeywords();
        if (!is_array($keywords) || empty($keywords)) {
            return;
        }

        $values = array();
        foreach ($keywords as $kw => $flag) {
            if ($flag && is_string($kw) && $kw !== '') {
                $values[] = $kw;
            }
        }

        if (!empty($values)) {
            // Single CATEGORIES line with comma-separated list
            $this->vcard->add('CATEGORIES', $values);
        }
    }

    /**
     * Sets JSContact personalInfo from vCard EXPERTISE, HOBBY, and INTEREST.
     * JSContact -> vCard: write EXPERTISE/HOBBY/INTEREST from ContactCard.personalInfo.
     *
     * - kind='expertise' -> EXPERTISE
     *   kind='hobby'     -> HOBBY
     *   kind='interest'  -> INTEREST
     * - value -> property value
     * - level low/medium/high -> LEVEL beginner/average/expert
     * - listAs -> INDEX
     */
    public function getPersonalInfoToJmap(ContactCard $card)
    {
        $info = array();

        // read a property group into PersonalInformation items
        $readProps = function ($propName, $kind) use (&$info) {
            $props = $this->vcard->$propName;
            if (!AdapterUtil::isSetAndNotNull($props) || empty($props)) {
                return;
            }

            foreach ($props as $prop) {
                $value = trim((string) $prop);
                if ($value === '') {
                    continue;
                }

                $level = null;
                if (isset($prop['LEVEL'])) {
                    $rawLevel = strtolower((string) $prop['LEVEL']);
                    if ($rawLevel === 'beginner') {
                        $level = 'low';
                    } elseif ($rawLevel === 'average' || $rawLevel === 'medium') {
                        $level = 'medium';
                    } elseif ($rawLevel === 'expert' || $rawLevel === 'high') {
                        $level = 'high';
                    }
                }

                $pi = new PersonalInformation($kind, $value);
                if ($level !== null) {
                    $pi->setLevel($level);
                }
                if (isset($prop['INDEX'])) {
                    $rawIndex = trim((string) $prop['INDEX']);
                    if ($rawIndex !== '' && ctype_digit($rawIndex)) {
                        $pi->setListAs((int) $rawIndex);
                    }
                }

                $info[] = $pi;
            }
        };

        $readProps('EXPERTISE', 'expertise');
        $readProps('HOBBY', 'hobby');
        $readProps('INTEREST', 'interest');

        if (!empty($info)) {
            $card->setPersonalInfo($info);
        }
    }

    /**
     * Copies JSContact personalInfo into vCard EXPERTISE, HOBBY, and INTEREST.
     * vCard -> JSContact: read EXPERTISE/HOBBY/INTEREST into ContactCard.personalInfo.
     *
     * - EXPERTISE/HOBBY/INTEREST:
     *   - property value -> PersonalInformation.value
     *   - LEVEL beginner/average/expert -> level low/medium/high
     *   - INDEX -> listAs
     * - kind field is set to "expertise", "hobby", or "interest".
     */
    public function setPersonalInfoFromJmap(ContactCard $card)
    {
        $info = $card->getPersonalInfo();
        if (!is_array($info) || empty($info)) {
            return;
        }

        foreach ($info as $pi) {
            if (!($pi instanceof PersonalInformation)) {
                continue;
            }

            $kind  = $pi->getKind();
            $value = $pi->getValue();
            if (!is_string($value) || $value === '') {
                continue;
            }

            if ($kind === 'expertise') {
                $propName = 'EXPERTISE';
            } elseif ($kind === 'hobby') {
                $propName = 'HOBBY';
            } elseif ($kind === 'interest') {
                $propName = 'INTEREST';
            } else {
                continue;
            }

            $params = array();

            $level = $pi->getLevel();
            if (is_string($level) && $level !== '') {
                if ($level === 'low') {
                    $params['LEVEL'] = 'beginner';
                } elseif ($level === 'medium') {
                    $params['LEVEL'] = 'average';
                } elseif ($level === 'high') {
                    $params['LEVEL'] = 'expert';
                }
            }

            $idx = $pi->getListAs();
            if (is_int($idx) && $idx > 0) {
                $params['INDEX'] = (string) $idx;
            }

            $this->vcard->add($propName, $value, $params);
        }
    }
}
