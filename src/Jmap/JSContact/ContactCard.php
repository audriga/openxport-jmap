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

    /** @var array<string,bool>|null */
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

    public function __construct()
    {
        // @type MUST be "Card".
        $this->setAtType('Card');
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
    }

    public function addMember($uid)
    {
        if ($this->members === null) {
            $this->members = [];
        }
        $this->members[$uid] = true;
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
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param array<string,bool>|null $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function addCategory($category)
    {
        if ($this->categories === null) {
            $this->categories = [];
        }
        $this->categories[$category] = true;
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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object) array_filter([
            "@type"       => $this->getAtType(),   // "Card"
            "version"     => $this->getVersion(),
            "uid"         => $this->getUid(),
            "kind"        => $this->getKind(),
            "language"    => $this->getLanguage(),
            "relatedTo"   => $this->getRelatedTo(),
            "members"     => $this->getMembers(),
            "prodId"      => $this->getProdId(),
            "description" => $this->getDescription(),
            "categories"  => $this->getCategories(),
            "keywords"    => $this->getKeywords(),

            "name"          => $this->getName(),
            "nicknames"     => $this->getNicknames(),
            "organizations" => $this->getOrganizations(),
            "titles"        => $this->getTitles(),
            "speakToAs"     => $this->getSpeakToAs(),
            "sortAs"        => $this->getSortAs(),

            "emails"             => $this->getEmails(),
            "onlineServices"     => $this->getOnlineServices(),
            "phones"             => $this->getPhones(),
            "media"              => $this->getMedia(),
            "preferredLanguages" => $this->getPreferredLanguages(),

            "addresses"     => $this->getAddresses(),
            "pronouns"      => $this->getPronouns(),
            "localizations" => $this->getLocalizations(),
            "anniversaries" => $this->getAnniversaries(),
            "personalInfo"  => $this->getPersonalInfo(),
            "notes"         => $this->getNotes(),
        ], function ($val) {
            return !is_null($val);
        });
    }
}
