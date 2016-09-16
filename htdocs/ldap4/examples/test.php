<?php

function explode_dn($dn, $with_attributes=0)
{
    $result = ldap_explode_dn($dn, $with_attributes);
    foreach($result as $key => $value) $result[$key] = preg_replace("/\\\([0-9A-Fa-f]{2})/e", "''.chr(hexdec('\\1')).''", $value);
    return $result;
}

function get_members($group,$user,$password) {
    $ldap_host = "ServerAD.vmap.com";
    $ldap_dn = "OU=some_group,OU=some_group,DC=vmap,DC=com";
    $base_dn = "DC=vmap,DC=com";
    $ldap_usr_dom = "@vmap.com";
    $ldap = ldap_connect($ldap_host);

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION,3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS,0);

    ldap_bind($ldap, $user . $ldap_usr_dom, $password);
    $results = ldap_search($ldap,$ldap_dn, "cn=" . $group);
    $member_list = ldap_get_entries($ldap, $results);

    $dirty = 0;
    $group_member_details = array();

    foreach($member_list[0]['member'] as $member) {
        if($dirty == 0) {
            $dirty = 1;
        } else {
            $member_dn = explode_dn($member);
            $member_cn = str_replace("CN=","",$member_dn[0]);
            $member_search = ldap_search($ldap, $base_dn, "(CN=" . $member_cn . ")");
            $member_details = ldap_get_entries($ldap, $member_search);
            $group_member_details[] = array($member_details[0]['givenname'][0],$member_details[0]['sn'][0],$member_details[0]['telephonenumber'][0],$member_details[0]['othertelephone'][0]);
        }
    }
    ldap_close($ldap);
    return $group_member_details;
}

// Specify the group from where to get members and a username and password with rights to query it
$result = get_members("groupname","username","password");

// The following will create an XML file with the details from $group_member_details
$xml = simplexml_load_string("<?xml version='1.0'?>\n<AddressBook></AddressBook>");
$version = $xml->addChild('version', '1');

foreach($result as $e) {
    $contact = $xml->addChild('Contact');
    $contact->addChild('FirstName', $e[0]);
    $contact->addChild('LastName', $e[1]);
    $phone = $contact->addChild('Phone');
    if ($e[3] == '') {
                $phone->addChild('phonenumber', '0');
        } else {
                $phone->addChild('phonenumber', $e[3]);
        }
    $phone->addChild('accountindex', '0');
    $phone = $contact->addChild('Phone');
    if ($e[2] == '') {
        $phone->addChild('phonenumber', '0');
    } else {
        $phone->addChild('phonenumber', $e[2]);
    }
    $phone->addChild('accountindex', '1');
    $contact->addChild('Group', '0');
    $contact->addChild('PhotoUrl', 'empty');
}

$xml->asXML('phonebook.xml');

?>