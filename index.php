<?php
    require "../sso/common.php";
    require "creds.php";
    require "action/settings_get.php";
    validate_token("https://infotoast.org/budget/");

$user_id = get_user_id();

$conn = mysqli_connect(get_database_host(), get_database_username(), get_database_password(), get_database_db());
if ($conn->connect_error) {
    die("ERROR: Could not connect to database! Please email frank@infotoast.org if you receive this error.");
} else {
    $googleChartEnabled = get_setting($conn, $user_id, 7) == 1;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Info Toast Budgeting</title>
    <script type="text/javascript" src="resources/js/detect-mobile.js"></script>
    <script type="text/javascript" src="resources/js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="resources/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/sso/resources/node_modules/js-cookie/dist/js.cookie.min.js"></script>
    <script type="text/javascript" src="/sso/resources/login-box.js"></script>
    <?php
    if ($googleChartEnabled) {
        ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
    }
    ?>
    <script type="text/javascript" src="resources/js/index.js"></script>
    <link type="text/css" rel="stylesheet" href="resources/css/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="/sso/resources/login-box.css"/>
    <link type="text/css" rel="stylesheet" href="resources/css/global.css"/>
    <link type="text/css" rel="stylesheet" href="resources/css/local.css"/>
</head>
<body>
    <div class="top">
        <div class="topleft">
            <h1>Budgeting</h1>
        </div>
        <div class="topright">
                <div class="loginbutton"></div>
        </div>
    </div>
    <div class="theBody">
        <div class="iconBodyHeader" id="firstHeader">
            <h2>📈This Month's Budget</h2>
        </div>
        <div class="iconSet">
            <div class="month-data">
                <?php
                if ($googleChartEnabled) {
                    ?>
                <div id="piechart" style="width: 60%; height: 40%;"></div>
                <br>
                <?php
                }
                ?>
                <div id="monthProgress"></div>
            </div>
        </div>
        <p class="errorMsg" id="errorMsg"></p>
        <button class="globalButton" id="settingsButton" onclick="window.location.replace('settings.php');">
            ⚙️
        </button>
        <div class="iconBodyHeader">
            <h2>📊Categories</h2>
        </div>
        <div class="iconSet">
            <a href="category.php?category=util">
                <div class="icon" style="background-color: cornflowerblue" id="util">
                    <svg class="serviceIcon" width="128px" height="128px" version="1.1" id="houseIcon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<g>
    <rect x="138" y="177.4" fill="#CC5454" width="236" height="268"/>
    <path d="M373.5,177.9v267h-235v-267H373.5 M374.5,176.9h-237v269h237V176.9L374.5,176.9z"/>
</g>
                        <polyline fill="#4F1B1B" stroke="#000000" stroke-miterlimit="10" points="137.5,176.9 256,66.1 374.5,176.9 "/>
                        <path fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" d="M259.5,332.5c-11.6,0-21,8.5-21,19v94h42v-94
	C280.5,341,271.1,332.5,259.5,332.5z"/>
                        <g>
                            <rect x="164.5" y="215.5" fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" width="67" height="67"/>
                            <line fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" x1="198" y1="215.5" x2="198" y2="282.5"/>
                            <line fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" x1="164.5" y1="249" x2="231.5" y2="249"/>
                        </g>
                        <g>
                            <rect x="289.7" y="215.2" fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" width="67" height="67"/>
                            <line fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" x1="323.2" y1="215.2" x2="323.2" y2="282.2"/>
                            <line fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" x1="289.7" y1="248.7" x2="356.7" y2="248.7"/>
                        </g>
</svg>
                    <p class="appName">Rent/Utilities</p>
                </div>
            </a>
            <a href="category.php?category=food">
                <div class="icon" style="background-color: orangered" id="food">
                    <svg version="1.1" class="serviceIcon" id="foodIcon" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<g>
    <circle fill="#EEEEEE" cx="256" cy="256" r="150.5"/>
    <path d="M256,106c40.1,0,77.7,15.6,106.1,43.9c28.3,28.3,43.9,66,43.9,106.1s-15.6,77.7-43.9,106.1S296.1,406,256,406
		s-77.7-15.6-106.1-43.9c-28.3-28.3-43.9-66-43.9-106.1s15.6-77.7,43.9-106.1C178.3,121.6,215.9,106,256,106 M256,105
		c-83.4,0-151,67.6-151,151s67.6,151,151,151s151-67.6,151-151S339.4,105,256,105L256,105z"/>
</g>
                        <g>
                            <ellipse fill="#FFFFFF" cx="256" cy="256" rx="121" ry="115"/>
                        </g>
                        <line fill="#737373" stroke="#737373" stroke-width="5" stroke-miterlimit="10" x1="426" y1="166.5" x2="494" y2="166.5"/>
                        <line fill="#737373" stroke="#737373" stroke-width="5" stroke-miterlimit="10" x1="420.5" y1="166" x2="420.5" y2="75.5"/>
                        <line fill="#737373" stroke="#737373" stroke-width="5" stroke-miterlimit="10" x1="445.5" y1="166" x2="445.5" y2="75.5"/>
                        <line fill="#737373" stroke="#737373" stroke-width="5" stroke-miterlimit="10" x1="472.5" y1="166" x2="472.5" y2="75.5"/>
                        <line fill="#737373" stroke="#737373" stroke-width="5" stroke-miterlimit="10" x1="498.5" y1="166" x2="498.5" y2="75.5"/>
                        <path fill="#737373" stroke="#737373" stroke-width="5" stroke-miterlimit="10" d="M426,166.5c3.4,2.1,7.8,3.8,13,5.1V401h0.1
	c0,0.6-0.1,1.2-0.1,1.8c0,11.2,9,20.2,20,20.2s20-9.1,20-20.2c0-0.6,0-1.2-0.1-1.8h0.1V172.1c6-1.3,11.2-3.2,15-5.6H426z"/>
                        <path fill="#969696" d="M84.8,145.1c0-30.4-17.9-55-40-55s-40,24.6-40,55c0,20.5,8.1,38.3,20.2,47.8V401h0.1c0,0.6-0.1,1.2-0.1,1.8
	c0,11.2,9,20.2,20,20.2s20-9.1,20-20.2c0-0.6,0-1.2-0.1-1.8H65V192.6C76.8,183,84.8,165.3,84.8,145.1z"/>
</svg>
                    <p class="appName">Food</p>
                </div>
            </a>
            <br><br><br>
            <a href="category.php?category=supply">
                <div class="icon" style="background-color: orange" id="supply">
                    <svg version="1.1" class="serviceIcon" id="supplyIcon" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<path fill="#28F75D" stroke="#000000" stroke-miterlimit="10" d="M305.8,63.8v-36h-81v0.5h-35.5h-24.4l24.4,71v37.5
	c-23.7,3.6-41.9,13.3-47.3,25.5h-1.7v299h0.2c2.6,17.9,32.4,32,68.8,32s66.2-14.1,68.8-32h0.2v-299h-1.7
	c-5.3-12-23.2-21.7-46.3-25.4V63.8H305.8z"/>
                        <path fill="#FFFFFF" stroke="#000000" stroke-width="3" stroke-miterlimit="10" d="M230.2,71.3c0,0,20.5,47.5,32.5,51.5"/>
                        <line stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" x1="365.8" y1="18.8" x2="324.8" y2="35.8"/>
                        <path fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" d="M324.8,48.1"/>
                        <line stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" x1="324.8" y1="48.1" x2="371.8" y2="47.8"/>
                        <line stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" x1="324.8" y1="60.5" x2="365.8" y2="80.4"/>
</svg>
                    <p class="appName">Household Supply</p>
                </div>
            </a>
            <a href="category.php?category=travel">
                <div class="icon" style="background-color: mediumpurple" id="travel">
                    <svg version="1.1" class="serviceIcon" id="travelIcon" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<line fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" x1="205.6" y1="240.4" x2="76.6" y2="335.3"/>
                        <ellipse transform="matrix(0.818 -0.5752 0.5752 0.818 -75.8262 179.3342)" fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" cx="245.5" cy="209.5" rx="45" ry="17"/>
                        <ellipse transform="matrix(0.7972 -0.6037 0.6037 0.7972 -114.2198 245.9364)" fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" cx="309" cy="293" rx="52.5" ry="17.5"/>
                        <path fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" d="M467.5,142.5l-40.6-8.4c-0.8-1.4-1.7-2.7-2.7-4.1
	c-11.8-15.8-32.3-20.4-45.8-10.3c-1.4,1.1-2.7,2.3-3.9,3.5l-0.4-0.5L97.8,329.2c-2,0.7-4,1.7-5.7,3c-12.4,9.3-12.5,30.1-0.2,46.6
	s32.4,22.3,44.8,13.1c2.2-1.6,4-3.7,5.4-5.9l275.2-205.6l-0.6-0.8c1.6-0.7,3.1-1.6,4.5-2.7c1.3-0.9,2.4-2,3.5-3.1L467.5,142.5z"/>
                        <polyline fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="92.1,332.3 51.5,270.5 126.3,308 "/>
                        <polyline fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="304.5,220.5 361.5,374.5 256,259.4 "/>
                        <polyline fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="236.7,225 183.5,155.5 262.9,205.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="384.5,128.5 407.4,122.2 416.5,135.5 397.5,155.5 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="155.4,321.4 164.5,314.4 170.9,321.4 161.5,328.9 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="170.4,309.4 179.5,302.4 185.9,309.4 176.5,316.9 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="185.4,296.9 194.5,289.9 200.9,296.9 191.5,304.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="200.4,285.9 209.5,278.9 215.9,285.9 206.5,293.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="215.4,273.9 224.5,266.9 230.9,273.9 221.5,281.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="230.4,262.9 239.5,255.9 245.9,262.9 236.5,270.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="245.4,251.9 254.5,244.9 260.9,251.9 251.5,259.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="260.4,239.9 269.5,232.9 275.9,239.9 266.5,247.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="275.4,229.9 284.5,222.9 290.9,229.9 281.5,237.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="290.4,218.9 299.5,211.9 305.9,218.9 296.5,226.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="305.4,206.9 314.5,199.9 320.9,206.9 311.5,214.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="320.4,195.9 329.5,188.9 335.9,195.9 326.5,203.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="335.4,184.9 344.5,177.9 350.9,184.9 341.5,192.4 "/>
                        <polygon fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="350.4,172.9 359.5,165.9 365.9,172.9 356.5,180.4 "/>
                        <polyline fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" points="135.5,344.5 151.2,396.4 117.5,356.5 "/>
                        <line fill="#FFFFFF" stroke="#000000" stroke-miterlimit="10" x1="260.9" y1="332.3" x2="134.4" y2="428"/>
</svg>
                    <p class="appName">Travel</p>
                </div>
            </a>
            <br><br><br>
            <a href="category.php?category=software">
                <div class="icon" style="background-color: steelblue" id="software">
                    <svg version="1.1" class="serviceIcon" id="softwareIcon" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<g>
    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="51" y1="256" x2="461" y2="256">
        <stop  offset="0" style="stop-color:#FFFFFF"/>
        <stop  offset="0" style="stop-color:#F5F5F5"/>
        <stop  offset="1" style="stop-color:#8E8E8E"/>
    </linearGradient>
    <circle fill="url(#SVGID_1_)" cx="256" cy="256" r="205"/>
    <path fill="#7A7A7A" d="M256,51.5c27.6,0,54.4,5.4,79.6,16.1c24.4,10.3,46.2,25,65,43.8c18.8,18.8,33.5,40.7,43.8,65
		c10.7,25.2,16.1,52,16.1,79.6s-5.4,54.4-16.1,79.6c-10.3,24.4-25,46.2-43.8,65c-18.8,18.8-40.7,33.5-65,43.8
		c-25.2,10.7-52,16.1-79.6,16.1s-54.4-5.4-79.6-16.1c-24.4-10.3-46.2-25-65-43.8c-18.8-18.8-33.5-40.7-43.8-65
		c-10.7-25.2-16.1-52-16.1-79.6s5.4-54.4,16.1-79.6c10.3-24.4,25-46.2,43.8-65c18.8-18.8,40.7-33.5,65-43.8
		C201.6,56.9,228.4,51.5,256,51.5 M256,50.5c-113.5,0-205.5,92-205.5,205.5s92,205.5,205.5,205.5s205.5-92,205.5-205.5
		S369.5,50.5,256,50.5L256,50.5z"/>
</g>
                        <g>
                            <circle fill="#FFFFFF" cx="256" cy="256" r="34.5"/>
                            <path d="M256,222c18.7,0,34,15.3,34,34s-15.3,34-34,34s-34-15.3-34-34S237.3,222,256,222 M256,221c-19.3,0-35,15.7-35,35
		s15.7,35,35,35s35-15.7,35-35S275.3,221,256,221L256,221z"/>
                        </g>
</svg>
                    <p class="appName">Software</p>
                </div>
            </a>
            <a href="category.php?category=luxury">
                <div class="icon" style="background-color: lawngreen" id="luxury">
                    <svg version="1.1" class="serviceIcon" id="luxuryIcon" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<g>
    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="190.7738" y1="164.5826" x2="397.5816" y2="164.5826">
        <stop  offset="0" style="stop-color:#CCE0F4"/>
        <stop  offset="6.405089e-02" style="stop-color:#C3DCF2"/>
        <stop  offset="0.1706" style="stop-color:#A9D2EE"/>
        <stop  offset="0.3066" style="stop-color:#80C2E7"/>
        <stop  offset="0.4649" style="stop-color:#47ACDE"/>
        <stop  offset="0.5674" style="stop-color:#1E9CD7"/>
        <stop  offset="0.8652" style="stop-color:#0075BE"/>
        <stop  offset="0.9944" style="stop-color:#005B97"/>
    </linearGradient>
    <polygon fill="url(#SVGID_1_)" stroke="#000000" stroke-miterlimit="10" points="307.5,223.7 294.9,120.7 307.5,223.7 397.6,223.7
		397,160.6 256,105.5 201.7,125.5 190.8,223.7 	"/>

    <linearGradient id="SVGID_00000034773323107891149040000008346801130064879783_" gradientUnits="userSpaceOnUse" x1="190.6878" y1="224.0628" x2="307.5956" y2="224.0628">
        <stop  offset="0" style="stop-color:#CCE0F4"/>
        <stop  offset="6.405089e-02" style="stop-color:#C3DCF2"/>
        <stop  offset="0.1706" style="stop-color:#A9D2EE"/>
        <stop  offset="0.3066" style="stop-color:#80C2E7"/>
        <stop  offset="0.4649" style="stop-color:#47ACDE"/>
        <stop  offset="0.5674" style="stop-color:#1E9CD7"/>
        <stop  offset="0.8652" style="stop-color:#0075BE"/>
        <stop  offset="0.9944" style="stop-color:#005B97"/>
    </linearGradient>

    <polygon fill="url(#SVGID_00000034773323107891149040000008346801130064879783_)" stroke="#000000" stroke-miterlimit="10" points="
		190.7,224.4 307.6,224.4 307.5,223.7 190.8,223.7 	"/>

    <linearGradient id="SVGID_00000033344706870883786970000015869288029348883073_" gradientUnits="userSpaceOnUse" x1="114.4184" y1="174.5842" x2="201.6944" y2="174.5842">
        <stop  offset="0" style="stop-color:#CCE0F4"/>
        <stop  offset="6.405089e-02" style="stop-color:#C3DCF2"/>
        <stop  offset="0.1706" style="stop-color:#A9D2EE"/>
        <stop  offset="0.3066" style="stop-color:#80C2E7"/>
        <stop  offset="0.4649" style="stop-color:#47ACDE"/>
        <stop  offset="0.5674" style="stop-color:#1E9CD7"/>
        <stop  offset="0.8652" style="stop-color:#0075BE"/>
        <stop  offset="0.9944" style="stop-color:#005B97"/>
    </linearGradient>

    <polygon fill="url(#SVGID_00000033344706870883786970000015869288029348883073_)" stroke="#000000" stroke-miterlimit="10" points="
		201.7,125.5 114.4,157.6 114.4,223.7 190.8,223.7 	"/>

    <linearGradient id="SVGID_00000017478342756572477330000013141994444047546042_" gradientUnits="userSpaceOnUse" x1="247.1029" y1="315.094" x2="397.5816" y2="315.094">
        <stop  offset="0" style="stop-color:#CCE0F4"/>
        <stop  offset="6.405089e-02" style="stop-color:#C3DCF2"/>
        <stop  offset="0.1706" style="stop-color:#A9D2EE"/>
        <stop  offset="0.3066" style="stop-color:#80C2E7"/>
        <stop  offset="0.4649" style="stop-color:#47ACDE"/>
        <stop  offset="0.5674" style="stop-color:#1E9CD7"/>
        <stop  offset="0.8652" style="stop-color:#0075BE"/>
        <stop  offset="0.9944" style="stop-color:#005B97"/>
    </linearGradient>

    <polygon fill="url(#SVGID_00000017478342756572477330000013141994444047546042_)" stroke="#000000" stroke-miterlimit="10" points="
		307.5,223.7 307.6,224.4 247.1,406.5 397.6,223.7 	"/>

    <linearGradient id="SVGID_00000012433023424961653560000001484101734143477382_" gradientUnits="userSpaceOnUse" x1="114.4184" y1="315.094" x2="247.1029" y2="315.094">
        <stop  offset="0" style="stop-color:#CCE0F4"/>
        <stop  offset="6.405089e-02" style="stop-color:#C3DCF2"/>
        <stop  offset="0.1706" style="stop-color:#A9D2EE"/>
        <stop  offset="0.3066" style="stop-color:#80C2E7"/>
        <stop  offset="0.4649" style="stop-color:#47ACDE"/>
        <stop  offset="0.5674" style="stop-color:#1E9CD7"/>
        <stop  offset="0.8652" style="stop-color:#0075BE"/>
        <stop  offset="0.9944" style="stop-color:#005B97"/>
    </linearGradient>

    <polygon fill="url(#SVGID_00000012433023424961653560000001484101734143477382_)" stroke="#000000" stroke-miterlimit="10" points="
		190.7,224.4 190.8,223.7 114.4,223.7 247.1,406.5 189.4,224.4 	"/>

    <linearGradient id="SVGID_00000062881270637713215220000017439417683114589337_" gradientUnits="userSpaceOnUse" x1="189.3943" y1="315.4802" x2="307.5956" y2="315.4802">
        <stop  offset="0" style="stop-color:#CCE0F4"/>
        <stop  offset="6.405089e-02" style="stop-color:#C3DCF2"/>
        <stop  offset="0.1706" style="stop-color:#A9D2EE"/>
        <stop  offset="0.3066" style="stop-color:#80C2E7"/>
        <stop  offset="0.4649" style="stop-color:#47ACDE"/>
        <stop  offset="0.5674" style="stop-color:#1E9CD7"/>
        <stop  offset="0.8652" style="stop-color:#0075BE"/>
        <stop  offset="0.9944" style="stop-color:#005B97"/>
    </linearGradient>

    <polygon fill="url(#SVGID_00000062881270637713215220000017439417683114589337_)" stroke="#000000" stroke-miterlimit="10" points="
		190.7,224.4 190.7,224.6 190.7,224.4 189.4,224.4 247.1,406.5 307.6,224.4 	"/>
</g>
</svg>
                    <p class="appName">Luxury</p>
                </div>
            </a>
        </div>
    </div>

</body>
</html>