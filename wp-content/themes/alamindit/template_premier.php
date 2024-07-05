<?php
/**
 * Template Name: Premier
 *
 * The blog page template displays the "blog-style" template on a sub-page.
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options;

?>

<?php woo_content_before();  ?>
    <div id="content" class="col-full">
    
    	<div id="main-sidebar-container">    
		
            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <section id="main" class="col-left">
            	
			<?php
                if ( is_home() && is_active_sidebar( 'homepage' ) ) {
                   // dynamic_sidebar( 'homepage' );
                } else {
                   // get_template_part( 'loop', 'index' );
                }
            ?>
<?php get_header(); ?>


<script type="text/javascript" charset="utf-8"  src="http://clients.chimpchamp.com/taichi/wp-includes/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8"  src="http://clients.chimpchamp.com/taichi/wp-includes/DataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" charset="utf-8"  src="http://clients.chimpchamp.com/taichi/wp-includes/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>

<style type="text/css" title="currentStyle">
    @import "http://clients.chimpchamp.com/taichi/wp-includes/DataTables-1.9.4/media/css/jquery.dataTables.css";
</style>









<div class="main_white_heading" style="width: 590px; margin: 30px 0px 10px; padding: 0px 0px 5px; border-width: 0px 0px 1px; border-bottom-style: dotted; border-bottom-color: #939393; outline: 0px; font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: #133e1c; font-weight: bold; line-height: 17px; background-color: #ffffff;">PREMIER INSTRUCTORS</div>

<span style="width: 590px; color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 12.222222328186035px; line-height: 17px; background-color: #ffffff;">Please click </span><a style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 13px; color: #133e1c; font-family: Arial, Helvetica, sans-serif; line-height: 17px; background-color: #ffffff;" href="http://taichi.wpengine.com/2014/01/28/premier-membership-benefits/">here </a><span style="width: 590px; color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 12.222222328186035px; line-height: 17px; background-color: #ffffff;">for more information about the benefits of Premier Instructors and how to become one.</span>

<hr style = "width: 590px;" />

<h2></h2>
<h2 style="width: 590px; margin: 0px 0px 10px; padding: 0px 0px 5px; border-width: 0px 0px 1px; border-bottom-style: dotted; border-bottom-color: #939393; outline: 0px; font-size: 17px; color: #133e1c; font-family: Arial, Helvetica, sans-serif; line-height: 17px; background-color: #ffffff;">To find certified instructors, choose your country.</h2>

<select id = "msds-select">
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
			<option name="Zambia" value="Zambia">Zambia</option>
</select>
<br><br>


<table style="width: 590px; margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px; border-collapse: collapse; border-spacing: 0px; color: #000000; font-family: Arial, Helvetica, sans-serif; line-height: 17px; background-color: #ffffff;" width="100%" border="0" cellspacing="0" cellpadding="0">
<tbody style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle" width="50%"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/arthritis.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/a.html','','scrollbars=yes,width=250,height=250');return false;" >Certified Tai Chi for Arthritis Instructor</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle" width="50%"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/work.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/w.html','','scrollbars=yes,width=250,height=250');return false;"">Certified Tai Chi for Work Instructor</a></td>
</tr>
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/diabetes.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/d.html','','scrollbars=yes,width=250,height=250');return false;">Certified Tai Chi for Diabetes Instructor</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle" width="50%"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/kidz.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/k.html','','scrollbars=yes,width=250,height=250');return false;">Certified Tai Chi for Kidz Instructor</a></td>
</tr>
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/back_pain.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/bp.html','','scrollbars=yes,width=250,height=250');return false;">Certified Tai Chi for Back Pain Instructor</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/seated.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/s.html','','scrollbars=yes,width=250,height=250');return false;">Certified Seated Tai Chi for Arthritis Instructor</a></td>
</tr>
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/osteoporosis.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/o.html','','scrollbars=yes,width=250,height=250');return false;">Certified Tai Chi for Osteoporosis Instructor</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/master.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/mt.html','','scrollbars=yes,width=250,height=250');return false;">Master Trainer</a></td>
</tr>
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/beginners.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/b.html','','scrollbars=yes,width=250,height=250');return false;">Certified Tai Chi for Beginners Instructor</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/senior.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/st.html','','scrollbars=yes,width=250,height=250');return false;">Senior Trainer</a></td>
</tr>
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/energy.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/e.html','','scrollbars=yes,width=250,height=250');return false;">Certified Tai Chi for Energy Instructor</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/premium.gif" width="20" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/p.html','','scrollbars=yes,width=250,height=250');return false;">Premier Instructor</a></td>
</tr>
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position instructor_icon_position_block" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/mta.png" width="40" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/mta.html','','scrollbars=yes,width=250,height=250');return false;">Tai Chi for Arthritis Master Trainer</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position instructor_icon_position_block" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/mto.png" width="40" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/mto.html','','scrollbars=yes,width=250,height=250');return false;">Tai Chi for Osteoporosis Master Trainer</a></td>
</tr>
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position instructor_icon_position_block" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/mtk.png" width="40" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/mtk.html','','scrollbars=yes,width=250,height=250');return false;">Tai Chi for Kidz Master Trainer</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position instructor_icon_position_block" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/mts.png" width="40" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/mts.html','','scrollbars=yes,width=250,height=250');return false;">Seated Tai Chi for Arthritis Master Trainer</a></td>
</tr>
<tr style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 12px;">
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position instructor_icon_position_block" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/mtd.png" width="40" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/mtd.html','','scrollbars=yes,width=250,height=250');return false;">Tai Chi for Diabetes Master Trainer</a></td>
<td class="instructor_icons" style="margin: 0px; padding: 0px 0px 7px; border: 0px; outline: 0px; font-size: 12px;" valign="middle"><img class="instructor_icon_position instructor_icon_position_block" style="margin: 5px; padding: 5px; outline: 0px; font-size: 12px; position: relative;" alt="" src="http://www.taichiforhealthinstitute.org/images/instructors/mtb.png" width="40" height="20" /> <a  style="margin: 0px; padding: 0px 0px 0px 5px; border: 0px; outline: 0px; font-size: 12px; color: #133e1c;" onClick="window.open('http://taichi.wpengine.com/certification_detail/mtb.html','','scrollbars=yes,width=250,height=250');return false;">Tai Chi for Beginners Master Trainer</a></td>
</tr>
</tbody>
</table>

<br>
Search: <input id = "search" type="text" name="search"><br>

<?php





global $wpdb;
$queryy = "
    SELECT distinct `wp_users`.* FROM `wp_users`
INNER JOIN wp_groups_user_group
ON  `wp_users`.`ID` = wp_groups_user_group.user_id
INNER JOIN wp_Instructors_Certification
ON  `wp_users`.`ID` = wp_Instructors_Certification.instructor_id

WHERE group_id = 11 and wp_Instructors_Certification.certification_expiry_date > curdate() 

    		   ";

?>

<table  id = "table_id" style = "width: 655px;" >
<thead>
<tr>
<th>Premier Instructors</th><th>State</th><th>Suburb</th><th>Qualifications</th><th hidden>country</th>
</tr>
</thead>
<tbody>
<?php
	$masters = $wpdb->get_results($queryy, OBJECT);
//print_r($masters);
foreach($masters as $mstrs)
	{

$sub = get_user_meta(  $mstrs->ID, 'suburb', true ); 
$stat = get_user_meta(  $mstrs->ID, 'state', true );
$cntry = get_user_meta(  $mstrs->ID, 'country', true );
$cert = $mstrs->meta_value;
						$certi = explode(',',$cert);
						$ind = 0;
						for($i = 0;$i<= sizeof($certi);$i++)
						{
							if ( $certi[$i] != '')
							{$certif[$ind] = $certi[$i];$ind++;}
						}
						for($i = 0;$i<= sizeof($certif);$i++)
						{
						if($certif[$i] == 'master')
								{
  							$n='m';

								}
						if($certif[$i] == 'senior')
								{
  							$n='s';

								}


						}



		$certif = array_filter($certif);			


$lastname = "
    SELECT * FROM `wp_usermeta` where meta_key = 'last_name' and user_id = ".$mstrs->ID."
    		   ";
$lastn = $wpdb->get_results($lastname, OBJECT);

$firstname = "
    SELECT * FROM `wp_usermeta` where meta_key = 'first_name' and user_id = ".$mstrs->ID."
    		   ";
$firstn = $wpdb->get_results($firstname, OBJECT);
?>

<tr>
<td><?php echo "<a href = 'http://taichi.wpengine.com/profile/".$mstrs->ID."'>".$lastn[0]->meta_value.",".$firstn[0]->meta_value."</a>";?></td><td>  <?php echo $stat  ?>   <t/d><td> <?php echo $sub          ?> <t/d><td><?php $queryy = "SELECT * FROM `wp_Instructors_Certification` where instructor_id = {$mstrs->ID} and certification_expiry_date > CURDATE() ";


	$user_certs_obj = $wpdb->get_results($queryy, ARRAY_A);
	
	foreach ($user_certs_obj as $cert_obj)
{			if($cert_obj['name'] == '')
					continue;					
	$cert_id = $wpdb->get_var( "SELECT ID FROM wp_posts where post_title ='{$cert_obj['name']}' and post_type = 'certificate_template' ");
					
  $cert_aid = $wpdb->get_var( "SELECT meta_value FROM `wp_postmeta` where post_id = $cert_id and meta_key = '_thumbnail_id'");							 $val = $wpdb->get_var( "SELECT guid  FROM wp_posts where ID =$guid_id ");
							$val = $wpdb->get_var( "SELECT guid FROM wp_posts where ID =$cert_aid ");							echo '<img src="'.$val.'" alt="Smiley face" >&nbsp&nbsp&nbsp';
							
							
							}?></td><td hidden> <?php echo $cntry ?> </td>

</tr>



<?php	$display = ""; }

?>
<tbody>
</table>




























<script type="text/javascript">
                        jQuery(document).ready(function($){

 $("#table_id").dataTable({
        "sPaginationType": "full_numbers",
        "bFilter": true,
        "sDom":"lrtip" // default is lfrtip, where the f is the filter
       });
      var oTable;
      oTable = $('#table_id').dataTable();

      $("#search").keyup( function () {
            /* Filter on the column (the index) of this element */
            oTable.fnFilter( $(this).val() );
        });

$('#msds-select').change( function() {
            oTable.fnFilter( $(this).val() );
       });
                       });


                  </script>

</section><!-- /#main -->
            <?php //woo_main_after(); ?>
    
            <?php //get_sidebar(); ?>
    
		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
	<?php //woo_content_after(); ?>
		
<?php get_footer(); ?>
