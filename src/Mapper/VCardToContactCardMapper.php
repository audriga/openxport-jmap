<?php

namespace OpenXPort\Mapper;

use OpenXPort\Adapter\VCardJsContactAdapter;
use OpenXPort\Jmap\JSContact\ContactCard;

class VCardToContactCardMapper extends AbstractMapper
{
    /**
     * Map from JMAP ContactCard objects (https://datatracker.ietf.org/doc/rfc9553/)
     * to vCard data (https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-vcard-03).
     *
     * @param array<string,ContactCard> $jmapData  creationId => ContactCard
     * @param VCardJsContactAdapter     $adapter
     *
     * @return array<int,array<string,mixed>>      [ [ creationId => vcardString ], ... ]
     */
    public function mapFromJmap($jmapData, $adapter)
    {
        $map = array();

        foreach ($jmapData as $creationId => $contactCard) {
            if (!($contactCard instanceof ContactCard)) {
                continue;
            }

            $adapter->setNameFromJmap($contactCard);
            $adapter->setFnFromJmap($contactCard);
            $adapter->setNicknameFromJmap($contactCard);
            $adapter->setOrganizationFromJmap($contactCard);
            $adapter->setTitlesFromJmap($contactCard);
            $adapter->setNotesFromJmap($contactCard);
            $adapter->setEmailsFromJmap($contactCard);
            $adapter->setPhonesFromJmap($contactCard);
            $adapter->setOnlineFromJmap($contactCard);
            $adapter->setAddressesFromJmap($contactCard);
            $adapter->setAnniversariesFromJmap($contactCard);
            $adapter->setRelatedToFromJmap($contactCard);
            $adapter->setMembersFromJmap($contactCard);
            $adapter->setKeywordsFromJmap($contactCard);
            $adapter->setPreferredLanguagesFromJmap($contactCard);
            $adapter->setPersonalInfoFromJmap($contactCard);

            $backendContact = $adapter->getContact();
            $map[] = array($creationId => $backendContact);
        }

        return $map;
    }

    /**
     * Map from vCard data (https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-vcard-03)
     * to JMAP ContactCard objects (https://datatracker.ietf.org/doc/rfc9553/).
     *
     * @param array<string,mixed>       $data      contactId => vcardString
     * @param VCardJsContactAdapter     $adapter
     *
     * @return ContactCard[]
     */
    public function mapToJmap($data, $adapter)
    {
        $list = array();

        foreach ($data as $contactId => $contactVCard) {
            $adapter->setContact($contactVCard);
            $contactCard = new ContactCard();
            $contactCard->setUid($contactId);

            $adapter->getNameToJmap($contactCard);
            $adapter->getNicknameToJmap($contactCard);
            $adapter->getOrganizationToJmap($contactCard);
            $adapter->getTitlesToJmap($contactCard);
            $adapter->getNotesToJmap($contactCard);
            $adapter->getEmailsToJmap($contactCard);
            $adapter->getPhonesToJmap($contactCard);
            $adapter->getOnlineToJmap($contactCard);
            $adapter->getAddressesToJmap($contactCard);
            $adapter->getAnniversariesToJmap($contactCard);
            $adapter->getRelatedToToJmap($contactCard);
            $adapter->getMembersToJmap($contactCard);
            $adapter->getKeywordsToJmap($contactCard);
            $adapter->getPreferredLanguagesToJmap($contactCard);
            $adapter->getPersonalInfoToJmap($contactCard);

            $list[] = $contactCard;
        }

        return $list;
    }
}
