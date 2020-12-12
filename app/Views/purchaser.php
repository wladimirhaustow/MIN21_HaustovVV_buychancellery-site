<?= view('header'); ?>
		
		<main role="main" class="pt-5 mt-5 mx-5 inner cover">
			<div class="form-group">
				<label for="exampleFormControlSelect1">Выберите пользователя</label>
				<select class="form-control bg-dark" id="users" style="color: white;"></select>
			  </div>
		
			<table class="table table-striped table-dark">
			  <thead>
				<tr>
				  <th scope="col">#</th>
				  <th scope="col">Наименование</th>
				  <th scope="col">Количество</th>
				  <th scope="col">ФИО кому</th>
				  <th scope="col">Телефон Кому</th>
				  <th scope="col">Примечание</th>
				</tr>
			  </thead>
			  <tbody id="table">
			  </tbody>
			</table>
		</main>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script>
			start();
			function start()
			{
                $.getJSON('/Request/getRequest', function(json) {
                    for(let dataId in json)
                    {
                        let dataVal = json[dataId];

                        $("#users").append(
                            jQuery('<option/>', {
                                text: dataVal,
                                value: dataId
                            })
                        );
                    }
                    $("#users").change();
                });


                $("#users").change(() => {
                    $(`#table`).empty();

                    let requestId = $("#users").val();

                    function getRequestById(requestId)
                    {

                        $.getJSON('/Request/getRequest/'+requestId, function(json) {
                            let el = json;

                            for(let i=0;i<el.length;i++){
                                $(`#table`).append(
                                    jQuery('<tr/>', {
                                    }).append(
                                        jQuery('<th/>', {
                                            scope: "row",
                                            text: i+1
                                        }),
                                        jQuery('<td/>', {
                                            text: el[i].product
                                        }),
                                        jQuery('<td/>', {
                                            text: el[i].count
                                        }),
                                        jQuery('<td/>', {
                                            text: el[i].FIO
                                        }),
                                        jQuery('<td/>', {
                                            text: el[i].telephone
                                        }),
                                        jQuery('<td/>', {
                                            text: el[i].comment
                                        })
                                    )
                                );
                            }


                        });

                    }

                    getRequestById(requestId);
                });
			}
		</script>
	</body>	
</html>