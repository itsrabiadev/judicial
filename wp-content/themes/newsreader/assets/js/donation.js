(function($) {
    $( document ).ready(function() {

        $( ".input-select" ).change(function() {

            //alert(12);
            var input_error_message = $( this).attr('error-message-custome');
            var input_on_blur_effect_flag = $( this).attr('on-blur-effect-flag');
            var input_on_blur_effect_flag_disabled = $( this).attr('on-blur-effect-flag-disabled');
            var input_val = $( this).val();
            input_val = $.trim(input_val);

            if(input_on_blur_effect_flag_disabled != 1){
                if(input_val == ''){
                    $( this).addClass("is-danger" );
                    $( this).parent().addClass("is-danger" );

                    $(this).next().html(input_error_message);
                }else{
                    if(input_on_blur_effect_flag != 1){
                        $( this).removeClass("is-danger" );
                        $( this).parent().removeClass("is-danger" );

                        $(this).next().html('');
                    }
                }


            }

            if ($('#billing-toggle').is(':checked')) {
                var input_on_blur_effect_flag_disabled_billing = $( this).attr('on-blur-effect-flag-disabled-billing');
                if(input_on_blur_effect_flag_disabled_billing != 1){
                    if(input_val == ''){
                        $( this).parent().addClass("is-danger" );
                        $( this).addClass("is-danger" );

                        $(this).next().html(input_error_message);
                    }else{
                        if(input_on_blur_effect_flag != 1){
                            $( this).parent().removeClass("is-danger" );
                            $( this).removeClass("is-danger" );

                            $(this).next().html('');
                        }
                    }
                }
            }



        });

        $('.cmxform input').blur(function(){
            var input_error_message = $( this).attr('error-message-custome');
            var input_on_blur_effect_flag = $( this).attr('on-blur-effect-flag');
            var input_on_blur_effect_flag_disabled = $( this).attr('on-blur-effect-flag-disabled');
            var input_val = $( this).val();
            input_val = $.trim(input_val);

            if(input_on_blur_effect_flag_disabled != 1){
                if(input_val == ''){
                    $( this).addClass("is-danger" );
                    $( this).parent().find('.icon').show();
                    $(this).parent().parent('.column').find('.vee-validate-error').html(input_error_message);
                }else{
                    if(input_on_blur_effect_flag != 1){
                        $( this).removeClass("is-danger" );
                        $( this).parent().find('.icon').hide();
                        $(this).parent().parent('.column').find('.vee-validate-error').html('');
                    }
                }


            }

            if ($('#billing-toggle').is(':checked')) {
                var input_on_blur_effect_flag_disabled_billing = $( this).attr('on-blur-effect-flag-disabled-billing');
                if(input_on_blur_effect_flag_disabled_billing != 1){
                    if(input_val == ''){
                        $( this).addClass("is-danger" );
                        $( this).parent().find('.icon').show();
                        $(this).parent().parent('.column').find('.vee-validate-error').html(input_error_message);
                    }else{
                        if(input_on_blur_effect_flag != 1){
                            $( this).removeClass("is-danger" );
                            $( this).parent().find('.icon').hide();
                            $(this).parent().parent('.column').find('.vee-validate-error').html('');
                        }
                    }
                }
            }

        });

        $( ".paypalFormSubmit" ).click(function() {

            var browser = '';
            var browserVersion = 0;
            var browser_flag = 0;
            if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                browser = 'Opera';
                browser_flag = 1;
            } else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
                browser = 'MSIE';
            } else if (/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                browser = 'Netscape';
                browser_flag = 1;
            } else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                browser = 'Chrome';
                browser_flag = 1;
            } else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                browser = 'Safari';
                /Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
                browserVersion = new Number(RegExp.$1);
                browser_flag = 1;
            } else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
                browser = 'Firefox';
                browser_flag = 1;
            }
            if(browserVersion === 0){
                browserVersion = parseFloat(new Number(RegExp.$1));
            }
//alert(navigator.userAgent);
//alert(browser + "*" + browserVersion);
            if(browser_flag){
                $( "#paypalformtwig" ).submit();
            }else{


                if($('#hidden_donation_amount').val() < 5 ){
                    $("#select_amount").show();
                    $("#all_error_class").show();
                    $(".donation-custom-transaction").show();
                    $("#all_error_display").hide();
                    $(".donation-custom-class").show().fadeOut(4000);
                    return false;
                }else{
                    $("#amount_paypal").attr("disabled",false);
                    $(".donation-custom-transaction").hide();
                    $("#amount_paypal").val($('#hidden_donation_amount').val());

                    $( "#paypalformtwig" ).submit();

                }
            }







        });

        $( "#cvv" ).keyup(function(e) {

            //var regCVV = /^[0-9]{3,3}$/;

            var regCVV = /^[0-9]+$/;
//	var cvvRegex = /^[0-9]{3,3}$/;
            //var cvvRegex = /^[0-9]$/;
            var cvv = $(this).val();

            var input_error_message = $( this).attr('error-message-custome');

            if (!regCVV.test(cvv)) {

                $( this).addClass("is-danger" );
                $( this).parent().find('.icon').show();
                $(this).parent().parent('.column').find('.vee-validate-error').html(input_error_message);

            }
            else{
                $( this).removeClass("is-danger" );
                $( this).parent().find('.icon').hide();
                $(this).parent().parent('.column').find('.vee-validate-error').html('');
            }
        });

        $( ".phone_number_val" ).keyup(function(e) {

            //var regCVV = /^[0-9]{3,3}$/;

            var regCVV = /^[0-9]+$/;
//	var cvvRegex = /^[0-9]{3,3}$/;
            //var cvvRegex = /^[0-9]$/;
            var cvv = $(this).val();

            var input_error_message = $( this).attr('error-message-custome');

            if (!regCVV.test(cvv) && cvv != '') {

                $( this).addClass("is-danger" );
                $( this).parent().find('.icon').show();
                $(this).parent().parent('.column').find('.vee-validate-error').html(input_error_message);

            }
            else{
                $( this).removeClass("is-danger" );
                $( this).parent().find('.icon').hide();
                $(this).parent().parent('.column').find('.vee-validate-error').html('');
            }



        });
        $( ".donate-input" ).keypress(function(e) {

            var specialKeys = new Array();
            specialKeys.push(8); //Backspace
            var keyCode = e.which ? e.which : e.keyCode;
            //alert(keyCode);
            // alert(specialKeys.indexOf(keyCode));
            // var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1); // For Integer Value
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1  || keyCode == 46); // For Decimal Value
            if(!ret){

                $(".donation-custom-class").show().fadeOut(4000);
                return false;
            }

            var val_ampunt = (($(this).val()) + String.fromCharCode(e.keyCode));
            var val_ampunt_split = val_ampunt.split(".");
            if(val_ampunt_split.length > 2){
                $(".donation-custom-class").show().fadeOut(4000);
                return false;
            }


            val_ampunt = parseFloat(val_ampunt);

            var regexp = /^\d+(\.\d{1,2})?$/;

            if(val_ampunt != "" && val_ampunt > 0){
                if(!regexp.test(val_ampunt)){
                    $(".donation-custom-class").show().fadeOut(4000);
                    return false;
                }
            }



        });




        $( ".donate-input" ).keyup(function(e) {
            $( ".button_select_amount" ).removeClass("is-active" );
            $("#button_select_amount_"+$( this).val()).addClass("is-active" );





            if( $( this).val( ) == "" || $( this).val( ) > 4 ){
                $("#select_amount").hide();
                $("#select_amount").hide();
                $("#all_error_class").hide();
                $(".donation-custom-transaction").hide();

            }else{
                $("#select_amount").show();
                $("#all_error_class").show();
                $("#all_error_display").hide();
                $(".donation-custom-transaction").show();
            }
            $("#hidden_donation_amount").val($( this).val( ));
            $(".donation_amount").html("$"+$( this).val());





        });



        getYearsList();
        $('#billing-toggle').click(function() {
            if ($(this).is(':checked')) {
                $("#billing_address_div").show();
            }else{
                $("#billing_address_div").hide();
            }

        });

        $('.button_select_amount').click(function() {
            $( ".button_select_amount" ).removeClass("is-active" );
            $( this).addClass("is-active" );
            $( ".donate-input" ).val('');
            $("#select_amount").hide();
            $("#hidden_donation_amount").val($( this).attr("selected_value" ));
            $(".donation_amount").html("$"+$( this).attr("selected_value" ));

            if($( this).attr("selected_value" ) > 4 ){
                $("#select_amount").hide();
                $("#select_amount").hide();
                $("#all_error_class").hide();
                $(".donation-custom-transaction").hide();

            }else{
                $("#select_amount").show();
                $("#all_error_class").show();
                $("#all_error_display").hide();
                $(".donation-custom-transaction").show();
            }


        });

        $('#monthly-donation-toggle').click(function() {
            if ($(this).is(':checked')) {
                $(".per_month").show();
            }else{
                $(".per_month").hide();
            }

        });

        $("#card-number").on('input', function() {
            // Remove non-numeric characters from the input value
            var card_number = $(this).val().replace(/[^0-9]/g, '');

            // Set the modified value back to the input field
            $(this).val(card_number);
        });


        /*$( "#card-number" ).keyup(function(e) {*/
        $("#card-number").on('blur', function() {
            var card_number = $(this).val();
            var american_express =  cardnumber_american_express(card_number);
            var visa_card =  cardnumber_visa_card(card_number);
//	var dinner_card =  cardnumber_dinner_card(card_number);
            var discover_card =  cardnumber_discover_card(card_number);
            //var jcb_card =  cardnumber_jcb_card(card_number);
            var master_card =  cardnumber_master_card(card_number);
            var input_error_message = $( this).attr('error-message-custome');
            if(american_express || visa_card || discover_card  || master_card){
                // $(".card-number").html("");
                $( this).removeClass("is-danger" );
                $( this).parent().find('.icon').hide();
                $(this).parent().parent('.column').find('.vee-validate-error').html('');
            }else{
                // $("#card-number").focus();
                // $(".card-number").html("The Card field is invalid");
                // alert(12);
                $( this).addClass("is-danger" );
                $( this).parent().find('.icon').show();
                $(this).parent().parent('.column').find('.vee-validate-error').html(input_error_message);

            }



        });

        $("#email_valid").on('input', function() {
            var email = $(this).val();
            var cleaned = email.replace(/\s/g, '');
            if (email !== cleaned) {
                $(this).val(cleaned);
            }
        });

        $( "#email_valid" ).keyup(function(e) {
            var card_number_email = $(this).val();
            var ValidateEmail_var =  ValidateEmail(card_number_email);
            var input_error_message = $( this).attr('error-message-custome');
            if(ValidateEmail_var){
                $(".email_valid").html("");
                $( this).removeClass("is-danger" );
                $( this).parent().find('.icon').hide();
                $(this).parent().parent('.column').find('.vee-validate-error').html('');

            }else{
                // $("#email_valid").focus();
                /// $(".email_valid").html("The Email field must be a valid email");

                $( this).addClass("is-danger" );
                $( this).parent().find('.icon').show();
                $(this).parent().parent('.column').find('.vee-validate-error').html('The Email field must be a valid email');

            }



        });

        $(".please_wait").hide();
    });

    window.sendPostRequest = function(frm)  {
        //  alert(12);
//	 console.log(JSON.stringify(frm));
        var submit_flag = 0;

        if($('#hidden_donation_amount').val() < 5 ){
            $("#select_amount").show();
            $("#all_error_class").show();
            $(".donation-custom-transaction").show();
            $("#all_error_display").hide();
        }


        $( ".input-select" ).each(function(index, obj){



            //alert(12);
            var input_error_message = $( this).attr('error-message-custome');
            var input_on_blur_effect_flag = $( this).attr('on-blur-effect-flag');
            var input_on_blur_effect_flag_disabled = $( this).attr('on-blur-effect-flag-disabled');
            var input_val = $( this).val();
            input_val = $.trim(input_val);

            if(input_on_blur_effect_flag_disabled != 1){
                if(input_val == ''){
                    $( this).addClass("is-danger" );
                    $( this).parent().addClass("is-danger" );

                    $(this).next().html(input_error_message);
                    submit_flag = 1;
                }else{
                    if(input_on_blur_effect_flag != 1){
                        $( this).removeClass("is-danger" );
                        $( this).parent().removeClass("is-danger" );

                        $(this).next().html('');
                    }
                }


            }

            if ($('#billing-toggle').is(':checked')) {
                var input_on_blur_effect_flag_disabled_billing = $( this).attr('on-blur-effect-flag-disabled-billing');
                if(input_on_blur_effect_flag_disabled_billing != 1){
                    if(input_val == ''){
                        $( this).parent().addClass("is-danger" );
                        $( this).addClass("is-danger" );

                        $(this).next().html(input_error_message);
                        submit_flag = 1;
                    }else{
                        if(input_on_blur_effect_flag != 1){
                            $( this).parent().removeClass("is-danger" );
                            $( this).removeClass("is-danger" );

                            $(this).next().html('');
                        }
                    }
                }
            }



        });


        $('.cmxform input' ).each(function(index, obj){

            var input_error_message = $( this).attr('error-message-custome');
            var input_on_blur_effect_flag = $( this).attr('on-blur-effect-flag');
            var input_on_blur_effect_flag_disabled = $( this).attr('on-blur-effect-flag-disabled');
            var input_val = $( this).val();
            input_val = $.trim(input_val);


            if(input_on_blur_effect_flag_disabled != 1){
                if(input_val == ''){
                    //alert(input_error_message);
                    $( this).addClass("is-danger" );
                    //  $( this).parent().find('.icon').show();
                    $( this).next().show();
                    $(this).parent().parent('.column').find('.vee-validate-error').html(input_error_message);
                    submit_flag = 1;
                }else{
                    if(input_on_blur_effect_flag != 1){
                        //alert(input_error_message);
                        $( this).removeClass("is-danger" );
                        $( this).next().hide();
                        $(this).parent().parent('.column').find('.vee-validate-error').html('');
                    }
                }


            }

            if ($('#billing-toggle').is(':checked')) {
                var input_on_blur_effect_flag_disabled_billing = $( this).attr('on-blur-effect-flag-disabled-billing');
                if(input_on_blur_effect_flag_disabled_billing != 1){
                    if(input_val == ''){
                        $( this).addClass("is-danger" );
                        //$( this).parent().find('.icon').show();
                        $( this).next().show();
                        $(this).parent().parent('.column').find('.vee-validate-error').html(input_error_message);
                        submit_flag = 1;
                    }else{
                        if(input_on_blur_effect_flag != 1){
                            //alert(12);
                            $( this).removeClass("is-danger" );
                            $( this).next().hide();
                            $(this).parent().parent('.column').find('.vee-validate-error').html('');
                        }
                    }
                }
            }

        });

        if(	submit_flag ){
            if($('#hidden_donation_amount').val() < 5 ){
                $("#select_amount").show();
                $("#all_error_class").show();
                $(".donation-custom-transaction").show();
                $("#all_error_display").hide();
            }else{
                $("#select_amount").hide();
                $("#all_error_class").show();
                $(".donation-custom-transaction").hide();
                $("#all_error_display").show();
            }
            return false;
        }

//var regCVV = /^[0-9]{3,3}$/;
        var regCVV = /^[0-9]+$/;
        var cvv = $("#cvv").val();
        if (!regCVV.test(cvv)) {

            //  $("#cvv").focus();
            //	 $(".cvv").html("CVV is Invalid");

            if($('#hidden_donation_amount').val() < 5 ){
                $("#select_amount").show();
                $("#all_error_class").show();
                $(".donation-custom-transaction").show();
                $("#all_error_display").hide();
            }else{
                $("#select_amount").hide();
                $("#all_error_class").show();
                $(".donation-custom-transaction").hide();
                $("#all_error_display").show();
            }
            return false;
        }
        else{
            $(".cvv").html("");
        }

        var card_number = $("#card-number").val();
        var american_express =  cardnumber_american_express(card_number);
        var visa_card =  cardnumber_visa_card(card_number);
//	var dinner_card =  cardnumber_dinner_card(card_number);
        var discover_card =  cardnumber_discover_card(card_number);
        //var jcb_card =  cardnumber_jcb_card(card_number);
        var master_card =  cardnumber_master_card(card_number);

        if(american_express || visa_card || discover_card  || master_card){
            $(".card-number").html("");
        }else{
            // $("#card-number").focus();
            $(".card-number").html("The Card field is invalid");
            if($('#hidden_donation_amount').val() < 5 ){
                $("#select_amount").show();
                $("#all_error_class").show();
                $(".donation-custom-transaction").show();
                $("#all_error_display").hide();
            }else{
                $("#select_amount").hide();
                $(".donation-custom-transaction").hide();
                $("#all_error_class").show();
                $("#all_error_display").show();
            }
            return false;

        }


        var emailField = $("#email_valid");
        var card_number_email = emailField.val().replace(/\s/g, '');
        emailField.val(card_number_email);
        var ValidateEmail_var =  ValidateEmail(card_number_email);

        if(ValidateEmail_var){
            $(".email_valid").html("");
        }else{
            // $("#email_valid").focus();
            $(".email_valid").html("The Email field must be a valid email");
            if($('#hidden_donation_amount').val() < 5 ){
                $("#select_amount").show();
                $("#all_error_class").show();
                $(".donation-custom-transaction").show();
                $("#all_error_display").hide();
            }else{
                $("#select_amount").hide();
                $(".donation-custom-transaction").hide();
                $("#all_error_class").show();
                $("#all_error_display").show();
            }
            return false;

        }

        if ($('#billing-toggle').is(':checked')) {
            $(".vee-validate-error").html('');
            var flagbilling_address = 0;
            var error_class = '';
            $( ".billing_address_field" ).each(function( index ) {
                //	console.log( index + ": " + $( this ).value() );

                var billing_address_values = $( this ).val();
                var billing_address_values_required_class = $( this ).attr('v-validate');
                error_class = $( this ).attr('data-vv-as');
                $("."+error_class+"_class").html("");
                //alert(billing_address_values);
                //alert(billing_address_values_required_class);
                if(billing_address_values == '' && billing_address_values_required_class == "'required'"){
                    //alert(1);data-vv-as
                    //alert(billing_address_values);
                    //$(this).closest(".vee-validate-error").html("This is required field!");
                    $("."+error_class+"_class").html("This is required field!");
                    flagbilling_address = 1;
                }

            });

            if(flagbilling_address){
                if($('#hidden_donation_amount').val() < 5 ){
                    $("#select_amount").show();
                    $("#all_error_class").show();
                    $(".donation-custom-transaction").show();
                    $("#all_error_display").hide();
                }else{
                    $("#select_amount").hide();
                    $(".donation-custom-transaction").hide();
                    $("#all_error_class").show();
                    $("#all_error_display").show();
                }
                return false;
            }

        }



//return false;
        // console.log(JSON.parse($(frm).serialize()));
//	 console.log(JSON.stringify($(frm).serializeArray()));


        var data_val = $(frm).serializeArray();


        var formdata = $(frm).serializeArray();
        var data_value = {};
        var card_number = "";
        var card_ccv = "";
        var card_month = "";
        var card_year = "";
        var person_name_first = "";
        var person_name_last = "";
        var person_address_street = "";
        var person_address_street_2 = "";
        var person_address_city = "";
        var person_address_state = "";
        var person_address_zipcode = "";
        var person_email = "";
        var person_phone = "";
        var billing_address_street = "";
        var billing_address_street_2 = "";
        var billing_address_city = "";
        var billing_address_state = "";
        var billing_address_zipcode = "";
        var donation_amount_hidden = "";
        var mb_tracking_code = "";
        $(formdata ).each(function(index, obj){
            // console.log(obj.name);
            if("card[number]" == obj.name ){
                card_number = obj.value;
            }
            if("card[ccv]" == obj.name ){
                card_ccv = obj.value;
            }

            if("card[month]" == obj.name ){
                card_month = obj.value;
            }

            if("card[year]" == obj.name ){
                card_year = obj.value;
            }

            if("person[name][first]" == obj.name ){
                person_name_first = obj.value;
            }

            if("person[name][last]" == obj.name ){
                person_name_last = obj.value;
            }
            if("person[address][street]" == obj.name ){
                person_address_street = obj.value;
            }

            if("person[address][street_2]" == obj.name ){
                person_address_street_2 = obj.value;
            }

            if("person[address][city]" == obj.name ){
                person_address_city = obj.value;
            }

            if("person[address][state]" == obj.name ){
                person_address_state = obj.value;
            }

            if("person[address][zipcode]" == obj.name ){
                person_address_zipcode = obj.value;
            }

            if("person[email]" == obj.name ){
                person_email = obj.value;
            }

            if("person[phone]" == obj.name ){
                person_phone = obj.value;
            }

            if("billing_address[street]" == obj.name ){
                billing_address_street = obj.value;
            }

            if("billing_address[street_2]" == obj.name ){
                billing_address_street_2 = obj.value;
            }

            if("billing_address[city]" == obj.name ){
                billing_address_city = obj.value;
            }

            if("billing_address[state]" == obj.name ){
                billing_address_state = obj.value;
            }

            if("billing_address[zipcode]" == obj.name ){
                billing_address_zipcode = obj.value;
            }

            if("donation_amount_hidden" == obj.name ){
                donation_amount_hidden = obj.value;
            }

            if("mb_tracking_code" == obj.name ){
                mb_tracking_code = obj.value;
            }
            //  data_value[obj.name] = obj.value;
        });
        //console.log(data_value);




        var postData = $.extend({
            card: {
                number: card_number,
                ccv: card_ccv,
                month: card_month,
                year: card_year
            },
            person: {
                email: person_email,
                phone: person_phone,
                name: {
                    first: person_name_first,
                    last: person_name_last
                },
                address: {
                    street: person_address_street,
                    street_2: person_address_street_2,
                    city: person_address_city,
                    state: person_address_state,
                    zipcode: person_address_zipcode
                },
            },
            billing_address: {
                isDifferentFromPersonalAddress: false,
                street: billing_address_street,
                street_2: billing_address_street_2,
                city: billing_address_city,
                state: billing_address_state,
                zipcode: billing_address_zipcode
            }
        },{
            transaction_is_recurring: $('#monthly-donation-toggle').is(':checked'),
            transaction_amount: donation_amount_hidden,
            mb_transaction_code: mb_tracking_code,
            action: 'donate_authorizenet',
            mbTrackingCode: $('#mb_tracking_code').val(),
            is_mobile_attached: $('#is-mobile-attached').is(':checked'),
            isMonthlyDonation: $('#monthly-donation-toggle').is(':checked'),
        });


        //console.log(postData);
        //return false;


        //window.location.href = '/thanks-for-your-donation';
        //console.log($.extend(frm));
        //alert(12);

        /*  var postData = $.extend(this.formFields, {
              transaction_is_recurring: this.isMonthlyDonation,
              transaction_amount: this.selectedDonationAmount,
              mb_transaction_code: this.mbTransactionCodeProp
          });*/

        $("#select_amount").hide();
        $("#all_error_class").hide();
        $(".donation-custom-transaction").hide();
        $("#all_error_display").hide();

        $(".button-donate-submit").hide();

        $(".please_wait").show();

        //	return false;
        var  formPostUrl = $("#form_url_submit").val();
//alert(formPostUrl);
        $.post(formPostUrl, postData)
            .then(function(resp) {
                //	console.log(resp);
                //	return false;
                ///	alert(12);

                if (resp.success) {

                    localStorage.setItem('donationResponseData', JSON.stringify(resp));
                    //   this.resetForm();
                    window.location.href = '/thanks-for-your-donation';
                } else {
                    // this.formIsSubmitting = false;

                    $(".button-donate-submit").show();
                    $(".please_wait").hide();
                    showResponseModal(resp);
                }
            }.bind(this))
            .then(function() {
                //   this.errors.clear();
            }.bind(this));


        return false;
    }


     window.hideResponseModal = function() {
        // this.responseModal.active = false;
        //  this.responseModal.message = null;
        //$(".modal-donate-response").hide(); //is-active




        $( ".modal-donate-response").removeClass("is-active" );


        $(".content-data_value").html("");
    }

    window.showResponseModal=function (response) {
        // this.responseModal.message = response.message;
        //$(".modal-donate-response").show();
        $( ".modal-donate-response").addClass("is-active" );
        $(".content-data_value").html(response.message);

        //this.responseModal.active = true;
    }

     window.setSelectedDonationAmount=function (floatValue) {
        this.selectedDonationAmount = floatValue;
        this.customDonationAmount = null;
    }


    window.ValidateEmail=function(inputText)
    {
        inputText = (inputText || '').replace(/\s/g, '');
//var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
        if (mailformat.test(inputText)) {

//document.form1.text1.focus();
            return true;
        }
        else
        {
//alert("You have entered an invalid email address!");
//document.form1.text1.focus();
            return false;
        }
    }

    window.cardnumber_american_express=function (inputtxt)
    {


        var cardno = /^(?:3[47][0-9]{13})$/;
        if (cardno.test(inputtxt)) {

            return true;
        }
        else
        {
            //    alert("Not a valid Amercican Express credit card number!");
            return false;
        }
    }


    window.cardnumber_visa_card=function (inputtxt)
    {
        var cardno = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
        if (cardno.test(inputtxt)) {

            return true;
        }
        else
        {
            //  alert("Not a valid Visa credit card number!");
            return false;
        }
    }

    window.cardnumber_dinner_card=function (inputtxt)
    {
        var cardno = /^(?:3(?:0[0-5]|[68][0-9])[0-9]{11})$/;
        if (cardno.test(inputtxt)) {

            return true;
        }
        else
        {
            //   alert("Not a valid Dinners Club card number!");
            return false;
        }
    }

    window.cardnumber_discover_card=function (inputtxt)
    {
        var cardno = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
        if (cardno.test(inputtxt)) {

            return true;
        }
        else
        {
            //   alert("Not a valid Discover card number!");
            return false;
        }
    }

  window.cardnumber_jcb_card=function (inputtxt)
    {
        var cardno = /^(?:(?:2131|1800|35\d{3})\d{11})$/;
        if (cardno.test(inputtxt)) {

            return true;
        }
        else
        {
            //    alert("Not a valid JCB card number!");
            return false;
        }
    }

    window.cardnumber_master_card=function (inputtxt)
    {
        var cardno = /^(?:5[1-5][0-9]{14})$/;
        if (cardno.test(inputtxt)) {

            return true;
        }
        else
        {
            //   alert("Not a valid Mastercard number!");
            return false;
        }
    }


    window.getYearsList=function (){
        //alert("test");
        var year = new Date().getFullYear();
        var years =[];

        var string_opt = '<option value="">Year *</option>';
        for(var i = 0; i<20;i++){
            //$()
            string_opt = string_opt +  '<option value="'+(year+i)+'">'+(year+i)+' </option>';
            //years.push(year+ i);
        }
        $('#year_select_twig').html(string_opt);
        //return years;
    }



})(jQuery);
