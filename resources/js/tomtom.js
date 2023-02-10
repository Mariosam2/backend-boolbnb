import { services } from '@tomtom-international/web-sdk-services';
import SearchBox from '@tomtom-international/web-sdk-plugin-searchbox';
const searchBoxWrapper = document.getElementById('searchBoxWrapper');
var options = {
    searchOptions: {
        key: "Ad83Ah6WsxYFXscdqk3lFXmhKanlaKHs",
        language: "it-IT",
        limit: 5,
    },
    autocompleteOptions: {
        key: "Ad83Ah6WsxYFXscdqk3lFXmhKanlaKHs",
        language: "it-IT",
    },
}




const ttSearchBox = new SearchBox(services, options);
const searchBoxHTML = ttSearchBox.getSearchBoxHTML()
searchBoxWrapper.insertAdjacentElement('beforeend', searchBoxHTML);








