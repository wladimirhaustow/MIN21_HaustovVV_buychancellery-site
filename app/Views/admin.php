<?= view('header'); ?>

		<main role="main" class="pt-5 mt-5 mx-5 inner cover">
			<table class="table table-striped table-dark">
			  <thead>
				<tr>
				  <th scope="col">#</th>
				  <th scope="col">Наименование</th>
				</tr>
			  </thead>
			  <tbody id="table">
				
				
				
			  </tbody>
			</table>
			
			<div class="my-5 row">
				<button type="button" class="col mx-auto btn btn-primary" id="saveBtn">Сохранить</button>
			</div>
		</main>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script>
			let AdminTable;
		
			$("#saveBtn").click(()=>{
				$.ajax({
					type: "POST",
					url: '/Product/setProduct',
                    data: JSON.stringify(AdminTable.tableInfo),
					dataType: 'JSON'
				}).done(obj => {
					alert("Сохранено!");
				});
			});
		
			function start()
			{
                $.getJSON('/Product/getProduct', function(json) {
                    AdminTable = new Tables("table", json);
                });
			}
		
			//Класс для работы с таблицей админки
			class Tables 
			{
				isFirstwAddNewElInTable = true;
				lastElId = null;
				tableInfo = [];
				tableTrNumber = 1;
				
				constructor(tableId, data = null) 
				{
					//Записываем id таблицы (tbody), для дальнейшей работы
					if($(`#${tableId}`).length)
						this.tableId = tableId;
					else return console.error("Передан неверный id таблицы");
					
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
							
							this.lastElId = Number.parseInt(data[data.length - 1].id) + 1;
							
						} else this.lastElId = 1;
						
						this.addLastElInTable();
						
						this.isFirstwAddNewElInTable = false;
					
					} else return console.error("Переданные данные не являются массивом");
				}
				
				_addElInTable(el)
				{
					this.tableInfo.push({
						id: el.id,
						name: el.name
					});
					
					$(`#${this.tableId}`).append(
						jQuery('<tr/>', {
							id: "trEl_" + el.id
						}).append(
							jQuery('<th/>', {
								scope: "row",
								text: this.tableTrNumber
							}),
							jQuery('<td/>', {
								id: "elTdText_" + el.id
							}).append(
								jQuery('<label/>', {
									id: "elText_" + el.id,
									text: el.name
								}),
								jQuery('<input/>', {
									type: "text",
									class: "form-control",
									id: "inputEditName_" + el.id,
									style: "display: none;",
									value: el.name
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
                    this.tableTrNumber = this.tableTrNumber + 1;
					
					$("#elTdText_" + el.id).click(()=>{
						
						$("#inputEditName_" + el.id).val($("#elText_" + el.id).text());
						$("#elText_" + el.id).hide();
						$("#inputEditName_" + el.id).show();
						$("#inputEditName_" + el.id).focus();						
					});
					
					let tmpFunction = ()=>{
						let newName = $("#inputEditName_" + el.id).val();
						$("#elText_" + el.id).text(newName);
						$("#elText_" + el.id).show();
						$("#inputEditName_" + el.id).hide();
						let tabeleEl = this.tableInfo.find(x => x.id === el.id);
						let elIndex = this.tableInfo.indexOf(tabeleEl);
						this.tableInfo[elIndex].name = newName;
					};
					
					
					$("#inputEditName_" + el.id).focusout(tmpFunction);
					$("#inputEditName_" + el.id).mouseout(tmpFunction);
					
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
								name: $("#inputName").val()
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
									text: this.tableTrNumber
								}),
								jQuery('<td/>', {
								}).append(
									jQuery('<input/>', {
										type: "text",
										class: "form-control",
										id: "inputName"
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
						
						$("#addNewElInTable").click(()=>{
							this.addLastElInTable();
						});
					} else return console.error("Метод отрисовки еще не был вызва ни разу!");						
					
				}
			}
			
			start();
		</script>
	</body>	
</html>