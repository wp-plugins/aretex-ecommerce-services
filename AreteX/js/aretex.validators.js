/**
 * Custom validators for letters and numbers only.  Uppercase/lowercase letters and numbers (0-9).
 */
jQuery.validator.addMethod("lettersAndNumbersOnly", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
}, "Please enter letters and numbers only.");


jQuery.validator.addMethod("datetime", function (value, element) {
   
    return this.optional(element) ||  (/\d{4}-\d{2}-\d{2}/.test(value) && value.length == 10)
    || (/\d{4}-\d{2}-\d{2} \d{2}:\d{2}/.test(value) && value.length == 16 )
    || (/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/.test(value) && value.length == 19 );
   
}, "Valid date/time please");
