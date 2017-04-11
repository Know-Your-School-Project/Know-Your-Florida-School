<?php

require_once( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );

$charterSchool      = $schoolData[count($schoolData)-1]["CharterSchool"];
$districtName       = $schoolData[count($schoolData)-1]["DISTRICT_NAME"];
$faxNumber          = $schoolData[count($schoolData)-1]["FAX_NUMBER"];
$gradeRange         = $schoolData[count($schoolData)-1]["GradeRange"]; 
$latitude           = $schoolData[count($schoolData)-1]["LATITUDE"]; 
$longitude          = $schoolData[count($schoolData)-1]["LONGITUDE"]; 
$magnetPurpose      = $schoolData[count($schoolData)-1]["MAGNET_PURPOSE"]; 
$magnetSpecialty    = $schoolData[count($schoolData)-1]["MAGNET_SPECIALTY"];  
$magnetStatus       = $schoolData[count($schoolData)-1]["MAGNET_STATUS"]; 
$mailingAddress1    = $schoolData[count($schoolData)-1]["MAILING_ADDRESS1"]; 
$mailingAddress2    = $schoolData[count($schoolData)-1]["MAILING_ADDRESS2"]; 
$mailingCity        = $schoolData[count($schoolData)-1]["MAILING_CITY"]; 
$mailingState       = $schoolData[count($schoolData)-1]["MAILING_STATE"]; 
$mailingZip         = $schoolData[count($schoolData)-1]["MAILING_ZIP"]; 
$phoneNumber        = $schoolData[count($schoolData)-1]["PHONE_NUMBER"]; 
$address            = $schoolData[count($schoolData)-1]["PHYSICAL_ADDRESS"]; 
$city               = $schoolData[count($schoolData)-1]["PHYSICAL_CITY"]; 
$state              = $schoolData[count($schoolData)-1]["PHYSICAL_STATE"]; 
$zip                = $schoolData[count($schoolData)-1]["PHYSICAL_ZIP"]; 
$principalFirst     = $schoolData[count($schoolData)-1]["PRINCIPAL_FIRST"]; 
$principalLast      = $schoolData[count($schoolData)-1]["PRINCIPAL_LAST"]; 
$principalMiddle    = $schoolData[count($schoolData)-1]["PRINCIPAL_MI"]; 
$principalTitle     = $schoolData[count($schoolData)-1]["PRINCIPAL_TITLE"];
$schoolType         = $schoolData[count($schoolData)-1]["TYPE"];   
$webAddress         = $schoolData[count($schoolData)-1]["WEB_ADDRESS"]; 
$yearRoundSchool    = $schoolData[count($schoolData)-1]["YEAR_ROUND_SCHOOL"]; 
$superintendentInd  = $schoolData[count($schoolData)-1]["SUPERINTENDENT_IND"]; 
$titleIStatus       = $schoolData[count($schoolData)-1]["TITLE_I_STATUS"]; 

if ( $districtName != "" ) {
	echo "<span class=\"stat stat-district\"><h6>District</h6><p>" . ucwords(strtolower($districtName)) . "</p></span>";
}
if ( $principalFirst != "" || $principalMiddle != "" || $principalLast != "" ) {
	echo "<span class=\"stat stat-principal\"><h6>Principal</h6><p>" . ucwords(strtolower($principalFirst)) . " " . ucwords(strtolower($principalMiddle)) . " " . ucwords(strtolower($principalLast)) . "</p></span>";
}
if ( $phoneNumber != "" ) {
	echo "<span class=\"stat stat-phone\"><h6>Phone</h6><p>" . sprintf("%s-%s-%s", substr($phoneNumber, 0, 3), substr($phoneNumber, 3, 3), substr($phoneNumber, 6)) . "</p></span>";
}
if ( $faxNumber != "" ) {
	echo "<span class=\"stat stat-fax\"><h6>Fax</h6><p>" . sprintf("%s-%s-%s", substr($faxNumber, 0, 3), substr($faxNumber, 3, 3), substr($faxNumber, 6)) . "</p></span>";
}
if ( $webAddress != "" ) {
	echo '<span class="stat stat-website"><h6>Website</h6><p><a href="' . $webAddress . '" target="_blank" title="Visit ' . $schoolName . '\'s Website" class="website-link">' . strtolower($webAddress) . "</a></p></span>";
}
echo "<span class=\"stat stat-mailing-address\"><h6>Mailing Address</h6><p>" . ucwords(strtolower($mailingAddress1)) . " " . ucwords(strtolower($mailingAddress2)) . " " . ucwords(strtolower($mailingCity)) . ", " . $mailingState . " " . $mailingZip . "</p></span>";
if ( $charterSchool != "" ) {
    $CharterSchools = api_call("https://api.jaxpef.org/charterschool/charterschool/?APIKey=" . $apiKEY, get_stylesheet_directory() . "/cache/charterschools.json");
    $CharterSchools = $CharterSchools->CharterSchool;
    if ( count($CharterSchools) > 0 ) {
        foreach ($CharterSchools as $CharterSchool) {
            if ( $CharterSchool->CharterSchool == $charterSchool ) {
                echo '<span class="stat stat-magnet-status"><h6>Charter</h6><p>' . $CharterSchool->CharterSchool_NAME . "</a></p></span>";
            }
        }
    }
}
if ( $magnetStatus != "" ) {
    $MagnetStatuses = api_call("https://api.jaxpef.org/magnetstatus/magnetstatus/?APIKey=" . $apiKEY, get_stylesheet_directory() . "/cache/magnetstatus.json");
    $MagnetStatuses = $MagnetStatuses->MagnetStatus;
    if ( count($MagnetStatuses) > 0 ) {
        foreach ($MagnetStatuses as $MagnetStatus) {
            if ( $MagnetStatus->MAGNET_STATUS == $magnetStatus ) {
                echo '<span class="stat stat-magnet-status"><h6>Magnet</h6><p>' . $MagnetStatus->MAGNET_STATUS_NAME . "</a></p></span>";
            }
        }
    }
}

?>