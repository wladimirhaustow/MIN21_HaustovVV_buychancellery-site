<?= view('header'); ?>
		
		<main role="main" class="pt-5 mt-5 mx-5 inner cover">
			<table class="table table-striped table-dark">
			  <thead>
				<tr>
				  <th scope="col">#</th>
				  <th scope="col">Наименование</th>
				  <th scope="col">Количество</th>
				  <th scope="col">ФИО Кому</th>
				  <th scope="col">Телефон Кому</th>
				  <th scope="col">Примечание</th>
				  <th scope="col">Удалить запись</th>
				</tr>
			  </thead>
			  <tbody id="table">	
				
			  </tbody>
			</table>
			
			<div class="my-4 row">
				<button type="button" class="col btn btn-primary mr-3" id="saveBtn">Сохранить черновик</button>
				<button type="button" class="col btn btn-success" id="sendBtn">Подписать и Отправить</button>
			</div>
		</main>			
		
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script>
			let UserTable = null;
            let names;
            $.getJSON('/Product/getProduct', function(json) {
                names = json;
                start();
            });

            function start(){
                let data = [];

                if(localStorage['data'] !== "" && localStorage['data'] !== undefined)
                {
                    data = JSON.parse(localStorage['data']);
                }

                UserTable = new Tables("table", data);
            }


			function getNameById(id)
            {
                for(let i=0;i<names.length;i++){
                    if(names[i].id === id)
                        return names[i].name;
                }
            }
			
			function getNameIdByText(text)
			{
                for(let i=0;i<names.length;i++){
                    if(names[i].name === text)
                        return names[i].id;
                }

			}

            $("#saveBtn").click(()=>{
                if(UserTable != null && UserTable.tableInfo.length > 0)
                {
                    localStorage['data'] = JSON.stringify(UserTable.tableInfo);
                } else return alert("Сохранять нечего");
            });
		
			$("#sendBtn").click(()=>{

				let resultTable = [];

				UserTable.tableInfo.forEach(x => {
					resultTable.push({
						product: x.name,
                        count: x.count,
                        FIO: x.FIO,
                        telephone: x.phone,
                        comment: x.comment
					});
				});

				console.log(resultTable);

                $.ajax({
                    type: "POST",
                    url: '/Request/send',
                    data: JSON.stringify(resultTable),
                    dataType: 'JSON'
                }).done(obj => {
                    alert("Отправлено!");
                });
			});
		
			//Класс для работы с таблицей админки
			class Tables 
			{
				isFirstwAddNewElInTable = true;
				lastElId = null;
				tableInfo = [];
				
				constructor(tableId, data = null) 
				{
					//Записываем id таблицы (tbody), для дальнейшей работы
					if($(`#${tableId}`).length)
						this.tableId = tableId;
					else return console.error("Передан не верный id таблицы");
					
					//если есть данные сразу их нарисуем в таблице
					if(data !== null)
					{
						this.redrawTable(data);
					}
				}
				
				//Метод перерисовки таблицы
				redrawTable(data)
				{
					//Предпологаем, что переданные данные - являются массивом
					if(Array.isArray(data))
					{
						if(data.length > 0)
						{
							//Идем по массиву данных
							for(let i=0; i<data.length; i++)
							{
								//Берем элемент данных, для удобный работы с ним в дальнейшем
								let el = data[i];
								
								//Предпологаем, что передданный элемент дданных - является объектом, содержащим требуемые для работы поля
								if(typeof el === "object" && "id" in el && "name" in el)
                                {
									this._addElInTable(el);
								
								} else return console.error("Переданный элеменныт данных, не является объектом, или не содежит нужных для работы полей");
								
							}
							
							this.lastElId = data[data.length - 1].id + 1;
							
						} else this.lastElId = 1;
						
						this.addLastElInTable();
						
						this.isFirstwAddNewElInTable = false;
					
					} else return console.error("Переданные данные не являются массивом");
				}
				
				//Приватный метод, предпологается, что будет использован только в пределах класса
				_addElInTable(el)
				{
					this.tableInfo.push({
						id: el.id,
						name: el.name,
						count: el.count,
						FIO: el.FIO,
						phone: el.phone,
						comment: el.comment
					});
					
					$(`#${this.tableId}`).append(
						jQuery('<tr/>', {
							id: "trEl_" + el.id
						}).append(
							jQuery('<th/>', {
								scope: "row",
								text: el.id
							}),
							jQuery('<td/>', {
								id: "elTdName_" + el.id
							}).append(
								jQuery('<label/>', {
									id: "elName_" + el.id,
									text: getNameById(el.name)
								}),
								jQuery('<select/>', {
									class: "form-control",
									id: "inputEditName_" + el.id,
									style: "display: none;",
									value: el.name
								})
							),
							jQuery('<td/>', {
								id: "elTdCount_" + el.id
							}).append(
								jQuery('<label/>', {
									id: "elCount_" + el.id,
									text: el.count
								}),
								jQuery('<input/>', {
									type: "text",
									class: "form-control",
									id: "inputEditCount_" + el.id,
									style: "display: none;",
									value: el.count
								})
							),
                            jQuery('<td/>', {
								id: "elTdFIO_" + el.id
							}).append(
								jQuery('<label/>', {
									id: "elFIO_" + el.id,
									text: el.FIO
								}),
								jQuery('<input/>', {
									type: "text",
									class: "form-control",
									id: "inputEditFIO_" + el.id,
									style: "display: none;",
									value: el.FIO
								})
							),
							jQuery('<td/>', {
								id: "elTdPhone_" + el.id
							}).append(
								jQuery('<label/>', {
									id: "elPhone_" + el.id,
									text: el.phone
								}),
								jQuery('<input/>', {
									type: "text",
									class: "form-control",
									id: "inputEditPhone_" + el.id,
									style: "display: none;",
									value: el.phone
								})
							),
							jQuery('<td/>', {
								id: "elTdComment_" + el.id
							}).append(
								jQuery('<label/>', {
									id: "elComment_" + el.id,
									text: el.comment
								}),
								jQuery('<input/>', {
									type: "text",
									class: "form-control",
									id: "inputEditComment_" + el.id,
									style: "display: none;",
									value: el.comment
								})
							),
							jQuery('<td/>', {
							}).append(
								jQuery('<button/>', {
									type: "button",
									class: "col mx-auto btn btn-danger",
									text: "Удалить",
									id: "deleteEl_" + el.id 
								})
							)
						)
					);

					for(let j=0; j<names.length; j++)
                    {

                        $("#inputEditName_" + el.id).append(
                            jQuery('<option/>', {
                                text: names[j].name,
                                value: names[j].id
                            })
                        );
                    }
					
					$("#elTdName_" + el.id).click(()=>{
						if($("#inputEditName_"+ el.id)[0].style.display == "none")
						{
							let textInputName = $("#elName_" + el.id).text();
						
							$("#inputEditName_" + el.id).val(getNameIdByText(textInputName));
							$("#elName_" + el.id).hide();
							$("#inputEditName_" + el.id).show();
							$("#inputEditName_" + el.id).focus();
						}					
					});
					
					$("#elTdCount_" + el.id).click(()=>{
						let textInputCount = $("#elCount_" + el.id).text();
						
						$("#inputEditCount_" + el.id).val(textInputCount);
						$("#elCount_" + el.id).hide();
						$("#inputEditCount_" + el.id).show();
						$("#inputEditCount_" + el.id).focus();
					});

					$("#elTdFIO_" + el.id).click(()=>{
						let textInputFIO = $("#elFIO_" + el.id).text();

						$("#inputEditFIO_" + el.id).val(textInputFIO);
						$("#elFIO_" + el.id).hide();
						$("#inputEditFIO_" + el.id).show();
						$("#inputEditFIO_" + el.id).focus();
					});
					
					$("#elTdPhone_" + el.id).click(()=>{
						let textInputPhone = $("#elPhone_" + el.id).text();
						
						$("#inputEditPhone_" + el.id).val(textInputPhone);
						$("#elPhone_" + el.id).hide();
						$("#inputEditPhone_" + el.id).show();
						$("#inputEditPhone_" + el.id).focus();
					});
					
					$("#elTdComment_" + el.id).click(()=>{
						let textInputComment = $("#elComment_" + el.id).text();
						
						$("#inputEditComment_" + el.id).val(textInputComment);
						$("#elComment_" + el.id).hide();
						$("#inputEditComment_" + el.id).show();
						$("#inputEditComment_" + el.id).focus();
					});
					
					
					
					let tmpFunctionName = ()=>{
						let newName = $("#inputEditName_" + el.id).val();
						
						$("#elName_" + el.id).text(getNameById(newName));
						$("#elName_" + el.id).show();
						$("#inputEditName_" + el.id).hide();
						let tabeleEl = this.tableInfo.find(x => x.id === el.id);
						let elIndex = this.tableInfo.indexOf(tabeleEl);
						this.tableInfo[elIndex].name = newName;
					};
					$("#inputEditName_" + el.id).focusout(tmpFunctionName);
					$("#inputEditCount_" + el.id).mouseout(tmpFunctionName);
					
					
					let tmpFunctionCount = ()=>{
						let newCount = $("#inputEditCount_" + el.id).val();
						
						if(isNaN(Number(newCount)))
							return alert("Введите число!");
						
						$("#elCount_" + el.id).text(newCount);
						$("#elCount_" + el.id).show();
						$("#inputEditCount_" + el.id).hide();
						let tabeleEl = this.tableInfo.find(x => x.id === el.id);
						let elIndex = this.tableInfo.indexOf(tabeleEl);
						this.tableInfo[elIndex].count = newCount;
					};
					$("#inputEditCount_" + el.id).focusout(tmpFunctionCount);
					$("#inputEditCount_" + el.id).mouseout(tmpFunctionCount);


					let tmpFunctionFIO = ()=>{
						let newFIO = $("#inputEditFIO_" + el.id).val();

						$("#elFIO_" + el.id).text(newFIO);
						$("#elFIO_" + el.id).show();
						$("#inputEditFIO_" + el.id).hide();
						let tabeleEl = this.tableInfo.find(x => x.id === el.id);
						let elIndex = this.tableInfo.indexOf(tabeleEl);
						this.tableInfo[elIndex].FIO = newFIO;
					};
					$("#inputEditFIO_" + el.id).focusout(tmpFunctionFIO);
					$("#inputEditFIO_" + el.id).mouseout(tmpFunctionFIO);
					
					
					let tmpFunctionPhone = ()=>{
						let newPhone = $("#inputEditPhone_" + el.id).val();
						$("#elPhone_" + el.id).text(newPhone);
						$("#elPhone_" + el.id).show();
						$("#inputEditPhone_" + el.id).hide();
						let tabeleEl = this.tableInfo.find(x => x.id === el.id);
						let elIndex = this.tableInfo.indexOf(tabeleEl);
						this.tableInfo[elIndex].phone = newPhone;
					};
					$("#inputEditPhone_" + el.id).focusout(tmpFunctionPhone);
					$("#inputEditPhone_" + el.id).mouseout(tmpFunctionPhone);
					
					
					let tmpFunctionComment = ()=>{
						let newComment = $("#inputEditComment_" + el.id).val();
						$("#elComment_" + el.id).text(newComment);
						$("#elComment_" + el.id).show();
						$("#inputEditComment_" + el.id).hide();
						let tabeleEl = this.tableInfo.find(x => x.id === el.id);
						let elIndex = this.tableInfo.indexOf(tabeleEl);
						this.tableInfo[elIndex].comment = newComment;
					};
					$("#inputEditComment_" + el.id).focusout(tmpFunctionComment);
					$("#inputEditComment_" + el.id).mouseout(tmpFunctionComment);
					
					
					
					
					
					
					
					$("#deleteEl_" + el.id).click(e => {
						$("#trEl_" + el.id).remove();
						
						let tabeleEl = this.tableInfo.find(x => x.id === el.id);
						let elIndex = this.tableInfo.indexOf(tabeleEl);
						this.tableInfo.splice(elIndex, 1);
						console.log(elIndex);
					});
				}
				
				addLastElInTable()
				{						
					if(this.lastElId !== null)
					{
						if(!this.isFirstwAddNewElInTable)
						{							
							this._addElInTable({
								id: this.lastElId,
								name: $("#inputName").val(),
								count: $("#inputCount").val(),
								FIO: $("#inputFIO").val(),
								phone: $("#inputPhone").val(),
								comment: $("#inputComment").val()
							});
							
							$("#trAddEl").remove();
							
							this.lastElId = this.lastElId + 1;
						}
					
						$(`#${this.tableId}`).append(
							jQuery('<tr/>', {
								id: "trAddEl"
							}).append(
								jQuery('<th/>', {
									scope: "row",
									text: this.lastElId
								}),
								jQuery('<td/>', {
								}).append(
									jQuery('<select/>', {
										class: "form-control",
										id: "inputName"
									})
								),
								jQuery('<td/>', {
								}).append(
									jQuery('<input/>', {
										type: "text",
										class: "form-control",
										id: "inputCount"
									})
								),
                                jQuery('<td/>', {
								}).append(
									jQuery('<input/>', {
										type: "text",
										class: "form-control",
										id: "inputFIO"
									})
								),
								jQuery('<td/>', {
								}).append(
									jQuery('<input/>', {
										type: "text",
										class: "form-control",
										id: "inputPhone"
									})
								),
								jQuery('<td/>', {
								}).append(
									jQuery('<input/>', {
										type: "text",
										class: "form-control",
										id: "inputComment"
									})
								),
								jQuery('<td/>', {
								}).append(
									jQuery('<button/>', {
										type: "button",
										class: "col mx-auto btn btn-success",
										text: "Добавить",
										id: "addNewElInTable"
									})
								)
							)
						);

                        for(let j=0; j<names.length; j++)
                        {

                            $("#inputName").append(
                                jQuery('<option/>', {
                                    text: names[j].name,
                                    value: names[j].id
                                })
                            );
                        }
						
						$("#addNewElInTable").click(()=>{
							
							if(isNaN(Number($("#inputCount").val())))
								return alert("Введите число!");
							
							this.addLastElInTable();
						});
					} else return console.error("Метод отрисовки еще не был вызва ни разу!");						
					
				}

			}




		</script>
	</body>	
</html>