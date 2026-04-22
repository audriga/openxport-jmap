<?php

declare(strict_types=1);

namespace OpenXPort\Jmap\JSContact;

/**
 * Deserializes stdClass (from JSON) to ContactCard objects.
 * Handles all properties defined in RFC 9553.
 */
class ContactCardDeserializer
{
    /**
     * Convert stdClass from JSON to a ContactCard object
     *
     * @param \stdClass $data The JSON-decoded contact data
     * @return ContactCard
     */
    public static function fromStdClass($data)
    {
        $card = new ContactCard();

        if (isset($data->uid)) {
            $card->setUid($data->uid);
        }
        if (isset($data->kind)) {
            $card->setKind($data->kind);
        }
        if (isset($data->language)) {
            $card->setLanguage($data->language);
        }
        if (isset($data->created)) {
            $card->setCreated($data->created);
        }
        if (isset($data->updated)) {
            $card->setUpdated($data->updated);
        }
        if (isset($data->prodId)) {
            $card->setProdId($data->prodId);
        }
        if (isset($data->description)) {
            $card->setDescription($data->description);
        }
        if (isset($data->sortAs)) {
            $card->setSortAs($data->sortAs);
        }
        if (isset($data->notes)) {
            $card->setNotes($data->notes);
        }
        if (isset($data->version)) {
            $card->setVersion($data->version);
        }

        if (isset($data->addressBookIds)) {
            $card->setAddressBookIds($data->addressBookIds);
        }
        if (isset($data->keywords)) {
            $card->setKeywords((array)$data->keywords);
        }
        if (isset($data->members)) {
            $card->setMembers((array)$data->members);
        }

        // Name object
        if (isset($data->name)) {
            $card->setName(self::deserializeName($data->name));
        }

        // Nicknames
        if (isset($data->nicknames)) {
            $nicks = [];
            foreach ($data->nicknames as $id => $n) {
                $nicks[$id] = self::deserializeNickname($n);
            }
            $card->setNicknames($nicks);
        }

        // Organizations
        if (isset($data->organizations)) {
            $orgs = [];
            foreach ($data->organizations as $id => $o) {
                $orgs[$id] = self::deserializeOrganization($o);
            }
            $card->setOrganizations($orgs);
        }

        // Titles
        if (isset($data->titles)) {
            $titles = [];
            foreach ($data->titles as $id => $t) {
                $titles[$id] = self::deserializeTitle($t);
            }
            $card->setTitles($titles);
        }

        // Email addresses
        if (isset($data->emails)) {
            $emails = [];
            foreach ($data->emails as $id => $e) {
                $emails[$id] = self::deserializeEmail($e);
            }
            $card->setEmails($emails);
        }

        // Phones
        if (isset($data->phones)) {
            $phones = [];
            foreach ($data->phones as $id => $p) {
                $phones[$id] = self::deserializePhone($p);
            }
            $card->setPhones($phones);
        }

        // Online Services
        if (isset($data->onlineServices)) {
            $services = [];
            foreach ($data->onlineServices as $id => $os) {
                $services[$id] = self::deserializeOnlineService($os);
            }
            $card->setOnlineServices($services);
        }

        // Addresses
        if (isset($data->addresses)) {
            $addresses = [];
            foreach ($data->addresses as $id => $a) {
                $addresses[$id] = self::deserializeAddress($a);
            }
            $card->setAddresses($addresses);
        }

        // Media (photos)
        if (isset($data->media)) {
            $mediaItems = [];
            foreach ($data->media as $id => $m) {
                $mediaItems[$id] = self::deserializeMedia($m);
            }
            $card->setMedia($mediaItems);
        }

        // Anniversaries
        if (isset($data->anniversaries)) {
            $anns = [];
            foreach ($data->anniversaries as $a) {
                $anns[] = self::deserializeAnniversary($a);
            }
            $card->setAnniversaries($anns);
        }

        // Pronouns
        if (isset($data->pronouns)) {
            $pronounsList = [];
            foreach ($data->pronouns as $id => $p) {
                $pronounsList[$id] = self::deserializePronouns($p);
            }
            $card->setPronouns($pronounsList);
        }

        // Preferred Languages
        if (isset($data->preferredLanguages)) {
            $langs = [];
            foreach ($data->preferredLanguages as $id => $l) {
                $langs[$id] = self::deserializeLanguagePref($l);
            }
            $card->setPreferredLanguages($langs);
        }

        // Note Objects
        if (isset($data->noteObjects)) {
            $notes = [];
            foreach ($data->noteObjects as $id => $n) {
                $notes[$id] = self::deserializeNote($n);
            }
            $card->setNoteObjects($notes);
        }

        // Personal Info
        if (isset($data->personalInfo)) {
            $infos = [];
            foreach ($data->personalInfo as $id => $pi) {
                $infos[$id] = self::deserializePersonalInfo($pi);
            }
            $card->setPersonalInfo($infos);
        }

        // Related To
        if (isset($data->relatedTo)) {
            $relations = [];
            foreach ($data->relatedTo as $uid => $r) {
                $relations[$uid] = self::deserializeRelation($r);
            }
            $card->setRelatedTo($relations);
        }

        // Scheduling Addresses
        if (isset($data->schedulingAddresses)) {
            $schedAddrs = [];
            foreach ($data->schedulingAddresses as $id => $sa) {
                $schedAddrs[$id] = self::deserializeSchedulingAddress($sa);
            }
            $card->setSchedulingAddresses($schedAddrs);
        }

        // Calendars
        if (isset($data->calendars)) {
            $cals = [];
            foreach ($data->calendars as $id => $c) {
                $cals[$id] = self::deserializeCalendar($c);
            }
            $card->setCalendars($cals);
        }

        // Crypto Keys
        if (isset($data->cryptoKeys)) {
            $keys = [];
            foreach ($data->cryptoKeys as $id => $ck) {
                $keys[$id] = self::deserializeCryptoKey($ck);
            }
            $card->setCryptoKeys($keys);
        }

        // Directories
        if (isset($data->directories)) {
            $dirs = [];
            foreach ($data->directories as $id => $d) {
                $dirs[$id] = self::deserializeDirectory($d);
            }
            $card->setDirectories($dirs);
        }

        // Links
        if (isset($data->links)) {
            $links = [];
            foreach ($data->links as $id => $l) {
                $links[$id] = self::deserializeLink($l);
            }
            $card->setLinks($links);
        }

        // SpeakToAs
        if (isset($data->speakToAs)) {
            $card->setSpeakToAs(self::deserializeSpeakToAs($data->speakToAs));
        }

        return $card;
    }

    private static function deserializeName($data)
    {
        $name = new Name();
        if (isset($data->full)) {
            $name->setFull($data->full);
        }
        if (isset($data->isOrdered)) {
            $name->setIsOrdered($data->isOrdered);
        }
        if (isset($data->defaultSeparator)) {
            $name->setDefaultSeparator($data->defaultSeparator);
        }

        if (isset($data->components)) {
            $comps = [];
            foreach ($data->components as $c) {
                $nc = new NameComponent();
                if (isset($c->kind)) {
                    $nc->setKind($c->kind);
                }
                if (isset($c->value)) {
                    $nc->setValue($c->value);
                }
                $comps[] = $nc;
            }
            $name->setComponents($comps);
        }

        return $name;
    }

    private static function deserializeNickname($data)
    {
        $nick = new Nickname();
        if (isset($data->name)) {
            $nick->setName($data->name);
        }
        return $nick;
    }

    private static function deserializeOrganization($data)
    {
        $org = new Organization();
        if (isset($data->name)) {
            $org->setName($data->name);
        }
        if (isset($data->units)) {
            $org->setUnits((array)$data->units);
        }
        if (isset($data->sortAs)) {
            $org->setSortAs($data->sortAs);
        }
        if (isset($data->contexts)) {
            $org->setContexts((array)$data->contexts);
        }
        return $org;
    }

    private static function deserializeTitle($data)
    {
        $title = new Title();
        if (isset($data->name)) {
            $title->setName($data->name);
        }
        if (isset($data->kind)) {
            $title->setKind($data->kind);
        }
        if (isset($data->organizationId)) {
            $title->setOrganizationId($data->organizationId);
        }
        return $title;
    }

    private static function deserializeEmail($data)
    {
        $email = new EmailAddress();
        if (isset($data->address)) {
            $email->setAddress($data->address);
        }
        if (isset($data->contexts)) {
            $email->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $email->setPref($data->pref);
        }
        if (isset($data->label)) {
            $email->setLabel($data->label);
        }
        return $email;
    }

    private static function deserializePhone($data)
    {
        $phone = new Phone();
        if (isset($data->number)) {
            $phone->setNumber($data->number);
        }
        if (isset($data->contexts)) {
            $phone->setContexts((array)$data->contexts);
        }
        if (isset($data->features)) {
            $phone->setFeatures((array)$data->features);
        }
        if (isset($data->pref)) {
            $phone->setPref($data->pref);
        }
        if (isset($data->label)) {
            $phone->setLabel($data->label);
        }
        return $phone;
    }

    private static function deserializeOnlineService($data)
    {
        $service = new OnlineService();
        if (isset($data->service)) {
            $service->setService($data->service);
        }
        if (isset($data->uri)) {
            $service->setUri($data->uri);
        }
        if (isset($data->user)) {
            $service->setUser($data->user);
        }
        if (isset($data->contexts)) {
            $service->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $service->setPref($data->pref);
        }
        if (isset($data->label)) {
            $service->setLabel($data->label);
        }
        return $service;
    }

    private static function deserializeAddress($data)
    {
        $addr = new Address();
        if (isset($data->full)) {
            $addr->setFullAddress($data->full);
        }
        if (isset($data->isOrdered)) {
            $addr->setIsOrdered($data->isOrdered);
        }
        if (isset($data->defaultSeparator)) {
            $addr->setDefaultSeparator($data->defaultSeparator);
        }
        if (isset($data->contexts)) {
            $addr->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $addr->setPref($data->pref);
        }
        if (isset($data->timeZone)) {
            $addr->setTimeZone($data->timeZone);
        }
        if (isset($data->coordinates)) {
            $addr->setCoordinates($data->coordinates);
        }

        if (isset($data->components)) {
            $comps = [];
            foreach ($data->components as $c) {
                $ac = new AddressComponent();
                if (isset($c->kind)) {
                    $ac->setKind($c->kind);
                }
                if (isset($c->value)) {
                    $ac->setValue($c->value);
                }
                if (isset($c->phonetic)) {
                    $ac->setPhonetic($c->phonetic);
                }
                $comps[] = $ac;
            }
            $addr->setComponents($comps);
        }
        return $addr;
    }

    private static function deserializeMedia($data)
    {
        $media = new Media();
        if (isset($data->kind)) {
            $media->setKind($data->kind);
        }
        if (isset($data->uri)) {
            $media->setUri($data->uri);
        }
        if (isset($data->mediaType)) {
            $media->setMediaType($data->mediaType);
        }
        if (isset($data->pref)) {
            $media->setPref($data->pref);
        }
        if (isset($data->contexts)) {
            $media->setContexts((array)$data->contexts);
        }
        return $media;
    }

    private static function deserializeAnniversary($data)
    {
        $ann = new Anniversary();
        if (isset($data->kind)) {
            $ann->setKind($data->kind);
        }
        if (isset($data->date)) {
            $ann->setDate($data->date);
        }
        if (isset($data->label)) {
            $ann->setLabel($data->label);
        }
        return $ann;
    }

    private static function deserializePronouns($data)
    {
        $pronouns = new Pronouns();
        if (isset($data->pronouns)) {
            $pronouns->setPronouns($data->pronouns);
        }
        if (isset($data->contexts)) {
            $pronouns->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $pronouns->setPref($data->pref);
        }
        return $pronouns;
    }

    private static function deserializeLanguagePref($data)
    {
        $lang = new LanguagePref();
        if (isset($data->language)) {
            $lang->setLanguage($data->language);
        }
        if (isset($data->contexts)) {
            $lang->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $lang->setPref($data->pref);
        }
        return $lang;
    }

    private static function deserializeNote($data)
    {
        $note = new Note();
        if (isset($data->note)) {
            $note->setNote($data->note);
        }
        if (isset($data->created)) {
            $note->setCreated($data->created);
        }
        return $note;
    }

    private static function deserializePersonalInfo($data)
    {
        $info = new PersonalInformation();
        if (isset($data->kind)) {
            $info->setKind($data->kind);
        }
        if (isset($data->value)) {
            $info->setValue($data->value);
        }
        if (isset($data->level)) {
            $info->setLevel($data->level);
        }
        if (isset($data->listAs)) {
            $info->setListAs($data->listAs);
        }
        return $info;
    }

    private static function deserializeRelation($data)
    {
        $relation = new Relation();
        if (isset($data->relation)) {
            $relation->setRelation((array)$data->relation);
        }
        return $relation;
    }

    private static function deserializeSchedulingAddress($data)
    {
        $schedAddr = new SchedulingAddress();
        if (isset($data->uri)) {
            $schedAddr->setUri($data->uri);
        }
        if (isset($data->contexts)) {
            $schedAddr->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $schedAddr->setPref($data->pref);
        }
        return $schedAddr;
    }

    private static function deserializeCalendar($data)
    {
        $cal = new Calendar();
        if (isset($data->kind)) {
            $cal->setKind($data->kind);
        }
        if (isset($data->uri)) {
            $cal->setUri($data->uri);
        }
        if (isset($data->mediaType)) {
            $cal->setMediaType($data->mediaType);
        }
        if (isset($data->contexts)) {
            $cal->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $cal->setPref($data->pref);
        }
        return $cal;
    }

    private static function deserializeCryptoKey($data)
    {
        $key = new CryptoKey();
        if (isset($data->uri)) {
            $key->setUri($data->uri);
        }
        if (isset($data->contexts)) {
            $key->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $key->setPref($data->pref);
        }
        return $key;
    }

    private static function deserializeDirectory($data)
    {
        $dir = new Directory();
        if (isset($data->kind)) {
            $dir->setKind($data->kind);
        }
        if (isset($data->uri)) {
            $dir->setUri($data->uri);
        }
        if (isset($data->contexts)) {
            $dir->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $dir->setPref($data->pref);
        }
        return $dir;
    }

    private static function deserializeLink($data)
    {
        $link = new Link();
        if (isset($data->kind)) {
            $link->setKind($data->kind);
        }
        if (isset($data->uri)) {
            $link->setUri($data->uri);
        }
        if (isset($data->mediaType)) {
            $link->setMediaType($data->mediaType);
        }
        if (isset($data->contexts)) {
            $link->setContexts((array)$data->contexts);
        }
        if (isset($data->pref)) {
            $link->setPref($data->pref);
        }
        return $link;
    }

    private static function deserializeSpeakToAs($data)
    {
        $sta = new SpeakToAs();
        if (isset($data->grammaticalGender)) {
            $sta->setGrammaticalGender($data->grammaticalGender);
        }
        if (isset($data->pronouns)) {
            $sta->setPronouns((array)$data->pronouns);
        }
        return $sta;
    }
}
