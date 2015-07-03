$(document).ready(function(){

    function showUsers(){
        var role = $("#selRole option:selected").val();

        var course = $("#selCourse option:selected").val();


        //if (role == 0) {
        //    alert("Change a role");
        //    return;
        //}

        $.ajax({
            type: "POST",
            url: "http://fwork.loc/ajax",
            data: { role: role, course: course },
            dataType: "json",
            cache: false,
            success: function(data) {

                //console.log(data);

                var tab = $('#tableUsers');

                var tabRows = tab.children();

                tabRows.remove();

                var TableTitle = ["Id", "Name", "Email", "Role", "Course", "Edit", "Delete"];

                tab.append(
                    $('<thead/>'),
                    $('<tfoot/>'),
                    $('<tbody/>')
                );

                var TitleRaw = $('<tr/>');

                $.each(TableTitle, function( index, value ) {
                    TitleRaw.append(
                        $('<th/>',{
                            text:value
                        })
                    );
                });
                $("thead").append(TitleRaw);

                for (var i = 0; i<data.length; i++) {

                    var BodyRaw = $('<tr/>');
                    BodyRaw.append(
                        $('<td/>',{
                            text:data[i]['id']
                        }),
                        $('<td/>',{
                            text:data[i]['name']
                        }),
                        $('<td/>',{
                            text:data[i].email
                        }),
                        $('<td/>',{
                            text:data[i].role
                        }),
                        $('<td/>',{
                            text:data[i].course
                        }),
                        $('<td/>').append(
                            $('<a/>',{
                                'href':'http://fwork.loc/edit/' + data[i]['id'] + '/update',
                                text:'Edit'
                            })),
                        $('<td/>').append(
                            $('<a/>',{
                                'href':'http://fwork.loc/del/' + data[i]['id'],
                                text:'Delete'
                            }))
                    );

                    $("tbody").append(BodyRaw);
                }
            }
        });
    }


    //$('button').on('click', function(){
    //    showUsers();
    //});

    $("#selRole").on('change',function(){
        showUsers();
    });

    $("#selCourse").on('change',function(){
        showUsers();
    });

});