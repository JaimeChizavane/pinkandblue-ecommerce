$(document).ready(function () {	
	var geocoder;
	var map;
	var marker;
	var mapa = document.getElementById("mapa");
	function initialize(){
		var latlng = new google.maps.LatLng(-25.891968,32.605135099999984);
		var options = {
			zoom: 5,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		map = new google.maps.Map(mapa, options);
		
		geocoder = new google.maps.Geocoder();
		
		marker = new google.maps.Marker({
			map: map,
			draggable: true,
		});
		
		marker.setPosition(latlng);
	}
	if(mapa !=undefined){
		initialize();
		
	var enderecoForm = $('.enderecoForm').val();	
	if(enderecoForm != undefined || enderecoForm != null){
		if(enderecoForm.length > 0){
			carregarNoMapa(enderecoForm);
		}	
	}
	
	var MapGoogle = $(".mapaSingle").attr('endereco');
	
	if(MapGoogle != undefined || MapGoogle != null){
		if(MapGoogle.length > 0){
			carregarNoMapa(MapGoogle);
		}	
	}
	
	function carregarNoMapa(endereco) {
		geocoder.geocode({ 'address': endereco + ', Moçambique', 'region': 'MZ' }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();		
					$('#txtEndereco').val(results[0].formatted_address);
					$('#txtLatitude').val(latitude);
					$('#txtLongitude').val(longitude);
					var location = new google.maps.LatLng(latitude, longitude);
					marker.setPosition(location);
					map.setCenter(location);
					map.setZoom(16);
				}
			}
			if(status == "ZERO_RESULTS"){
				alert("Endereço não encontrado. Sugestão: deixe apenas nomes dos bairros, Ruas, Avenidas, Cidades, Provincias e País não inclua o nome do ímovel.");
			}
		})
	}
	
	$("#btnEndereco").click(function() {
		if($(this).val() != "")
			if(carregarNoMapa($("#txtEndereco").val())){
				console.log("Verifica o endereco");
			}			
	});
	
	google.maps.event.addListener(marker, 'drag', function () {
		geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {  
					$('#txtEndereco').val(results[0].formatted_address);
					$('#txtLatitude').val(marker.getPosition().lat());
					$('#txtLongitude').val(marker.getPosition().lng());
				}
			}
		});
	});
	
	$("#txtEndereco").autocomplete({
		source: function (request, response) {
			geocoder.geocode({ 'address': request.term + ', Moçambique', 'region': 'MZ' }, function (results, status) {
				response($.map(results, function (item) {
					return {
						label: item.formatted_address,
						value: item.formatted_address,
						latitude: item.geometry.location.lat(),
						longitude: item.geometry.location.lng()
					}
				}));
			})
		},
		select: function (event, ui) {
			$("#txtLatitude").val(ui.item.latitude);
			$("#txtLongitude").val(ui.item.longitude);
			var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
			marker.setPosition(location);
			map.setCenter(location);
			map.setZoom(16);
			}
		});
		
	}//end of undefined object map
	
	});