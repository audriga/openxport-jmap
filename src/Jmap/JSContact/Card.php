<?php

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * A Card object stores information about a person, organization or company.
 *
 * MIME type: application/jscontact+json;type=card
 *
 * Implemented as per JSContact IETF draft version 09
 * @see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09
 */
class Card extends TypeableEntity implements JsonSerializable
{
    /* === JMAP-specific properties === */
    /** @var string $id (mandatory) */
    private $addressBookId;

    /* === Metadata properties === */

    /** @var string $id (mandatory) (This property is not part of the JSContact spec and is added by audriga) */
    private $id;

    /** @var string $uid (mandatory) */
    private $uid;

    /** @var string $prodId (optional) */
    private $prodId;

    /** @var UTCDateTime $created (optional) */
    private $created;

    /** @var UTCDateTime $updated (optional) */
    private $updated;

    /** @var string $kind (optional) */
    private $kind;

    /** @var array<string, Relation> $relatedTo (optional) */
    private $relatedTo;

    /** @var string $language (optional) */
    private $language;


    /* === Name and Organization properties === */

    /** @var Name $name (optional) */
    private $name;

    /** @var string $fullName (optional) */
    private $fullName;

    /** @var string[] $nickNames (optional) */
    private $nickNames;

    /** @var array<string, Organization> $organizations (optional) */
    private $organizations;

    /** @var array<string, Title> $titles (optional) */
    private $titles;

    /** @var SpeakToAs $speakToAs (optional) */
    private $speakToAs;


    /* === Contact properties === */

    /** @var array<string, EmailAddress> $emails (optional)
     * The string keys of the array are of type Id
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.2)
    */
    private $emails;

    /** @var array<string, OnlineService> $onlineServices (optional)
     * The string keys of the array are of type Id
     * (see https://www.ietf.org/archive/id/draft-ietf-calext-jscontact-07.html#name-onlineservices)
    */
    private $onlineServices;

    /** @var array<string, Phone> $phones (optional)
     * The string keys of the array are of type Id
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.2)
    */
    private $phones;

    /** @var array<string, Resource> $online (optional)
     * The string keys of the array are of type Id
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.2)
     * @deprecated
    */
    private $online;

    /** @var array<string, File> $photos (optional)
     * The string keys of the array are of type Id
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.2)
     * @deprecated
    */
    private $photos;

    /** @var string $preferredContactMethod (optional)
     * @deprecated
     * */
    private $preferredContactMethod;

    /** @var array<string, ContactLanguage[]> $preferredContactLanguages (optional)
     * The keys in the object MUST be [RFC5646] language tags.
     * The values are a (possibly empty) list of contact language
     * preferences for this language.
     * A valid ContactLanguage object MUST have at least one
     * of its properties set.
     * @deprecated
    */
    private $preferredContactLanguages;


    /* === Address and Location properties === */

    /** @var array<string, Address> $addresses (optional)
     * The string keys of the array are of type Id
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.2)
    */
    private $addresses;


    /* === Multilingual properties === */

    /** @var array<string, PatchObject> $localizations (optional) */
    private $localizations;


    /* === Additional properties === */

    /** @var array<string, Anniversary> $anniversaries (optional)
     * The string keys of the array are of type Id
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.2)
    */
    private $anniversaries;

    /** @var array<string, PersonalInformation> $personalInfo (optional)
     * The string keys of the array are of type Id
     * (see https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-09#section-1.5.2)
    */
    private $personalInfo;

    /** @var string $notes (optional) */
    private $notes;

    /** @var array<string, boolean> $categories (optional) */
    private $categories;

    /** @var array<string, TimeZone> $timeZones (optional)
     * For a description of this property see the timeZones property definition in [RFC8984].
     */
    private $timeZones;


    /* === Extended properties (added by audriga) === */

    /** @var string|null $maidenName (optional) */
    private $maidenName;

    public function getAddressBookId()
    {
        return $this->addressBookId;
    }

    public function setAddressBookId($addressBookId)
    {
        $this->addressBookId = $addressBookId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getProdId()
    {
        return $this->prodId;
    }

    public function setProdId($prodId)
    {
        $this->prodId = $prodId;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getNickNames()
    {
        return $this->nickNames;
    }

    public function setNickNames($nickNames)
    {
        $this->nickNames = $nickNames;
    }

    public function getOrganizations()
    {
        return $this->organizations;
    }

    public function setOrganizations($organizations)
    {
        $this->organizations = $organizations;
    }

    public function getTitles()
    {
        return $this->titles;
    }

    public function setTitles($titles)
    {
        $this->titles = $titles;
    }

    public function getSpeakToAs()
    {
        return $this->speakToAs;
    }

    public function setSpeakToAs($speakToAs)
    {
        $this->speakToAs = $speakToAs;
    }

    public function getEmails()
    {
        return $this->emails;
    }

    public function setEmails($emails)
    {
        $this->emails = $emails;
    }

    public function getOnlineServices()
    {
        return $this->onlineServices;
    }

    public function setOnlineServices($services)
    {
        $this->onlineServices = $services;
    }

    public function getPhones()
    {
        return $this->phones;
    }

    public function setPhones($phones)
    {
        $this->phones = $phones;
    }

    public function getOnline()
    {
        trigger_error("Called method " . __METHOD__ . " is outdated, use onlineServices instead.", E_USER_DEPRECATED);
        return $this->online;
    }

    public function setOnline($online)
    {
        trigger_error("Called method " . __METHOD__ . " is outdated, use onlineServices instead.", E_USER_DEPRECATED);
        $this->online = $online;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    public function getPreferredContactMethod()
    {
        return $this->preferredContactMethod;
    }

    public function setPreferredContactMethod($preferredContactMethod)
    {
        $this->preferredContactMethod = $preferredContactMethod;
    }

    public function getPreferredContactLanguages()
    {
        return $this->preferredContactLanguages;
    }

    public function setPreferredContactLanguages($preferredContactLanguages)
    {
        $this->preferredContactLanguages = $preferredContactLanguages;
    }

    public function getAddresses()
    {
        return $this->addresses;
    }

    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }

    public function getLocalizations()
    {
        return $this->localizations;
    }

    public function setLocalizations($localizations)
    {
        $this->localizations = $localizations;
    }

    public function getAnniversaries()
    {
        return $this->anniversaries;
    }

    public function setAnniversaries($anniversaries)
    {
        $this->anniversaries = $anniversaries;
    }

    public function getPersonalInfo()
    {
        return $this->personalInfo;
    }

    public function setPersonalInfo($personalInfo)
    {
        $this->personalInfo = $personalInfo;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getTimeZones()
    {
        return $this->timeZones;
    }

    public function setTimeZones($timeZones)
    {
        $this->timeZones = $timeZones;
    }

    public function getMaidenName()
    {
        return $this->maidenName;
    }

    public function setMaidenName($maidenName)
    {
        $this->maidenName = $maidenName;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            // JMAP-specific properties
            "addressBookId" => $this->getAddressBookId(),

            // Metadata properties
            "@type" => $this->getAtType(),
            "id" => $this->getId(),
            "uid" => $this->getUid(),
            "prodId" => $this->getProdId(),
            "created" => $this->getCreated(),
            "updated" => $this->getUpdated(),
            "kind" => $this->getKind(),
            "relatedTo" => $this->getRelatedTo(),
            "language" => $this->getLanguage(),

            // Name and Organization properties
            "name" => $this->getName(),
            "fullName" => $this->getFullName(),
            "nickNames" => $this->getNickNames(),
            "organizations" => $this->getOrganizations(),
            "titles" => $this->getTitles(),
            "speakToAs" => $this->getSpeakToAs(),

            // Contact properties
            "emails" => $this->getEmails(),
            "onlineServices" => $this->getOnlineServices(),
            "phones" => $this->getPhones(),
            "online" => $this->online,
            "photos" => $this->getPhotos(),
            "preferredContactMethod" => $this->getPreferredContactMethod(),
            "preferredContactLanguages" => $this->getPreferredContactLanguages(),

            // Address and Location properties
            "addresses" => $this->getAddresses(),

            // Multilingual properties
            "localizations" => $this->getLocalizations(),

            // Additional properties
            "anniversaries" => $this->getAnniversaries(),
            "personalInfo" => $this->getPersonalInfo(),
            "notes" => $this->getNotes(),
            "categories" => $this->getCategories(),
            "timeZones" => $this->getTimeZones()
        ], function ($val) {
            return !is_null($val);
        });
    }
}
