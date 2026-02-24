<?php

namespace OpenXPort\Mapper;

use OpenXPort\Jmap\JSContact\ContactCard;
use OpenXPort\Jmap\JSContact\Name;
use OpenXPort\Jmap\JSContact\EmailAddress;
use OpenXPort\Jmap\JSContact\Phone;
use OpenXPort\Jmap\JSContact\OnlineService;
use OpenXPort\Jmap\JSContact\Address;
use OpenXPort\Jmap\JSContact\Note;
use OpenXPort\Jmap\JSContact\Nickname;
use OpenXPort\Jmap\JSContact\Organization;
use OpenXPort\Jmap\JSContact\Title;
use OpenXPort\Jmap\JSContact\Anniversary;

class VCardToContactCardMapper extends AbstractMapper
{
    /// Map from JMAP ContactCard objects to vCard data.
    public function mapFromJmap($jmapData, $adapter)
    {
        $map = [];

        foreach ($jmapData as $creationId => $contactCard) {
            $name = $contactCard->getName();
            if ($name instanceof Name) {
                if (method_exists($adapter, 'setDisplayname')) {
                    $adapter->setDisplayname($name->getFull());
                }

                $components = $name->getComponents();
                $firstName  = null;
                $lastName   = null;
                $middleName = null;
                $prefix     = null;
                $suffix     = null;

                if (is_array($components)) {
                    foreach ($components as $component) {
                        $kind  = method_exists($component, 'getKind') ? $component->getKind() : null;
                        $value = method_exists($component, 'getValue') ? $component->getValue() : null;

                        if ($kind === 'surname') {
                            $lastName = $value;
                        } elseif ($kind === 'given') {
                            $firstName = $value;
                        } elseif ($kind === 'middle') {
                            $middleName = $value;
                        } elseif ($kind === 'prefix') {
                            $prefix = $value;
                        } elseif ($kind === 'suffix') {
                            $suffix = $value;
                        }
                    }
                }

                if (method_exists($adapter, 'setName')) {
                    $adapter->setName(
                        $lastName,
                        $firstName,
                        $middleName,
                        $prefix,
                        $suffix
                    );
                }
            }

            $nicknames = $contactCard->getNicknames();
            if (is_array($nicknames) && !empty($nicknames) && method_exists($adapter, 'setNickname')) {
                $firstNick = reset($nicknames);
                if ($firstNick instanceof Nickname && method_exists($firstNick, 'getName')) {
                    $adapter->setNickname($firstNick->getName());
                }
            }

            $organizations = $contactCard->getOrganizations();
            if (is_array($organizations) && !empty($organizations) && method_exists($adapter, 'setOrganization')) {
                $firstOrg = reset($organizations);
                if ($firstOrg instanceof Organization && method_exists($firstOrg, 'getName')) {
                    $adapter->setOrganization($firstOrg->getName());
                }
            }

            $titles = $contactCard->getTitles();
            if (is_array($titles) && !empty($titles) && method_exists($adapter, 'setJobTitle')) {
                $firstTitle = reset($titles);
                if ($firstTitle instanceof Title) {
                    $adapter->setJobTitle($firstTitle->getName());
                }
            }

            $noteObjects = $contactCard->getNoteObjects();
            if (is_array($noteObjects) && !empty($noteObjects) && method_exists($adapter, 'setNotes')) {
                $note = reset($noteObjects);
                if ($note instanceof Note && method_exists($note, 'getNote')) {
                    $adapter->setNotes($note->getNote());
                }
            }

            $emails = $contactCard->getEmails();
            if (is_array($emails) && method_exists($adapter, 'setEmails')) {
                $vcardEmails = [];
                foreach ($emails as $email) {
                    if ($email instanceof EmailAddress) {
                        $vcardEmails[] = [
                            'value' => $email->getAddress(),
                        ];
                    }
                }
                $adapter->setEmails($vcardEmails);
            }

            $phones = $contactCard->getPhones();
            if (is_array($phones) && method_exists($adapter, 'setPhones')) {
                $vcardPhones = [];
                foreach ($phones as $phone) {
                    if ($phone instanceof Phone && method_exists($phone, 'getNumber')) {
                        $vcardPhones[] = [
                            'value' => $phone->getNumber(),
                        ];
                    }
                }
                $adapter->setPhones($vcardPhones);
            }

            $onlineServices = $contactCard->getOnlineServices();
            if (is_array($onlineServices)) {
                $websites = [];
                $ims      = [];
                foreach ($onlineServices as $os) {
                    if ($os instanceof OnlineService && method_exists($os, 'getUri')) {
                        $uri = $os->getUri();
                        $websites[] = ['value' => $uri];
                    }
                }
                if (method_exists($adapter, 'setWebsites')) {
                    $adapter->setWebsites($websites);
                }
                if (method_exists($adapter, 'setIm')) {
                    $adapter->setIm($ims);
                }
            }

            $addresses = $contactCard->getAddresses();
            if (is_array($addresses) && method_exists($adapter, 'setAddresses')) {
                $vcardAddresses = [];
                foreach ($addresses as $address) {
                    if ($address instanceof Address) {
                        $formatted = method_exists($address, 'getFullAddress')
                            ? $address->getFullAddress()
                            : null;

                        $vcardAddresses[] = [
                            'formatted' => $formatted,
                        ];
                    }
                }
                $adapter->setAddresses($vcardAddresses);
            }

            $anniversaries = $contactCard->getAnniversaries();
            if (is_array($anniversaries)) {
                $birthDate = null;
                $otherDate = null;

                foreach ($anniversaries as $ann) {
                    if (!($ann instanceof Anniversary)) {
                        continue;
                    }
                    $kind = method_exists($ann, 'getKind') ? $ann->getKind() : null;
                    $date = method_exists($ann, 'getDate') ? $ann->getDate() : null;

                    if ($kind === 'birth' && $birthDate === null) {
                        $birthDate = $date;
                    } elseif ($kind === 'other' && $otherDate === null) {
                        $otherDate = $date;
                    }
                }

                if ($birthDate && method_exists($adapter, 'setBirthday')) {
                    $adapter->setBirthday($birthDate);
                }
                if ($otherDate && method_exists($adapter, 'setAnniversary')) {
                    $adapter->setAnniversary($otherDate);
                }
            }

            if (method_exists($adapter, 'setRelatedTo')) {
                $adapter->setRelatedTo($contactCard->getRelatedTo());
            }

            $backendContact = $adapter->getContact();
            $map[] = [$creationId => $backendContact];
        }

        return $map;
    }
    /// Map from vCard data to JMAP ContactCard objects.
    /// The adapter provides access to the vCard data and allows setting properties
    // on the backend contact object as needed.
    public function mapToJmap($data, $adapter)
    {
        $list = [];

        foreach ($data as $contactId => $contactVCard) {
            $adapter->setContact($contactVCard);

            $contactCard = new ContactCard();

            $contactCard->setUid($contactId);

            if (method_exists($adapter, 'getAddressBookId')) {
                $addressBookId = $adapter->getAddressBookId();
                if (!empty($addressBookId)) {
                    $contactCard->addAddressBookId($addressBookId);
                }
            }

            $name = new Name();
            if (method_exists($adapter, 'getDisplayname')) {
                $name->setFull($adapter->getDisplayname());
            }
            $contactCard->setName($name);

            if (method_exists($adapter, 'getNickname')) {
                $nickname = $adapter->getNickname();
                if (!empty($nickname)) {
                    $nickObj = new Nickname();
                    $nickObj->setName($nickname);
                    $contactCard->setNicknames(['n1' => $nickObj]);
                }
            }

            if (method_exists($adapter, 'getOrganization')) {
                $orgName = $adapter->getOrganization();
                if (!empty($orgName)) {
                    $org = new Organization();
                    $org->setName($orgName);
                    $contactCard->setOrganizations(['o1' => $org]);
                }
            }

            if (method_exists($adapter, 'getJobTitle')) {
                $jobTitle = $adapter->getJobTitle();
                if (!empty($jobTitle)) {
                    $title = new Title();
                    $title->setName($jobTitle);
                    $contactCard->setTitles(['t1' => $title]);
                }
            }

            if (method_exists($adapter, 'getNotes')) {
                $noteText = $adapter->getNotes();
                if (!empty($noteText)) {
                    $note = new Note();
                    $note->setNote($noteText);
                    $contactCard->setNoteObjects(['n1' => $note]);
                }
            }

            if (method_exists($adapter, 'getEmails')) {
                $emails = $adapter->getEmails();
                if (!empty($emails)) {
                    $emailMap = [];
                    foreach ($emails as $idx => $email) {
                        $e = new EmailAddress();
                        $e->setAddress(\is_array($email) ? (isset($email['value']) ? $email['value'] : null) : $email);
                        $emailMap['e' . $idx] = $e;
                    }
                    $contactCard->setEmails($emailMap);
                }
            }

            if (method_exists($adapter, 'getPhones')) {
                $phones = $adapter->getPhones();
                if (!empty($phones)) {
                    $phoneMap = [];
                    foreach ($phones as $idx => $phone) {
                        $p = new Phone();
                        $p->setNumber(\is_array($phone) ? (isset($phone['value']) ? $phone['value'] : null) : $phone);
                        $phoneMap['p' . $idx] = $p;
                    }
                    $contactCard->setPhones($phoneMap);
                }
            }

            $websites = method_exists($adapter, 'getWebsites') ? (array) $adapter->getWebsites() : [];
            $ims      = method_exists($adapter, 'getIm') ? (array) $adapter->getIm() : [];
            $online   = array_merge($websites, $ims);

            if (!empty($online)) {
                $onlineMap = [];
                foreach ($online as $idx => $entry) {
                    $o = new OnlineService();
                    $o->setUri(\is_array($entry) ? (isset($entry['value']) ? $entry['value'] : null) : $entry);
                    $onlineMap['os' . $idx] = $o;
                }
                $contactCard->setOnlineServices($onlineMap);
            }

            if (method_exists($adapter, 'getAddresses')) {
                $addresses = $adapter->getAddresses();
                if (!empty($addresses)) {
                    $addrMap = [];

                    foreach ($addresses as $idx => $addr) {
                        $a = new Address();
                        $a->setIsOrdered(true);
                        $a->setDefaultSeparator(', ');

                        $components = [];

                        if (is_object($addr)) {
                            if (!empty($addr->number)) {
                                $c = new \OpenXPort\Jmap\JSContact\AddressComponent();
                                $c->setKind('number');
                                $c->setValue($addr->number);
                                $components[] = $c;
                            }

                            if (!empty($addr->number) && !empty($addr->street)) {
                                $sep = new \OpenXPort\Jmap\JSContact\AddressComponent();
                                $sep->setKind('separator');
                                $sep->setValue(' ');
                                $components[] = $sep;
                            }

                            if (!empty($addr->street)) {
                                $c = new \OpenXPort\Jmap\JSContact\AddressComponent();
                                $c->setKind('name');
                                $c->setValue($addr->street);
                                $components[] = $c;
                            }

                            if (!empty($addr->locality)) {
                                $c = new \OpenXPort\Jmap\JSContact\AddressComponent();
                                $c->setKind('locality');
                                $c->setValue($addr->locality);
                                $components[] = $c;
                            }

                            if (!empty($addr->region)) {
                                $c = new \OpenXPort\Jmap\JSContact\AddressComponent();
                                $c->setKind('region');
                                $c->setValue($addr->region);
                                $components[] = $c;
                            }

                            if (!empty($addr->region) && !empty($addr->postcode)) {
                                $sep = new \OpenXPort\Jmap\JSContact\AddressComponent();
                                $sep->setKind('separator');
                                $sep->setValue(' ');
                                $components[] = $sep;
                            }

                            if (!empty($addr->postcode)) {
                                $c = new \OpenXPort\Jmap\JSContact\AddressComponent();
                                $c->setKind('postcode');
                                $c->setValue($addr->postcode);
                                $components[] = $c;
                            }

                            if (!empty($addr->country)) {
                                $c = new \OpenXPort\Jmap\JSContact\AddressComponent();
                                $c->setKind('country');
                                $c->setValue($addr->country);
                                $components[] = $c;
                            }
                        }

                        if (!empty($components)) {
                            $a->setComponents($components);
                        }

                        $addrMap['a' . $idx] = $a;
                    }

                    $contactCard->setAddresses($addrMap);
                }
            }

            $anniversaries = [];

            if (method_exists($adapter, 'getBirthday')) {
                $birthday = $adapter->getBirthday();
                if (!empty($birthday) && $birthday !== '0000-00-00') {
                    $ann = new Anniversary();
                    $ann->setKind('birth');
                    $ann->setDate($birthday);
                    $anniversaries[] = $ann;
                }
            }

            if (method_exists($adapter, 'getAnniversary')) {
                $anniv = $adapter->getAnniversary();
                if (!empty($anniv) && $anniv !== '0000-00-00') {
                    $ann = new Anniversary();
                    $ann->setKind('other');
                    $ann->setDate($anniv);
                    $anniversaries[] = $ann;
                }
            }

            if (!empty($anniversaries)) {
                $contactCard->setAnniversaries($anniversaries);
            }

            if (method_exists($adapter, 'getRelatedTo')) {
                $contactCard->setRelatedTo($adapter->getRelatedTo());
            }

            $list[] = $contactCard;
        }

        return $list;
    }
}
