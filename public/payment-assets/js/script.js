$(function () {

    var owner = $('#owner');
    var cardNumber = $('#cardNumber');
    var cardNumberField = $('#card-number-field');
    var CVV = $("#cvv");
    var mastercard = $("#mastercard");
    var confirmButton = $('#confirm-purchase');
    var visa = $("#visa");
    var amex = $("#amex");
    var stripe_id = $("#stripe_id");
    var package = $("#package");
    var mm = $("#mm");
    var yy = $("#yy");

    // Use the payform library to format and validate
    // the payment fields.

    cardNumber.payform('formatCardNumber');
    CVV.payform('formatCardCVC');


    cardNumber.keyup(function () {

        amex.removeClass('transparent');
        visa.removeClass('transparent');
        mastercard.removeClass('transparent');

        if ($.payform.validateCardNumber(cardNumber.val()) == false) {
            cardNumberField.addClass('has-error');
        } else {
            cardNumberField.removeClass('has-error');
            cardNumberField.addClass('has-success');
        }

        if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
            mastercard.addClass('transparent');
            amex.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'amex') {
            mastercard.addClass('transparent');
            visa.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
            amex.addClass('transparent');
            visa.addClass('transparent');
        }
    });

    confirmButton.click(function (e) {

        e.preventDefault();

        // var isCardValid = $.payform.validateCardNumber(cardNumber.val());
        // var isCvvValid = $.payform.validateCardCVC(CVV.val());

        var isCvvValid = $.payform.validateCardCVC(CVV.val());
        if(isCvvValid){
            // Everything is correct. Add your form submission code here.
            $('#confirm-purchase').prop('disabled', true);
            $("#confirm-purchase").html("Please Wait...");
            Stripe.card.createToken({
                number: cardNumber.val(),
                cvc: CVV.val(),
                exp_month: mm.val(),
                exp_year: yy.val(),
            }, function (status, response) {

                if (response.error) {
                    Swal.fire({
                        title: 'Error!',
                        text: response.error.message,
                        icon: 'error',
                    })
                    $('#confirm-purchase').prop('disabled', false);
                    $("#confirm-purchase").html("Submit");
                } else {
                    console.log(response);
                    var cc_token = response.id;
                    var cardId = response.card.id;
                    var cardBrand = response.card.brand;
                    var cardLast4 = response.card.last4;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/pay-with-stripe",
                        type: "POST",
                        data: {
                            package: package.val(),
                            cardId: cardId,
                            last4 : cardLast4,
                            brand : cardBrand,
                            cc_token : cc_token
                        },
                        success: function (data) {
                            window.location.replace('/admin/dashboard');
                            $('#confirm-purchase').prop('disabled', false);
                            $("#confirm-purchase").html("Submit"); 
                        },
                        error: function(error){
                            Swal.fire({
                                title: 'Error!',
                                text: "There is an error",
                                icon: 'error',
                            })
                            $('#confirm-purchase').prop('disabled', false);
                            $("#confirm-purchase").html("Submit"); 
                        }
                    });
                }
            });
        }
        else{
            Swal.fire({
                title: 'Error!',
                text: "CVV is not valid",
                icon: 'error',
            })
        }


    });
});
