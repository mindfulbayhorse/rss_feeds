import Axios from "axios";

class QuickAccessForm{

    constructor(data){

      this.originalData = JSON.parse(JSON.stringify(data));

      Object.assign(this, data);

      this.errors = {};

    }

    data() {

      return Object.keys(this.originalData).reduce((data, attribute) => {
          data[attribute] = this[attribute];
          return data;
      }, {});

    }

    submit(endpoint){
      return axios.post(endpoint, this.data())
              .catch(this.onFail.bind(this))
              .then(this.onSuccess.bind(this));
    }

    onSuccess(response){
      this.errors = {};
      return response;
    }

    onFail(error){
        this.errors = error.response.data.errors;

        throw error;
    }

    reset(){
      Object.assign(this.originalData);
    }
    
}

export default QuickAccessForm;