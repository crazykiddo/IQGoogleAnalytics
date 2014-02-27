/*==========================
	ON LOAD
==========================*/
$(document).ready(function(){

	// KEY CAPTURE
	$(window).keyup(function(e) {
		var key = e.which;
		//var key = e.charCode;
		//alert('Handler for .keypress() called. - ' + event.charCode);
		//console.log(key);
		
		if (key==38 && e.ctrlKey){
			showhidedebug('1');
		}
		if (key==40 && e.ctrlKey){
			showhidedebug('0');
		}
		
	});

});

/*==========================
	CHARTS
==========================*/
function ShowChart_Bars(chartid, data1, data2, labels){
	var barChartData = {
			labels : labels,
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					data : data1
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					data : data2
				}
			]
		}
	var myLine = new Chart(document.getElementById(chartid).getContext("2d")).Bar(barChartData);
}

/*==========================
	FUNCTIONS
==========================*/
function showhidedebug(dowhat){
	if (dowhat=="1"){
		$('#debugbox').show().animate({
			'bottom':'50%'
		},2000,function(){
		
		});
	}else{
		$('#debugbox').show().animate({
			'bottom':'-100%'
		},2000,function(){
		
		});
	}	
}

function SetSiteProfile(thisin){
	var getv = thisin.value;
	if (getv!=""){
		var temp = getv.split(",");
		var aID = temp[0];
		var pID = temp[1];
		log(aID);
		log(pID);
		
		$.post('ajax.php?todo=setsitesession', {
			aid: aID,
			pid: pID
		}, function (data) {
			//alert(data);
			location.reload();
		});		
		
	}else{
		//message("");
	}	
}

function log(mess){
	console.log(mess);
}
function message(mess){
	alert(mess);
}