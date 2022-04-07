<?php

namespace OpenXPort\Adapter;

use Sabre\VObject;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;

class VCardAdapter extends AbstractAdapter
{
    protected $logger;

    /** @var VObject\Component\VCard */
    protected $vcard;

    public function __construct()
    {
        $this->vcard = new VObject\Component\VCard();
    }

    public function getContact()
    {
        return $this->vcard->serialize();
    }

    public function setContact($vCardString)
    {
        $this->vcard = VObject\Reader::read($vCardString);
    }

    // TODO: Refactor such that it is not Roundcube-specific, but generic vCard-conformant
    public function getRelatedTo()
    {
        $jmapRelatedTo = [];

        // Obtain the RELATED property from vCard, check if it's not null, set and not empty and if yes,
        // iterate through all of its entries (there can be more than one entries), take each entry's value
        // and try to map it to its JMAP counterpart.
        $vCardRelated = $this->vcard->RELATED;

        if (AdapterUtil::isSetAndNotNull($vCardRelated) && !empty($vCardRelated)) {
            foreach ($vCardRelated as $vCardRelatedEntry) {
                $vCardRelatedValue = $vCardRelatedEntry->getParts()[0];

                // TODO: Our usage of JMAP's relatedTo property is currently kind of hacky
                // (i.e. we used it as a property in JMAP for Contacts (https://jmap.io/spec-contacts.html)
                // when it is actually defined in a draft as a property in
                // JSContact (https://datatracker.ietf.org/doc/html/draft-ietf-jmap-jscontact-07#section-2.1.6))
                // We used it with this hacky approach in order to be able to read information about a contact's spouse,
                // assistant or manager.
                // However, this usage of ours for relatedTo does not allow for an exact mapping to its counterpart
                // in vCard, namely RELATED, since only 'spouse' as a type in relatedTo can be found in RELATED
                // in vCard.
                // That's why currently in this generic vCard <-> JMAP adapter, we only map the spouse
                // type of relatedTo and we leave out assistant and manager.
                // The vCard for Roundcube, for example, maps assistant and manager as well, however, it does not
                // work with vCard's RELATED property, but with Roundcube's custom vCard properties X-ASSISTANT,
                // X-MANAGER and X-SPOUSE.
                switch ($vCardRelatedValue) {
                    case 'spouse':
                        $jmapRelatedTo[$vCardRelatedValue] = array("relation" => array("spouse" => true));
                        break;
                }
            }
        }

        return $jmapRelatedTo;
    }

    // TODO: Refactor such that it is not Roundcube-specific, but generic vCard-conformant
    public function setRelatedTo($relatedTo)
    {
        // The $relatedTo JMAP property that we receive here is a map of string values to Relation objects
        // We need to take each string value and set it accordingly in our vCard as per the defined relation
        // in the Relation object (e.g., spouse relation, assistant relation, manager relation)
        foreach ($relatedTo as $relatedToString => $relationObject) {
            // Check if the string value is set, not null and not empty and only then proceed with using it
            // as a value to set for a spouse, assistant or manager property in our vCard
            if (AdapterUtil::isSetAndNotNull($relatedToString) && !empty($relatedToString)) {
                // Obtain the actual relation property from the Relation object and check the type of relation in it
                $relation = $relationObject->relation;

                if (AdapterUtil::isSetAndNotNull($relation) && !empty($relation)) {
                    $relationType = key($relation);
                    // Name of the vCard type to set based on the relation type (e.g., spouse)
                    $vCardType = null;

                    // TODO: Due to reasons listed in getRelatedTo's TODO (see above), we currently only map
                    // from JMAP's relatedTo 'spouse' type to vCard's RELATED 'spouse' type.
                    switch ($relationType) {
                        case 'spouse':
                            $vCardType = 'spouse';
                            break;

                        default:
                            return;
                            break;
                    }

                    // Add the RELATED property to our vCard and set its value and type accordingly
                    // from what we have obtained above.
                    $this->vcard->add(
                        'RELATED',
                        $relatedToString,
                        [
                            'type' => $vCardType
                        ]
                    );
                }
            }
        }
    }
}
