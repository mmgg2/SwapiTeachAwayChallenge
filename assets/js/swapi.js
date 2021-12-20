$(document).ready(function() {

    /*=============================
            Vehicles Ajax
    ============================= */
    $('#vehicleForm').submit(function(e) {
        $("#vehicle").find("tr:not(:first)").remove();
        $('#vehicleGrid').hide();
        $('#starshipGrid').hide();
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'src/Controller/SwapiController.php',
            data: $(this).serialize(),
            success: function(response)
            {
                let vehicleData = JSON.parse(response);

                console.log(vehicleData);

                if(vehicleData.additionalData.error){
                    alert(vehicleData.additionalData.msj);
                }
                else{
                    let trHTML = '';
                    trHTML += '<tr><td>' + vehicleData.additionalData.id +'</td>';
                    trHTML += '<td>' + vehicleData.name +'</td>';
                    trHTML +='<td>' + vehicleData.model +'</td>';
                    trHTML +='<td>' + vehicleData.manufacturer +'</td>';
                    trHTML +='<td>' + vehicleData.cost_in_credits +'</td>';
                    trHTML +='<td>' + vehicleData.length +'</td>';
                    trHTML +='<td>' + vehicleData.max_atmosphering_speed +'</td>';
                    trHTML +='<td>' + vehicleData.crew +'</td>';
                    trHTML +='<td>' + vehicleData.passengers +'</td>';
                    trHTML +='<td>' + vehicleData.cargo_capacity +'</td>';
                    trHTML +='<td>' + vehicleData.consumables +'</td>';
                    trHTML +='<td>' + vehicleData.vehicle_class+'</td></tr>';

                    $('#vehicle').append(trHTML);
                    $('#id').val(vehicleData.additionalData.id);
                    $('span#total').html('Total Units: '+ vehicleData.additionalData.total);
                    $('span#title').html('Inventory - Vehicle: '+ vehicleData.additionalData.id);
                    $('#vehicleGrid').show();
                }
            }
       });
     });

   
    $("#btnSetTotalVehicle").click(function() {
        $("#myform input[type=text]").val('');
        $("#myform input[type=number]").val('');
        $("#myform input[name=action]").val('2');
        $("#myform").toggle();
    });


    $("#btnIncrementVehicle").click(function() {
        $("#myform input[type=text]").val('');
        $("#myform input[type=number]").val('');
        $("#myform input[name=action]").val('3');
        $("#myform").toggle();
    });


    $("#btnDecrementVehicle").click(function() {
        $("#myform input[type=text]").val('');
        $("#myform input[type=number]").val('');
        $("#myform input[name=action]").val('4');
        $("#myform").toggle();
    });

     /*=============================
            Starships Ajax
    ============================= */
    $('#starshipForm').submit(function(e) {
        $("#starship").find("tr:not(:first)").remove();
        $('#vehicleGrid').hide();
        $('#starshipGrid').hide();
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'src/Controller/SwapiController.php',
            data: $(this).serialize(),
            success: function(response)
            {
                let startshipData = JSON.parse(response);
    
                console.log(startshipData);
    
                if(startshipData.additionalData.error){
                    alert(startshipData.additionalData.msj);
                }
                else{
                    let trHTML = '';
                    trHTML += '<tr><td>' + startshipData.additionalData.id +'</td>';
                    trHTML += '<td>' + startshipData.name +'</td>';
                    trHTML +='<td>' + startshipData.model +'</td>';
                    trHTML +='<td>' + startshipData.manufacturer +'</td>';
                    trHTML +='<td>' + startshipData.cost_in_credits +'</td>';
                    trHTML +='<td>' + startshipData.length +'</td>';
                    trHTML +='<td>' + startshipData.max_atmosphering_speed +'</td>';
                    trHTML +='<td>' + startshipData.crew +'</td>';
                    trHTML +='<td>' + startshipData.passengers +'</td>';
                    trHTML +='<td>' + startshipData.cargo_capacity +'</td>';
                    trHTML +='<td>' + startshipData.consumables +'</td>';
                    trHTML +='<td>' + startshipData.hyperdrive_rating +'</td>';
                    trHTML +='<td>' + startshipData.MGLT +'</td>';
                    trHTML +='<td>' + startshipData.starship_class+'</td></tr>';
    
                    $('#starship').append(trHTML);
                    $('#id').val(startshipData.additionalData.id);
                    $('span#total').html('Total: '+ startshipData.additionalData.total);
                    $('span#title').html('Inventory - Starship: '+ startshipData.additionalData.id);
                    $('#starshipGrid').show();
                }
            }
       });
     });

    $("#btnSetTotalStarship").click(function() {
        $("#myform input[type=text]").val('');
        $("#myform input[type=number]").val('');
        $("#myform input[name=action]").val('6');
        $("#myform").toggle();
    });

    $("#btnIncrementStarship").click(function() {
        $("#myform input[type=text]").val('');
        $("#myform input[type=number]").val('');
        $("#myform input[name=action]").val('7');
        $("#myform").toggle();
    });

    $("#btnDecrementStarship").click(function() {
        $("#myform input[type=text]").val('');
        $("#myform input[type=number]").val('');
        $("#myform input[name=action]").val('8');
        $("#myform").toggle();
    });

    /*=============================
            Popup Total units
    ============================= */
    $('#dialogForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'src/Controller/SwapiController.php',
            data: $(this).serialize(),
            success: function(response)
            {
                let result = JSON.parse(response);
                alert(result.additionalData.msj);
                $('span#total').html('Total: '+ result.additionalData.total);
                $("#myform").hide(400);
            }
       });
     });

     $("#btnCancel").click(function() {
        $("#myform").hide(400);
    });
});