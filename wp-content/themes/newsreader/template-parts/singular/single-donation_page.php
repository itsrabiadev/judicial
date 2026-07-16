<?php
/**
 * Template part singular content
 *
 * @package Newsreader
 */
global $wp;
$page          = get_post();
$defaultImage  = get_theme_file_uri('assets/images/section-title-bg-issues.jpg');
$backgroundImg = get_field('page_header_background_image', $page->ID) ?: $defaultImage;

$donateAmounts = [35, 100, 250, 500, 1000, 2500];
$acfAmounts    = get_field('contribution_amounts', $page->ID);

if (is_array($acfAmounts) && count($acfAmounts)) {
    $donateAmounts = array_map(function($amount) {
        return (int) array_values($amount)[0];
    }, $acfAmounts);
}

$preselectRecurring = get_field('preselect_recurring_donation', $page->ID);
if (!$preselectRecurring && isset($_GET['isc_is_recur'])) {
    $preselectRecurring = true;
}

$clickId = null;
if (!session_id()) {
    session_start();
}
if (!empty($_SESSION['click_id'])) {
    $clickId = $_SESSION['click_id'];
    unset($_SESSION['click_id']);
}
$paypalReturnUrl   = home_url('/thanks-for-your-donation');
$paypalCancelReturnUrl= home_url($wp->request);
$allowPaypal       = get_field('allow_paypal', $page->ID);
$mbTrackingCode    = get_field('mb_tracking_code',$page->ID);
$petitionSubmittedSuccess = !empty($_SESSION['petition_successful_submission']);
$pageContentAvailable     = strlen($page->post_content) > 0;
$pageContentNotAvailable  = !$pageContentAvailable;
$preselectRecurringCheckbox = $preselectRecurring;

// Now pass vars directly to template below
?>
<style>
    template {
        display: none;
    }
    .cs-entry__header{
        display:none;
    }
</style>



                <!-- Section: Page Content -->

                <?php if ($pageContentAvailable) { ?>
                    <section class="page-content page-container container-1140 p-t-50 mobile-p-t-40">

                        <?php if ($petitionSubmittedSuccess) { ?>
                            <img height="1" width="1" src="https://trk.lockerdome.com/ldpix.gif?ldc=11201001709622784_judicialwatch_suppression">
                        <?php } ?>

                        <div class="wysiwyg-content">
                            <h1><?php echo get_the_title(); ?></h1>
                        </div>
                        <div class="columns is-multiline">

                            <div class="column is-two-thirds">
                                <div class="wysiwyg-content">
                                    <?php the_content(); ?>
                                </div>
                            </div>

                            <div class="column is-one-third">
                                <div id="VueDonateComponent">

                                    <div>
                                        <div class="modal modal-donate-response" :class="{ 'is-active': this['responseModal'].active }">
                                            <div class="modal-background"></div>
                                            <div class="modal-content">
                                                <div class="content-data_value"></div>
                                                <button type="button" class="button is-primary is-inverted is-slim"  onclick="hideResponseModal();">Close</button>
                                            </div>
                                        </div>

                                        <button v-if="isQaEnabled" @click="setQaValues()" type="button" style="display:none;">QA: Fill Out Form Fields</button>

                                        <!-- Select Donation Amount -->
                                        <h2 class="m-b-15">Select Amount to Donate</h2>
                                        <input type="hidden" value="<?php echo admin_url('admin-post.php'); ?>" name="form_url_submit" id="form_url_submit" >
                                        <div class="columns is-multiline is-grid-20px grid-button-list columns-donate-buttons">

                                            <?php foreach ($donateAmounts as $donateAmount_twig) { ?>
                                                <div
                                                        class="column is-one-third">
                                                    <button type="button"
                                                            class="button is-primary button_select_amount is-wide"
                                                            selected_value="<?= $donateAmount_twig ?>" id="button_select_amount_<?= $donateAmount_twig ?>" >

                                                        $<?= $donateAmount_twig ?>
                                                    </button>
                                                </div>
                                            <?php } ?>


                                            <!-- Custom Amount -->
                                            <div class="column is-one-third">
                                                <div class="control has-icons-right">
                                                    <input type="text"
                                                           ref="otherDonationAmountInput"
                                                           @keyup="setOtherDonationAmount()"
                                                           placeholder="Other amount..."
                                                           v-validate="'numeric'"
                                                           data-vv-as="donation"
                                                           name="custom_donation_amount"
                                                           v-model="customDonationAmount"
                                                           :class="{ 'is-danger': errors.has('custom_donation_amount') }"
                                                           class="input donate-input"/>
                                                    <!--   <span class="icon is-small is-right" v-if="errors.has('custom_donation_amount')">
                                                         <span class="fas fa-exclamation-circle has-text-danger"></span>
                                                     </span> -->
                                                </div>
                                                <span class="vee-validate-error donation-custom-class" style="display:none;">Please enter a valid amount</span>
                                                <span class="vee-validate-error donation-custom-transaction" style="display:none;">Minimum Transaction $5</span>
                                            </div>
                                            <!-- PayPal -->

                                            <?php if ($allowPaypal) { ?>

                                                <div v-if="allowPaypal" class="column is-one-third">
                                                    <form  id="paypalformtwig" name="paypalform" method="post" action="https://www.paypal.com/cgi-bin/webscr" target="_top">
                                                        <input type="hidden" name="business" value="development@judicialwatch.org">
                                                        <input type="hidden" name="cmd" value="_donations" />
                                                        <input type="hidden" name="cancel_return" value="<?php echo $paypalCancelReturnUrl ?>" />
                                                        <input type="hidden" name="return" value="<?php echo $paypalReturnUrl ?>" />
                                                        <input type="hidden" name="currency_code" value="USD" />
                                                        <input type="hidden" name="amount" value="1" id="amount_paypal" disabled="true">

                                                        <input type="image" name="submit" style="display:none" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_donate_92x26.png" alt="Donate" />
                                                        <img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" />
                                                        <button type="button" class="button is-primary is-inverted is-slim paypalFormSubmit" >
                                                            <img src="/wp-content/themes/judicial-watch/assets/images/button-paypal-logo.png" class="all-browser"  style="width:100%;"/>
                                                        </button>
                                                    </form>

                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="field">
                                            <?php if ($preselectRecurringCheckbox == '1') { ?>
                                                <input id="monthly-donation-toggle" type="checkbox"  checked v-model="formFields.isMonthlyDonation" class="is-checkradio is-info has-bg-active"/>
                                            <?php } ?>
                                            <?php if ($preselectRecurringCheckbox == '0') { ?>
                                                <input id="monthly-donation-toggle" type="checkbox"  v-model="formFields.isMonthlyDonation"  class="is-checkradio is-info has-bg-active"/>
                                            <?php } ?>
                                            <label for="monthly-donation-toggle"
                                                   class="checkradio-label is-marginless">
                                               Make this a monthly donation! Please note, monthly donations are processed immediately and then on the 1st of every month.
                                            </label>
                                        </div>

                                        <!-- Payment Information -->
                                        <h2 class="m-t-50">Payment Information</h2>
                                        <form class="cmxform" id="form1"  onsubmit="return sendPostRequest(this);" method="post" >
                                            <div class="columns is-multiline is-gap-10px">
                                                <!-- Required Fields Label -->
                                                <div class="column is-full">
                <span class="help-text is-italic p-t-5">
                    <div class="col-asterisk">
                        <span class="far fa-asterisk"></span>
                    </div>
                    <div class="col">
                        <span class="content">Required field</span>
                    </div>
                </span>
                                                    <div class="cc-list">
                                                        <span class="fab fa-cc-visa"></span>
                                                        <span class="fab fa-cc-mastercard"></span>
                                                        <span class="fab fa-cc-discover"></span>
                                                        <span class="fab fa-cc-amex"></span>
                                                    </div>
                                                </div>
                                                <!-- First Row -->
                                                <div class="column is-full p-t-0">
                                                    <div class="control has-icons-right">
                                                        <input name="card[number]"
                                                               v-validate="'credit_card|required'"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.card.number"
                                                               data-vv-as="Card"
                                                               type="text"
                                                               class="input"
                                                               :class="{ 'is-danger': errors.has('card[number]') }"
                                                               placeholder="Card Number *" id="card-number" error-message-custome="The Card field is invalid" on-blur-effect-flag="1"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('card[number]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="card-number vee-validate-error"></span>
                                                </div>
                                                <!-- Second row -->
                                                <div class="column is-one-third p-t-0">
                                                    <div class="control has-icons-right">
                                                        <input name="card[ccv]"
                                                               v-validate="'numeric|required'"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.card.ccv"
                                                               data-vv-as="CCV"
                                                               type="text"
                                                               class="input"
                                                               :class="{ 'is-danger': errors.has('card[ccv]') }"
                                                               placeholder="Security Code *" id="cvv" error-message-custome="The CCV field may only contain numeric characters" on-blur-effect-flag="1" />
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('card[ccv]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error cvv"></span>
                                                </div>
                                                <div class="column is-one-third">
                                                    <div class="select" :class="{ 'is-danger': errors.has('card[month]') }">
                                                        <select v-model="formFields.card.month"
                                                                name="card[month]"
                                                                v-validate="'required'"
                                                                data-vv-as="Month"
                                                                :class="{ 'is-danger': errors.has('card[month]') }"
                                                                class="input-select" error-message-custome="The Month field is required">
                                                            <option value="">Month *</option>
                                                            <option value="01">January</option>
                                                            <option value="02">February</option>
                                                            <option value="03">March</option>
                                                            <option value="04">April</option>
                                                            <option value="05">May</option>
                                                            <option value="06">June</option>
                                                            <option value="07">July</option>
                                                            <option value="08">August</option>
                                                            <option value="09">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                        <span class="vee-validate-error"></span>
                                                    </div>
                                                </div>
                                                <div class="column is-one-third">
                                                    <div class="select" :class="{ 'is-danger': errors.has('card[year]') }">
                                                        <select v-model="formFields.card.year"
                                                                name="card[year]"
                                                                v-validate="'required'"
                                                                data-vv-as="Year"
                                                                :class="{ 'is-danger': errors.has('card[year]') }"
                                                                class="input-select" id="year_select_twig" error-message-custome="The Year field is required">
                                                            <option value="">Year *</option>




                                                        </select>
                                                        <span class="vee-validate-error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <h2 class="m-t-50">Personal Information</h2>
                                            <div class="columns is-multiline">
                                                <!-- Required Fields Label -->
                                                <div class="column is-full">
                <span class="help-text is-italic p-t-5">
                    <div class="col-asterisk">
                        <span class="far fa-asterisk"></span>
                    </div>
                    <div class="col">
                        <span class="content">Required field</span>
                    </div>
                </span>

                                                </div>

                                                <!-- Row: Name -->
                                                <div class="column is-half p-t-0">
                                                    <div class="control has-icons-right">
                                                        <input name="person[name][first]"
                                                               type="text"
                                                               class="input"
                                                               :class="{ 'is-danger': errors.has('person[name][first]') }"
                                                               v-validate="'required'"
                                                               data-vv-validate-on="blur"
                                                               data-vv-as="Name"
                                                               v-model="formFields.person.name.first"
                                                               placeholder="First Name *" error-message-custome="The Name field is required"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[name][first]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error"></span>
                                                </div>
                                                <div class="column is-half p-t-0">
                                                    <div class="control has-icons-right">
                                                        <input name="person[name][last]"
                                                               type="text"
                                                               class="input"
                                                               v-validate="'required'"
                                                               data-vv-as="Name"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.person.name.last"
                                                               :class="{ 'is-danger': errors.has('person[name][last]') }"
                                                               placeholder="Last Name *" error-message-custome="The Name field is required"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[name][last]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error"></span>
                                                </div>

                                                <!-- Row: Address -->
                                                <div class="column is-full">
                                                    <div class="control has-icons-right">
                                                        <input name="person[address][street]"
                                                               type="text"
                                                               class="input"
                                                               v-validate="'required'"
                                                               :class="{ 'is-danger': errors.has('person[address][street]') }"
                                                               data-vv-as="Address"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.person.address.street"
                                                               placeholder="Address *" error-message-custome="The Address field is required"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[address][street]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error"></span>
                                                </div>

                                                <!-- Row: Address 2 -->
                                                <div class="column is-full">
                                                    <input name="person[address][street_2]"
                                                           type="text"
                                                           class="input"
                                                           v-model="formFields.person.address.street_2"
                                                           placeholder="Address 2" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                                </div>

                                                <!-- Row: City & State -->
                                                <div class="column is-three-fifths">
                                                    <div class="control has-icons-right">
                                                        <input name="person[address][city]"
                                                               type="text"
                                                               class="input"
                                                               v-validate="'required'"
                                                               data-vv-as="City"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.person.address.city"
                                                               :class="{ 'is-danger': errors.has('person[address][city]') }"
                                                               placeholder="City *" error-message-custome="The City field is required"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[address][city]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error"></span>
                                                </div>
                                                <div class="column is-two-fifths">
                                                    <div class="select" :class="{ 'is-danger': errors.has('person[address][state]') }">
                                                        <select v-model="formFields.person.address.state"
                                                                name="person[address][state]"
                                                                v-validate="'required'"
                                                                data-vv-as="State"
                                                                class="input-select" error-message-custome="The State field is required">
                                                            <option value="">State *</option>
                                                            <option value="AL">Alabama</option>
                                                            <option value="AK">Alaska</option>
                                                            <option value="AZ">Arizona</option>
                                                            <option value="AE">Armed Forces Africa</option>
                                                            <option value="AA">Armed Forces Americas (except Canada)</option>
                                                            <option value="AE">Armed Forces Canada</option>
                                                            <option value="AE">Armed Forces Europe</option>
                                                            <option value="AE">Armed Forces Middle East</option>
                                                            <option value="AP">Armed Forces Pacific</option>
                                                            <option value="AR">Arkansas</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="CA">California</option>
                                                            <option value="CO">Colorado</option>
                                                            <option value="CT">Connecticut</option>
                                                            <option value="DE">Delaware</option>
                                                            <option value="DC">District Of Columbia</option>
                                                            <option value="FL">Florida</option>
                                                            <option value="GA">Georgia</option>
                                                            <option value="GU">Guam</option>
                                                            <option value="HI">Hawaii</option>
                                                            <option value="ID">Idaho</option>
                                                            <option value="IL">Illinois</option>
                                                            <option value="IN">Indiana</option>
                                                            <option value="IA">Iowa</option>
                                                            <option value="KS">Kansas</option>
                                                            <option value="KY">Kentucky</option>
                                                            <option value="LA">Louisiana</option>
                                                            <option value="ME">Maine</option>
                                                            <option value="MD">Maryland</option>
                                                            <option value="MA">Massachusetts</option>
                                                            <option value="MI">Michigan</option>
                                                            <option value="MN">Minnesota</option>
                                                            <option value="MS">Mississippi</option>
                                                            <option value="MO">Missouri</option>
                                                            <option value="MT">Montana</option>
                                                            <option value="NE">Nebraska</option>
                                                            <option value="NV">Nevada</option>
                                                            <option value="NH">New Hampshire</option>
                                                            <option value="NJ">New Jersey</option>
                                                            <option value="NM">New Mexico</option>
                                                            <option value="NY">New York</option>
                                                            <option value="NC">North Carolina</option>
                                                            <option value="ND">North Dakota</option>
                                                            <option value="NM">Northern Mariana Islands</option>
                                                            <option value="OH">Ohio</option>
                                                            <option value="OK">Oklahoma</option>
                                                            <option value="OR">Oregon</option>
                                                            <option value="PA">Pennsylvania</option>
                                                            <option value="PR">Puerto Rico</option>
                                                            <option value="RI">Rhode Island</option>
                                                            <option value="SC">South Carolina</option>
                                                            <option value="SD">South Dakota</option>
                                                            <option value="TN">Tennessee</option>
                                                            <option value="TX">Texas</option>
                                                            <option value="US">United States Virgin Islands</option>
                                                            <option value="UT">Utah</option>
                                                            <option value="VT">Vermont</option>
                                                            <option value="VA">Virginia</option>
                                                            <option value="WA">Washington</option>
                                                            <option value="WV">West Virginia</option>
                                                            <option value="WI">Wisconsin</option>
                                                            <option value="WY">Wyoming</option>
                                                        </select>
                                                        <span class="vee-validate-error"></span>
                                                    </div>
                                                </div>

                                                <!-- Row: Zip -->
                                                <div class="column is-one-third">
                                                    <div class="control has-icons-right">
                                                        <input name="person[address][zipcode]"
                                                               type="text"
                                                               class="input"
                                                               v-validate="'required'"
                                                               data-vv-as="Zipcode"
                                                               data-vv-validate-on="blur"
                                                               :class="{ 'is-danger': errors.has('person[address][zipcode]') }"
                                                               v-model="formFields.person.address.zipcode"
                                                               placeholder="Zipcode *" error-message-custome="The Zipcode field is required"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[address][zipcode]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error"></span>
                                                </div>
                                                <div class="column is-two-thirds"></div>

                                                <!-- Row: Email & Phone -->
                                                <div class="column is-one-third">
                                                    <div class="control has-icons-right">
                                                        <input name="person[email]"
                                                               type="text"
                                                               class="input"
                                                               v-validate="'required|email'"
                                                               data-vv-as="Email"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.person.email"
                                                               :class="{ 'is-danger': errors.has('person[email]') }"
                                                               placeholder="Email *" id="email_valid" error-message-custome="The Email field is required" on-blur-effect-flag="1"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[email]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error email_valid"></span>
                                                </div>
                                                <div class="column is-two-thirds">
                                                    <div class="control has-icons-right">
                                                        <input name="person[phone]"
                                                               type="text"
                                                               class="input phone_number_val"
                                                               v-validate="'numeric'"
                                                               data-vv-as="Phone"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.person.phone"
                                                               :class="{ 'is-danger': errors.has('person[phone]') }"
                                                               placeholder="Mobile" error-message-custome="The Phone field may only contain numeric characters" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[phone]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error"></span>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <input id="is-mobile-attached"
                                                       type="checkbox"
                                                       v-model="formFields.isMobileAttached"
                                                       class="is-checkradio is-info has-bg-active" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                                <label for="is-mobile-attached" class="checkradio-label is-marginless">
                                                    By providing my mobile phone number, I opt in to receive text alerts, updates, and news messages via SMS/MMS from Judicial Watch. Donations may be solicited. Additional message and data rates may apply. Text STOP to opt-out. Text HELP for assistance or call 888-593-8442. Message frequency may vary. SMS opt-in data or phone numbers will not be sold, rented, or shared with third parties. <a href="https://tandcs.us/jwi" target="_blank">Terms & conditions/privacy policy apply</a>
                                                </label>
                                            </div>

                                            <div class="field">
                                                <input id="billing-toggle"
                                                       type="checkbox"
                                                       v-model="formFields.billing_address.isDifferentFromPersonalAddress"
                                                       class="is-checkradio is-info has-bg-active" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                                <label for="billing-toggle" class="checkradio-label is-marginless">
                                                    My billing address is different from above
                                                </label>
                                            </div>

                                            <!-- Billing Address -->
                                            <div id="billing_address_div" style="display:none;">
                                                <!-- Row: Address -->
                                                <div class="column is-full">
                                                    <div class="control has-icons-right">
                                                        <input name="billing_address[street]"
                                                               type="text"
                                                               class="input billing_address_field"
                                                               v-validate="'required'"
                                                               data-vv-as="Address"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.billing_address.street"
                                                               :class="{ 'is-danger': errors.has('billing_address[street]') }"
                                                               placeholder="Address *" error-message-custome="The Address field is required" on-blur-effect-flag-disabled="1"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('billing_address[street]')" >
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error Address_class"></span>
                                                </div>

                                                <!-- Row: Address 2 -->
                                                <div class="column is-full">
                                                    <div class="control has-icons-right">
                                                        <input name="billing_address[street_2]"
                                                               type="text"
                                                               class="input billing_address_field"
                                                               v-model="formFields.billing_address.street_2"
                                                               placeholder="Address 2" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('billing_address[street_2]')"  >
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                </div>

                                                <!-- Row: City & State -->
                                                <div class="column is-three-fifths">
                                                    <div class="control has-icons-right">
                                                        <input name="billing_address[city]"
                                                               type="text"
                                                               class="input billing_address_field"
                                                               v-validate="'required'"
                                                               data-vv-as="City"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.billing_address.city"
                                                               :class="{ 'is-danger': errors.has('billing_address[city]') }"
                                                               placeholder="City *" error-message-custome="The City field is required" on-blur-effect-flag-disabled="1"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('billing_address[city]')"  >
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error City_class"></span>
                                                </div>
                                                <div class="column is-two-fifths">
                                                    <div class="select" :class="{ 'is-danger': errors.has('billing_address[state]') }">
                                                        <select v-model="formFields.billing_address.state"
                                                                name="billing_address[state]"
                                                                :class="{ 'is-danger': errors.has('billing_address[state]') }"
                                                                v-validate="'required'"
                                                                data-vv-as="State"
                                                                class="input-select billing_address_field" error-message-custome="The State field is required" on-blur-effect-flag-disabled="1">
                                                            <option value="">State *</option>
                                                            <option value="AL">Alabama</option>
                                                            <option value="AK">Alaska</option>
                                                            <option value="AZ">Arizona</option>
                                                            <option value="AE">Armed Forces Africa</option>
                                                            <option value="AA">Armed Forces Americas (except Canada)</option>
                                                            <option value="AE">Armed Forces Canada</option>
                                                            <option value="AE">Armed Forces Europe</option>
                                                            <option value="AE">Armed Forces Middle East</option>
                                                            <option value="AP">Armed Forces Pacific</option>
                                                            <option value="AR">Arkansas</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="CA">California</option>
                                                            <option value="CO">Colorado</option>
                                                            <option value="CT">Connecticut</option>
                                                            <option value="DE">Delaware</option>
                                                            <option value="DC">District Of Columbia</option>
                                                            <option value="FL">Florida</option>
                                                            <option value="GA">Georgia</option>
                                                            <option value="GU">Guam</option>
                                                            <option value="HI">Hawaii</option>
                                                            <option value="ID">Idaho</option>
                                                            <option value="IL">Illinois</option>
                                                            <option value="IN">Indiana</option>
                                                            <option value="IA">Iowa</option>
                                                            <option value="KS">Kansas</option>
                                                            <option value="KY">Kentucky</option>
                                                            <option value="LA">Louisiana</option>
                                                            <option value="ME">Maine</option>
                                                            <option value="MD">Maryland</option>
                                                            <option value="MA">Massachusetts</option>
                                                            <option value="MI">Michigan</option>
                                                            <option value="MN">Minnesota</option>
                                                            <option value="MS">Mississippi</option>
                                                            <option value="MO">Missouri</option>
                                                            <option value="MT">Montana</option>
                                                            <option value="NE">Nebraska</option>
                                                            <option value="NV">Nevada</option>
                                                            <option value="NH">New Hampshire</option>
                                                            <option value="NJ">New Jersey</option>
                                                            <option value="NM">New Mexico</option>
                                                            <option value="NY">New York</option>
                                                            <option value="NC">North Carolina</option>
                                                            <option value="ND">North Dakota</option>
                                                            <option value="NM">Northern Mariana Islands</option>
                                                            <option value="OH">Ohio</option>
                                                            <option value="OK">Oklahoma</option>
                                                            <option value="OR">Oregon</option>
                                                            <option value="PA">Pennsylvania</option>
                                                            <option value="PR">Puerto Rico</option>
                                                            <option value="RI">Rhode Island</option>
                                                            <option value="SC">South Carolina</option>
                                                            <option value="SD">South Dakota</option>
                                                            <option value="TN">Tennessee</option>
                                                            <option value="TX">Texas</option>
                                                            <option value="US">United States Virgin Islands</option>
                                                            <option value="UT">Utah</option>
                                                            <option value="VT">Vermont</option>
                                                            <option value="VA">Virginia</option>
                                                            <option value="WA">Washington</option>
                                                            <option value="WV">West Virginia</option>
                                                            <option value="WI">Wisconsin</option>
                                                            <option value="WY">Wyoming</option>
                                                        </select>
                                                        <span class="vee-validate-error State_class"></span>
                                                    </div>
                                                </div>

                                                <!-- Row: Zip -->
                                                <div class="column is-one-third">
                                                    <div class="control has-icons-right">
                                                        <input name="billing_address[zipcode]"
                                                               type="text"
                                                               class="input billing_address_field"
                                                               v-validate="'required'"
                                                               data-vv-as="Zipcode"
                                                               data-vv-validate-on="blur"
                                                               v-model="formFields.billing_address.zipcode"
                                                               :class="{ 'is-danger': errors.has('billing_address[zipcode]') }"
                                                               placeholder="Zipcode *" error-message-custome="The Zipcode field is required" on-blur-effect-flag-disabled="1"/>
                                                        <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[address][street]')" >
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                                    </div>
                                                    <span class="vee-validate-error Zipcode_class"></span>
                                                </div>
                                                <div class="column is-two-thirds"></div>
                                            </div>

                                            <!-- Submit -->
                                            <div class="columns donate-form-submit">
                                                <div v-if="formWasSubmitted && errors.any()" class="form-error-label" style="display:none;" id="all_error_class">
                                                    <div class="select_amount" id="select_amount" style="display:none;">
                                                        Please update donation value to be at least $5
                                                    </div>
                                                    <div id="all_error_display" style="display:none;">
                                                        Please fix errors above before donating
                                                    </div>
                                                </div>
                                                <div class="column is-narrow">
                                                    <input type="submit" value="Donate"  class=" submit button is-primary is-wide button-donate-submit">
                                                    <div class="please_wait" style="display:none;">
                                                        <span class="m-r-15">Please Wait</span>
                                                        <span class="fa fa-spinner fa-spin"></span>
                                                    </div>

                                                    <!--    <button @click="validateForm()"
                                                              type="button"
                                                              :disabled="this.formIsSubmitting"
                                                              class="button is-primary is-wide button-donate-submit">
                                                          <template v-if="this.formIsSubmitting">
                                                              <span class="m-r-15">Please Wait</span>
                                                              <span class="fa fa-spinner fa-spin"></span>
                                                          </template>
                                                          <template v-else>
                                                              Donate
                                                          </template>
                                                      </button> -->
                                                </div>



                                                <div class="column">
                                                    <div class="donate-label">Amount</div>
                                                    <div class="donate-amount">
                                                        <span class="donation_amount">$0</span>
                                                        <span class="per_month" style="display:none;">/ month</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden"
                                                   name="donation_amount_hidden"
                                                   id="hidden_donation_amount"
                                                   value="0"
                                                   v-validate="'required|min_value:1'">

                                            <input type="hidden"
                                                   name="mb_tracking_code"
                                                   value="<?php echo $mbTrackingCode ?>" id="mb_tracking_code" />
                                        </form>

                                        <hr class="donate-form-divider"/>
                                    </div>




















                                </div>

                            </div>
                        </div>

                        <div class="about-jw">
                            <h4 class="m-b-10">About Judicial Watch Donations</h4>
                            <p>
                                If you have any questions or comments, please contact Judicial Watch by emailing us or calling us toll free at (1) 888-593-8442.
                            </p>
                            <p>
                                Judicial Watch is a 501(c)(3) nonprofit organization. Contributions are received from individuals, foundations, and corporations and are tax-deductible to the extent allowed by law.
                            </p>
                            <p>
                                For a copy of our latest IRS form 990 send an email to Development@judicialwatch.org
                            </p>

                            <a href="/contact" class="button is-primary is-inverted is-wide is-slim button-contact">Contact</a>
                        </div>

                        <h4>Other Ways to Donate</h4>
                        <div class="columns columns-donate-options is-multiline is-gapless">
                            <div class="column is-full">
                                <div class="columns is-variable">
                                    <div class="column"><a href="/wp-content/uploads/2021/05/Donate-by-Mail-Form-updated.pdf">Donate by Mail</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Donate by Telephone</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Monthly Giving</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Matching Gifts</a></div>
                                </div>
                            </div>
                            <div class="column is-full">
                                <div class="columns">
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Stocks, Bonds, & Securities</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Charitable Gift Annuities</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Wills & Trusts</a></div>
                                </div>
                            </div>
                        </div>
                    </section>

                <?php } ?>

                <?php if ($pageContentNotAvailable) { ?>
                    <section class="page-content page-container container-750 p-t-50 mobile-p-t-40">

                        <?php if ($petitionSubmittedSuccess) { ?>
                            <img height="1" width="1" src="https://trk.lockerdome.com/ldpix.gif?ldc=11201001709622784_judicialwatch_suppression">
                        <?php } ?>

                        <div class="wysiwyg-content">
                            <h1><?php echo get_the_title(); ?></h1>

                            <?php echo get_the_content(); ?>
                        </div>

                        <div id="VueDonateComponent">

                            <div>
                                <div class="modal modal-donate-response" :class="{ 'is-active': this.responseModal.active }">
                                    <div class="modal-background"></div>
                                    <div class="modal-content">
<!--                                        <div class="content-data_value"> --><?php //echo $this['responseModal'].message; ?><!--  </div>-->
                                        <button type="button" class="button is-primary is-inverted is-slim"  onclick="hideResponseModal();">Close</button>
                                    </div>
                                </div>

                                <button v-if="isQaEnabled" @click="setQaValues()" type="button" style="display:none;">QA: Fill Out Form Fields</button>

                                <!-- Select Donation Amount -->
                                <h2 class="m-b-15">Select Amount to Donate</h2>
                                <input type="hidden" value="<?php echo admin_url('admin-post.php'); ?>" name="form_url_submit" id="form_url_submit" >
                                <div class="columns is-multiline is-grid-20px grid-button-list columns-donate-buttons">

                                    <?php foreach ($donateAmounts as $donateAmount_twig) { ?>
                                        <div
                                                class="column is-one-third">
                                            <button type="button"
                                                    class="button is-primary button_select_amount is-wide"
                                                    selected_value="<?= $donateAmount_twig ?>" id="button_select_amount_<?= $donateAmount_twig?>" >

                                                $<?= $donateAmount_twig?>
                                            </button>
                                        </div>
                                    <?php } ?>


                                    <!-- Custom Amount -->
                                    <div class="column is-one-third">
                                        <div class="control has-icons-right">
                                            <input type="text"
                                                   ref="otherDonationAmountInput"
                                                   @keyup="setOtherDonationAmount()"
                                                   placeholder="Other amount..."
                                                   v-validate="'numeric'"
                                                   data-vv-as="donation"
                                                   name="custom_donation_amount"
                                                   v-model="customDonationAmount"
                                                   :class="{ 'is-danger': errors.has('custom_donation_amount') }"
                                                   class="input donate-input"/>
                                            <!--   <span class="icon is-small is-right" v-if="errors.has('custom_donation_amount')">
                                                 <span class="fas fa-exclamation-circle has-text-danger"></span>
                                             </span> -->
                                        </div>
                                        <span class="vee-validate-error donation-custom-class" style="display:none;">Please enter a valid amount</span>
                                        <span class="vee-validate-error donation-custom-transaction" style="display:none;">Minimum Transaction $5</span>
                                    </div>
                                    <!-- PayPal -->

                                    <?php if ($allowPaypal) { ?>

                                        <div v-if="allowPaypal" class="column is-one-third">
                                            <form  id="paypalformtwig" name="paypalform" method="post" action="https://www.paypal.com/cgi-bin/webscr" target="_top">
                                                <input type="hidden" name="business" value="development@judicialwatch.org">
                                                <input type="hidden" name="cmd" value="_donations" />
                                                <input type="hidden" name="cancel_return" value="<?= $paypalCancelReturnUrl ?>" />
                                                <input type="hidden" name="return" value="<?= $paypalReturnUrl ?>" />
                                                <input type="hidden" name="currency_code" value="USD" />


                                                <input type="hidden" name="amount" value="1" id="amount_paypal" disabled="true">
                                                <input type="image" name="submit" style="display:none" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_donate_92x26.png" alt="Donate" />
                                                <img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" />
                                                <button type="button" class="button is-primary is-inverted is-slim paypalFormSubmit" >
                                                    <img src="/wp-content/themes/judicial-watch/assets/images/button-paypal-logo.png" class="all-browser"  style="width:100%;"/>
                                                </button>
                                            </form>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="field">
                                    <input id="monthly-donation-toggle"
                                           type="checkbox"
                                           v-model="formFields.isMonthlyDonation"
                                           class="is-checkradio is-info has-bg-active"/>
                                    <label for="monthly-donation-toggle"
                                           class="checkradio-label is-marginless">
                                        Make this a monthly donation! Please note, monthly donations are processed immediately on the 1st of every month.
                                    </label>
                                </div>

                                <!-- Payment Information -->
                                <h2 class="m-t-50">Payment Information</h2>
                                <form class="cmxform" id="form1"  onsubmit="return sendPostRequest(this);" method="post" >
                                    <div class="columns is-multiline is-gap-10px">
                                        <!-- Required Fields Label -->
                                        <div class="column is-full">
                <span class="help-text is-italic p-t-5">
                    <div class="col-asterisk">
                        <span class="far fa-asterisk"></span>
                    </div>
                    <div class="col">
                        <span class="content">Required field</span>
                    </div>
                </span>
                                            <div class="cc-list">
                                                <span class="fab fa-cc-visa"></span>
                                                <span class="fab fa-cc-mastercard"></span>
                                                <span class="fab fa-cc-discover"></span>
                                                <span class="fab fa-cc-amex"></span>
                                            </div>
                                        </div>
                                        <!-- First Row -->
                                        <div class="column is-full p-t-0">
                                            <div class="control has-icons-right">
                                                <input name="card[number]"
                                                       v-validate="'credit_card|required'"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.card.number"
                                                       data-vv-as="Card"
                                                       type="text"
                                                       class="input"
                                                       :class="{ 'is-danger': errors.has('card[number]') }"
                                                       placeholder="Card Number *" id="card-number" error-message-custome="The Card field is invalid" on-blur-effect-flag="1"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('card[number]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="card-number vee-validate-error"></span>
                                        </div>
                                        <!-- Second row -->
                                        <div class="column is-one-third p-t-0">
                                            <div class="control has-icons-right">
                                                <input name="card[ccv]"
                                                       v-validate="'numeric|required'"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.card.ccv"
                                                       data-vv-as="CCV"
                                                       type="text"
                                                       class="input"
                                                       :class="{ 'is-danger': errors.has('card[ccv]') }"
                                                       placeholder="Security Code *" id="cvv" error-message-custome="The CCV field may only contain numeric characters" on-blur-effect-flag="1" />
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('card[ccv]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error cvv"></span>
                                        </div>
                                        <div class="column is-one-third">
                                            <div class="select" :class="{ 'is-danger': errors.has('card[month]') }">
                                                <select v-model="formFields.card.month"
                                                        name="card[month]"
                                                        v-validate="'required'"
                                                        data-vv-as="Month"
                                                        :class="{ 'is-danger': errors.has('card[month]') }"
                                                        class="input-select" error-message-custome="The Month field is required">
                                                    <option value="">Month *</option>
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                                <span class="vee-validate-error"></span>
                                            </div>
                                        </div>
                                        <div class="column is-one-third">
                                            <div class="select" :class="{ 'is-danger': errors.has('card[year]') }">
                                                <select v-model="formFields.card.year"
                                                        name="card[year]"
                                                        v-validate="'required'"
                                                        data-vv-as="Year"
                                                        :class="{ 'is-danger': errors.has('card[year]') }"
                                                        class="input-select" id="year_select_twig" error-message-custome="The Year field is required">
                                                    <option value="">Year *</option>




                                                </select>
                                                <span class="vee-validate-error"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <h2 class="m-t-50">Personal Information</h2>
                                    <div class="columns is-multiline">
                                        <!-- Required Fields Label -->
                                        <div class="column is-full">
                <span class="help-text is-italic p-t-5">
                    <div class="col-asterisk">
                        <span class="far fa-asterisk"></span>
                    </div>
                    <div class="col">
                        <span class="content">Required field</span>
                    </div>
                </span>

                                        </div>

                                        <!-- Row: Name -->
                                        <div class="column is-half p-t-0">
                                            <div class="control has-icons-right">
                                                <input name="person[name][first]"
                                                       type="text"
                                                       class="input"
                                                       :class="{ 'is-danger': errors.has('person[name][first]') }"
                                                       v-validate="'required'"
                                                       data-vv-validate-on="blur"
                                                       data-vv-as="Name"
                                                       v-model="formFields.person.name.first"
                                                       placeholder="First Name *" error-message-custome="The Name field is required"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[name][first]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error"></span>
                                        </div>
                                        <div class="column is-half p-t-0">
                                            <div class="control has-icons-right">
                                                <input name="person[name][last]"
                                                       type="text"
                                                       class="input"
                                                       v-validate="'required'"
                                                       data-vv-as="Name"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.person.name.last"
                                                       :class="{ 'is-danger': errors.has('person[name][last]') }"
                                                       placeholder="Last Name *" error-message-custome="The Name field is required"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[name][last]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error"></span>
                                        </div>

                                        <!-- Row: Address -->
                                        <div class="column is-full">
                                            <div class="control has-icons-right">
                                                <input name="person[address][street]"
                                                       type="text"
                                                       class="input"
                                                       v-validate="'required'"
                                                       :class="{ 'is-danger': errors.has('person[address][street]') }"
                                                       data-vv-as="Address"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.person.address.street"
                                                       placeholder="Address *" error-message-custome="The Address field is required"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[address][street]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error"></span>
                                        </div>

                                        <!-- Row: Address 2 -->
                                        <div class="column is-full">
                                            <input name="person[address][street_2]"
                                                   type="text"
                                                   class="input"
                                                   v-model="formFields.person.address.street_2"
                                                   placeholder="Address 2" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1" />
                                        </div>

                                        <!-- Row: City & State -->
                                        <div class="column is-three-fifths">
                                            <div class="control has-icons-right">
                                                <input name="person[address][city]"
                                                       type="text"
                                                       class="input"
                                                       v-validate="'required'"
                                                       data-vv-as="City"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.person.address.city"
                                                       :class="{ 'is-danger': errors.has('person[address][city]') }"
                                                       placeholder="City *" error-message-custome="The City field is required"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[address][city]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error"></span>
                                        </div>
                                        <div class="column is-two-fifths">
                                            <div class="select" :class="{ 'is-danger': errors.has('person[address][state]') }">
                                                <select v-model="formFields.person.address.state"
                                                        name="person[address][state]"
                                                        v-validate="'required'"
                                                        data-vv-as="State"
                                                        class="input-select" error-message-custome="The State field is required">
                                                    <option value="">State *</option>
                                                    <option value="AL">Alabama</option>
                                                    <option value="AK">Alaska</option>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="AE">Armed Forces Africa</option>
                                                    <option value="AA">Armed Forces Americas (except Canada)</option>
                                                    <option value="AE">Armed Forces Canada</option>
                                                    <option value="AE">Armed Forces Europe</option>
                                                    <option value="AE">Armed Forces Middle East</option>
                                                    <option value="AP">Armed Forces Pacific</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="AS">American Samoa</option>
                                                    <option value="CA">California</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="DC">District Of Columbia</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="GU">Guam</option>
                                                    <option value="HI">Hawaii</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="NM">Northern Mariana Islands</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="PR">Puerto Rico</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="US">United States Virgin Islands</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WA">Washington</option>
                                                    <option value="WV">West Virginia</option>
                                                    <option value="WI">Wisconsin</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                                <span class="vee-validate-error"></span>
                                            </div>
                                        </div>

                                        <!-- Row: Zip -->
                                        <div class="column is-one-third">
                                            <div class="control has-icons-right">
                                                <input name="person[address][zipcode]"
                                                       type="text"
                                                       class="input"
                                                       v-validate="'required'"
                                                       data-vv-as="Zipcode"
                                                       data-vv-validate-on="blur"
                                                       :class="{ 'is-danger': errors.has('person[address][zipcode]') }"
                                                       v-model="formFields.person.address.zipcode"
                                                       placeholder="Zipcode *" error-message-custome="The Zipcode field is required"/>
                                                <span class="icon is-small is-right"style="display:none;" v-if="errors.has('person[address][zipcode]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error"></span>
                                        </div>
                                        <div class="column is-two-thirds"></div>

                                        <!-- Row: Email & Phone -->
                                        <div class="column is-one-third">
                                            <div class="control has-icons-right">
                                                <input name="person[email]"
                                                       type="text"
                                                       class="input"
                                                       v-validate="'required|email'"
                                                       data-vv-as="Email"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.person.email"
                                                       :class="{ 'is-danger': errors.has('person[email]') }"
                                                       placeholder="Email *" id="email_valid" error-message-custome="The Email field is required" on-blur-effect-flag="1"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[email]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error"></span>
                                        </div>
                                        <div class="column is-two-thirds">
                                            <div class="control has-icons-right">
                                                <input name="person[phone]"
                                                       type="text"
                                                       class="input phone_number_val"
                                                       v-validate="'numeric'"
                                                       data-vv-as="Phone"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.person.phone"
                                                       :class="{ 'is-danger': errors.has('person[phone]') }"
                                                       placeholder="Mobile" error-message-custome="The Phone field may only contain numeric characters" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[phone]')">
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error"></span>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <input id="is-mobile-attached"
                                               type="checkbox"
                                               v-model="formFields.isMobileAttached"
                                               class="is-checkradio is-info has-bg-active" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                        <label for="is-mobile-attached" class="checkradio-label is-marginless">
                                                                By providing my mobile phone number, I opt in to receive text alerts, updates, and news messages via SMS/MMS from Judicial Watch. Donations may be solicited. Additional message and data rates may apply. Text STOP to opt-out. Text HELP for assistance or call 888-593-8442. Message frequency may vary. SMS opt-in data or phone numbers will not be sold, rented, or shared with third parties. <a href="https://tandcs.us/jwi" target="_blank">Terms & conditions/privacy policy apply</a>
    
                                    </label>
                                    </div>
                                    <div class="field">
                                        <input id="billing-toggle"
                                               type="checkbox"
                                               v-model="formFields.billing_address.isDifferentFromPersonalAddress"
                                               class="is-checkradio is-info has-bg-active" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                        <label for="billing-toggle" class="checkradio-label is-marginless">
                                            My billing address is different from above
                                        </label>
                                    </div>

                                    <!-- Billing Address -->
                                    <div id="billing_address_div" style="display:none;">
                                        <!-- Row: Address -->
                                        <div class="column is-full">
                                            <div class="control has-icons-right">
                                                <input name="billing_address[street]"
                                                       type="text"
                                                       class="input billing_address_field"
                                                       v-validate="'required'"
                                                       data-vv-as="Address"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.billing_address.street"
                                                       :class="{ 'is-danger': errors.has('billing_address[street]') }"
                                                       placeholder="Address *" error-message-custome="The Address field is required" on-blur-effect-flag-disabled="1"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('billing_address[street]')" >
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error Address_class"></span>
                                        </div>

                                        <!-- Row: Address 2 -->
                                        <div class="column is-full">
                                            <div class="control has-icons-right">
                                                <input name="billing_address[street_2]"
                                                       type="text"
                                                       class="input billing_address_field"
                                                       v-model="formFields.billing_address.street_2"
                                                       placeholder="Address 2" on-blur-effect-flag-disabled="1" on-blur-effect-flag-disabled-billing="1"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('billing_address[street_2]')"  >
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                        </div>

                                        <!-- Row: City & State -->
                                        <div class="column is-three-fifths">
                                            <div class="control has-icons-right">
                                                <input name="billing_address[city]"
                                                       type="text"
                                                       class="input billing_address_field"
                                                       v-validate="'required'"
                                                       data-vv-as="City"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.billing_address.city"
                                                       :class="{ 'is-danger': errors.has('billing_address[city]') }"
                                                       placeholder="City *" error-message-custome="The City field is required" on-blur-effect-flag-disabled="1"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('billing_address[city]')"  >
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error City_class"></span>
                                        </div>
                                        <div class="column is-two-fifths">
                                            <div class="select" :class="{ 'is-danger': errors.has('billing_address[state]') }">
                                                <select v-model="formFields.billing_address.state"
                                                        name="billing_address[state]"
                                                        :class="{ 'is-danger': errors.has('billing_address[state]') }"
                                                        v-validate="'required'"
                                                        data-vv-as="State"
                                                        class="input-select billing_address_field" error-message-custome="The State field is required" on-blur-effect-flag-disabled="1">
                                                    <option value="">State *</option>
                                                    <option value="AL">Alabama</option>
                                                    <option value="AK">Alaska</option>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="AE">Armed Forces Africa</option>
                                                    <option value="AA">Armed Forces Americas (except Canada)</option>
                                                    <option value="AE">Armed Forces Canada</option>
                                                    <option value="AE">Armed Forces Europe</option>
                                                    <option value="AE">Armed Forces Middle East</option>
                                                    <option value="AP">Armed Forces Pacific</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="AS">American Samoa</option>
                                                    <option value="CA">California</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="DC">District Of Columbia</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="GU">Guam</option>
                                                    <option value="HI">Hawaii</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="NM">Northern Mariana Islands</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="PR">Puerto Rico</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="US">United States Virgin Islands</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WA">Washington</option>
                                                    <option value="WV">West Virginia</option>
                                                    <option value="WI">Wisconsin</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                                <span class="vee-validate-error State_class"></span>
                                            </div>
                                        </div>

                                        <!-- Row: Zip -->
                                        <div class="column is-one-third">
                                            <div class="control has-icons-right">
                                                <input name="billing_address[zipcode]"
                                                       type="text"
                                                       class="input billing_address_field"
                                                       v-validate="'required'"
                                                       data-vv-as="Zipcode"
                                                       data-vv-validate-on="blur"
                                                       v-model="formFields.billing_address.zipcode"
                                                       :class="{ 'is-danger': errors.has('billing_address[zipcode]') }"
                                                       placeholder="Zipcode *" error-message-custome="The Zipcode field is required" on-blur-effect-flag-disabled="1"/>
                                                <span class="icon is-small is-right" style="display:none;" v-if="errors.has('person[address][street]')" >
                            <span class="fas fa-exclamation-circle has-text-danger"></span>
                        </span>
                                            </div>
                                            <span class="vee-validate-error Zipcode_class"></span>
                                        </div>
                                        <div class="column is-two-thirds"></div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="columns donate-form-submit">
                                        <div v-if="formWasSubmitted && errors.any()" class="form-error-label" style="display:none;" id="all_error_class">
                                            <div class="select_amount" id="select_amount" style="display:none;">
                                                Please update donation value to be at least $5
                                            </div>
                                            <div id="all_error_display" style="display:none;">
                                                Please fix errors above before donating
                                            </div>
                                        </div>
                                        <div class="column is-narrow">
                                            <input type="submit" value="Donate"  class=" submit button is-primary is-wide button-donate-submit">
                                            <div class="please_wait" style="display:none;">
                                                <span class="m-r-15">Please Wait</span>
                                                <span class="fa fa-spinner fa-spin"></span>
                                            </div>

                                            <!--    <button @click="validateForm()"
                                                      type="button"
                                                      :disabled="this.formIsSubmitting"
                                                      class="button is-primary is-wide button-donate-submit">
                                                  <template v-if="this.formIsSubmitting">
                                                      <span class="m-r-15">Please Wait</span>
                                                      <span class="fa fa-spinner fa-spin"></span>
                                                  </template>
                                                  <template v-else>
                                                      Donate
                                                  </template>
                                              </button> -->
                                        </div>



                                        <div class="column">
                                            <div class="donate-label">Amount</div>
                                            <div class="donate-amount">
                                                <span class="donation_amount">$0</span>
                                                <span class="per_month" style="display:none;">/ month</span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden"
                                           name="donation_amount_hidden"
                                           id="hidden_donation_amount"
                                           value="0"
                                           v-validate="'required|min_value:1'">

                                    <input type="hidden"
                                           name="mb_tracking_code"
                                           value="<?= $mbTrackingCode ?>" id="mb_tracking_code" />
                                </form>

                                <hr class="donate-form-divider"/>
                            </div>


                            <style>
                                template {
                                    display: none;
                                }
                            </style>

















                        </div>






            
                         <div class="about-jw">
                            <h4 class="m-b-10">About Judicial Watch Donations</h4>
                            <p>
                                If you have any questions or comments, please contact Judicial Watch by emailing us or calling us toll free at (1) 888-593-8442.
                            </p>
                            <p>
                                Judicial Watch is a 501(c)(3) nonprofit organization. Contributions are received from individuals, foundations, and corporations and are tax-deductible to the extent allowed by law.
                            </p>
                            <p>
                                For a copy of our latest IRS form 990 send an email to Development@judicialwatch.org
                            </p>

                            <a href="/contact" class="button is-primary is-inverted is-wide is-slim button-contact">Contact</a>
                        </div>

                        <h4>Other Ways to Donate</h4>
                        <div class="columns columns-donate-options is-multiline is-gapless">
                            <div class="column is-full">
                                <div class="columns is-variable">
                                    <div class="column"><a href="/wp-content/uploads/2021/05/Donate-by-Mail-Form-updated.pdf">Donate by Mail</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Donate by Telephone</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Monthly Giving</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Matching Gifts</a></div>
                                </div>
                            </div>
                            <div class="column is-full">
                                <div class="columns">
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Stocks, Bonds, & Securities</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Charitable Gift Annuities</a></div>
                                    <div class="column"><a href="/about/support-judicial-watch/#how-do-i-make-a-donation-to-judicial-watch">Wills & Trusts</a></div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php } ?>


