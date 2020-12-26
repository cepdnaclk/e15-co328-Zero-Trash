
export const setUserToken = (token) => {
   const current_time = new Date();
   let ttl = 1000*60*15;
   const usertoken = {
      value: token,
      expiry: current_time.getTime() + ttl,
   }

   localStorage.setItem('usertoken', JSON.stringify(usertoken))
   console.log('token is set');
}

export const register = newCustomer => {
   const data = {
      firstName: newCustomer.firstName,
      lastName: newCustomer.lastName,
      phoneNo: newCustomer.phoneNo,
      email: newCustomer.email,
      address1: newCustomer.address1,
      address2: newCustomer.address2,
      city: newCustomer.city,
      regDate: newCustomer.regDate,
      password: newCustomer.password,
      customerType: newCustomer.customerType,
      language: newCustomer.language,
      municipalCouncil: newCustomer.municipalCouncil,
   };

   return fetch(global.config.backend + '/api/v1/register/', {
      method: 'POST',
      headers: {},
      body: JSON.stringify(data)
   })
   .then((response) => response.json())
   .then(response => {
      return response;
   })
   .catch(err => {
      console.log(err)
   })
}

export const login = input => {
   let newCustomer = input.customer;
   //let rememberMe = input.rememberMe;
   const data = {
      phoneNo: newCustomer.phoneNo,
      email: newCustomer.email,
      password: newCustomer.password
   };

   return fetch(global.config.backend + '/api/v1/login/', {
      method: 'POST',
      headers: {},
      body: JSON.stringify(data)
   })
   .then((response) => response.json())
   .then(response => {
      console.log(response);
      return response;
   })
   .catch(err => {
      console.log(err)
   })
}

export const devVerification = input => {

   const data = {
      accessToken: 'f83bdbecf8f2596cfd837b11ab2aa1fb',
      userToken: input.token,
      userTele: input.phoneNo
   };


   return fetch(global.config.telco.tokenVerify, {
      method: 'POST',
      headers: {},
      body: JSON.stringify(data)
   })
   .then((response) => response.json())
   .then(response => {
      console.log(response)
      return response
   })
   .catch(err => {
      console.log(err)
   })
}
