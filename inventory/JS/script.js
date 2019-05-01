/*
* Auteur Jessy Nadeau
* Scipt.js
* Read xml files and process values to then display them in a chart
*/

//////////////////////////////////////////////////
//	Global Values
//////////////////////////////////////////////////
let valTemp= [];
let valHum = [];
let valPH;

let colors = [
		'rgba(255, 99, 132)',
		'rgba(54, 162, 235)',
		'rgba(255, 206, 86)',
		'rgba(75, 192, 192)',
		'rgba(153, 102, 255)',
		'rgba(255, 159, 64)',
		'rgba(100, 220, 25)'
];

let phColor = [
	"#aa0000",
	"#ff0000",
	"#f96352",
	"#c15613",
	"#f99e3b",
	"#ffe500",
	"#3bb200",
	"#5dccae",
	"#227b9b",
	"#a23bd6",
	"#4a78db",
	"#141fba",
	"#701ca0",
	"#63007a"

];
let zoneName = [];
let tempLabelName = [];
let humLabelName = [];

let tempAverageDoor = false;
let humAverageDoor = false;
let phAverageDoor = false;

//compare loads the last value in xml
let tempCompareDoor = false;

let humCompareDoor = false;

let xmlData;

let name = [];

let datasetsTemp = [{}];


//////////////////////////////////////////////////
//	Script init
//////////////////////////////////////////////////
function init() {
	area = "zones";
	xmlData = openXML();

	loadZone();

	readXML();

	if(tempCompareDoor)
		loadChartTempBar();
	else
		loadChartTempLine();

		loadChartHumBar();

	loadPH();
}

//////////////////////////////////////////////////
//	Chart builder
//////////////////////////////////////////////////
function loadChartTempBar(){
	var ctx = document.getElementById('chartTemp');
	var ctx = document.getElementById('chartTemp').getContext('2d');
	var chartTemp = new Chart(ctx, {
	    type: "bar",
	    data: {
	        labels: tempLabelName,
	        datasets: [{
	            label: "Temperature C",
	            data: valTemp,
	            backgroundColor: colors,
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true
	                }
	            }]
	        }
	    }
	});
}
/*
pour avoir plusieurs ligne dans le meme graph
je crois qui faut fair des objets JS des objet de type data (labels, datasets) et datasets (label, data)
 */
function loadChartTempLine() {
	var ctx = document.getElementById('chartTemp');
	var ctx = document.getElementById('chartTemp').getContext('2d');
	var chartTemp = new Chart(ctx, {
		type: "line",
		data: {
			labels: tempLabelName,
			datasets: datasetsTemp
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}
	});
}

function loadChartHumBar(){
	var ctx = document.getElementById('#chartHum');
	var ctx = document.getElementById('chartHum').getContext('2d');
	var chart2 = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: humLabelName,
	        datasets: [{
	            label: "Humidity %",
	            data: valHum,
	            backgroundColor: colors,
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                	suggestedMax : 100,
	                    beginAtZero: true

	                }
	            }]
	        }
	    }
	});
}

//////////////////////////////////////////////////
//	XML Processing
//////////////////////////////////////////////////
function readXML() {
	readTemp();
	readHumidity();
	readPH();
}

function openXML() {
	let xml=new XMLHttpRequest();
	xml.open("GET", "mesures.xml",false);
	xml.send();
	return xml.responseXML;
}

//////////////////////////////////////////////////
//	value processing
//////////////////////////////////////////////////
function readTemp() {
	let temp = xmlData.getElementsByTagName("temp");
	datasetsTemp = [];
	for(i = 0; i < temp.length; i++)
	{
		datasetsTemp.push({
			label: "Temperature C",
        	data: 0,
        	borderColor: colors[i], 
        	fill: false,
		});
		if(!tempAverageDoor){
			if(tempCompareDoor)
			{
				datasetsTemp[i].data = valTemp = loadValueCompare(temp);
				break;
			}
			else{
				datasetsTemp[i].data = valTemp = loadValueTime(temp, i);// 0 is the position in xml !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				if(tempLabelName.length < name.length)
					tempLabelName = name;
			}
	}
	else
		valTemp = average(temp);
	}
}
function readHumidity() {
	let humidity = xmlData.getElementsByTagName("humidity");
	if(!humAverageDoor)
		if(humCompareDoor)
			valHum = loadValueCompare(humidity)
		else{
			valHum = loadValueTime(humidity, 0)//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			humLabelName = name;
		}
	else
		valHum = average(humidity);
}
function readPH() {
	let ph = xmlData.getElementsByTagName("ph");
	if(phAverageDoor)
		valPH = average(ph);
	else
		valPH = ph[0].getElementsByTagName("value")[0].firstChild.data;
}

//////////////////////////////////////////////////
//	Load Values with specific
//////////////////////////////////////////////////
function loadValueCompare(arr){
	let val = [];
	for (let i = 0; i < arr.length; i++){
		val[i] = arr[i].getElementsByTagName("value")[arr[i].getElementsByTagName("value").length-1].firstChild.data;
	}
	return val;
}
//k is the position in xml
function loadValueTime(arr, k){
	let val = [];
	for (let i = 0; i < arr[k].getElementsByTagName("value").length; i++){
		val[i] = arr[k].getElementsByTagName("value")[i].firstChild.data;
	}
	loadTime(arr,k);
	return val;
}

//////////////////////////////////////////////////
//	Area Name
//////////////////////////////////////////////////
function loadZone(){

	let zone = xmlData.getElementsByTagName("zone");
	for (let i = 0; i < zone.length; i++){
		zoneName[i] = zone[i].getElementsByTagName("name")[0].firstChild.data;
	}
	tempLabelName = humLabelName = zoneName;
}

function loadTime(arr, k){
	name = [];
		for (let i = 0; i < arr[k].getElementsByTagName("value").length; i++){
		name[i] = arr[k].getElementsByTagName("time")[i].firstChild.data;
	}
}
//////////////////////////////////////////////////
//	Useful function
//////////////////////////////////////////////////
function average(arr){
	let val = 0;
	for (let i = 0; i < arr.length; i++) {
		val += parseFloat(arr[i].getElementsByTagName("value")[0].firstChild.data);
	}
	return val / arr.length;
}

function loadPH(){
	document.getElementById("ph").innerHTML = valPH;
	document.getElementsByClassName("ph")[0].style.backgroundColor = phColor[Math.floor(valPH - 1)];
}
