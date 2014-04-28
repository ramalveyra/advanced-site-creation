<style>
	.asc_option_table{
		width: 100%;
		border-collapse: collapse;
    	
	}
	.asc_option_table tr th {
		text-align: left;font-size: 12px;
		background: #ddd;padding: 6px;
		border:1px solid #ccc;
	}
	.asc_option_table tr td{
		border: 1px solid #ccc;
		padding: 6px;
	}
	.asc_option_table tr td.label{
		width: 20%;
	}
	.asc_option_table tr td.values{
		width: 50%;
	}
	.ui-widget-content{
		background:#f1f1f1 !important; 
		
	}
</style>
<div class="wrap">
<h2><?php echo __('Advanced Site Creation: Build Site Settings');?></h2>
<p><?php echo __('This page enables you to build the settings you want to be available for a new site. These settings will be available when the "Create Site from Built Settings" is selected. You can also set random settings values for site creation.');?></p>

<p><strong>* Include on site creation</strong> - <em>Check this if you want the setting to be available during site creation. Otherwise it will use Wordpress default values.</em></p>

<p><strong>* Randomize</strong> - <em>Check this if you want the plugin to generate random values of a setting. Add/Remove the values for each setting you want to be available when applying the randomize command.</em></p>
<form name="asc_build_site_settings_frm" action="<?php echo network_admin_url('settings.php?page=asc_build_site_settings');?>" method="post">
<div id="accordion">
<h3>General Settings</h3>
<div>
	<h4>Timezone</h4>
	<table class="asc_option_table">
		<tbody>
			<tr>
				<th>Option Code</th>
				<th>Values</th>
				<th>Include on site creation</th>
				<th>Randomize</th>
				
			</tr>
			<tr>
				<td class="label"><em>timezone_string</em></td>
				<td class="values">
					<select id="timezone_string" name="timezone_string">
						<optgroup label="Africa">
						<option value="Africa/Abidjan">Abidjan</option>
						<option value="Africa/Accra">Accra</option>
						<option value="Africa/Addis_Ababa">Addis Ababa</option>
						<option value="Africa/Algiers">Algiers</option>
						<option value="Africa/Asmara">Asmara</option>
						<option value="Africa/Bamako">Bamako</option>
						<option value="Africa/Bangui">Bangui</option>
						<option value="Africa/Banjul">Banjul</option>
						<option value="Africa/Bissau">Bissau</option>
						<option value="Africa/Blantyre">Blantyre</option>
						<option value="Africa/Brazzaville">Brazzaville</option>
						<option value="Africa/Bujumbura">Bujumbura</option>
						<option value="Africa/Cairo">Cairo</option>
						<option value="Africa/Casablanca">Casablanca</option>
						<option value="Africa/Ceuta">Ceuta</option>
						<option value="Africa/Conakry">Conakry</option>
						<option value="Africa/Dakar">Dakar</option>
						<option value="Africa/Dar_es_Salaam">Dar es Salaam</option>
						<option value="Africa/Djibouti">Djibouti</option>
						<option value="Africa/Douala">Douala</option>
						<option value="Africa/El_Aaiun">El Aaiun</option>
						<option value="Africa/Freetown">Freetown</option>
						<option value="Africa/Gaborone">Gaborone</option>
						<option value="Africa/Harare">Harare</option>
						<option value="Africa/Johannesburg">Johannesburg</option>
						<option value="Africa/Juba">Juba</option>
						<option value="Africa/Kampala">Kampala</option>
						<option value="Africa/Khartoum">Khartoum</option>
						<option value="Africa/Kigali">Kigali</option>
						<option value="Africa/Kinshasa">Kinshasa</option>
						<option value="Africa/Lagos">Lagos</option>
						<option value="Africa/Libreville">Libreville</option>
						<option value="Africa/Lome">Lome</option>
						<option value="Africa/Luanda">Luanda</option>
						<option value="Africa/Lubumbashi">Lubumbashi</option>
						<option value="Africa/Lusaka">Lusaka</option>
						<option value="Africa/Malabo">Malabo</option>
						<option value="Africa/Maputo">Maputo</option>
						<option value="Africa/Maseru">Maseru</option>
						<option value="Africa/Mbabane">Mbabane</option>
						<option value="Africa/Mogadishu">Mogadishu</option>
						<option value="Africa/Monrovia">Monrovia</option>
						<option value="Africa/Nairobi">Nairobi</option>
						<option value="Africa/Ndjamena">Ndjamena</option>
						<option value="Africa/Niamey">Niamey</option>
						<option value="Africa/Nouakchott">Nouakchott</option>
						<option value="Africa/Ouagadougou">Ouagadougou</option>
						<option value="Africa/Porto-Novo">Porto-Novo</option>
						<option value="Africa/Sao_Tome">Sao Tome</option>
						<option value="Africa/Tripoli">Tripoli</option>
						<option value="Africa/Tunis">Tunis</option>
						<option value="Africa/Windhoek">Windhoek</option>
						</optgroup>
						<optgroup label="America">
						<option value="America/Adak">Adak</option>
						<option value="America/Anchorage">Anchorage</option>
						<option value="America/Anguilla">Anguilla</option>
						<option value="America/Antigua">Antigua</option>
						<option value="America/Araguaina">Araguaina</option>
						<option value="America/Argentina/Buenos_Aires">Argentina - Buenos Aires</option>
						<option value="America/Argentina/Catamarca">Argentina - Catamarca</option>
						<option value="America/Argentina/Cordoba">Argentina - Cordoba</option>
						<option value="America/Argentina/Jujuy">Argentina - Jujuy</option>
						<option value="America/Argentina/La_Rioja">Argentina - La Rioja</option>
						<option value="America/Argentina/Mendoza">Argentina - Mendoza</option>
						<option value="America/Argentina/Rio_Gallegos">Argentina - Rio Gallegos</option>
						<option value="America/Argentina/Salta">Argentina - Salta</option>
						<option value="America/Argentina/San_Juan">Argentina - San Juan</option>
						<option value="America/Argentina/San_Luis">Argentina - San Luis</option>
						<option value="America/Argentina/Tucuman">Argentina - Tucuman</option>
						<option value="America/Argentina/Ushuaia">Argentina - Ushuaia</option>
						<option value="America/Aruba">Aruba</option>
						<option value="America/Asuncion">Asuncion</option>
						<option value="America/Atikokan">Atikokan</option>
						<option value="America/Bahia">Bahia</option>
						<option value="America/Bahia_Banderas">Bahia Banderas</option>
						<option value="America/Barbados">Barbados</option>
						<option value="America/Belem">Belem</option>
						<option value="America/Belize">Belize</option>
						<option value="America/Blanc-Sablon">Blanc-Sablon</option>
						<option value="America/Boa_Vista">Boa Vista</option>
						<option value="America/Bogota">Bogota</option>
						<option value="America/Boise">Boise</option>
						<option value="America/Cambridge_Bay">Cambridge Bay</option>
						<option value="America/Campo_Grande">Campo Grande</option>
						<option value="America/Cancun">Cancun</option>
						<option value="America/Caracas">Caracas</option>
						<option value="America/Cayenne">Cayenne</option>
						<option value="America/Cayman">Cayman</option>
						<option value="America/Chicago">Chicago</option>
						<option value="America/Chihuahua">Chihuahua</option>
						<option value="America/Costa_Rica">Costa Rica</option>
						<option value="America/Creston">Creston</option>
						<option value="America/Cuiaba">Cuiaba</option>
						<option value="America/Curacao">Curacao</option>
						<option value="America/Danmarkshavn">Danmarkshavn</option>
						<option value="America/Dawson">Dawson</option>
						<option value="America/Dawson_Creek">Dawson Creek</option>
						<option value="America/Denver">Denver</option>
						<option value="America/Detroit">Detroit</option>
						<option value="America/Dominica">Dominica</option>
						<option value="America/Edmonton">Edmonton</option>
						<option value="America/Eirunepe">Eirunepe</option>
						<option value="America/El_Salvador">El Salvador</option>
						<option value="America/Fortaleza">Fortaleza</option>
						<option value="America/Glace_Bay">Glace Bay</option>
						<option value="America/Godthab">Godthab</option>
						<option value="America/Goose_Bay">Goose Bay</option>
						<option value="America/Grand_Turk">Grand Turk</option>
						<option value="America/Grenada">Grenada</option>
						<option value="America/Guadeloupe">Guadeloupe</option>
						<option value="America/Guatemala">Guatemala</option>
						<option value="America/Guayaquil">Guayaquil</option>
						<option value="America/Guyana">Guyana</option>
						<option value="America/Halifax">Halifax</option>
						<option value="America/Havana">Havana</option>
						<option value="America/Hermosillo">Hermosillo</option>
						<option value="America/Indiana/Indianapolis">Indiana - Indianapolis</option>
						<option value="America/Indiana/Knox">Indiana - Knox</option>
						<option value="America/Indiana/Marengo">Indiana - Marengo</option>
						<option value="America/Indiana/Petersburg">Indiana - Petersburg</option>
						<option value="America/Indiana/Tell_City">Indiana - Tell City</option>
						<option value="America/Indiana/Vevay">Indiana - Vevay</option>
						<option value="America/Indiana/Vincennes">Indiana - Vincennes</option>
						<option value="America/Indiana/Winamac">Indiana - Winamac</option>
						<option value="America/Inuvik">Inuvik</option>
						<option value="America/Iqaluit">Iqaluit</option>
						<option value="America/Jamaica">Jamaica</option>
						<option value="America/Juneau">Juneau</option>
						<option value="America/Kentucky/Louisville">Kentucky - Louisville</option>
						<option value="America/Kentucky/Monticello">Kentucky - Monticello</option>
						<option value="America/Kralendijk">Kralendijk</option>
						<option value="America/La_Paz">La Paz</option>
						<option value="America/Lima">Lima</option>
						<option value="America/Los_Angeles">Los Angeles</option>
						<option value="America/Lower_Princes">Lower Princes</option>
						<option value="America/Maceio">Maceio</option>
						<option value="America/Managua">Managua</option>
						<option value="America/Manaus">Manaus</option>
						<option value="America/Marigot">Marigot</option>
						<option value="America/Martinique">Martinique</option>
						<option value="America/Matamoros">Matamoros</option>
						<option value="America/Mazatlan">Mazatlan</option>
						<option value="America/Menominee">Menominee</option>
						<option value="America/Merida">Merida</option>
						<option value="America/Metlakatla">Metlakatla</option>
						<option value="America/Mexico_City">Mexico City</option>
						<option value="America/Miquelon">Miquelon</option>
						<option value="America/Moncton">Moncton</option>
						<option value="America/Monterrey">Monterrey</option>
						<option value="America/Montevideo">Montevideo</option>
						<option value="America/Montreal">Montreal</option>
						<option value="America/Montserrat">Montserrat</option>
						<option value="America/Nassau">Nassau</option>
						<option value="America/New_York">New York</option>
						<option value="America/Nipigon">Nipigon</option>
						<option value="America/Nome">Nome</option>
						<option value="America/Noronha">Noronha</option>
						<option value="America/North_Dakota/Beulah">North Dakota - Beulah</option>
						<option value="America/North_Dakota/Center">North Dakota - Center</option>
						<option value="America/North_Dakota/New_Salem">North Dakota - New Salem</option>
						<option value="America/Ojinaga">Ojinaga</option>
						<option value="America/Panama">Panama</option>
						<option value="America/Pangnirtung">Pangnirtung</option>
						<option value="America/Paramaribo">Paramaribo</option>
						<option value="America/Phoenix">Phoenix</option>
						<option value="America/Port-au-Prince">Port-au-Prince</option>
						<option value="America/Port_of_Spain">Port of Spain</option>
						<option value="America/Porto_Velho">Porto Velho</option>
						<option value="America/Puerto_Rico">Puerto Rico</option>
						<option value="America/Rainy_River">Rainy River</option>
						<option value="America/Rankin_Inlet">Rankin Inlet</option>
						<option value="America/Recife">Recife</option>
						<option value="America/Regina">Regina</option>
						<option value="America/Resolute">Resolute</option>
						<option value="America/Rio_Branco">Rio Branco</option>
						<option value="America/Santa_Isabel">Santa Isabel</option>
						<option value="America/Santarem">Santarem</option>
						<option value="America/Santiago">Santiago</option>
						<option value="America/Santo_Domingo">Santo Domingo</option>
						<option value="America/Sao_Paulo">Sao Paulo</option>
						<option value="America/Scoresbysund">Scoresbysund</option>
						<option value="America/Shiprock">Shiprock</option>
						<option value="America/Sitka">Sitka</option>
						<option value="America/St_Barthelemy">St Barthelemy</option>
						<option value="America/St_Johns">St Johns</option>
						<option value="America/St_Kitts">St Kitts</option>
						<option value="America/St_Lucia">St Lucia</option>
						<option value="America/St_Thomas">St Thomas</option>
						<option value="America/St_Vincent">St Vincent</option>
						<option value="America/Swift_Current">Swift Current</option>
						<option value="America/Tegucigalpa">Tegucigalpa</option>
						<option value="America/Thule">Thule</option>
						<option value="America/Thunder_Bay">Thunder Bay</option>
						<option value="America/Tijuana">Tijuana</option>
						<option value="America/Toronto">Toronto</option>
						<option value="America/Tortola">Tortola</option>
						<option value="America/Vancouver">Vancouver</option>
						<option value="America/Whitehorse">Whitehorse</option>
						<option value="America/Winnipeg">Winnipeg</option>
						<option value="America/Yakutat">Yakutat</option>
						<option value="America/Yellowknife">Yellowknife</option>
						</optgroup>
						<optgroup label="Antarctica">
						<option value="Antarctica/Casey">Casey</option>
						<option value="Antarctica/Davis">Davis</option>
						<option value="Antarctica/DumontDUrville">DumontDUrville</option>
						<option value="Antarctica/Macquarie">Macquarie</option>
						<option value="Antarctica/Mawson">Mawson</option>
						<option value="Antarctica/McMurdo">McMurdo</option>
						<option value="Antarctica/Palmer">Palmer</option>
						<option value="Antarctica/Rothera">Rothera</option>
						<option value="Antarctica/South_Pole">South Pole</option>
						<option value="Antarctica/Syowa">Syowa</option>
						<option value="Antarctica/Vostok">Vostok</option>
						</optgroup>
						<optgroup label="Arctic">
						<option value="Arctic/Longyearbyen">Longyearbyen</option>
						</optgroup>
						<optgroup label="Asia">
						<option value="Asia/Aden">Aden</option>
						<option value="Asia/Almaty">Almaty</option>
						<option value="Asia/Amman">Amman</option>
						<option value="Asia/Anadyr">Anadyr</option>
						<option value="Asia/Aqtau">Aqtau</option>
						<option value="Asia/Aqtobe">Aqtobe</option>
						<option value="Asia/Ashgabat">Ashgabat</option>
						<option value="Asia/Baghdad">Baghdad</option>
						<option value="Asia/Bahrain">Bahrain</option>
						<option value="Asia/Baku">Baku</option>
						<option value="Asia/Bangkok">Bangkok</option>
						<option value="Asia/Beirut">Beirut</option>
						<option value="Asia/Bishkek">Bishkek</option>
						<option value="Asia/Brunei">Brunei</option>
						<option value="Asia/Choibalsan">Choibalsan</option>
						<option value="Asia/Chongqing">Chongqing</option>
						<option value="Asia/Colombo">Colombo</option>
						<option value="Asia/Damascus">Damascus</option>
						<option value="Asia/Dhaka">Dhaka</option>
						<option value="Asia/Dili">Dili</option>
						<option value="Asia/Dubai">Dubai</option>
						<option value="Asia/Dushanbe">Dushanbe</option>
						<option value="Asia/Gaza">Gaza</option>
						<option value="Asia/Harbin">Harbin</option>
						<option value="Asia/Hebron">Hebron</option>
						<option value="Asia/Ho_Chi_Minh">Ho Chi Minh</option>
						<option value="Asia/Hong_Kong">Hong Kong</option>
						<option value="Asia/Hovd">Hovd</option>
						<option value="Asia/Irkutsk">Irkutsk</option>
						<option value="Asia/Jakarta">Jakarta</option>
						<option value="Asia/Jayapura">Jayapura</option>
						<option value="Asia/Jerusalem">Jerusalem</option>
						<option value="Asia/Kabul">Kabul</option>
						<option value="Asia/Kamchatka">Kamchatka</option>
						<option value="Asia/Karachi">Karachi</option>
						<option value="Asia/Kashgar">Kashgar</option>
						<option value="Asia/Kathmandu">Kathmandu</option>
						<option value="Asia/Kolkata">Kolkata</option>
						<option value="Asia/Krasnoyarsk">Krasnoyarsk</option>
						<option value="Asia/Kuala_Lumpur">Kuala Lumpur</option>
						<option value="Asia/Kuching">Kuching</option>
						<option value="Asia/Kuwait">Kuwait</option>
						<option value="Asia/Macau">Macau</option>
						<option value="Asia/Magadan">Magadan</option>
						<option value="Asia/Makassar">Makassar</option>
						<option value="Asia/Manila">Manila</option>
						<option value="Asia/Muscat">Muscat</option>
						<option value="Asia/Nicosia">Nicosia</option>
						<option value="Asia/Novokuznetsk">Novokuznetsk</option>
						<option value="Asia/Novosibirsk">Novosibirsk</option>
						<option value="Asia/Omsk">Omsk</option>
						<option value="Asia/Oral">Oral</option>
						<option value="Asia/Phnom_Penh">Phnom Penh</option>
						<option value="Asia/Pontianak">Pontianak</option>
						<option value="Asia/Pyongyang">Pyongyang</option>
						<option value="Asia/Qatar">Qatar</option>
						<option value="Asia/Qyzylorda">Qyzylorda</option>
						<option value="Asia/Rangoon">Rangoon</option>
						<option value="Asia/Riyadh">Riyadh</option>
						<option value="Asia/Sakhalin">Sakhalin</option>
						<option value="Asia/Samarkand">Samarkand</option>
						<option value="Asia/Seoul">Seoul</option>
						<option value="Asia/Shanghai">Shanghai</option>
						<option value="Asia/Singapore">Singapore</option>
						<option value="Asia/Taipei">Taipei</option>
						<option value="Asia/Tashkent">Tashkent</option>
						<option value="Asia/Tbilisi">Tbilisi</option>
						<option value="Asia/Tehran">Tehran</option>
						<option value="Asia/Thimphu">Thimphu</option>
						<option value="Asia/Tokyo">Tokyo</option>
						<option value="Asia/Ulaanbaatar">Ulaanbaatar</option>
						<option value="Asia/Urumqi">Urumqi</option>
						<option value="Asia/Vientiane">Vientiane</option>
						<option value="Asia/Vladivostok">Vladivostok</option>
						<option value="Asia/Yakutsk">Yakutsk</option>
						<option value="Asia/Yekaterinburg">Yekaterinburg</option>
						<option value="Asia/Yerevan">Yerevan</option>
						</optgroup>
						<optgroup label="Atlantic">
						<option value="Atlantic/Azores">Azores</option>
						<option value="Atlantic/Bermuda">Bermuda</option>
						<option value="Atlantic/Canary">Canary</option>
						<option value="Atlantic/Cape_Verde">Cape Verde</option>
						<option value="Atlantic/Faroe">Faroe</option>
						<option value="Atlantic/Madeira">Madeira</option>
						<option value="Atlantic/Reykjavik">Reykjavik</option>
						<option value="Atlantic/South_Georgia">South Georgia</option>
						<option value="Atlantic/Stanley">Stanley</option>
						<option value="Atlantic/St_Helena">St Helena</option>
						</optgroup>
						<optgroup label="Australia">
						<option value="Australia/Adelaide">Adelaide</option>
						<option value="Australia/Brisbane">Brisbane</option>
						<option value="Australia/Broken_Hill">Broken Hill</option>
						<option value="Australia/Currie">Currie</option>
						<option value="Australia/Darwin">Darwin</option>
						<option value="Australia/Eucla">Eucla</option>
						<option value="Australia/Hobart">Hobart</option>
						<option value="Australia/Lindeman">Lindeman</option>
						<option value="Australia/Lord_Howe">Lord Howe</option>
						<option value="Australia/Melbourne">Melbourne</option>
						<option value="Australia/Perth">Perth</option>
						<option value="Australia/Sydney">Sydney</option>
						</optgroup>
						<optgroup label="Europe">
						<option value="Europe/Amsterdam">Amsterdam</option>
						<option value="Europe/Andorra">Andorra</option>
						<option value="Europe/Athens">Athens</option>
						<option value="Europe/Belgrade">Belgrade</option>
						<option value="Europe/Berlin">Berlin</option>
						<option value="Europe/Bratislava">Bratislava</option>
						<option value="Europe/Brussels">Brussels</option>
						<option value="Europe/Bucharest">Bucharest</option>
						<option value="Europe/Budapest">Budapest</option>
						<option value="Europe/Chisinau">Chisinau</option>
						<option value="Europe/Copenhagen">Copenhagen</option>
						<option value="Europe/Dublin">Dublin</option>
						<option value="Europe/Gibraltar">Gibraltar</option>
						<option value="Europe/Guernsey">Guernsey</option>
						<option value="Europe/Helsinki">Helsinki</option>
						<option value="Europe/Isle_of_Man">Isle of Man</option>
						<option value="Europe/Istanbul">Istanbul</option>
						<option value="Europe/Jersey">Jersey</option>
						<option value="Europe/Kaliningrad">Kaliningrad</option>
						<option value="Europe/Kiev">Kiev</option>
						<option value="Europe/Lisbon">Lisbon</option>
						<option value="Europe/Ljubljana">Ljubljana</option>
						<option value="Europe/London">London</option>
						<option value="Europe/Luxembourg">Luxembourg</option>
						<option value="Europe/Madrid">Madrid</option>
						<option value="Europe/Malta">Malta</option>
						<option value="Europe/Mariehamn">Mariehamn</option>
						<option value="Europe/Minsk">Minsk</option>
						<option value="Europe/Monaco">Monaco</option>
						<option value="Europe/Moscow">Moscow</option>
						<option value="Europe/Oslo">Oslo</option>
						<option value="Europe/Paris">Paris</option>
						<option value="Europe/Podgorica">Podgorica</option>
						<option value="Europe/Prague">Prague</option>
						<option value="Europe/Riga">Riga</option>
						<option value="Europe/Rome">Rome</option>
						<option value="Europe/Samara">Samara</option>
						<option value="Europe/San_Marino">San Marino</option>
						<option value="Europe/Sarajevo">Sarajevo</option>
						<option value="Europe/Simferopol">Simferopol</option>
						<option value="Europe/Skopje">Skopje</option>
						<option value="Europe/Sofia">Sofia</option>
						<option value="Europe/Stockholm">Stockholm</option>
						<option value="Europe/Tallinn">Tallinn</option>
						<option value="Europe/Tirane">Tirane</option>
						<option value="Europe/Uzhgorod">Uzhgorod</option>
						<option value="Europe/Vaduz">Vaduz</option>
						<option value="Europe/Vatican">Vatican</option>
						<option value="Europe/Vienna">Vienna</option>
						<option value="Europe/Vilnius">Vilnius</option>
						<option value="Europe/Volgograd">Volgograd</option>
						<option value="Europe/Warsaw">Warsaw</option>
						<option value="Europe/Zagreb">Zagreb</option>
						<option value="Europe/Zaporozhye">Zaporozhye</option>
						<option value="Europe/Zurich">Zurich</option>
						</optgroup>
						<optgroup label="Indian">
						<option value="Indian/Antananarivo">Antananarivo</option>
						<option value="Indian/Chagos">Chagos</option>
						<option value="Indian/Christmas">Christmas</option>
						<option value="Indian/Cocos">Cocos</option>
						<option value="Indian/Comoro">Comoro</option>
						<option value="Indian/Kerguelen">Kerguelen</option>
						<option value="Indian/Mahe">Mahe</option>
						<option value="Indian/Maldives">Maldives</option>
						<option value="Indian/Mauritius">Mauritius</option>
						<option value="Indian/Mayotte">Mayotte</option>
						<option value="Indian/Reunion">Reunion</option>
						</optgroup>
						<optgroup label="Pacific">
						<option value="Pacific/Apia">Apia</option>
						<option value="Pacific/Auckland">Auckland</option>
						<option value="Pacific/Chatham">Chatham</option>
						<option value="Pacific/Chuuk">Chuuk</option>
						<option value="Pacific/Easter">Easter</option>
						<option value="Pacific/Efate">Efate</option>
						<option value="Pacific/Enderbury">Enderbury</option>
						<option value="Pacific/Fakaofo">Fakaofo</option>
						<option value="Pacific/Fiji">Fiji</option>
						<option value="Pacific/Funafuti">Funafuti</option>
						<option value="Pacific/Galapagos">Galapagos</option>
						<option value="Pacific/Gambier">Gambier</option>
						<option value="Pacific/Guadalcanal">Guadalcanal</option>
						<option value="Pacific/Guam">Guam</option>
						<option value="Pacific/Honolulu">Honolulu</option>
						<option value="Pacific/Johnston">Johnston</option>
						<option value="Pacific/Kiritimati">Kiritimati</option>
						<option value="Pacific/Kosrae">Kosrae</option>
						<option value="Pacific/Kwajalein">Kwajalein</option>
						<option value="Pacific/Majuro">Majuro</option>
						<option value="Pacific/Marquesas">Marquesas</option>
						<option value="Pacific/Midway">Midway</option>
						<option value="Pacific/Nauru">Nauru</option>
						<option value="Pacific/Niue">Niue</option>
						<option value="Pacific/Norfolk">Norfolk</option>
						<option value="Pacific/Noumea">Noumea</option>
						<option value="Pacific/Pago_Pago">Pago Pago</option>
						<option value="Pacific/Palau">Palau</option>
						<option value="Pacific/Pitcairn">Pitcairn</option>
						<option value="Pacific/Pohnpei">Pohnpei</option>
						<option value="Pacific/Port_Moresby">Port Moresby</option>
						<option value="Pacific/Rarotonga">Rarotonga</option>
						<option value="Pacific/Saipan">Saipan</option>
						<option value="Pacific/Tahiti">Tahiti</option>
						<option value="Pacific/Tarawa">Tarawa</option>
						<option value="Pacific/Tongatapu">Tongatapu</option>
						<option value="Pacific/Wake">Wake</option>
						<option value="Pacific/Wallis">Wallis</option>
						</optgroup>
						<optgroup label="UTC">
						<option value="UTC">UTC</option>
						</optgroup>
						<optgroup label="Manual Offsets">
						<option value="UTC-12">UTC-12</option>
						<option value="UTC-11.5">UTC-11:30</option>
						<option value="UTC-11">UTC-11</option>
						<option value="UTC-10.5">UTC-10:30</option>
						<option value="UTC-10">UTC-10</option>
						<option value="UTC-9.5">UTC-9:30</option>
						<option value="UTC-9">UTC-9</option>
						<option value="UTC-8.5">UTC-8:30</option>
						<option value="UTC-8">UTC-8</option>
						<option value="UTC-7.5">UTC-7:30</option>
						<option value="UTC-7">UTC-7</option>
						<option value="UTC-6.5">UTC-6:30</option>
						<option value="UTC-6">UTC-6</option>
						<option value="UTC-5.5">UTC-5:30</option>
						<option value="UTC-5">UTC-5</option>
						<option value="UTC-4.5">UTC-4:30</option>
						<option value="UTC-4">UTC-4</option>
						<option value="UTC-3.5">UTC-3:30</option>
						<option value="UTC-3">UTC-3</option>
						<option value="UTC-2.5">UTC-2:30</option>
						<option value="UTC-2">UTC-2</option>
						<option value="UTC-1.5">UTC-1:30</option>
						<option value="UTC-1">UTC-1</option>
						<option value="UTC-0.5">UTC-0:30</option>
						<option selected="selected" value="UTC+0">UTC+0</option>
						<option value="UTC+0.5">UTC+0:30</option>
						<option value="UTC+1">UTC+1</option>
						<option value="UTC+1.5">UTC+1:30</option>
						<option value="UTC+2">UTC+2</option>
						<option value="UTC+2.5">UTC+2:30</option>
						<option value="UTC+3">UTC+3</option>
						<option value="UTC+3.5">UTC+3:30</option>
						<option value="UTC+4">UTC+4</option>
						<option value="UTC+4.5">UTC+4:30</option>
						<option value="UTC+5">UTC+5</option>
						<option value="UTC+5.5">UTC+5:30</option>
						<option value="UTC+5.75">UTC+5:45</option>
						<option value="UTC+6">UTC+6</option>
						<option value="UTC+6.5">UTC+6:30</option>
						<option value="UTC+7">UTC+7</option>
						<option value="UTC+7.5">UTC+7:30</option>
						<option value="UTC+8">UTC+8</option>
						<option value="UTC+8.5">UTC+8:30</option>
						<option value="UTC+8.75">UTC+8:45</option>
						<option value="UTC+9">UTC+9</option>
						<option value="UTC+9.5">UTC+9:30</option>
						<option value="UTC+10">UTC+10</option>
						<option value="UTC+10.5">UTC+10:30</option>
						<option value="UTC+11">UTC+11</option>
						<option value="UTC+11.5">UTC+11:30</option>
						<option value="UTC+12">UTC+12</option>
						<option value="UTC+12.75">UTC+12:45</option>
						<option value="UTC+13">UTC+13</option>
						<option value="UTC+13.75">UTC+13:45</option>
						<option value="UTC+14">UTC+14</option>
						</optgroup>
					</select>
				</td>
				<td><input name="timezone_string_is_included" type="checkbox" id="timezone_string_is_included" value="1" checked="checked"></td>
				<td><input name="timezone_string_is_rand" type="checkbox" id="timezone_string_is_rand" value="0"></td>
			</tr>
		</tbody>
	</table>
	<h4>Date Format</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
			
		</tr>
		<tr>
		<td class="label"><em>date_format</em></td>
		<td class="values">
			<textarea rows="5" id="date_format" name="date_format">F j, Y
Y/m/d
m/d/Y
d/m/Y
	</textarea>
	<br/>
	<em>Add a custom value at the end above.</em>
		</td>
		<td><input name="date_format_is_included" type="checkbox" id="date_format_is_included" value="1" checked="checked"></td>
		<td><input name="date_format_is_rand" type="checkbox" id="date_format_is_rand" value="1" checked="checked"></td>
		</tr>
	</table>
	<h4>Time Format</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr>
		<tr>
		<td class="label"><em>time_format</em></td>
		<td class="values">
			<textarea rows="4" id="time_format" name="time_format">g:i a
g:i A
H:i

	</textarea>
	<br/>
	<em>Add a custom value at the end above.</em>
		</td>
		<td><input name="time_format_is_included" type="checkbox" id="time_format_is_included" value="1" checked="checked"></td>
		<td><input name="time_format_is_rand" type="checkbox" id="time_format_is_rand" value="1" checked="checked"></td>
		</tr>
	</table>
	<h4>Week Starts On</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>start_of_week</em></td>
		<td class="values">
			<select multiple name="start_of_week" id="start_of_week" style="width:75%">
				<option value="0" selected="selected">Sunday</option>
				<option value="1" selected="selected">Monday</option>
				<option value="2" selected="selected">Tuesday</option>
				<option value="3" selected="selected">Wednesday</option>
				<option value="4" selected="selected">Thursday</option>
				<option value="5" selected="selected">Friday</option>
				<option value="6" selected="selected">Saturday</option>
			</select>
		</td>
		<td><input name="start_of_week_is_included" type="checkbox" id="start_of_week_is_included" value="1" checked="checked"></td>
		<td><input name="start_of_week_is_rand" type="checkbox" id="start_of_week_is_rand" value="1" checked="checked"></td>
		</tr>
	</table>
	<br/>
</div>

<h3>Writing Settings</h3>
<div>
	<h4>Formatting</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>use_smilies</em></td>
		<td class="values">
			<p>Convert emoticons like :-) and :-P to graphics on display</p>
			<select name="use_smilies" id="use_smilies" multiple>
				<option value="0" selected>No</option>
				<option value="1" selected>Yes</option>
			</select>
		</td>
		<td><input name="use_smilies_is_included" type="checkbox" id="use_smilies_is_included" value="1" checked="checked"></td>
		<td><input name="use_smilies_is_rand" type="checkbox" id="use_smilies_is_rand" value="1" checked="checked"></td>
		</tr>
		<tr>
			<td class="label"><em>use_balanceTags</em></td>
			<td class="values">
				<p>WordPress should correct invalidly nested XHTML automatically</p>
				<select name="use_balanceTags" id="use_balanceTags" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select>
			</td>
			<td><input name="use_balanceTags_is_included" type="checkbox" id="use_smilies_is_included" value="1" checked="checked"></td>
			<td><input name="use_balanceTags_is_rand" type="checkbox" id="use_balanceTags_is_rand" value="1" checked="checked"></td>
		</tr>
	</table>

	<h4>Default Post Category</h4>
	<p><em>This option only available if there are categories setup for the site. Change this setting after the site has been created.</em></p>
	<h4>Default Post Format</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>default_post_format</em></td>
		<td class="values">
			<select multiple name="default_post_format" id="default_post_format" style="width:75%">
				<option value="0" selected>Standard</option>
				<option value="aside" selected>Aside</option>
				<option value="chat" selected>Chat</option>
				<option value="gallery" selected>Gallery</option>
				<option value="link" selected>Link</option>
				<option value="image" selected>Image</option>
				<option value="quote" selected>Quote</option>
				<option value="status" selected>Status</option>
				<option value="video" selected>Video</option>
				<option value="audio" selected>Audio</option>
			</select>
		</td>
		<td><input name="default_post_format_is_included" type="checkbox" id="default_post_format_is_included" value="1" checked="checked"></td>
		<td><input name="default_post_format_is_rand" type="checkbox" id="default_post_format_is_rand" value="1" checked="checked"></td>
		</tr>
	</table>
</div>

<h3>Reading Settings</h3>
<div>
	<h4>Front page displays</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>show_on_front</em></td>
		<td class="values">
			<input type="text" name="show_on_front" id="show_on_front" value="page" readonly />
			<p><em>'Static Page' option can only be set if there is a page/post available within the site. Changed this setting after you've created the site and added post/page you want to use as a front page.</em></p>
		</td>
		<td><input name="show_on_front_is_included" type="checkbox" id="show_on_front_is_included" value="1" checked="checked"></td>
		<td><input name="show_on_front_is_rand" type="checkbox" id="show_on_front_is_rand" value="0"></td>
		</tr>
	</table>

	<h4>Blog pages show at most</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>posts_per_page</em></td>
		<td class="values">
			Min: <input name="posts_per_page_min" type="number" step="1" min="1" id="posts_per_page_min" value="10" class="small-text"/>
			Max: <input name="posts_per_page_max" type="number" step="1" min="1" id="posts_per_page_max" value="10" class="small-text"/> posts
		</td>
		<td><input name="show_on_front_is_included" type="checkbox" id="show_on_front_is_included" value="1" checked="checked"></td>
		<td><input name="show_on_front_is_rand" type="checkbox" id="show_on_front_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>

	<h4>Syndication feeds show the most recent</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>posts_per_rss</em></td>
		<td class="values">
			Min: <input name="posts_per_rss_min" type="number" step="1" min="1" id="posts_per_rss_min" value="10" class="small-text"/>
			Max: <input name="posts_per_rss_max" type="number" step="1" min="1" id="posts_per_rss_max" value="10" class="small-text"/> items
		</td>
		<td><input name="posts_per_rss_is_included" type="checkbox" id="posts_per_rss_is_included" value="1" checked="checked"></td>
		<td><input name="posts_per_rss_is_rand" type="checkbox" id="posts_per_rss_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>


	<h4>For each article in a feed, show</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>rss_use_excerpt</em></td>
		<td class="values">
			<select name="rss_use_excerpt" id="rss_use_excerpt" multiple>
				<option value="0" selected>Full text</option>
				<option value="1" selected>Summary</option>
			</select>
		</td>
		<td><input name="rss_use_excerpt_is_included" type="checkbox" id="rss_use_excerpt_is_included" value="1" checked="checked"></td>
		<td><input name="rss_use_excerpt_is_rand" type="checkbox" id="rss_use_excerpt_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>


	<h4>Search Engine Visibility</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
		<td class="label"><em>blog_public</em></td>
		<td class="values">
			<p>Discourage search engines from indexing this site</p>
			<select name="blog_public" id="blog_public" multiple>
				<option value="0" selected>No</option>
				<option value="1" selected>Yes</option>
			</select> <br/>
			<p><em>It is up to search engines to honor this request.</em></p>
		</td>
		<td><input name="blog_public_is_included" type="checkbox" id="blog_public_is_included" value="1" checked="checked"></td>
		<td><input name="blog_public_is_rand" type="checkbox" id="blog_public_is_rand" value="0"></td>
		</tr>
	</table>
</div>

<h3>Discussion Settings</h3>
<div>
	<h4>Default article settings</h4>
	<p><em>These are grouped settings. When 'randomize' is selected, it will generate combinations containing the below settings. 
	   <br/>Remove allowed values if you want to force a setting to display/randomize a default value.</em>
	</p>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>default_pingback_flag</em></td>
			<td class="values">
				<select name="default_pingback_flag" id="default_pingback_flag" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>
				<p><em>Attempt to notify any blogs linked to from the article</em></p>
			</td>
			<td><input name="default_pingback_flag_is_included" type="checkbox" id="default_pingback_flag_is_included" value="1" checked="checked"></td>
			<td><input name="default_pingback_flag_is_rand" type="checkbox" id="default_pingback_flag_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>default_ping_status</em></td>
			<td class="values">
				<select name="default_ping_status" id="default_ping_status" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>
				<p><em>Allow link notifications from other blogs (pingbacks and trackbacks)</em></p>
			</td>
			<td><input name="default_ping_status_is_included" type="checkbox" id="default_ping_status_is_included" value="1" checked="checked"></td>
			<td><input name="default_ping_status_is_rand" type="checkbox" id="default_ping_status_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>default_comment_status</em></td>
			<td class="values">
				<select name="default_comment_status" id="default_comment_status" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>
				<p><em>Allow people to post comments on new articles</em></p>
			</td>
			<td><input name="default_comment_status_is_included" type="checkbox" id="default_comment_status_is_included" value="1" checked="checked"></td>
			<td><input name="default_comment_status_is_rand" type="checkbox" id="default_comment_status_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>

	<h4>Other comment settings</h4>
	<p><em>These are grouped settings. When 'randomize' is selected, it will generate combinations containing the below settings. 
	   <br/>Remove allowed values if you want to force a setting to display/randomize a default value.</em>
	</p>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>require_name_email</em></td>
			<td class="values">
				<select name="require_name_email" id="require_name_email" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>
				<p><em>Comment author must fill out name and e-mail.</em></p>
			</td>
			<td><input name="require_name_email_is_included" type="checkbox" id="require_name_email_is_included" value="1" checked="checked"></td>
			<td><input name="require_name_email_is_rand" type="checkbox" id="require_name_email_is_rand" value="1" checked="checked"></td>
		</tr>
		<tr>
			<td class="label"><em>comment_registration</em></td>
			<td class="values">
				<select name="comment_registration" id="comment_registration" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>
				<p><em>Users must be registered and logged in to comment (Signup has been disabled. Only members of this site can comment.)</em></p>
			</td>
			<td><input name="comment_registration_is_included" type="checkbox" id="comment_registration_is_included" value="1" checked="checked"></td>
			<td><input name="comment_registration_is_rand" type="checkbox" id="comment_registration_is_rand" value="1" checked="checked"></td>
		</tr>
		<tr>
			<td class="label"><em>close_comments_for_old_posts</em></td>
			<td class="values">
				<select name="close_comments_for_old_posts" id="close_comments_for_old_posts" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>

				<p>
					Automatically close comments on articles older than
					(Min: <input name="close_comments_days_old_min" type="number" step="1" min="1" id="close_comments_days_old_min" value="14" class="small-text"/>
					Max: <input name="close_comments_days_old_max" type="number" step="1" min="1" id="close_comments_days_old_max" value="14" class="small-text"/>)
				</p>
			</td>
			<td><input name="close_comments_for_old_posts_is_included" type="checkbox" id="close_comments_for_old_posts_is_included" value="1" checked="checked"></td>
			<td><input name="close_comments_for_old_posts_is_rand" type="checkbox" id="close_comments_for_old_posts_is_rand" value="1" checked="checked"></td>
		</tr>

		<tr>
			<td class="label"><em>thread_comments</em></td>
			<td class="values">
				<select name="thread_comments" id="thread_comments" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>

				<p>
					Enable threaded (nested) comments
					<select name="thread_comments_depth" id="thread_comments_depth" multiple>
						<option value="2" selected>2</option>
						<option value="3" selected>3</option>
						<option value="4" selected>4</option>
						<option value="5" selected>5</option>
						<option value="6" selected>6</option>
						<option value="7" selected>7</option>
						<option value="8" selected>8</option>
						<option value="9" selected>9</option>
						<option value="10" selected>10</option>
					</select>
					levels deep
				</p>
			</td>
			<td><input name="thread_comments_is_included" type="checkbox" id="thread_comments_is_included" value="1" checked="checked"></td>
			<td><input name="thread_comments_is_rand" type="checkbox" id="thread_comments_is_rand" value="1" checked="checked"></td>
		</tr>

		<tr>
			<td class="label"><em>thread_comments</em></td>
			<td class="values">
				<select name="thread_comments" id="thread_comments" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>

				<p>
					Enable threaded (nested) comments
					<select name="thread_comments_depth" id="thread_comments_depth" multiple>
						<option value="2" selected>2</option>
						<option value="3" selected>3</option>
						<option value="4" selected>4</option>
						<option value="5" selected>5</option>
						<option value="6" selected>6</option>
						<option value="7" selected>7</option>
						<option value="8" selected>8</option>
						<option value="9" selected>9</option>
						<option value="10" selected>10</option>
					</select>
					levels deep
				</p>
			</td>
			<td><input name="thread_comments_is_included" type="checkbox" id="thread_comments_is_included" value="1" checked="checked"></td>
			<td><input name="thread_comments_is_rand" type="checkbox" id="thread_comments_is_rand" value="1" checked="checked"></td>
		</tr>

		<tr>
			<td class="label"><em>page_comments</em></td>
			<td class="values">
				<select name="page_comments" id="page_comments" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select> <br/>

				<p>
					
					Break comments into pages with 
					Min: <input name="comments_per_page_min" type="number" step="1" min="1" id="comments_per_page_min" value="50" class="small-text"/>
					Max: <input name="comments_per_page_max" type="number" step="1" min="1" id="comments_per_page_max" value="50" class="small-text"/>
					 top level comments per page and the 
					<select name="default_comments_page" id="default_comments_page" multiple>
						<option value="newest" selected>last</option>
						<option value="oldest" selected>first</option>
					</select> page displayed by default
				</p>
			</td>
			<td><input name="page_comments_is_included" type="checkbox" id="page_comments_is_included" value="1" checked="checked"></td>
			<td><input name="page_comments_is_rand" type="checkbox" id="page_comments_is_rand" value="1" checked="checked"></td>
		</tr>

		<tr>
			<td class="label"><em>comment_order</em></td>
			<td class="values">
				<p>
					Comments should be displayed with the 
					<select name="comment_order" id="comment_order" multiple>
					<option value="asc" selected>older</option>
					<option value="desc" selected>newer</option>
					</select>
					 comments at the top of each page
				</p>
			</td>
			<td><input name="comment_order_is_included" type="checkbox" id="comment_order_is_included" value="1" checked="checked"></td>
			<td><input name="comment_order_is_rand" type="checkbox" id="comment_order_is_rand" value="1" checked="checked"></td>
		</tr>
	</table>

	<h4>Before a comment appears</h4>
	<p><em>These are grouped settings. When 'randomize' is selected, it will generate combinations containing the below settings. 
	   <br/>Remove allowed values if you want to force a setting to display/randomize a default value.</em>
	</p>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>comment_moderation</em></td>
			<td class="values">
				<select name="comment_moderation" id="comment_moderation" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select>
				<br />
				<p>Comment must be manually approved</p>
			</td>
			<td><input name="comment_moderation_is_included" type="checkbox" id="comment_moderation_is_included" value="1" checked="checked"></td>
			<td><input name="comment_moderation_is_rand" type="checkbox" id="comment_moderation_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>comment_whitelist</em></td>
			<td class="values">
				<select name="comment_whitelist" id="comment_whitelist" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select>
				<br />
				<p>Comment author must have a previously approved comment</p>
			</td>
			<td><input name="comment_whitelist_is_included" type="checkbox" id="comment_whitelist_is_included" value="1" checked="checked"></td>
			<td><input name="comment_whitelist_is_rand" type="checkbox" id="comment_whitelist_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>

	<h4>Comment Moderation</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>comment_max_links</em></td>
			<td class="values">
				<p>Hold a comment in the queue if it contains  
					Min: <input name="comment_max_links_min" type="number" step="1" min="1" id="comment_max_links_min" value="2" class="small-text"/>
					Max: <input name="comment_max_links_max" type="number" step="1" min="1" id="comment_max_links_max" value="2" class="small-text"/>
				or more links. (A common characteristic of comment spam is a large number of hyperlinks.)</p>
			</td>
			<td><input name="comment_max_links_is_included" type="checkbox" id="comment_max_links_is_included" value="1" checked="checked"></td>
			<td><input name="comment_max_links_is_rand" type="checkbox" id="comment_max_links_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>moderation_keys</em></td>
			<td class="values">
				<p>When a comment contains any of these words in its content, name, URL, e-mail, or IP, it will be held in the moderation queue. One word or IP per line. It will match inside words, so “press” will match “WordPress”.</p>
				<textarea name="moderation_keys" rows="10" cols="50" id="moderation_keys" class="large-text code"></textarea>
			</td>
			<td><input name="moderation_keys_is_included" type="checkbox" id="moderation_keys_is_included" value="1" checked="checked"></td>
			<td><input name="moderation_keys_is_rand" type="checkbox" id="moderation_keys_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>

	<h4>Comment Blacklist</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>blacklist_keys</em></td>
			<td class="values">
				<p>When a comment contains any of these words in its content, name, URL, e-mail, or IP, it will be marked as spam. One word or IP per line. It will match inside words, so “press” will match “WordPress”.</p>
				<textarea name="blacklist_keys" rows="10" cols="50" id="blacklist_keys" class="large-text code"></textarea>
			</td>
			<td><input name="blacklist_keys_is_included" type="checkbox" id="blacklist_keys_is_included" value="1" checked="checked"></td>
			<td><input name="blacklist_keys_is_rand" type="checkbox" id="blacklist_keys_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>

	<h4>Avatar Display</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>show_avatars</em></td>
			<td class="values">
				<select name="show_avatars" id="show_avatars" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select><br/>
				<p>Show Avatars</p>
			</td>
			<td><input name="show_avatars_is_included" type="checkbox" id="show_avatars_is_included" value="1" checked="checked"></td>
			<td><input name="show_avatars_is_rand" type="checkbox" id="show_avatars_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>

	<h4>Maximum Rating</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>avatar_rating</em></td>
			<td class="values">
				<select name="avatar_rating" id="avatar_rating" multiple>
					<option value="G" selected>G</option>
					<option value="PG" selected>PG</option>
					<option value="R" selected>R</option>
					<option value="X" selected>X</option>
				</select><br/>
			</td>
			<td><input name="avatar_rating_is_included" type="checkbox" id="avatar_rating_is_included" value="1" checked="checked"></td>
			<td><input name="avatar_rating_is_rand" type="checkbox" id="avatar_rating_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>
	<h4>Default Avatar</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>avatar_default</em></td>
			<td class="values">
				<p>For users without a custom avatar of their own, you can either display a generic logo or a generated one based on their e-mail address.</p>
				<select name="avatar_default" id="avatar_default" multiple>
					<option value="mystery" selected>Mystery Man</option>
					<option value="blank" selected>Blank</option>
					<option value="gravatar_default" selected>Gravatar Logo</option>
					<option value="identicon" selected>Identicon</option>
					<option value="wavatar" selected>Wavatar</option>
					<option value="monsterid" selected>MonsterID</option>
					<option value="retro" selected>Retro</option>
				</select><br/>
			</td>
			<td><input name="avatar_default_is_included" type="checkbox" id="avatar_default_is_included" value="1" checked="checked"></td>
			<td><input name="avatar_default_is_rand" type="checkbox" id="avatar_default_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>
</div>

<h3>Media</h3>
<div>
	<h3>Image sizes</h3>
	<p>The sizes listed below determine the maximum dimensions in pixels to use when adding an image to the Media Library.</p>
	<h4>Thumbnail size</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>thumbnail_size_w</em></td>
			<td class="values">
				<p>Width</p>
				Min: <input name="thumbnail_size_w_min" type="number" step="1" min="1" id="thumbnail_size_w_min" value="150" class="small-text"/>
				Max: <input name="thumbnail_size_w_max" type="number" step="1" min="1" id="thumbnail_size_w_max" value="150" class="small-text"/>
			</td>
			<td><input name="thumbnail_size_w_is_included" type="checkbox" id="thumbnail_size_w_is_included" value="1" checked="checked"></td>
			<td><input name="thumbnail_size_w_is_rand" type="checkbox" id="thumbnail_size_w_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>thumbnail_size_h</em></td>
			<td class="values">
				<p>Height</p>
				Min: <input name="thumbnail_size_h_min" type="number" step="1" min="1" id="thumbnail_size_h_min" value="150" class="small-text"/>
				Max: <input name="thumbnail_size_h_max" type="number" step="1" min="1" id="thumbnail_size_h_max" value="150" class="small-text"/>
			</td>
			<td><input name="thumbnail_size_h_is_included" type="checkbox" id="thumbnail_size_h_is_included" value="1" checked="checked"></td>
			<td><input name="thumbnail_size_h_is_rand" type="checkbox" id="thumbnail_size_h_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>thumbnail_crop</em></td>
			<td class="values">
				<p>Crop thumbnail to exact dimensions (normally thumbnails are proportional)</p>
				<select name="thumbnail_crop" id="thumbnail_crop" multiple>
					<option value="0" selected>No</option>
					<option value="1" selected>Yes</option>
				</select>
			</td>
			<td><input name="thumbnail_crop_is_included" type="checkbox" id="thumbnail_crop_is_included" value="1" checked="checked"></td>
			<td><input name="thumbnail_crop_w_is_rand" type="checkbox" id="thumbnail_crop_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>
	<h4>Medium size</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>medium_size_w</em></td>
			<td class="values">
				<p>Max Width</p>
				Min: <input name="medium_size_w_min" type="number" step="1" min="1" id="medium_size_w_min" value="300" class="small-text"/>
				Max: <input name="medium_size_w_max" type="number" step="1" min="1" id="medium_size_w_max" value="300" class="small-text"/>
			</td>
			<td><input name="medium_size_w_is_included" type="checkbox" id="medium_size_w_is_included" value="1" checked="checked"></td>
			<td><input name="medium_size_w_is_rand" type="checkbox" id="medium_size_w_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>medium_size_h</em></td>
			<td class="values">
				<p>Max Height</p>
				Min: <input name="medium_size_h_min" type="number" step="1" min="1" id="medium_size_h_min" value="300" class="small-text"/>
				Max: <input name="medium_size_h_max" type="number" step="1" min="1" id="medium_size_h_max" value="300" class="small-text"/>
			</td>
			<td><input name="medium_size_h_is_included" type="checkbox" id="medium_size_h_is_included" value="1" checked="checked"></td>
			<td><input name="medium_size_h_is_rand" type="checkbox" id="medium_size_h_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>
	<h4>Large size</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>large_size_w</em></td>
			<td class="values">
				<p>Max Width</p>
				Min: <input name="large_size_w_min" type="number" step="1" min="1" id="large_size_w_min" value="1024" class="small-text"/>
				Max: <input name="large_size_w_max" type="number" step="1" min="1" id="large_size_w_max" value="1024" class="small-text"/>
			</td>
			<td><input name="large_size_w_is_included" type="checkbox" id="large_size_w_is_included" value="1" checked="checked"></td>
			<td><input name="large_size_w_is_rand" type="checkbox" id="large_size_w_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>large_size_h</em></td>
			<td class="values">
				<p>Max Height</p>
				Min: <input name="large_size_h_min" type="number" step="1" min="1" id="large_size_h_min" value="1024" class="small-text"/>
				Max: <input name="large_size_h_max" type="number" step="1" min="1" id="large_size_h_max" value="1024" class="small-text"/>
			</td>
			<td><input name="large_size_h_is_included" type="checkbox" id="large_size_h_is_included" value="1" checked="checked"></td>
			<td><input name="large_size_h_is_rand" type="checkbox" id="large_size_h_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>
</div>
<h3>Permalinks</h3>
<div>
	<h4>Common Settings</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>permalink_structure</em></td>
			<td class="values">
				<select name="permalink_structure" id="permalink_structure" multiple>
					<option value="" selected>Default</option>
					<option value="/%year%/%monthnum%/%day%/%postname%/" selected>Day and name</option>
					<option value="/archives/%post_id%" selected>Month and name</option>
					<option value="/%postname%/" selected>Post name</option>
				</select>
			</td>
			<td><input name="permalink_structure_is_included" type="checkbox" id="permalink_structure_is_included" value="1" checked="checked"></td>
			<td><input name="permalink_structure_is_rand" type="checkbox" id="permalink_structure_is_rand" checked="checked" value="1"></td>
		</tr>
		<tr>
			<td class="label"><em>custom_selection</em></td>
			<td class="values">
				<p>Custom values for permalink_structure</p>
				<textarea rows="5" id="permalink_structure_custom" name="permalink_structure_custom"></textarea>
			</td>
			<td><input name="permalink_structure_custom_is_included" type="checkbox" id="permalink_structure_custom_is_included" value="1" checked="checked"></td>
			<td><input name="permalink_structure_custom_is_rand" type="checkbox" id="permalink_structure_custom_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>

	<h4>Optional</h4>
	<p>If you like, you may enter custom structures for your category and tag URLs here. For example, using topics as your category base would make your category links like http://example.org/topics/uncategorized/. If you leave these blank the defaults will be used.</p>
	<h4>Category Base</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>category_base</em></td>
			<td class="values">
				<p>Custom values for permalink_structure</p>
				<textarea rows="5" id="category_base" name="category_base"></textarea>
			</td>
			<td><input name="category_base_is_included" type="checkbox" id="category_base_is_included" value="1" checked="checked"></td>
			<td><input name="category_base_is_rand" type="checkbox" id="category_base_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>
	<h4>Tag Base</h4>
	<table class="asc_option_table">
		<tr>
			<th>Option Code</th>
			<th>Values</th>
			<th>Include on site creation</th>
			<th>Randomize</th>
		</tr >
		<tr>
			<td class="label"><em>tag_base</em></td>
			<td class="values">
				<p>Custom values for permalink_structure</p>
				<textarea rows="5" id="tag_base" name="tag_base"></textarea>
			</td>
			<td><input name="tag_base_is_included" type="checkbox" id="tag_base_is_included" value="1" checked="checked"></td>
			<td><input name="tag_base_is_rand" type="checkbox" id="tag_base_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>
</div>

<h3>Themes</h3>
<div>
	<h3>Allowed Themes</h3>
	<p><em>Select the themes you would like to be available during site creation</em></p>
	<table class="asc_option_table">
		<tr>
			<th>Avaiable Themes</th>
			<th>Randomize</th>
		</tr>
		<tr>
			<td>
				<select name="themes" id="themes" multiple style="width:100%;">
					<option value="twentyfourteen" selected>Twenty Fourteen</option>
					<option value="twentythirteen" selected>Twenty Thirteen</option>
					<option value="twentytwelve" selected>Twenty Twelve</option>
				</select>
			</td>
			<td><input name="themes_is_rand" type="checkbox" id="themes_is_rand" checked="checked" value="1"></td>
		</tr>
	</table>
</div>

<h3>Plugins</h3>
<div>
	<h3>Allowed Plugins</h3>
	<p><em>Select the plugins you would like to be available during site creation.</em></p>
	<table class="asc_option_table">
		<tr>
			<th>Avaiable Plugins</th>
		</tr>
		<tr>
			<td>
				<select name="plugins" id="plugins" multiple style="width:100%;">
					<option value="0" selected>Content Spinner</option>
					<option value="1" selected>Virtual Pages with Templates</option>
					<option value="2" selected>Virtual Related Pages</option>
				</select>
			</td>
		</tr>
	</table>
</div>

</div><!-- end Accordion -->
<br/>
<input type="hidden" name="build_site_settings_page_POST" value="Y" />
<input type="submit" name="submit" class="button-primary" value="Save Settings" /> 
</form>
</div>
<script>
	(function($) {
	    $(document).ready(function() {
	    	$('#accordion').accordion({
	    		collapsible: true,
	    		heightStyle: "content"
	    	});
	    	$("#start_of_week").select2();
	    	$("#default_post_format").select2();
	    	$('#use_smilies, #use_balanceTags').select2();
	    	$('#rss_use_excerpt').select2();
	    	$('#blog_public').select2();
	    	$('#default_pingback_flag, #default_ping_status, #default_comment_status').select2();
	    	$('#require_name_email, #comment_registration, #close_comments_for_old_posts, #thread_comments, #thread_comments_depth').select2();
	    	$('#page_comments, #default_comments_page, #comment_order').select2();
	    	$('#comments_notify, #moderation_notify').select2();
	    	$('#comment_moderation, #comment_whitelist').select2();
	    	$('#show_avatars').select2();
	    	$('#avatar_rating').select2();
	    	$('#avatar_default').select2();
	    	$('#thumbnail_crop').select2();
	    	$('#permalink_structure').select2();
	    	$('#themes, #plugins').select2();
	    });
	})(jQuery);
</script>