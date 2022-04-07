<?php

namespace OpenXPort\Adapter;

use OpenXPort\Jmap\Contact\ContactInformation;
use OpenXPort\Jmap\Contact\Address;
use OpenXPort\Jmap\Contact\File;
use Sabre\VObject;
use OpenXPort\Util\AdapterUtil;
use OpenXPort\Util\Logger;

class VCardOxpAdapter extends VCardAdapter
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

    public function getFirstName()
    {
        $vCardName = $this->vcard->N;

        if (AdapterUtil::isSetAndNotNull($vCardName)) {
            // The vCard property N contains name components in a list
            // That's why, first obtain the different name components via getParts()
            // Then, obtain the element with index 1, since the N property contains first name as a second element
            return $vCardName->getParts()[1];
        }

        return null;
    }

    public function getLastName()
    {
        $vCardName = $this->vcard->N;

        if (AdapterUtil::isSetAndNotNull($vCardName)) {
            // The vCard property N contains name components in a list
            // That's why, first obtain the different name components via getParts()
            // Then, obtain the element with index 0, since the N property contains last name as a first element
            return $vCardName->getParts()[0];
        }

        return null;
    }

    public function getPrefix()
    {
        $vCardName = $this->vcard->N;

        if (AdapterUtil::isSetAndNotNull($vCardName)) {
            // The vCard property N contains name components in a list
            // That's why, first obtain the different name components via getParts()
            // Then, obtain the element with index 3, since the N property contains prefix as a fourth element
            return $vCardName->getParts()[3];
        }

        return null;
    }

    public function getSuffix()
    {
        $vCardName = $this->vcard->N;

        if (AdapterUtil::isSetAndNotNull($vCardName)) {
            // The vCard property N contains name components in a list
            // That's why, first obtain the different name components via getParts()
            // Then, obtain the element with index 4, since the N property contains suffix as a fifth element
            return $vCardName->getParts()[4];
        }

        return null;
    }

    public function setName($lastName, $firstName, $middleName, $prefix, $suffix)
    {
        // Check each of the name components if it is either unset, null or empty
        // If yes, then set it to have the value of the empty string
        // Otherwise, just use its value for setting the corresponding name component value in vCard
        $lastName = AdapterUtil::isSetAndNotNull($lastName) && !empty($lastName) ? $lastName : "";
        $firstName = AdapterUtil::isSetAndNotNull($firstName) && !empty($firstName) ? $firstName : "";
        $middleName = AdapterUtil::isSetAndNotNull($middleName) && !empty($middleName) ? $middleName : "";
        $prefix = AdapterUtil::isSetAndNotNull($prefix) && !empty($prefix) ? $prefix : "";
        $suffix = AdapterUtil::isSetAndNotNull($suffix) && !empty($suffix) ? $suffix : "";

        // Create a vCard N property with the supplied name components
        $vCardNameProperty = $this->vcard->createProperty(
            "N",
            array($lastName, $firstName, $middleName, $prefix, $suffix)
        );

        // Add the created N property as a property of our vCard
        $this->vcard->add($vCardNameProperty);
    }

    public function getNickname()
    {
        $vCardNickname = $this->vcard->NICKNAME;

        if (AdapterUtil::isSetAndNotNull($vCardNickname)) {
            // The vCard property NICKNAME contains a single string value which we simply
            // obtain via the getParts() method and subsequently return
            // (getParts() always returns an array, even for single values,
            // that's why in this case we access the value from it with index 0)
            return $vCardNickname->getParts()[0];
        }

        return null;
    }

    public function setNickname($nickname)
    {
        if (AdapterUtil::isSetAndNotNull($nickname) && !empty($nickname)) {
            $this->vcard->add(
                'NICKNAME',
                $nickname
            );
        }
    }

    public function getBirthday()
    {
        $vCardBirthday = $this->vcard->BDAY;

        if (AdapterUtil::isSetAndNotNull($vCardBirthday)) {
            // The vCard property BDAY contains a single string value which represents a date
            // which we obtain via the getParts() method.
            // (getParts() always returns an array, even for single values,
            // that's why in this case we access the value from it with index 0)
            // Then, we use our util method for parsing dates and dates with time and try to parse it.
            // If parsing failed, i.e., the util method returns null, then we return the default value for JMAP
            // which in this case is "0000-00-00"
            $inputDateFormat = "Y-m-d";
            $outputDateFormat = "Y-m-d";
            $alternativeInputDateFormat = "Ymd";
            $jmapBirthday = AdapterUtil::parseDateTime(
                $vCardBirthday->getParts()[0],
                $inputDateFormat,
                $outputDateFormat,
                $alternativeInputDateFormat
            );

            if (is_null($jmapBirthday)) {
                return "0000-00-00";
            }

            return $jmapBirthday;
        }

        // Return default JMAP value if the supplied data from the vCard is either not set or null
        return "0000-00-00";
    }

    public function setBirthday($birthday)
    {
        // Check that the birthday we receive as value from JMAP is set, not null, not empty and does not equal
        // the string "0000-00-00" (which in JMAP terms denotes that the birthday date is unknown)
        // Only if all of the checks have passed, go on and create a vCard BDAY property
        if (AdapterUtil::isSetAndNotNull($birthday) && !empty($birthday) && strcmp($birthday, "0000-00-00") !== 0) {
            $inputDateFormat = "Y-m-d";
            $outputDateFormat = "Y-m-d";

            // Use our util function for parsing the JMAP datetime string and returning a vCard datetime string
            $vCardBirthday = AdapterUtil::parseDateTime(
                $birthday,
                $inputDateFormat,
                $outputDateFormat
            );

            // If the datetime parsing was unsuccessful, then the parseDateTime function will have returned null.
            // We can check if $vCardBirthday is null and if yes, then we don't proceed with writing birthday data
            if (is_null($vCardBirthday)) {
                return;
            }

            // If all is good thus far, write the birthday data in a BDAY property and set its VALUE parameter to
            // have the value of DATE
            $this->vcard->add(
                'BDAY',
                $vCardBirthday,
                [
                    'value' => 'date'
                ]
            );
        }
    }

    public function getAnniversary()
    {
        $vCardAnniversary = $this->vcard->__get("ANNIVERSARY");

        if (AdapterUtil::isSetAndNotNull($vCardAnniversary)) {
            // The vCard property ANNIVERSARY contains a single string value which represents a date
            // which we obtain via the getParts() method.
            // (getParts() always returns an array, even for single values,
            // that's why in this case we access the value from it with index 0)
            // Then, we use our util method for parsing dates and dates with time and try to parse it.
            // (For the parsing, first we try with the format 'Ymd' and alternatively also with the format
            // 'Y-m-d'). TODO: Check if these formats are exhaustive and enough to cover the ANNIVERSARY property
            // as per vCard.
            // If parsing failed, i.e., the util method returns null, then we return the default value for JMAP
            // which in this case is "0000-00-00"
            $inputDateFormat = "Ymd";
            $alternativeInputDateFormat = "Y-m-d";
            $outputDateFormat = "Y-m-d";
            $jmapAnniversary = AdapterUtil::parseDateTime(
                $vCardAnniversary->getParts()[0],
                $inputDateFormat,
                $outputDateFormat,
                $alternativeInputDateFormat
            );

            if (is_null($jmapAnniversary)) {
                return "0000-00-00";
            }

            return $jmapAnniversary;
        }

        // Return default JMAP value if the supplied data from the vCard is either not set or null
        return "0000-00-00";
    }

    public function setAnniversary($anniversary)
    {
        // Check that the anniversary we receive as value from JMAP is set, not null, not empty and does not equal
        // the string "0000-00-00" (which in JMAP terms denotes that the anniversary date is unknown)
        // Only if all of the checks have passed, go on and create a vCard ANNIVERSARY property
        if (
            AdapterUtil::isSetAndNotNull($anniversary)
            && !empty($anniversary)
            && strcmp($anniversary, "0000-00-00") !== 0
        ) {
            $inputDateFormat = "Y-m-d";
            $outputDateFormat = "Ymd";

            // Use our util function for parsing the JMAP datetime string and returning a vCard datetime string
            $vCardAnniversary = AdapterUtil::parseDateTime(
                $anniversary,
                $inputDateFormat,
                $outputDateFormat
            );

            // If the datetime parsing was unsuccessful, then the parseDateTime function will have returned null.
            // We can check if $vCardAnniversary is null and if yes, then we don't proceed with writing anniversary data
            if (is_null($vCardAnniversary)) {
                return;
            }

            // If all is good thus far, write the anniversary data in a ANNIVERSARY property and set its
            // VALUE parameter to have the value of DATE
            $this->vcard->add(
                'ANNIVERSARY',
                $vCardAnniversary,
                [
                    'value' => 'date'
                ]
            );
        }
    }

    public function getJobTitle()
    {
        $vCardJobTitle = $this->vcard->TITLE;

        if (AdapterUtil::isSetAndNotNull($vCardJobTitle) && !empty($vCardJobTitle)) {
            // The vCard property TITLE contains a single string value which we simply
            // obtain via the getParts() method and subsequently return
            // (getParts() always returns an array, even for single values,
            // that's why in this case we access the value from it with index 0)
            return $vCardJobTitle->getParts()[0];
        }

        return null;
    }

    public function setJobTitle($jobTitle)
    {
        if (AdapterUtil::isSetAndNotNull($jobTitle) && !empty($jobTitle)) {
            $this->vcard->add(
                'TITLE',
                $jobTitle
            );
        }
    }

    public function getOrganization()
    {
        $vCardOrganization = $this->vcard->ORG;

        if (AdapterUtil::isSetAndNotNull($vCardOrganization) && !empty($vCardOrganization)) {
            // The vCard property ORG contains a single string value which we simply
            // obtain via the getParts() method and subsequently return
            // (getParts() always returns an array, even for single values,
            // that's why in this case we access the value from it with index 0)
            return $vCardOrganization->getParts()[0];
        }

        return null;
    }

    public function setOrganization($organization)
    {
        if (AdapterUtil::isSetAndNotNull($organization) && !empty($organization)) {
            $this->vcard->add(
                'ORG',
                $organization
            );
        }
    }

    // TODO: Possibly entirely remove from this adapter, since this is Roundcube-specific
    // Alternative TODO: Keep it, but refactor it such that it is not Roundcube-specific
    public function getDepartment()
    {
        $vCardDepartment = $this->vcard->__get("X-DEPARTMENT");

        if (AdapterUtil::isSetAndNotNull($vCardDepartment) && !empty($vCardDepartment)) {
            // The vCard property X-DEPARTMENT contains a single string value which we simply
            // obtain via the getParts() method and subsequently return
            // (getParts() always returns an array, even for single values,
            // that's why in this case we access the value from it with index 0)
            return $vCardDepartment->getParts()[0];
        }

        return null;
    }

    // TODO: Possibly entirely remove from this adapter, since this is Roundcube-specific
    // Alternative TODO: Keep it, but refactor it such that it is not Roundcube-specific
    public function setDepartment($department)
    {
        if (AdapterUtil::isSetAndNotNull($department) && !empty($department)) {
            $this->vcard->add(
                'X-DEPARTMENT',
                $department
            );
        }
    }

    public function getNotes()
    {
        $vCardNote = $this->vcard->NOTE;

        if (AdapterUtil::isSetAndNotNull($vCardNote)) {
            // The vCard property NOTE contains a single string value which we simply
            // obtain via the getValue() method and subsequently return
            // Hint: DO NOT use getParts() for NOTE like for other properties,
            // since the presence of commas in the value of NOTE in vCard forces the
            // vObject library to turn the entire value into an array, split by commas
            // rather than keeping it as an entire text
            return $vCardNote->getValue();
        }

        return null;
    }

    public function setNotes($notes)
    {
        if (AdapterUtil::isSetAndNotNull($notes) && !empty($notes)) {
            $this->vcard->add(
                'NOTE',
                $notes
            );
        }
    }

    // TODO: Refactor such that no Roundcube-specific email types are used, i.e. keep it generic
    public function getEmails()
    {
        // An array to hold our JMAP emails
        $jmapEmails = [];

        // The emails from vCard
        $vCardEmails = $this->vcard->EMAIL;

        // Check if the emails from vCard are set, not null and not empty and only then proceed with
        // the transformation to JMAP emails
        if (AdapterUtil::isSetAndNotNull($vCardEmails) && !empty($vCardEmails)) {
            // Since we can have multiple email entries in vCard, we can iterate through them with foreach
            foreach ($vCardEmails as $vCardEmail) {
                $vCardEmailValue = $vCardEmail->getParts()[0];

                // If the email value is not set, is null or is empty, continue iterating and skip this entry
                if (!AdapterUtil::isSetAndNotNull($vCardEmailValue) || empty($vCardEmailValue)) {
                    continue;
                }

                // Create a JMAP email object
                $jmapEmail = new ContactInformation();
                $jmapEmail->setValue($vCardEmailValue);
                $jmapEmail->setLabel(null);
                $jmapEmail->setIsDefault(false);

                // Obtain the parameter "TYPE" which describes if the email is of type "home", "work" or "other"
                $vCardEmailType = $vCardEmail->parameters()["TYPE"];

                if (AdapterUtil::isSetAndNotNull($vCardEmailType) && !empty($vCardEmailType)) {
                    // Check the type of the vCard email and set the JMAP type accordingly
                    if (in_array("HOME", $vCardEmailType->getParts())) {
                        $jmapEmail->setType("personal");
                    } elseif (in_array("WORK", $vCardEmailType->getParts())) {
                        $jmapEmail->setType("work");
                    } else {
                        $jmapEmail->setType("other");
                    }
                } else { // Set default type of "other" if no TYPE received from vCard
                    $jmapEmail->setType("other");
                }

                array_push($jmapEmails, $jmapEmail);
            }

            // In case we don't have any JMAP emails, return null
            if (count($jmapEmails) === 0) {
                return null;
            }

            return $jmapEmails;
        }

        // If the vCard emails were not set, null or empty, return null
        return null;
    }

    // TODO: Refactor such that no Roundcube-specific email types are used, i.e. keep it generic
    public function setEmails($emails)
    {
        // Check if the emails that we receive from JMAP are set, not null and not empty
        // and only then proceed with mapping them to vCard emails
        if (AdapterUtil::isSetAndNotNull($emails) && !empty($emails)) {
            foreach ($emails as $email) {
                // Obtain the JMAP email's value and if it's unset, null or empty, skip this email entry
                $emailValue = $email->value;
                if (!AdapterUtil::isSetAndNotNull($emailValue) || empty($emailValue)) {
                    continue;
                }

                // Obtain the JMAP email's type and map it accordingly to the corresponding vCard type
                $emailType = $email->type;
                $vCardEmailType = null;

                switch ($emailType) {
                    case 'personal':
                        $vCardEmailType = 'home';
                        break;

                    case 'work':
                        $vCardEmailType = 'work';
                        break;

                    case 'other':
                        $vCardEmailType = 'other';
                        break;

                    default:
                        $vCardEmailType = 'other';
                        break;
                }

                // Finally, create a vCard EMAIL property with the email value and type that we already have
                // and add this created property to our vCard
                $this->vcard->add(
                    'EMAIL',
                    $emailValue,
                    [
                        'type' => ['internet', $vCardEmailType]
                    ]
                );
            }
        }
    }

    // TODO: Refactor such that no Roundcube-specific phone types are used, i.e. keep it generic
    public function getPhones()
    {
        // An array to hold our JMAP phones
        $jmapPhones = [];

        // The phones from vCard
        $vCardPhones = $this->vcard->TEL;

        // Check if the phones from vCard are set, not null and not empty and only then proceed with
        // the transformation to JMAP phones
        if (AdapterUtil::isSetAndNotNull($vCardPhones) && !empty($vCardPhones)) {
            // Since we can have multiple phone entries in vCard, we can iterate through them with foreach
            foreach ($vCardPhones as $vCardPhone) {
                $vCardPhoneValue = $vCardPhone->getParts()[0];

                // If the phone value is not set, is null or is empty, continue iterating and skip this entry
                if (!AdapterUtil::isSetAndNotNull($vCardPhoneValue) || empty($vCardPhoneValue)) {
                    continue;
                }

                // Create a JMAP phone object
                $jmapPhone = new ContactInformation();
                $jmapPhone->setValue($vCardPhoneValue);
                $jmapPhone->setLabel(null);
                $jmapPhone->setIsDefault(false);

                // Obtain the parameter "TYPE" which describes the phone's type
                // (e.g., "home", "work", etc.)
                $vCardPhoneType = $vCardPhone->parameters()["TYPE"];

                // Map the vCard phone type to the JMAP phone type
                switch (strtolower($vCardPhoneType->getParts()[0])) {
                    case 'home':
                        $jmapPhone->setType("home");
                        break;

                    case 'work':
                        $jmapPhone->setType("work");
                        break;

                    case 'cell':
                        $jmapPhone->setType("mobile");
                        break;

                    case 'fax':
                        $jmapPhone->setType("fax");
                        break;

                    case 'pager':
                        $jmapPhone->setType("pager");
                        break;

                    default:
                        $jmapPhone->setType("other");
                        break;
                }

                array_push($jmapPhones, $jmapPhone);
            }

            // In case we don't have any JMAP phones, return null
            if (count($jmapPhones) === 0) {
                return null;
            }

            return $jmapPhones;
        }

        // If the vCard phones were not set, null or empty, return null
        return null;
    }

    // TODO: Refactor such that no Roundcube-specific phone types are used, i.e. keep it generic
    public function setPhones($phones)
    {
        // Check if the phones that we receive from JMAP are set, not null and not empty
        // and only then proceed with mapping them to vCard phones
        if (AdapterUtil::isSetAndNotNull($phones) && !empty($phones)) {
            foreach ($phones as $phone) {
                // Obtain the JMAP phone's value and if it's unset, null or empty, skip this phone entry
                $phoneValue = $phone->value;
                if (!AdapterUtil::isSetAndNotNull($phoneValue) || empty($phoneValue)) {
                    continue;
                }

                // Obtain the JMAP phone's type and map it accordingly to the corresponding vCard type
                $phoneType = $phone->type;
                $vCardPhoneType = null;

                switch ($phoneType) {
                    case 'home':
                        $vCardPhoneType = 'home';
                        break;

                    case 'work':
                        $vCardPhoneType = 'work';
                        break;

                    case 'mobile':
                        $vCardPhoneType = 'cell';
                        break;

                    case 'fax':
                        $vCardPhoneType = 'fax';
                        break;

                    case 'pager':
                        $vCardPhoneType = 'pager';
                        break;

                    default:
                        $vCardPhoneType = 'other';
                        break;
                }

                // Finally, create a vCard TEL property with the phone value and type that we already have
                // and add this created property to our vCard
                $this->vcard->add(
                    'TEL',
                    $phoneValue,
                    [
                        'type' => $vCardPhoneType
                    ]
                );
            }
        }
    }

    // TODO: Refactor such that no Roundcube-specific website types are used, i.e. keep it generic
    public function getWebsites()
    {
        // An array to hold our JMAP websites
        $jmapWebsites = [];

        // The websites from vCard
        $vCardWebsites = $this->vcard->URL;

        // Check if the websites from vCard are set, not null and not empty and only then proceed with
        // the transformation to JMAP websites
        if (AdapterUtil::isSetAndNotNull($vCardWebsites) && !empty($vCardWebsites)) {
            // Since we can have multiple website entries in vCard, we can iterate through them with foreach
            foreach ($vCardWebsites as $vCardWebsite) {
                $vCardWebsiteValue = $vCardWebsite->getParts()[0];

                // If the website value is not set, is null or is empty, continue iterating and skip this entry
                if (!AdapterUtil::isSetAndNotNull($vCardWebsiteValue) || empty($vCardWebsiteValue)) {
                    continue;
                }

                // Create a JMAP website object
                $jmapWebsite = new ContactInformation();
                $jmapWebsite->setValue($vCardWebsiteValue);
                $jmapWebsite->setLabel(null);
                $jmapWebsite->setIsDefault(false);
                $jmapWebsite->setType("uri");

                array_push($jmapWebsites, $jmapWebsite);
            }

            // In case we don't have any JMAP websites, return null
            if (count($jmapWebsites) === 0) {
                return null;
            }

            return $jmapWebsites;
        }

        // If the vCard websites were not set, null or empty, return null
        return null;
    }

    // TODO: Refactor such that no Roundcube-specific website types are used, i.e. keep it generic
    public function setWebsites($websites)
    {
        // Check if the websites that we receive from JMAP are set, not null and not empty
        // and only then proceed with mapping them to vCard websites
        if (AdapterUtil::isSetAndNotNull($websites) && !empty($websites)) {
            foreach ($websites as $website) {
                // Obtain the JMAP website's value and if it's unset, null or empty, skip this website entry
                $websiteValue = $website->value;
                if (!AdapterUtil::isSetAndNotNull($websiteValue) || empty($websiteValue)) {
                    continue;
                }

                // If the JMAP website's type is 'uri', then save it as a vCard website (as a URL property)
                $websiteType = $website->type;
                if (strcmp($websiteType, 'uri') === 0) {
                    $this->vcard->add(
                        'URL',
                        $websiteValue,
                        [
                            'value' => 'uri'
                        ]
                    );
                }
            }
        }
    }

    // TODO: Refactor such that IM is handled in a non-Roundcube-specific way, i.e. stick to IMPP from vCard for IM
    public function getIm()
    {
        $jmapIms = [];

        $vCardIm = $this->vcard->IMPP;

        // Get all IM data and convert it to JMAP IM data
        if (AdapterUtil::isSetAndNotNull($vCardIm) && !empty($vCardIm)) {
            foreach ($vCardIm as $im) {
                $vCardImValue = $vCardIm->getParts()[0];

                // If the IM value is not set, is null or is empty, continue iterating and skip this entry
                if (!AdapterUtil::isSetAndNotNull($vCardImValue) || empty($vCardImValue)) {
                    continue;
                }
                $jmapIm = new ContactInformation();
                $jmapIm->setType('username');
                $jmapIm->setValue($vCardImValue);
                $jmapIm->setLabel(null);
                $jmapIm->setIsDefault(false);

                array_push($jmapIms, $jmapIm);
            }
        }

        // In case we don't have any JMAP IM entries, return null
        if (count($jmapIms) === 0) {
            return null;
        }

        return $jmapIms;
    }

    // TODO: Refactor such that IM is handled in a non-Roundcube-specific way, i.e. stick to IMPP from vCard for IM
    public function setIm($ims)
    {
        // Check if the IMs that we receive from JMAP are set, not null and not empty
        // and only then proceed with mapping them to vCard IMs
        if (AdapterUtil::isSetAndNotNull($ims) && !empty($ims)) {
            foreach ($ims as $im) {
                // Obtain the JMAP IM's value and if it's unset, null or empty, skip this IM entry
                $imValue = $im->value;
                if (!AdapterUtil::isSetAndNotNull($imValue) || empty($imValue)) {
                    continue;
                }

                // If the JMAP IM's type is 'username', then save it as a vCard IM
                $imType = $im->type;
                if (strcmp($imType, 'username') === 0) {
                    $this->vcard->add(
                        'IMPP',
                        $imValue
                    );
                }
            }
        }
    }

    public function getAddresses()
    {
        // An array to hold our JMAP addresses
        $jmapAddresses = [];

        // The addresses from vCard
        $vCardAddresses = $this->vcard->ADR;

        // Check if the addresses from vCard are set, not null and not empty and only then proceed with
        // the transformation to JMAP addresses
        if (AdapterUtil::isSetAndNotNull($vCardAddresses) && !empty($vCardAddresses)) {
            // Since we can have multiple address entries in vCard, we can iterate through them with foreach
            foreach ($vCardAddresses as $vCardAddress) {
                $vCardAddressValue = $vCardAddress->getParts();

                // If the address value is not set, is null or is empty, continue iterating and skip this entry
                if (!AdapterUtil::isSetAndNotNull($vCardAddressValue) || empty($vCardAddressValue)) {
                    continue;
                }

                // Create a JMAP address object
                $jmapAddress = new Address();
                $jmapAddress->setLabel(null);
                $jmapAddress->setIsDefault(false);

                // Take the values for street, locality, etc. by exploding the value of address
                // and accessing the corresponding index
                // Index 0 => post office box
                // Index 1 => extended address (e.g., apartment or suite number)
                // Index 2 => street address
                // Index 3 => locality (e.g., city)
                // Index 4 => region (e.g., state or province)
                // Index 5 => postal code
                // Index 6 => country name
                $jmapAddress->setStreet($vCardAddressValue[2]);
                $jmapAddress->setLocality($vCardAddressValue[3]);
                $jmapAddress->setRegion($vCardAddressValue[4]);
                $jmapAddress->setPostcode($vCardAddressValue[5]);
                $jmapAddress->setCountry($vCardAddressValue[6]);

                // Obtain the parameter "TYPE" which describes the address's type
                // (e.g., "home", "work", etc.)
                $vCardAddressType = $vCardAddress->parameters()["TYPE"];

                // Map the vCard address type to the JMAP address type
                switch (strtolower($vCardAddressType->getParts()[0])) {
                    case 'home':
                        $jmapAddress->setType("home");
                        break;

                    case 'work':
                        $jmapAddress->setType("work");
                        break;

                    case 'other':
                        $jmapAddress->setType("other");
                        break;

                    default:
                        $jmapAddress->setType("other");
                        break;
                }

                array_push($jmapAddresses, $jmapAddress);
            }

            // In case we don't have any JMAP addresses, return null
            if (count($jmapAddresses) === 0) {
                return null;
            }

            return $jmapAddresses;
        }

        // If the vCard addresses were not set, null or empty, return null
        return null;
    }

    public function setAddresses($addresses)
    {
        // Check if the JMAP addresses that we receive are in fact set, not null and not empty
        // and only then proceed with turning them to vCard addresses
        if (AdapterUtil::isSetAndNotNull($addresses) && !empty($addresses)) {
            foreach ($addresses as $address) {
                // For each address component (i.e., street, country, etc.), check if it's set, not null
                // and not empty and only then take its value from the JMAP address, otherwise, leave it empty
                $street = AdapterUtil::isSetAndNotNull($address->street) && !empty($address->street)
                    ? $address->street : '';

                $locality = AdapterUtil::isSetAndNotNull($address->locality) && !empty($address->locality)
                    ? $address->locality : '';

                $region = AdapterUtil::isSetAndNotNull($address->region) && !empty($address->region)
                    ? $address->region : '';

                $postcode = AdapterUtil::isSetAndNotNull($address->postcode) && !empty($address->postcode)
                    ? $address->postcode : '';

                $country = AdapterUtil::isSetAndNotNull($address->country) && !empty($address->country)
                    ? $address->country : '';


                // Determine the vCard address type based on the JMAP address type
                $addressType = $address->type;
                $vCardAddressType = null;

                switch ($addressType) {
                    case 'home':
                        $vCardAddressType = 'home';
                        break;

                    case 'work':
                        $vCardAddressType = 'work';
                        break;

                    case 'other':
                        $vCardAddressType = 'other';
                        break;

                    default:
                        $vCardAddressType = 'other';
                        break;
                }

                // Create an ADR property with the obtained values and with the obtained type
                // and add it to our vCard
                $this->vcard->add(
                    'ADR',
                    ['', '', $street, $locality, $region, $postcode, $country],
                    [
                        'type' => $vCardAddressType
                    ]
                );
            }
        }
    }

    public function getMiddlename()
    {
        $vCardName = $this->vcard->N;

        if (AdapterUtil::isSetAndNotNull($vCardName) && !empty($vCardName)) {
            // The vCard property N contains name components in a list
            // That's why, first obtain the different name components via getParts()
            // Then, obtain the element with index 2, since the N property contains middle name (a.k.a. additional name)
            // as a third element
            // In case the value is not null, set and not empty, only then return it
            $middleName = $vCardName->getParts()[2];
            if (AdapterUtil::isSetAndNotNull($middleName) && !empty($middleName)) {
                return $middleName;
            }
        }

        return null;
    }

    public function getDisplayname()
    {
        $vCardDisplayName = $this->vcard->FN;

        if (AdapterUtil::isSetAndNotNull($vCardDisplayName) && !empty($vCardDisplayName)) {
            // The vCard property FN contains a single string value which we simply
            // obtain via the getParts() method and subsequently return
            // (getParts() always returns an array, even for single values,
            // that's why in this case we access the value from it with index 0)
            return $vCardDisplayName->getParts()[0];
        }

        return null;
    }

    public function setDisplayname($displayname)
    {
        if (AdapterUtil::isSetAndNotNull($displayname) && !empty($displayname)) {
            $this->vcard->add(
                'FN',
                $displayname
            );
        }
    }

    // TODO: Refactor such that it is not Roundcube-specific, but generic vCard-conformant
    public function getGender()
    {
        $vCardGender = $this->vcard->GENDER;

        if (AdapterUtil::isSetAndNotNull($vCardGender) && !empty($vCardGender)) {
            // The vCard property GENDER contains a single string value which we simply
            // obtain via the getParts() method and subsequently return
            // (getParts() always returns an array, even for single values,
            // that's why in this case we access the value from it with index 0)
            // We need to check if the value corresponds to the JMAP value 'male' or 'female'
            // If it does not correspond, we return null and we log the issue, as well as
            // the encountered vCard value for GENDER.
            $vCardGenderValue = strtolower($vCardGender->getParts()[0]);
            $jmapGenderValue = null;

            switch ($vCardGenderValue) {
                case 'm':
                    $jmapGenderValue = 'male';
                    break;

                case 'f':
                    $jmapGenderValue = 'female';
                    break;

                default:
                    $this->logger = Logger::getInstance();
                    $this->logger->error("Couldn't transform to JMAP gender. vCard value is: " . $vCardGenderValue);
                    break;
            }

            return $jmapGenderValue;
        }

        return null;
    }

    // TODO: Refactor such that it is not Roundcube-specific, but generic vCard-conformant
    public function setGender($gender)
    {
        if (
            AdapterUtil::isSetAndNotNull($gender)
            && !empty($gender)
            && in_array($gender, array("male", "female")) // Check if the value of $gender is one of the allowed values
        ) {
            $this->vcard->add(
                'GENDER',
                $gender
            );
        }
    }

    public function getRole()
    {
        // TODO: Implement me
    }

    public function getAvatar()
    {
        $jmapAvatar = null;

        $vCardPhoto = $this->vcard->PHOTO;

        if (AdapterUtil::isSetAndNotNull($vCardPhoto) && !empty($vCardPhoto)) {
            // The vCard property PHOTO contains a raw binary value of the photo. That's why we
            // call `base64_encode` on the binary value in order to get a base64-encoded value to
            // save into the JMAP avatar's base64 representation.
            $base64Value = base64_encode($vCardPhoto->getParts()[0]);
            $jmapAvatar = new File();
            $jmapAvatar->setBase64($base64Value);
        }

        return $jmapAvatar;
    }

    public function setAvatar($avatar)
    {
        if (AdapterUtil::isSetAndNotNull($avatar) && !empty($avatar)) {
            // Obtain the base64 value of the JMAP avatar and check if it is set, not null and not empty
            $base64Value = $avatar->base64;
            if (AdapterUtil::isSetAndNotNull($base64Value) && !empty($base64Value)) {
                $this->vcard->add(
                    'PHOTO',
                    $base64Value,
                    [
                        'encoding' => 'b'
                    ]
                );
            }
        }
    }
}
