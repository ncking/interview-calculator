"use strict";

/*
 * 
 */

$(function () {
    var 
    $input = $('.calculator-input'), 
    $result = $('.calculator-result'),
    calculator = require('./calculator');
    /*
     * 
     */
    $('.calculator-calc').on('click', function () {
        $result.html('');
        calculator.calc($input.val()).done(function (result) {
            $result.html(result.value);
        });
        return false;
    });

});





