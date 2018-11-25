
<?php
$header[1]['src'] = '//miketabor.com/banners/Altaro-VM-300_250.png';
$header[1]['link'] = 'https://miketabor.com/links/altaro/';
$header[1]['title'] = 'Altaro VM Backup';
$header[2]['src'] = '//miketabor.com/banners/Thinscale300x250.png';
$header[2]['link'] = 'https://miketabor.com/links/thinscale/';
$header[2]['title'] = 'ThinScale';
$header[3]['src'] = '//miketabor.com/banners/1709_vm_troubleshooting-banners_300x250.png';
$header[3]['link'] = 'https://miketabor.com/links/solarwinds300/';
$header[3]['title'] = 'SolarWinds';

shuffle( $header );
$headerad = '';
foreach( $header as $arr )
{
    $headerad .= '<div style="text-align:center; padding-bottom:8px;"><a href="' . $arr['link'] . '" title="' . $arr['title'] . '" rel="nofollow external" class="250ban"><img src="' . $arr['src'] . '" alt="' . $arr['title'] . '" width="300" height="250" /></a></div>';
}

echo $headerad;

?>
