var d = $.Deferred(), request;


module.exports = {
    /*
     * 
     */
    calc: function (equation) {
        if (request) {
            request.abort();
        }
        request = $.ajax({
            cache: false,
            data: {equation: equation},
            method: 'GET',
            url: 'calculator.php',
            dataType: 'json'
        }).done(function (response) {
            d.resolve(response);
        }).fail(function (response) {
            d.reject({
                success: false,
                data: response});
        });
        return d.promise();
    }
}

