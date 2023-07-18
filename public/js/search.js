$(document).ready(function() {
    $("#searchButton").click(function() {
        let data = {
            "name" : $("#inputHouseName").val(),
            "bedrooms" : $("#inputBedrooms").val(),
            "bathrooms" : $("#inputBathrooms").val(),
            "garages" : $("#inputGarages").val(),
            "storeys" : $("#inputStoreys").val(),
            "costMin" : $("#inputCostMin").val(),
            "costMax" : $("#inputCostMax").val()
        }
        $.ajax({
            url: "/house/search",
            type: "POST",
            data: data,
            success: function(response) {
                $("#overlay").show();
                $('#cardContainer').empty();
                if (response) {
                    searchCard(JSON.parse(response));
                } else {
                    $("#cardContainer").append('<h1 id="notFound">По вашему запросу ничего не найдено</h1>');
                    $("#overlay").hide()
                }
            }
        });
    });
});

function searchCard(data) {
    $.each(data, function(index,house) {
        let container = $('<div class="col-4"></div>'),
            card = $('<div class="card mt-5"></div>'),
            image = $('<img class="card-img-top" src="/img/house.jpg" alt="Card image cap">'),
            cardBody = $('<div class="card-body"></div>'),
            title = $('<h5 class="card-title">' + house.name + '</h5>'),
            details = $('<p class="card-text">Кроватей: ' + house.bedrooms + ' шт <br> Ванных комнат: ' + house.bathrooms + ' шт <br> Этажность: ' + house.storeys + ' шт <br> Гаражей: ' + house.garages + ' шт</p>'),
            price = $('<p class="card-text">Цена: ' + house.price + ' у.е.</p>');
        cardBody.append(title);
        cardBody.append(details);
        cardBody.append(price);
        card.append(image);
        card.append(cardBody);
        container.append(card);
        $("#cardContainer").append(container);
    });
    $("#overlay").hide()
}