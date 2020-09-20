window.onload = initPage;
var searchInput = 'address';

const componentForm = {
    street_number: {type: "short_name", value: ""},
    route: {type: "long_name", value: ""},
    locality: {type: "long_name", value: ""},
    administrative_area_level_1: {type: "short_name", value: ""},
    country: {type: "long_name", value: ""},
    postal_code: {type: "short_name", value: ""},
    lat: {value: ""},
    lon: {value: ""}
  };

var autocomplete;

function initPage() {
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode'],
        componentRestrictions: {
            country: "USA"
        }
    });
// Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  autocomplete.setFields(["address_component", "geometry"]);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener("place_changed", fillInAddress);
  autocomplete.setComponentRestrictions({
    country: ["us"]
  });
};

function fillInAddress() {
    // Get the place details from the autocomplete object.
    const place = autocomplete.getPlace();
    console.log(place)
  
    for (const component in componentForm) {
        if (document.getElementById(component)){
            document.getElementById(component).value = "";
            document.getElementById(component).disabled = false;
        }
    }
  
    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    for (const component of place.address_components) {
      const addressType = component.types[0];
  
      if (componentForm[addressType]) {
        const val = component[componentForm[addressType].type];
        componentForm[addressType].value= val;
      }
      
    }
    componentForm['lat'].value = place.geometry.location.lat();
    componentForm['lon'].value = place.geometry.location.lng();
    
    for (const component in componentForm) {
        if (document.getElementById(component)){
        document.getElementById(component).value = componentForm[component].value;
        }
    }
     document.getElementById('address').value = componentForm['street_number'].value +' '+componentForm['route'].value;
}

// function getAPIResponse( style ) {

//     // var URL = (style) ? 
//     //     APIForm.XMLContent.value 
//     //     :
//     //     ((APIForm.secure.checked)?"https://":"http://")+APIForm.APIServer.value+
//     //     APIForm.tURI.value+"?API="+APIForm.APIName.value+"&XML="+
//     //     APIForm.XMLContent.value;

//     var usps = 'https://production.shippingapis.com/ShippingAPITest.dll?API=Verify&XML='+
//     '<AddressValidateRequest USERID="922WORDP5317">'+
//         '<Address ID="0">'+
//             '<Address1></Address1>'+
//             '<Address2>6406 Ivy Lane</Address2>'+
//             '<City>Greenbelt</City>'+
//             '<State>MD</State>'+
//             '<Zip5></Zip5>'+
//             '<Zip4></Zip4>'
//         '</Address>'+
//     '</AddressValidateRequest>'
//     ;

// // alert( URL );
//     var request = createRequest();
//       try {
//           request.open ("GET", usps, false); 
//           request.send ();
//           XMLResponse.innerText = (request.status == 200) ?
//             request.responseText 
//             : 
//             "HTTP Error " + request.status + ' '+request.responseText;
//         }

//       catch(e) { XMLResponse.innerText = "Error condition " + e.description;}
// }

function validateAddress(){
    var address = getNode('input#address').value.trim().replace(' ', '+'),
        city = getNode('input#locality').value.trim().replace(' ', '+'),
        state = getNode('input#administrative_area_level_1').value.trim().replace(' ', '+')
    ;
    var request = createRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
           suggestAddress(request.responseText);   
        }
    }
      request.open("GET", 'https://us-street.api.smartystreets.com/street-address?'+
      'street='+address+'&city='+city+'&state='+state+'&candidates=10&key=33312426711717008', true); 
      
      request.send();
}

// function suggestAddress(json) {
//     var response = JSON.parse(json);
//     response = response[0];

//     var address = getNode('input#address'),
//         city = getNode('input#locality'),
//         state = getNode('input#administrative_area_level_1'),
//         zip = getNode('input#postal_code'),
//         lat = getNode('input#lat'),
//         lon = getNode('input#lon')
//     ;
//     var addressLine1 = response['delivery_line_1'];
//     var addressLine2 = response['last_line'];
//     var form = getNode('form#signupForm');

//     var useAddress = confirm('Choose the most accurate address to continue...\n\n'+
//         'Input:\n'+address.value.trim()+'\n'+city.value.trim()+ ' ' +state.value.trim()+ ' ' +zip.value.trim()+'\n\n'+
//         'Suggested address:\n'+addressLine1+'\n'+addressLine2
//     );
//     if (useAddress){
//         address.value = addressLine1;
//         city.value = response.components.city_name;
//         state.value = response.components.state_abbreviation;
//         zip.value = response.components.zipcode+'-'+response.components.plus4_code;
//         lat.value = response.metadata.latitude;
//         lon.value = response.metadata.longitude;
//                 form.submit();
//     }
// }
function suggestAddress(json) {
    var response = JSON.parse(json);
    response = response[0];

    var address = getNode('input#address'),
        city = getNode('input#locality'),
        state = getNode('input#administrative_area_level_1'),
        zip = getNode('input#postal_code'),
        lat = getNode('input#lat'),
        lon = getNode('input#lon'),
        submitBtn = getNode('input#signupSubmit'),
        oldAdress = getNode('input#oldAddress'),
        newAdress = getNode('input#newAddress')
    ;
    var addressLine1 = response['delivery_line_1'];
    var addressLine2 = response['last_line'];

    var modal = getNode('div#myModal');
    var modalBody = document.getElementsByClassName('modal-body')[0];

    var data='<table>'+
                '<tr>'+
                    '<td style="padding: 8px;">'+
                        '<table>'+
                            '<tr><td>Your Adrress:</td></tr>'+
                            '<tr><td style="font-weight: 300;">'+address.value.trim()+'</td></tr>'+
                            '<tr><td style="font-weight: 300;">'+city.value.trim()+ ' ' +state.value.trim()+ ' ' +zip.value.trim()+ '</td></tr>'+
                        '</table>'+
                    '</td>'+
                    '<td style="padding: 8px;">'+
                        '<table>'+
                            '<tr><td>Standardized Address:</td></tr>'+
                            '<tr><td style="font-weight: 300;">'+addressLine1+'</td></tr>'+
                            '<tr><td style="font-weight: 300;">'+addressLine2+'</td></tr>'+
                        '</table>'+
                    '</td>'+
                '</tr>'+
            '</table>';
    
    modalBody.innerHTML = data;
    modal.style.display = "block";

    addEventHandler(oldAdress, 'click', function(){
        
        lat.value = response.metadata.latitude;
        lon.value = response.metadata.longitude;
        oldAdress.innerText = 'Submitting...';
        setTimeout(() => {
            submitBtn.click();
        }, 1000);
    });
    addEventHandler(newAdress, 'click', function(){
        address.value = addressLine1;
        city.value = response.components.city_name;
        state.value = response.components.state_abbreviation;
        zip.value = response.components.zipcode+'-'+response.components.plus4_code;
        lat.value = response.metadata.latitude;
        lon.value = response.metadata.longitude;
        newAddress.innerText = 'Submitting...';
        setTimeout(() => {
            submitBtn.click();
        }, 1000);
    });
}