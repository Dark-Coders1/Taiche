<?php
/**
 * Index Template
 *
 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage
 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options;
?>      
    
    <!-- #content Starts -->
    <?php woo_content_before(); 
    ?>
    <div id="content" class="col-full">
    
        <div id="main-sidebar-container">    
        
            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <section id="main" class="col-left">
                
            <?php
                if ( is_home() && is_active_sidebar( 'homepage' ) ) {
                    dynamic_sidebar( 'homepage' );
                } else {
//get_template_part( 'loop', 'index' );
                    ?><h1 style="font-weight: bold; color: #133e1c;">Subscribe</h1>
<table border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td height="100%">
<table border="0" cellspacing="2" cellpadding="0">
<tbody>
<tr>
<td valign="top" height="100%">
<table style="height: 420px;" border="0" width="430" cellspacing="0" cellpadding="0">
<tbody>
<tr style="color: #000000;">
<td colspan="3" height="10"></td>
</tr>
<tr style="color: #000000;">
<td width="19"></td>
<td width="392"><form action="http://taichi.wpengine.com/wp-content/themes/alamindit/sub.php" method="post">
<table class="ParagraphText" border="0" width="98%" cellspacing="2" cellpadding="0">
<tbody>
<tr valign="top">
<td></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td colspan="2" height="30">ALL information marked with an (<span style="color: #ff0000;">*</span>) is mandatory.</td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td height="19">Title</td>
<td><select id="Title" class="formfield" name="Title">                                       <option value="">Please Select One:</option>                                       <option value="Mr">Mr</option>                                       <option value="Mrs">Mrs</option>                                       <option value="Miss">Miss</option>                                       <option value="Ms">Ms</option>                                       <option value="Dr">Dr</option>                                    </select></td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td height="19">First Name</td>
<td><input id="FirstName" class="formfield" name="FirstName" type="text" value="" /> <span style="color: #ff0000;">*</span></td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td height="19">Last Name</td>
<td><input id="LastName" class="formfield" name="LastName" type="text" value="" /> <span style="color: #ff0000;">*</span></td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td>Email</td>
<td><input id="Email6" class="formfield" name="Email" type="text" value="" /> <span style="color: #ff0000;">*</span></td>

</tr>
<tr>
<td height="19">Country</td>
<td><select style ="width:147px"id="Title" class="formfield" name="Country">                                       
<option name="All Countries" value="" selected=selected>All Countries</option>
			<option name="Australia" value="Australia">Australia</option>
			<option name="United Kingdom" value="United Kingdom">United Kingdom</option>
			<option name="United States" value="United States">United States</option>
			<option name="New Zealand" value="New Zealand">New Zealand</option>
			<option name="----------" value="----------">----------</option>
			<option name="Afghanistan" value="Afghanistan">Afghanistan</option>
			<option name="Albania" value="Albania">Albania</option>
			<option name="Algeria" value="Algeria">Algeria</option>
			<option name="American Samoa" value="American Samoa">American Samoa</option>
			<option name="Andorra" value="Andorra">Andorra</option>
			<option name="Angola" value="Angola">Angola</option>
			<option name="Anguilla" value="Anguilla">Anguilla</option>
			<option name="Antarctica" value="Antarctica">Antarctica</option>
			<option name="Antigua And Barbuda" value="Antigua And Barbuda">Antigua And Barbuda</option>
			<option name="Argentina" value="Argentina">Argentina</option>
			<option name="Armenia" value="Armenia">Armenia</option>
			<option name="Aruba" value="Aruba">Aruba</option>
			<option name="Australia" value="Australia">Australia</option>
			<option name="Austria" value="Austria">Austria</option>
			<option name="Azerbaijan" value="Azerbaijan">Azerbaijan</option>
			<option name="Bahamas" value="Bahamas">Bahamas</option>
			<option name="Bahrain" value="Bahrain">Bahrain</option>
			<option name="Bangladesh" value="Bangladesh">Bangladesh</option>
			<option name="Barbados" value="Barbados">Barbados</option>
			<option name="Belarus" value="Belarus">Belarus</option>
			<option name="Belgium" value="Belgium">Belgium</option>
			<option name="Belize" value="Belize">Belize</option>
			<option name="Benin" value="Benin">Benin</option>
			<option name="Bermuda" value="Bermuda">Bermuda</option>
			<option name="Bhutan" value="Bhutan">Bhutan</option>
			<option name="Bolivia" value="Bolivia">Bolivia</option>
			<option name="Bosnia and Herzegovina" value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
			<option name="Botswana" value="Botswana">Botswana</option>
			<option name="Bouvet Island" value="Bouvet Island">Bouvet Island</option>
			<option name="Brazil" value="Brazil">Brazil</option>
			<option name="British Indian Ocean Territory" value="British Indian Ocean Territory">British Indian Ocean Territory</option>
			<option name="Brunei" value="Brunei">Brunei</option>
			<option name="Bulgaria" value="Bulgaria">Bulgaria</option>
			<option name="Burkina Faso" value="Burkina Faso">Burkina Faso</option>
			<option name="Burundi" value="Burundi">Burundi</option>
			<option name="Cambodia" value="Cambodia">Cambodia</option>
			<option name="Cameroon" value="Cameroon">Cameroon</option>
			<option name="Canada" value="Canada">Canada</option>
			<option name="Cape Verde" value="Cape Verde">Cape Verde</option>
			<option name="Cayman Islands" value="Cayman Islands">Cayman Islands</option>
			<option name="Central African Republic" value="Central African Republic">Central African Republic</option>
			<option name="Chad" value="Chad">Chad</option>
			<option name="Chile" value="Chile">Chile</option>
			<option name="China" value="China">China</option>
			<option name="Christmas Island" value="Christmas Island">Christmas Island</option>
			<option name="Cocos (Keeling) Islands" value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
			<option name="Colombia" value="Colombia">Colombia</option>
			<option name="Comoros" value="Comoros">Comoros</option>
			<option name="Congo" value="Congo">Congo</option>
			<option name="Congo" value="Congo">Congo</option>
			<option name=" Democractic Republic of the " value=" Democractic Republic of the "> Democractic Republic of the </option>
			<option name="Cook Islands" value="Cook Islands">Cook Islands</option>
			<option name="Costa Rica" value="Costa Rica">Costa Rica</option>
			<option name="Cote D'Ivoire (Ivory Coast)" value="Cote D'Ivoire (Ivory Coast)">Cote D'Ivoire (Ivory Coast)</option>
			<option name="Croatia (Hrvatska)" value="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
			<option name="Cuba" value="Cuba">Cuba</option>
			<option name="Cyprus" value="Cyprus">Cyprus</option>
			<option name="Czech Republic" value="Czech Republic">Czech Republic</option>
			<option name="Denmark" value="Denmark">Denmark</option>
			<option name="Djibouti" value="Djibouti">Djibouti</option>
			<option name="Dominica" value="Dominica">Dominica</option>
			<option name="Dominican Republic" value="Dominican Republic">Dominican Republic</option>
			<option name="East Timor" value="East Timor">East Timor</option>
			<option name="Ecuador" value="Ecuador">Ecuador</option>
			<option name="Egypt" value="Egypt">Egypt</option>
			<option name="El Salvador" value="El Salvador">El Salvador</option>
			<option name="Equatorial Guinea" value="Equatorial Guinea">Equatorial Guinea</option>
			<option name="Eritrea" value="Eritrea">Eritrea</option>
			<option name="Estonia" value="Estonia">Estonia</option>
			<option name="Ethiopia" value="Ethiopia">Ethiopia</option>
			<option name="Falkland Islands (Islas Malvinas)" value="Falkland Islands (Islas Malvinas)">Falkland Islands (Islas Malvinas)</option>
			<option name="Faroe Islands" value="Faroe Islands">Faroe Islands</option>
			<option name="Fiji Islands" value="Fiji Islands">Fiji Islands</option>
			<option name="Finland" value="Finland">Finland</option>
			<option name="France" value="France">France</option>
			<option name="French Guiana" value="French Guiana">French Guiana</option>
			<option name="French Polynesia" value="French Polynesia">French Polynesia</option>
			<option name="French Southern Territories" value="French Southern Territories">French Southern Territories</option>
			<option name="Gabon" value="Gabon">Gabon</option>
			<option name="Gambia" value="Gambia">Gambia</option>
			<option name="Georgia" value="Georgia">Georgia</option>
			<option name="Germany" value="Germany">Germany</option>
			<option name="Ghana" value="Ghana">Ghana</option>
			<option name="Gibraltar" value="Gibraltar">Gibraltar</option>
			<option name="Greece" value="Greece">Greece</option>
			<option name="Greenland" value="Greenland">Greenland</option>
			<option name="Grenada" value="Grenada">Grenada</option>
			<option name="Guadeloupe" value="Guadeloupe">Guadeloupe</option>
			<option name="Guam" value="Guam">Guam</option>
			<option name="Guatemala" value="Guatemala">Guatemala</option>
			<option name="Guinea" value="Guinea">Guinea</option>
			<option name="Guinea-Bissau" value="Guinea-Bissau">Guinea-Bissau</option>
			<option name="Guyana" value="Guyana">Guyana</option>
			<option name="Haiti" value="Haiti">Haiti</option>
			<option name="Heard and McDonald Islands" value="Heard and McDonald Islands">Heard and McDonald Islands</option>
			<option name="Honduras" value="Honduras">Honduras</option>
			<option name="Hong Kong S.A.R." value="Hong Kong S.A.R.">Hong Kong S.A.R.</option>
			<option name="Hungary" value="Hungary">Hungary</option>
			<option name="Iceland" value="Iceland">Iceland</option>
			<option name="India" value="India">India</option>
			<option name="Indonesia" value="Indonesia">Indonesia</option>
			<option name="Iran" value="Iran">Iran</option>
			<option name="Iraq" value="Iraq">Iraq</option>
			<option name="Ireland" value="Ireland">Ireland</option>
			<option name="Israel" value="Israel">Israel</option>
			<option name="Italy" value="Italy">Italy</option>
			<option name="Jamaica" value="Jamaica">Jamaica</option>
			<option name="Japan" value="Japan">Japan</option>
			<option name="Jordan" value="Jordan">Jordan</option>
			<option name="Kazakhstan" value="Kazakhstan">Kazakhstan</option>
			<option name="Kenya" value="Kenya">Kenya</option>
			<option name="Kiribati" value="Kiribati">Kiribati</option>
			<option name="Korea" value="Korea">Korea</option>
			<option name="Korea-North " value="Korea-North ">Korea-North </option>
			<option name="Kuwait" value="Kuwait">Kuwait</option>
			<option name="Kyrgyzstan" value="Kyrgyzstan">Kyrgyzstan</option>
			<option name="Laos" value="Laos">Laos</option>
			<option name="Latvia" value="Latvia">Latvia</option>
			<option name="Lebanon" value="Lebanon">Lebanon</option>
			<option name="Lesotho" value="Lesotho">Lesotho</option>
			<option name="Liberia" value="Liberia">Liberia</option>
			<option name="Libya" value="Libya">Libya</option>
			<option name="Liechtenstein" value="Liechtenstein">Liechtenstein</option>
			<option name="Lithuania" value="Lithuania">Lithuania</option>
			<option name="Luxembourg" value="Luxembourg">Luxembourg</option>
			<option name="Macau S.A.R." value="Macau S.A.R.">Macau S.A.R.</option>
			<option name="Macedonia" value="Macedonia">Macedonia</option>
			<option name=" Former Yugoslav Republic of" value=" Former Yugoslav Republic of"> Former Yugoslav Republic of</option>
			<option name="Madagascar" value="Madagascar">Madagascar</option>
			<option name="Malawi" value="Malawi">Malawi</option>
			<option name="Malaysia" value="Malaysia">Malaysia</option>
			<option name="Maldives" value="Maldives">Maldives</option>
			<option name="Mali" value="Mali">Mali</option>
			<option name="Malta" value="Malta">Malta</option>
			<option name="Marshall Islands" value="Marshall Islands">Marshall Islands</option>
			<option name="Martinique" value="Martinique">Martinique</option>
			<option name="Mauritania" value="Mauritania">Mauritania</option>
			<option name="Mauritius" value="Mauritius">Mauritius</option>
			<option name="Mayotte" value="Mayotte">Mayotte</option>
			<option name="Mexico" value="Mexico">Mexico</option>
			<option name="Micronesia" value="Micronesia">Micronesia</option>
			<option name="Moldova" value="Moldova">Moldova</option>
			<option name="Monaco" value="Monaco">Monaco</option>
			<option name="Mongolia" value="Mongolia">Mongolia</option>
			<option name="Montserrat" value="Montserrat">Montserrat</option>
			<option name="Morocco" value="Morocco">Morocco</option>
			<option name="Mozambique" value="Mozambique">Mozambique</option>
			<option name="Myanmar" value="Myanmar">Myanmar</option>
			<option name="Namibia" value="Namibia">Namibia</option>
			<option name="Nauru" value="Nauru">Nauru</option>
			<option name="Nepal" value="Nepal">Nepal</option>
			<option name="Netherlands Antilles" value="Netherlands Antilles">Netherlands Antilles</option>
			<option name="Netherlands" value="Netherlands">Netherlands</option>
			<option name="New Caledonia" value="New Caledonia">New Caledonia</option>
			<option name="New Zealand" value="New Zealand">New Zealand</option>
			<option name="Nicaragua" value="Nicaragua">Nicaragua</option>
			<option name="Niger" value="Niger">Niger</option>
			<option name="Nigeria" value="Nigeria">Nigeria</option>
			<option name="Niue" value="Niue">Niue</option>
			<option name="Norfolk Island" value="Norfolk Island">Norfolk Island</option>
			<option name="Northern Ireland" value="Northern Ireland">Northern Ireland</option>
			<option name="Northern Mariana Islands" value="Northern Mariana Islands">Northern Mariana Islands</option>
			<option name="Norway" value="Norway">Norway</option>
			<option name="Oman" value="Oman">Oman</option>
			<option name="Pakistan" value="Pakistan">Pakistan</option>
			<option name="Palau" value="Palau">Palau</option>
			<option name="Panama" value="Panama">Panama</option>
			<option name="Papua new Guinea" value="Papua new Guinea">Papua new Guinea</option>
			<option name="Paraguay" value="Paraguay">Paraguay</option>
			<option name="Peru" value="Peru">Peru</option>
			<option name="Philippines" value="Philippines">Philippines</option>
			<option name="Pitcairn Island" value="Pitcairn Island">Pitcairn Island</option>
			<option name="Poland" value="Poland">Poland</option>
			<option name="Portugal" value="Portugal">Portugal</option>
			<option name="Puerto Rico" value="Puerto Rico">Puerto Rico</option>
			<option name="Qatar" value="Qatar">Qatar</option>
			<option name="Reunion" value="Reunion">Reunion</option>
			<option name="Romania" value="Romania">Romania</option>
			<option name="Russia" value="Russia">Russia</option>
			<option name="Rwanda" value="Rwanda">Rwanda</option>
			<option name="Saint Helena" value="Saint Helena">Saint Helena</option>
			<option name="Saint Kitts And Nevis" value="Saint Kitts And Nevis">Saint Kitts And Nevis</option>
			<option name="Saint Lucia" value="Saint Lucia">Saint Lucia</option>
			<option name="Saint Pierre and Miquelon" value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
			<option name="Saint Vincent And The Grenadines" value="Saint Vincent And The Grenadines">Saint Vincent And The Grenadines</option>
			<option name="Samoa" value="Samoa">Samoa</option>
			<option name="San Marino" value="San Marino">San Marino</option>
			<option name="Sao Tome and Principe" value="Sao Tome and Principe">Sao Tome and Principe</option>
			<option name="Saudi Arabia" value="Saudi Arabia">Saudi Arabia</option>
			<option name="Scotland" value="Scotland">Scotland</option>
			<option name="Senegal" value="Senegal">Senegal</option>
			<option name="Seychelles" value="Seychelles">Seychelles</option>
			<option name="Sierra Leone" value="Sierra Leone">Sierra Leone</option>
			<option name="Singapore" value="Singapore">Singapore</option>
			<option name="Slovakia" value="Slovakia">Slovakia</option>
			<option name="Slovenia" value="Slovenia">Slovenia</option>
			<option name="Solomon Islands" value="Solomon Islands">Solomon Islands</option>
			<option name="Somalia" value="Somalia">Somalia</option>
			<option name="South Africa" value="South Africa">South Africa</option>
			<option name="South Georgia And The South Sandwich Islands" value="South Georgia And The South Sandwich Islands">South Georgia And The South Sandwich Islands</option>
			<option name="Spain" value="Spain">Spain</option>
			<option name="Sri Lanka" value="Sri Lanka">Sri Lanka</option>
			<option name="Sudan" value="Sudan">Sudan</option>
			<option name="Suriname" value="Suriname">Suriname</option>
			<option name="Svalbard And Jan Mayen Islands" value="Svalbard And Jan Mayen Islands">Svalbard And Jan Mayen Islands</option>
			<option name="Swaziland" value="Swaziland">Swaziland</option>
			<option name="Sweden" value="Sweden">Sweden</option>
			<option name="Switzerland" value="Switzerland">Switzerland</option>
			<option name="Syria" value="Syria">Syria</option>
			<option name="Taiwan" value="Taiwan">Taiwan</option>
			<option name="Tajikistan" value="Tajikistan">Tajikistan</option>
			<option name="Tanzania" value="Tanzania">Tanzania</option>
			<option name="Thailand" value="Thailand">Thailand</option>
			<option name="Togo" value="Togo">Togo</option>
			<option name="Tokelau" value="Tokelau">Tokelau</option>
			<option name="Tonga" value="Tonga">Tonga</option>
			<option name="Trinidad And Tobago" value="Trinidad And Tobago">Trinidad And Tobago</option>
			<option name="Tunisia" value="Tunisia">Tunisia</option>
			<option name="Turkey" value="Turkey">Turkey</option>
			<option name="Turkmenistan" value="Turkmenistan">Turkmenistan</option>
			<option name="Turks And Caicos Islands" value="Turks And Caicos Islands">Turks And Caicos Islands</option>
			<option name="Tuvalu" value="Tuvalu">Tuvalu</option>
			<option name="Uganda" value="Uganda">Uganda</option>
			<option name="Ukraine" value="Ukraine">Ukraine</option>
			<option name="United Arab Emirates" value="United Arab Emirates">United Arab Emirates</option>
			<option name="United Kingdom" value="United Kingdom">United Kingdom</option>
			<option name="United States" value="United States">United States</option>
			<option name="United States Minor Outlying Islands" value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
			<option name="Uruguay" value="Uruguay">Uruguay</option>
			<option name="Uzbekistan" value="Uzbekistan">Uzbekistan</option>
			<option name="Vanuatu" value="Vanuatu">Vanuatu</option>
			<option name="Vatican City State (Holy See)" value="Vatican City State (Holy See)">Vatican City State (Holy See)</option>
			<option name="Venezuela" value="Venezuela">Venezuela</option>
			<option name="Vietnam" value="Vietnam">Vietnam</option>
			<option name="Virgin Islands (British)" value="Virgin Islands (British)">Virgin Islands (British)</option>
			<option name="Virgin Islands (US)" value="Virgin Islands (US)">Virgin Islands (US)</option>
			<option name="Wallis And Futuna Islands" value="Wallis And Futuna Islands">Wallis And Futuna Islands</option>
			<option name="Yemen" value="Yemen">Yemen</option>
			<option name="Yugoslavia" value="Yugoslavia">Yugoslavia</option>
			<option name="Zambia" value="Zambia">Zambia</option>                           </select></td>
</tbody>
</table>
<table border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td width="34" height="40"><input class="formfield" checked="checked" name="NewsletterUnsubscribed" type="checkbox" value="0" /></td>
<td class="SmallNewsTitle" width="548">Please send me Dr Lam's monthly newsletter.</td>
</tr>
<tr>
<td width="34" height="40"><input class="formfield" checked="checked" name="UpcomingWorkshops" type="checkbox" value="1" /></td>
<td class="SmallNewsTitle" width="548">Please send me information on Dr Lam's Upcoming Workshops.</td>

</tr>
</tbody>
</table>
<input class="subscribe" name="subscribe" type="submit" value="subscribe" /></form></td>
<td width="19"></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
                    <?php
                }
            ?>
                    
            </section><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>
    
        </div><!-- /#main-sidebar-container -->         

        <?php get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
    <?php woo_content_after(); ?>
    <script>
//document.getElementsByClassName('widget widget_clw')[0].style.visibility='hidden';
document.getElementById("clw-6").remove();
</script>   
<?php get_footer(); ?>



