<?php

namespace OpenXPort\Jmap\JSContact\Audriga;

class Card extends \OpenXPort\Jmap\JSContact\Card
{
    public function jsonSerialize()
    {
        return (object)[
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

            // Contact and Resource properties
            "emails" => $this->getEmails(),
            "phones" => $this->getPhones(),
            "online" => $this->getOnline(),
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
            "timeZones" => $this->getTimeZones(),

            // Extended properties (added by audriga)
            CardExtensionsUtil::VSPE_PREFIX_ROUNDCUBE . "maidenName" => $this->getMaidenName()
        ];
    }
}