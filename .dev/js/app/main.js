"use strict";

/*
 * 
 */

$(function () {
    var
            $input = $('.calculator-input'),
            $result = $('.calculator-result'),
            calculator = require('./calculator'),
            $resultWrap = $result.parent();
    /*
     * 
     */
    var renderResult = function (txt, clss) {
        $resultWrap.removeClass('alert-success alert-danger');
        if (clss) {
            $resultWrap.addClass('alert-' + clss);
        }
        $result.html(txt);
    }
    /*
     * 
     */
    $input.on('focus blur', function () {
        renderResult('');
    });


    $('.calculator-calc').on('click', function () {
        var equation = $input.val();

        calculator.calc(equation).done(function (result) {
            renderResult($input.val() + '= ' + result.value, 'success');
        }).fail(function () {
            renderResult('Please enter an equation', 'danger');
        });
        return false;
    });
});