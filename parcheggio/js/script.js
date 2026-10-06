$(document).ready(function () {
    var oggi = new Date(); 0
    const days =
        ['Domenica', 'Lunedì', 'Martedì', 'Mercoledì',
            'Giovedì', 'Venerdì', 'Sabato'];
    $("h2#oggi").html(days[oggi.getDay()] + "&emsp;" + oggi.getDate() + "/" + (oggi.getMonth() + 1) + "/" + oggi.getFullYear());
    read_data(oggi.getDate());
    //read_data("Lunedì");
});

function read_data(curr_giorno) {
    $.ajax({
        url: 'js/vie.json',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            //console.log("%j", response);
            $('p#scheda').html(JSON.stringify(response));
            var content = "<table id='scheda'>";
            content += "<tr>";
            content += "<th>ID</th>";
            content += "<th>VIA</th>";
            content += "<th>DA</th>";
            content += "<th>A</th>";
            content += "</tr>";
            for (current in response) {
                console.log(response[current].giorno);
                console.log(curr_giorno);
                if (response[current].giorno==curr_giorno) {
                    for (let vie of Object.values(response[current].vie)) {
                        content+="<tr>";
                        content+="<td>"+vie.id+"</td>";
                        content+="<td>"+vie.via+"</td>";
                        content+="<td>"+vie.da+"</td>";
                        content+="<td>"+vie.a+"</td>";
                        content+="</tr>";
                    }
                }
            }
            content += "</table>";
            $('#scheda').append(content);
        }
    });
};

