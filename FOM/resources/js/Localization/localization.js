import LocalizedStrings from 'react-localization';
import axios from 'axios';
 
class Localization{
    constructor(){
        this.strings = {}
    }

    initialize(fileName,lang){
        let data = {
            fileName: fileName,
            lang: lang
        }
        axios.post('/api/v1/localization',data).then((response)=>{
            this.strings = new LocalizedStrings({lang:response.data})
        });
    }
    trans(key){
        return this.strings[key];
    }
}
    
export default Localization;