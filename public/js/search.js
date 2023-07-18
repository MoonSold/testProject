$(document).ready(function() {
    $("#searchButton").click(function() {
        let data = {
            "name":$("#inputHouseName").val(),
            "bedrooms":$("#inputBedrooms").val(),
            "bathrooms":$("#inputBathrooms").val(),
            "garages":$("#inputGarages").val(),
            "storeys":$("#inputStoreys").val(),
            "costMin":$("#inputCostMin").val(),
            "costMax":$("#inputCostMax").val()
        }
        $.ajax({
            url: "/house/search",
            type: "POST",
            data: data,
            success: function(response) {
                searchCard(JSON.parse(response));
            }
        });
    });
});
