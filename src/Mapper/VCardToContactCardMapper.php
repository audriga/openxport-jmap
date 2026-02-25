<?php

namespace OpenXPort\Mapper;

use OpenXPort\Adapter\VCardJsContactAdapter;
use OpenXPort\Jmap\JSContact\ContactCard;

class VCardToContactCardMapper extends AbstractMapper
{
    /**
     * Map from JMAP ContactCard objects to vCard data.
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

            $backendContact = $adapter->getContact();
            $map[] = array($creationId => $backendContact);
        }

        return $map;
    }

    /**
     * Map from vCard data to JMAP ContactCard objects.
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

            $adapter->setNameOnJmap($contactCard);
            $adapter->setNicknameOnJmap($contactCard);
            $adapter->setOrganizationOnJmap($contactCard);
            $adapter->setTitlesOnJmap($contactCard);
            $adapter->setNotesOnJmap($contactCard);
            $adapter->setEmailsOnJmap($contactCard);
            $adapter->setPhonesOnJmap($contactCard);
            $adapter->setOnlineOnJmap($contactCard);
            $adapter->setAddressesOnJmap($contactCard);
            $adapter->setAnniversariesOnJmap($contactCard);
            $adapter->setRelatedToOnJmap($contactCard);

            $list[] = $contactCard;
        }

        return $list;
    }
}
