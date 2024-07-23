$(document).ready(function () {
    $('#formReg1').validate({
        rules: {
            email: {
                required: true,
                validEmailid: true,
            },
            mobile: {
                required: true,
                indianMobileNumber: true
            }
        },
    })
    $('#formReg2').validate({
        rules: {
            firstName: {
                required: true,
            },
            lastName: {
                required: true,
            },
            address: {
                required: true,
            },
            gender: {
                required: true,
            },
            dob: {
                required: true,
            },
            father: {
                required: true,
            },
            profession: {
                required: true,
            },
            aadhar: {
                required: true,
            },
            religion: {
                required: true,
            },
            caste: {
                required: true,
            },
            bloodGroup: {
                required: true,
            }
        },
    })
    $('#form3').validate({
        rules: {
            district:{
                required:true,
            },
            assembly:{
                required:true,
            },
            lgs:{
                required:true,
            },
            ward:{
                required:true,
            },
            reference:{
                required:true,
            }

        }
    })








    //Custom validator for input is a Mobile Phone Number
    $.validator.addMethod("indianMobileNumber", function (value, element) {
        return this.optional(element) || /^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/.test(value)
    }, "Enter a valid indian mobile number without country code");
    //Custom validator for input is an email address
    $.validator.addMethod("validEmailid", function (value, element) {
        return this.optional(element) || /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(value)
    }, "Enter email address like yourname@example.com");
    //Custom validator for AADHAR number is valid or invalid
    $.validator.addMethod("validAadhar", function (value, element) {
        return this.optional(element) || checkAadharNumber(value)
    }, "AADHAR Number is invalid")
    //Custom validator for AADHAR number is alredy regisetered in the database
    $.validator.addMethod("duplicateAadhar", function (value, element) {
        return this.optional(element) || checkAadharDuplication(value)
    }, "This AADHAR number already registered")
    $.validator.addMethod("strongPassword", function (value, element) {
        return this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/.test(value)
    }, "Password contains\n1. At least one digit, At least one lowercase character, At least one uppercase character , At least one special character, At least 8 characters in length, but no more than 16.")

    function checkAadharNumber(value) {
        let x = false;
        $.ajax({
            async: false,
            url: '/validate-aadhar',
            data: {
                aadhar: value
            },
            method: 'POST',
            success: (response) => {
                if (response.status)
                    x = true
            }
        })
        return x;
    }
    function checkAadharDuplication(value) {
        let x = false;
        $.ajax({
            async: false,
            url: '/aadhar-duplicate',
            data: {
                aadhar: value
            },
            method: 'POST',
            success: (response) => {
                if (!response.status)
                    x = true
            }
        })
        return x;
    }
})