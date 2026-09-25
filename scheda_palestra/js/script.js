$(document).ready(function () {
    var oggi = new Date(); 0
    const days =
        ['Domenica', 'Lunedì', 'Martedì', 'Mercoledì',
            'Giovedì', 'Venerdì', 'Sabato'];
    $("h2#oggi").html(days[oggi.getDay()] + "&emsp;" + oggi.getDate() + "/" + (oggi.getMonth() + 1) + "/" + oggi.getFullYear());
    read_data(days[oggi.getDay()]);
    //read_data("Lunedì");
});

function read_data(curr_giorno) {
    $.ajax({
        url: 'js/esercizi.json',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("%j", response);
            $('p#scheda').html(JSON.stringify(response));
            var content = "<table id='scheda'>";
            content += "<tr>";
            content += "<th>ID</th>";
            content += "<th>ESERCIZIO</th>";
            content += "<th>SERIE</th>";
            content += "<th>RIPETIZIONI</th>";
            content += "<th>FATTO</th>";
            content += "</tr>";
            for (current in response) {
                console.log(response[current]);
                if (response[current].giorno==curr_giorno) {
                    for (let esercizi of Object.values(response[current].esercizi)) {
                        content+="<tr>";
                        content+="<td>"+esercizi.id+"</td>";
                        content+="<td>"+esercizi.esercizio+"</td>";
                        content+="<td>"+esercizi.serie+"</td>";
                        content+="<td>"+esercizi.ripetizioni+"</td>";
                        content+="<td><input class='checkbox' type='checkbox'></td>";
                        content+="</tr>";
                    }
                }
            }
            content += "</table>";
            $('#scheda').append(content);
        }
    });
};

