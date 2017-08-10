<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <title>Tictactoe Game</title>
		<style>
		    .success {
				color: #4F8A10;
				background-color: #DFF2BF;
				/*background-image:url('success.png');*/
			}

			table#tictactoe_table tr.highlight td {
				background-color: #8888ff;
			}

			table#tictactoe_table tr.normal {
				background-color: #ffffff;
			}

			table#tictactoe_table th {
				white-space: nowrap; 
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #666666;
				background-color: #dedede;
			}

			table#tictactoe_table td {
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #666666;
				background-color: #ffffff;
			}

			#disabler {
				width: 204px;
				height: 204px;
				background-color: #bbb;
				opacity: 0.5;
				margin-bottom: -204px;
			}
		</style>
		<script type="text/javascript" src="jquery-latest.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var defaultData = getTableData();
				disableTable(false);
				//console.log(defaultData);

				var newData = Array();
				$('#tictactoe_table tr td').on('click', function() {
					$(this).html('X');
					newData = getTableData();
					//console.log(newData);
					if (newData != defaultData) {
					}

					setTimeout(function () { 
						$.ajax({
							type: "POST",
					        url: "tictactoe.php",
					        dataType: "json",
					        data: 'board='+newData,
					        success: function(response) {
		                        var responseData = $.parseJSON(JSON.stringify(response)).board;
		                        var responseMessage = $.parseJSON(JSON.stringify(response)).message;
		                        
		                        console.log(responseMessage.indexOf('wins'));
		                        if (responseMessage.indexOf('wins') != -1 ) {
		                            //event.stopPropagation();
		                            setTableData(responseData, true);
		                            $('#success_msg').html(responseMessage);
		                        }
		                        else{
		                            setTableData(responseData, false);
		                        }
		                        defaultData = responseData;
					        },
					        error: function(response) {
					            console.log(response);
					        }
						});
					}, 500);	
				});
			});

			function getTableData() {
				var data = Array();
				$("table tr").each(function(i, v){
					data[i] = Array();
					$(this).children('td').each(function(ii, vv){
					    data[i][ii] = $(this).text();
					}); 
				});
				return JSON.stringify(data);
			}


			function setTableData(data, disableTableFlag) {
				$(data).each(function(i, v){
					$(v).each(function(ii, vv){
						$('#td_'+i+'_'+ii).text(vv);
					}); 
				});

				if(disableTableFlag == false) {
					disableTable(false);
				} else {
					disableTable(true);			
				}
			}
			function disableTable(disabled){
			    var elem = document.getElementById("disabler");
			    if(disabled){
			        elem.style.display = "";
			    } else {
			        elem.style.display = "none"; //Hider disabler
			        
			    }
			}
		</script>
	</head>
	<body>
		<div align="center">
			<h1>TicTacToe - Code Test</h1>
			<div id="disabler"></div>
			<table border="1" cellspacing="0" id="tictactoe_table">
				<tr>
					<td height="50" width="50" align="center" valign="center" id="td_0_0"></td>
					<td height="50" width="50" align="center" valign="center" id="td_0_1"></td>
					<td height="50" width="50" align="center" valign="center" id="td_0_2"></td>
				</tr>
				<tr>
					<td height="50" width="50" align="center" valign="center" id="td_1_0"></td>
					<td height="50" width="50" align="center" valign="center" id="td_1_1"></td>
					<td height="50" width="50" align="center" valign="center" id="td_1_2"></td>
				</tr>
				<tr>
					<td height="50" width="50" align="center" valign="center" id="td_2_0"></td>
					<td height="50" width="50" align="center" valign="center" id="td_2_1"></td>
					<td height="50" width="50" align="center" valign="center" id="td_2_2"></td>
				</tr>
			</table>

			<h1 id="success_msg" class="success" style="width: 204px;"></h1>
		</div>
	</body>
</html>