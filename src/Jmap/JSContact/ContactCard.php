<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\JSContact;

use JsonSerializable;

/**
 * JSContact Card object as defined in RFC 9553.
 *
 * MIME type: application/jscontact+json;type=card
 */
class ContactCard extends TypeableEntity implements JsonSerializable
{
    /** @var string */
    private $version = '1.0';

    /** @var string */
    private $uid;

    /**
     * addressBookIds: Id[Boolean] (JMAP ContactCard).
     *
     * The set of AddressBook ids this card belongs to. Keys are
     * AddressBook ids, values MUST be true.
     *
     * @var array<string,bool>|null
     */
    private $addressBookIds;

    /** @var string|null */
    private $kind;

    /** @var string|null */
    private $language;

    /**
     * relatedTo: String[Relation] (optional).
     *
     * @var array<string,Relation>|null
     */
    private $relatedTo;

    /**
     * members: String[Boolean] (optional).
     *
     * The set of Cards that are members of this group Card. Each key is the
     * uid of the member Card; each value MUST be true. If this is set, kind
     * MUST be "group" (RFC 9553, Section 2.1.6).
     *
     * @var array<string,bool>|null
     */
    private $members;

    /** @var string|null */
    private $prodId;

    /** @var string|null */
    private $description;

    /** @var array<string,bool>|null */
    private $categories;

    /** @var array<string,bool>|null */
    private $keywords;

    /** @var Name|null */
    private $name;

    /** @var array<string,Nickname>|null */
    private $nicknames;

    /** @var array<string,Organization>|null */
    private $organizations;

    /** @var array<string,Title>|null */
    private $titles;

    /** @var SpeakToAs|null */
    private $speakToAs;

    /** @var string|null */
    private $sortAs;

    /** @var array<string,EmailAddress>|null */
    private $emails;

    /** @var array<string,OnlineService>|null */
    private $onlineServices;

    /** @var array<string,Phone>|null */
    private $phones;

    /** @var array<string,Media>|null */
    private $media;

    /**
     * preferredLanguages : Id[LanguagePref] (optional).
     *
     * @var array<string,LanguagePref>|null
     */
    private $preferredLanguages;

    /** @var array<string,Address>|null */
    private $addresses;

    /** @var array<string,Pronouns>|null */
    private $pronouns;

    /** @var array<string,PatchObject>|null */
    private $localizations;

    /** @var array<string,Anniversary>|null */
    private $anniversaries;

    /** @var array<string,PersonalInformation>|null */
    private $personalInfo;

    /** @var string|null */
    private $notes;

    /**
     * notes: Id[Note] (optional).
     *
     * @var array<string,Note>|null
     */
    private $noteObjects;

    /** @var string|null */
    private $created;

    /** @var string|null */
    private $updated;

    /** @var array<string,SchedulingAddress>|null */
    private $schedulingAddresses;

    /** @var array<string,CryptoKey>|null */
    private $cryptoKeys;

    /** @var array<string,Directory>|null */
    private $directories;

    /** @var array<string,Link>|null */
    private $links;

    public function __construct(
        $uid = null,
        $addressBookIds = null,
        $kind = null,
        $language = null,
        $name = null,
        $nicknames = null,
        $organizations = null,
        $titles = null,
        $emails = null,
        $phones = null,
        $onlineServices = null,
        $addresses = null,
        $anniversaries = null,
        $relatedTo = null,
        $members = null,
        $noteObjects = null,
        $personalInfo = null,
        $keywords = null,
        $created = null,
        $updated = null
    ) {
        $this->setAtType('Card');

        if ($uid !== null) {
            $this->setUid($uid);
        }

        if ($addressBookIds !== null) {
            $this->setAddressBookIds($addressBookIds);
        }

        if ($kind !== null) {
            $this->setKind($kind);
        }

        if ($language !== null) {
            $this->setLanguage($language);
        }

        if ($name !== null) {
            $this->setName($name);
        }

        if ($nicknames !== null) {
            $this->setNicknames($nicknames);
        }

        if ($organizations !== null) {
            $this->setOrganizations($organizations);
        }

        if ($titles !== null) {
            $this->setTitles($titles);
        }

        if ($emails !== null) {
            $this->setEmails($emails);
        }

        if ($phones !== null) {
            $this->setPhones($phones);
        }

        if ($onlineServices !== null) {
            $this->setOnlineServices($onlineServices);
        }

        if ($addresses !== null) {
            $this->setAddresses($addresses);
        }

        if ($anniversaries !== null) {
            $this->setAnniversaries($anniversaries);
        }

        if ($relatedTo !== null) {
            $this->setRelatedTo($relatedTo);
        }

        if ($members !== null) {
            $this->setMembers($members);
        }

        if ($noteObjects !== null) {
            $this->setNoteObjects($noteObjects);
        }

        if ($personalInfo !== null) {
            $this->setPersonalInfo($personalInfo);
        }

        if ($keywords !== null) {
            $this->setKeywords($keywords);
        }

        if ($created !== null) {
            $this->setCreated($created);
        }

        if ($updated !== null) {
            $this->setUpdated($updated);
        }
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
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

    /**
     * @return array<string,SchedulingAddress>|null
     */
    public function getSchedulingAddresses()
    {
        return $this->schedulingAddresses;
    }

    /**
     * @param array<string,SchedulingAddress>|null $schedulingAddresses
     */
    public function setSchedulingAddresses($schedulingAddresses)
    {
        $this->schedulingAddresses = $schedulingAddresses;
    }

    /**
     * @return array<string,CryptoKey>|null
     */
    public function getCryptoKeys()
    {
        return $this->cryptoKeys;
    }

    /**
     * @param array<string,CryptoKey>|null $cryptoKeys
     */
    public function setCryptoKeys($cryptoKeys)
    {
        $this->cryptoKeys = $cryptoKeys;
    }

    /**
     * @return array<string,Directory>|null
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * @param array<string,Directory>|null $directories
     */
    public function setDirectories($directories)
    {
        $this->directories = $directories;
    }

    /**
     * @return array<string,Link>|null
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array<string,Link>|null $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return array<string,Relation>|null
     */
    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    /**
     * @param array<string,Relation>|null $relatedTo
     */
    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function addRelatedTo($uid, Relation $relation)
    {
        if ($this->relatedTo === null) {
            $this->relatedTo = [];
        }
        $this->relatedTo[$uid] = $relation;
    }

    /**
     * @return array<string,bool>|null
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param array<string,bool>|null $members
     */
    public function setMembers($members)
    {
        $this->members = $members;

        // RFC 9553: if members is set and non-empty, kind MUST be "group".
        if ($members !== null && $members !== []) {
            $this->kind = 'group';
        }
    }

    public function addMember($uid)
    {
        if ($this->members === null) {
            $this->members = [];
        }
        $this->members[$uid] = true;
        if ($this->kind !== 'group') {
            $this->kind = 'group';
        }
    }

    public function getProdId()
    {
        return $this->prodId;
    }

    public function setProdId($prodId)
    {
        $this->prodId = $prodId;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array<string,bool>|null
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array<string,bool>|null $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function addKeyword($keyword)
    {
        if ($this->keywords === null) {
            $this->keywords = [];
        }
        $this->keywords[$keyword] = true;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array<string,Nickname>|null
     */
    public function getNicknames()
    {
        return $this->nicknames;
    }

    /**
     * @param array<string,Nickname>|null $nicknames
     */
    public function setNicknames($nicknames)
    {
        $this->nicknames = $nicknames;
    }

    /**
     * @return array<string,Organization>|null
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * @param array<string,Organization>|null $organizations
     */
    public function setOrganizations($organizations)
    {
        $this->organizations = $organizations;
    }

    /**
     * @return array<string,Title>|null
     */
    public function getTitles()
    {
        return $this->titles;
    }

    /**
     * @param array<string,Title>|null $titles
     */
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

    public function getSortAs()
    {
        return $this->sortAs;
    }

    public function setSortAs($sortAs)
    {
        $this->sortAs = $sortAs;
    }

    /**
     * @return array<string,EmailAddress>|null
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param array<string,EmailAddress>|null $emails
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
    }

    /**
     * @return array<string,OnlineService>|null
     */
    public function getOnlineServices()
    {
        return $this->onlineServices;
    }

    /**
     * @param array<string,OnlineService>|null $onlineServices
     */
    public function setOnlineServices($onlineServices)
    {
        $this->onlineServices = $onlineServices;
    }

    /**
     * @return array<string,Phone>|null
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * @param array<string,Phone>|null $phones
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;
    }

    /**
     * @return array<string,Media>|null
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param array<string,Media>|null $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * @return array<string,LanguagePref>|null
     */
    public function getPreferredLanguages()
    {
        return $this->preferredLanguages;
    }

    /**
     * @param array<string,LanguagePref>|null $preferredLanguages
     */
    public function setPreferredLanguages($preferredLanguages)
    {
        $this->preferredLanguages = $preferredLanguages;
    }

    /**
     * @return array<string,Address>|null
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param array<string,Address>|null $addresses
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @return array<string,Pronouns>|null
     */
    public function getPronouns()
    {
        return $this->pronouns;
    }

    /**
     * @param array<string,Pronouns>|null $pronouns
     */
    public function setPronouns($pronouns)
    {
        $this->pronouns = $pronouns;
    }

    /**
     * @return array<string,PatchObject>|null
     */
    public function getLocalizations()
    {
        return $this->localizations;
    }

    /**
     * @param array<string,PatchObject>|null $localizations
     */
    public function setLocalizations($localizations)
    {
        $this->localizations = $localizations;
    }

    /**
     * @return array<string,Anniversary>|null
     */
    public function getAnniversaries()
    {
        return $this->anniversaries;
    }

    /**
     * @param array<string,Anniversary>|null $anniversaries
     */
    public function setAnniversaries($anniversaries)
    {
        $this->anniversaries = $anniversaries;
    }

    /**
     * @return array<string,PersonalInformation>|null
     */
    public function getPersonalInfo()
    {
        return $this->personalInfo;
    }

    /**
     * @param array<string,PersonalInformation>|null $personalInfo
     */
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

    /**
     * @return array<string,Note>|null
     */
    public function getNoteObjects()
    {
        return $this->noteObjects;
    }

    /**
     * @param array<string,Note>|null $noteObjects
     */
    public function setNoteObjects($noteObjects)
    {
        $this->noteObjects = $noteObjects;
    }

    public function addNoteObject($id, Note $note)
    {
        if ($this->noteObjects === null) {
            $this->noteObjects = [];
        }
        $this->noteObjects[$id] = $note;
    }

    /**
     * @return array<string,bool>|null
     */
    public function getAddressBookIds()
    {
        return $this->addressBookIds;
    }

    /**
     * @param array<string,bool>|null $addressBookIds
     */
    public function setAddressBookIds($addressBookIds)
    {
        $this->addressBookIds = $addressBookIds;
    }

    public function addAddressBookId($addressBookId)
    {
        if ($this->addressBookIds === null) {
            $this->addressBookIds = [];
        }
        $this->addressBookIds[$addressBookId] = true;
    }

    public function removeAddressBookId($addressBookId)
    {
        if ($this->addressBookIds !== null && array_key_exists($addressBookId, $this->addressBookIds)) {
            unset($this->addressBookIds[$addressBookId]);
            if ($this->addressBookIds === []) {
                $this->addressBookIds = null;
            }
        }
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "_debugMarker"   => "ContactCard-jsonSerialize-hit",
            "@type"          => $this->getAtType(),   // "Card"
            "version"        => $this->getVersion(),
            "uid"            => $this->getUid(),
            "addressBookIds" => $this->getAddressBookIds(),
            "kind"           => $this->getKind(),
            "language"       => $this->getLanguage(),
            "created"        => $this->getCreated(),
            "updated"        => $this->getUpdated(),
            "relatedTo"      => $this->getRelatedTo(),
            "members"        => $this->getMembers(),
            "prodId"         => $this->getProdId(),
            "description"    => $this->getDescription(),
            "keywords"       => $this->getKeywords(),
            "name"               => $this->getName(),
            "nicknames"          => $this->getNicknames(),
            "organizations"      => $this->getOrganizations(),
            "titles"             => $this->getTitles(),
            "speakToAs"          => $this->getSpeakToAs(),
            "sortAs"             => $this->getSortAs(),
            "emails"             => $this->getEmails(),
            "onlineServices"     => $this->getOnlineServices(),
            "phones"             => $this->getPhones(),
            "media"              => $this->getMedia(),
            "preferredLanguages"  => $this->getPreferredLanguages(),
            "schedulingAddresses" => $this->getSchedulingAddresses(),
            "addresses"      => $this->getAddresses(),
            "pronouns"       => $this->getPronouns(),
            "localizations"  => $this->getLocalizations(),
            "cryptoKeys"     => $this->getCryptoKeys(),
            "directories"    => $this->getDirectories(),
            "links"          => $this->getLinks(),
            "anniversaries"  => $this->getAnniversaries(),
            "personalInfo"   => $this->getPersonalInfo(),
            "notes"          => $this->getNoteObjects(),
        ], static function ($val) {
            return $val !== null;
        });
    }
}
