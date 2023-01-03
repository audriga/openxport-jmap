<?php

namespace OpenXPort\Jmap\Contact;

use JsonSerializable;
use OpenXPort\Util\AdapterUtil;

class Contact implements JsonSerializable
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $addressBookId;

    /** @var boolean */
    protected $isFlagged;

    /** @var File */
    protected $avatar;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    protected $prefix;

    protected $suffix;

    protected $nickname;

    protected $birthday;

    protected $anniversary;

    protected $jobTitle;

    protected $company;

    protected $department;

    protected $notes;

    /** @var ContactInformation[] */
    protected $emails;

    /** @var ContactInformation[] */
    protected $phones;

    /** @var ContactInformation[] */
    protected $online;

    /** @var Address[] */
    protected $addresses;

    protected $uid;

    // Extra properties (as per https://web.audriga.com/mantis/view.php?id=5071)
    protected $middlename;
    protected $displayname;
    protected $maidenname;
    protected $gender;
    protected $relatedTo;
    protected $role;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAddressBookId()
    {
        return $this->addressBookId;
    }

    public function setAddressBookId($addressBookId)
    {
        $this->addressBookId = $addressBookId;
    }

    public function getIsFlagged()
    {
        return $this->isFlagged;
    }

    public function setIsFlagged($isFlagged)
    {
        $this->isFlagged = $isFlagged;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function getSuffix()
    {
        return $this->suffix;
    }

    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getAnniversary()
    {
        return $this->anniversary;
    }

    public function setAnniversary($anniversary)
    {
        $this->anniversary = $anniversary;
    }

    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getEmails()
    {
        return $this->emails;
    }

    public function setEmails($emails)
    {
        $this->emails = $emails;
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
        return $this->online;
    }

    public function setOnline($online)
    {
        $this->online = $online;
    }

    public function getAddresses()
    {
        return $this->addresses;
    }

    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getMiddlename()
    {
        return $this->middlename;
    }

    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
    }

    public function getDisplayname()
    {
        return $this->displayname;
    }

    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;
    }

    public function getMaidenname()
    {
        return $this->maidenname;
    }

    public function setMaidenname($maidenname)
    {
        $this->maidenname = $maidenname;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return (object)[
            "id" => $this->getId(),
            "addressBookId" => $this->getAddressBookId(),
            "isFlagged" => $this->getIsFlagged(),
            "avatar" => $this->getAvatar(),
            "firstName" => $this->getFirstName(),
            "lastName" => $this->getLastName(),
            "prefix" => $this->getPrefix(),
            "suffix" => $this->getSuffix(),
            "nickname" => $this->getNickname(),
            "birthday" => $this->getBirthday(),
            "anniversary" => $this->getAnniversary(),
            "jobTitle" => $this->getJobTitle(),
            "company" => $this->getCompany(),
            "department" => $this->getDepartment(),
            "notes" => $this->getNotes(),
            "emails" => $this->getEmails(),
            "phones" => $this->getPhones(),
            "online" => $this->getOnline(),
            "addresses" => $this->getAddresses(),
            "uid" => $this->getUid(),
            "middlename" => $this->getMiddlename(),
            "displayname" => $this->getDisplayname(),
            "maidenname" => $this->getMaidenname(),
            "gender" => $this->getGender(),
            "relatedTo" => $this->getRelatedTo(),
            "role" => $this->getRole()
        ];
    }

    /**
     * Sanitize free text fields that could potentially contain Unicode chars.
     * Only called in case an error is observed during JSON encoding.
     */
    public function sanitizeFreeText()
    {
        if ($this->avatar) {
            $this->avatar->sanitizeFreeText();
        }
        // all ContactInformation objects may have free text fields
        if ($this->emails) {
            foreach ($this->emails as $mail) {
                $mail->sanitizeFreeText();
            }
        }
        if ($this->phones) {
            foreach ($this->phones as $phone) {
                $phone->sanitizeFreeText();
            }
        }
        if ($this->online) {
            foreach ($this->online as $online) {
                $online->sanitizeFreeText();
            }
        }
        if ($this->addresses) {
            foreach ($this->addresses as $addr) {
                $addr->sanitizeFreeText();
            }
        }

        $this->firstName = AdapterUtil::reencode($this->firstName);
        $this->lastName = AdapterUtil::reencode($this->lastName);
        $this->prefix = AdapterUtil::reencode($this->prefix);
        $this->suffix = AdapterUtil::reencode($this->suffix);
        $this->nickname = AdapterUtil::reencode($this->nickname);
        $this->jobTitle = AdapterUtil::reencode($this->jobTitle);
        $this->company = AdapterUtil::reencode($this->company);
        $this->department = AdapterUtil::reencode($this->department);
        $this->notes = AdapterUtil::reencode($this->notes);
        $this->middlename = AdapterUtil::reencode($this->middlename);
        $this->displayname = AdapterUtil::reencode($this->displayname);
        $this->maidenname = AdapterUtil::reencode($this->maidenname);
    }
}
